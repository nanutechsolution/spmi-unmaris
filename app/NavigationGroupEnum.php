<?php

namespace App;

/**
 * Enum untuk standarisasi nama grup navigasi di sidebar Filament.
 * Digunakan pada properti $navigationGroup di setiap Resource.
 */
enum NavigationGroupEnum: string
{
    case MASTER = 'Master SPMI';
    case EDOM = 'Evaluasi Dosen (EDOM)';
    case AMI = 'Audit Mutu Internal (AMI)';
    case PORTAL = 'Portal & Survei';
    case SETTINGS = 'Pengaturan Sistem';

    /**
     * Mendapatkan label string dari enum.
     */
    public function getLabel(): string
    {
        return $this->value;
    }
}
