<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Accreditation\LkpsStudentSatisfaction;
use App\Models\Edom\Response as EdomResponse;
use App\Models\Spmi\Standard;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class SpmiPublicApiController extends Controller
{
    /**
     * Mengambil status ketercapaian Standar SPMI secara global.
     * Endpoint: GET /api/v1/quality-stats
     */
    public function getQualityStats(): JsonResponse
    {
        return Cache::remember('api_quality_stats', now()->addHours(6), function () {
            $totalStandards = Standard::count();
            $activeStandards = Standard::where('is_active', true)->count();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'institution' => 'Universitas Stella Maris Sumba',
                    'total_standards' => $totalStandards,
                    'active_standards' => $activeStandards,
                    'last_updated' => now()->toIso8601String(),
                ]
            ]);
        });
    }

    /**
     * Mengambil rekapitulasi kepuasan mahasiswa (Data LKPS).
     * Endpoint: GET /api/v1/accreditation/student-satisfaction
     */
    public function getAccreditationStats(): JsonResponse
    {
        return Cache::remember('api_accreditation_stats', now()->addHours(12), function () {
            $stats = LkpsStudentSatisfaction::all();

            return response()->json([
                'success' => true,
                'data' => $stats,
                'metadata' => [
                    'source' => 'SPMI UNMARIS Internal Quality Audit',
                    'generated_at' => now()->toIso8601String()
                ]
            ]);
        });
    }

    /**
     * Mengambil skor EDOM dosen tertentu untuk integrasi ke portal profil dosen.
     * Endpoint: GET /api/v1/lecturer-edom/{siakad_lecturer_id}
     */
    public function getLecturerEdomScore(string $siakad_lecturer_id): JsonResponse
    {
        $cacheKey = "api_lecturer_score_{$siakad_lecturer_id}";

        $data = Cache::remember($cacheKey, now()->addHours(24), function () use ($siakad_lecturer_id) {
            $score = EdomResponse::where('siakad_lecturer_id', $siakad_lecturer_id)
                ->avg('score');

            if (!$score) return null;

            return [
                'lecturer_id' => $siakad_lecturer_id,
                'average_score' => round($score, 2),
                'scale' => '4.00',
                'label' => $this->getScoreLabel($score)
            ];
        });

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Helper untuk label predikat nilai.
     */
    private function getScoreLabel($score): string
    {
        if ($score >= 3.5) return 'Sangat Baik';
        if ($score >= 3.0) return 'Baik';
        if ($score >= 2.0) return 'Cukup';
        return 'Kurang';
    }
}