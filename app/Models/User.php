<?php


namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use Notifiable, HasRoles; // Tambahkan HasRoles di sini

    protected $fillable = [
        'name',
        'email',
        'password',
        'siakad_user_id', // ID referensi dari SIAKAD nantinya
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Menentukan siapa yang boleh masuk ke dashboard Filament.
     * Jika return false, user akan mendapatkan error 403.
     */
    public function canAccessPanel(Panel $panel): bool
    {

        // Izinkan akses jika user memiliki salah satu role yang terdaftar di sistem
        return $this->hasAnyRole([
            'Super Admin',
            'superadmin',
            'LPM Admin',
            'Auditor',
            'Dosen',
            'Mahasiswa'
        ]);

    }
}
