<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Spmi\Standard;
use App\Models\Spmi\Indicator;
use App\Models\Ami\Finding;
use App\Models\Ami\Schedule;
use App\Models\Document;
use App\Models\Edom\Response;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SpmiOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Standar Mutu', Standard::count())
                ->description('Jumlah standar yang terdaftar')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('primary'),

            Stat::make('Indikator Kinerja', Indicator::count())
                ->description('Indikator yang harus dipenuhi')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('info'),

            Stat::make('Temuan AMI (KTS)', Finding::whereNotIn('status', ['closed', 'verified'])->count())
                ->description('Temuan audit yang masih terbuka')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),

            Stat::make('Rata-rata Skor EDOM', number_format(Response::avg('score') ?? 0, 2))
                ->description('Kepuasan mahasiswa terhadap dosen')
                ->descriptionIcon('heroicon-m-star')
                ->color('success'),

            Stat::make('Dokumen Mutu', Document::count())
                ->description('Kebijakan, Manual, & Formulir')
                ->descriptionIcon('heroicon-m-document-duplicate')
                ->color('warning'),
            Stat::make('Total Pengguna Sistem', User::count())
                ->description('User yang terdaftar melalui SSO')
                ->descriptionIcon('heroicon-m-users')
                ->color('gray'),

            Stat::make('Audit Selesai', Schedule::where('status', 'completed')->count())
                ->description('Siklus audit yang telah tuntas')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
