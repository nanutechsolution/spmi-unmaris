<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Edom\Period;
use App\Models\Survey\Question;
use App\Models\Survey\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EdomApiController extends Controller
{
    /**
     * Verifikasi kunci akses dari Portal React
     */
    private function isUnauthorized(Request $request)
    {
        // Sesuaikan dengan nama variabel di .env SPMI Anda
        $serverKey = config('services.siakad.api_key'); 
        $clientKey = $request->header('X-SIMA-KEY');
        
        return (!$clientKey || $clientKey !== $serverKey);
    }

    /**
     * Mengambil KRS dari SIAKAD dan mencocokkan status di SPMI
     */
    public function getMyKrs(Request $request)
    {
        if ($this->isUnauthorized($request)) {
            return response()->json(['message' => 'Unauthorized Client'], 401);
        }

        $studentId = $request->query('student_id');

        // 1. Cari periode aktif di sistem SPMI
        $activePeriod = Period::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$activePeriod) {
            return response()->json(['data' => [], 'message' => 'Tidak ada periode EDOM yang aktif.']);
        }

        // 2. Tarik data KRS Mentah dari SIAKAD (sebagai jembatan)
        try {
            $siakadResponse = Http::withHeaders([
                'X-SIMA-KEY' => config('services.siakad.api_key')
            ])->get(config('services.siakad.url') . '/api/v1/user/krs', [
                'student_id' => $studentId,
                'semester_id' => $activePeriod->siakad_semester_id // ID Semester yang ditarik saat admin buat periode
            ]);

            $krsData = $siakadResponse->successful() ? $siakadResponse->json('data') : [];

            // 3. Gabungkan dengan data status "Selesai" di database SPMI
            foreach ($krsData as &$item) {
                // Cek apakah mahasiswa ini sudah menilai kelas & dosen ini di periode ini
                $item['is_completed'] = Response::where('siakad_student_id', $studentId)
                    ->where('siakad_class_id', $item['class_id'])
                    ->where('edom_period_id', $activePeriod->id)
                    ->exists();
            }

            return response()->json(['data' => $krsData]);

        } catch (\Exception $e) {
            return response()->json(['data' => [], 'message' => 'Gagal mengambil data dari server akademik.'], 500);
        }
    }

    /**
     * Mengirim daftar pertanyaan EDOM
     */
    public function getQuestions(Request $request)
    {
        if ($this->isUnauthorized($request)) {
            return response()->json(['message' => 'Unauthorized Client'], 401);
        }

        // Ambil soal yang berstatus aktif dari tabel SPMI
        // (Sesuaikan kolom 'order' atau 'is_active' dengan skema tabel Anda)
        $questions = Question::where('is_active', true)->get();
        
        // Memformat data agar dimengerti oleh React
        $formatted = $questions->map(function($q) {
            return [
                'id' => $q->id,
                'question_text' => $q->question // Pastikan nama kolom 'question' sesuai DB SPMI
            ];
        });

        return response()->json(['data' => $formatted]);
    }

    /**
     * Menerima dan menyimpan jawaban EDOM
     */
    public function submitEdom(Request $request)
    {
        if ($this->isUnauthorized($request)) {
            return response()->json(['message' => 'Unauthorized Client'], 401);
        }

        $request->validate([
            'course_id' => 'required',
            'lecturer_id' => 'required',
            'class_id' => 'required',
            'student_id' => 'required',
            'answers' => 'required|array'
        ]);

        // Cek periode aktif
        $activePeriod = Period::where('is_active', true)->first();
        
        if (!$activePeriod) {
            return response()->json(['message' => 'Gagal. Periode pengisian telah ditutup.'], 400);
        }

        // Pastikan belum pernah mengisi sebelumnya (Mencegah Bypass dari Postman)
        $hasFilled = Response::where('siakad_student_id', $request->student_id)
            ->where('siakad_class_id', $request->class_id)
            ->where('edom_period_id', $activePeriod->id)
            ->exists();

        if ($hasFilled) {
            return response()->json(['message' => 'Anda sudah mengevaluasi kelas ini.'], 422);
        }

        // Simpan setiap jawaban ke database SPMI
        foreach ($request->answers as $questionId => $score) {
            Response::create([
                'edom_period_id' => $activePeriod->id,
                'edom_question_id' => $questionId,
                'siakad_student_id' => $request->student_id,
                'siakad_lecturer_id' => $request->lecturer_id,
                'siakad_class_id' => $request->class_id,
                'siakad_course_id' => $request->course_id,
                'score' => $score
            ]);
        }

        return response()->json(['message' => 'Evaluasi berhasil disimpan ke sistem penjaminan mutu.']);
    }
}