<?php

namespace App\Filament\Widgets;

use App\Models\Edom\Response;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class EdomLecturerBarChart extends ChartWidget
{
    protected  ?string $heading = 'Top 10 Dosen dengan Nilai Tertinggi';
    
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        // Mengambil 10 dosen dengan rata-rata nilai tertinggi
        $data = Response::query()
            ->select('siakad_lecturer_id', DB::raw('AVG(score) as average'))
            ->groupBy('siakad_lecturer_id')
            ->orderByDesc('average')
            ->limit(10)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Rata-rata Skor',
                    'data' => $data->pluck('average')->toArray(),
                    'backgroundColor' => '#3b82f6',
                    'borderRadius' => 8,
                ],
            ],
            'labels' => $data->pluck('siakad_lecturer_id')->toArray(), // Menampilkan NIDN
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'min' => 0,
                    'max' => 5,
                ],
            ],
        ];
    }
}