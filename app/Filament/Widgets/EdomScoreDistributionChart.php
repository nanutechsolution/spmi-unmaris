<?php

namespace App\Filament\Widgets;

use App\Models\Edom\Response;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class EdomScoreDistributionChart extends ChartWidget
{
    protected  ?string $heading = 'Distribusi Skor Evaluasi';
    
    protected static ?int $sort = 4;

    /**
     * Menambahkan filter pada widget.
     * Filter ini akan muncul sebagai dropdown di pojok kanan atas widget.
     */
    protected function getFilters(): ?array
    {
        try {
            // Mengambil daftar PRODI dari API SIAKAD
            // Pastikan Anda telah membuat endpoint /api/v1/prodi di SIAKAD
            $response = Http::withHeaders([
                'X-SIMA-KEY' => config('services.siakad.api_key'),
                'Accept' => 'application/json'
            ])->get(config('services.siakad.url') . "/api/v1/prodi"); 

            if ($response->successful()) {
                // Menyesuaikan dengan format JSON {id, name}
                return collect($response->json('data'))->pluck('name', 'id')->toArray();
            }
        } catch (\Exception $e) {
            // Log error jika diperlukan
        }

        // Fallback jika API belum siap atau gagal
        return [
            null => 'Semua Program Studi',
            'INF' => 'Informatika',
            'SI' => 'Sistem Informasi',
            'TE' => 'Teknik Elektro',
        ];
    }

    protected function getData(): array
    {
        // Mengambil filter yang sedang dipilih (ID Prodi)
        $activeFilter = $this->filter;

        $query = Response::query();

        // Jika filter dipilih, lakukan penyaringan data
        if ($activeFilter) {
            $query->where('siakad_prodi_id', $activeFilter);
        }

        // Menghitung jumlah masing-masing skor (1-5)
        $data = $query->select('score', DB::raw('count(*) as count'))
            ->groupBy('score')
            ->orderBy('score')
            ->pluck('count', 'score')
            ->toArray();

        // Memastikan semua skor (1-5) ada di array meskipun jumlahnya 0
        $formattedData = [];
        for ($i = 1; $i <= 5; $i++) {
            $formattedData[] = $data[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Jawaban',
                    'data' => $formattedData,
                    'backgroundColor' => [
                        '#ef4444', // 1 - Sangat Kurang
                        '#f97316', // 2 - Kurang
                        '#facc15', // 3 - Cukup
                        '#84cc16', // 4 - Baik
                        '#22c55e', // 5 - Sangat Baik
                    ],
                ],
            ],
            'labels' => [
                '1 - Sangat Kurang',
                '2 - Kurang',
                '3 - Cukup',
                '4 - Baik',
                '5 - Sangat Baik'
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}