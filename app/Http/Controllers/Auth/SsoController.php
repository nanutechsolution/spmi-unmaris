<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;
use Spatie\Permission\Models\Role;

class SsoController extends Controller
{
    /**
     * Menangani proses login dari form SPMI ke API SIAKAD.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // 1. Kirim Kredensial ke SIAKAD
        $response = Http::withHeaders([
            'X-SIMA-KEY' => config('services.siakad.api_key'),
            'Accept' => 'application/json',
        ])->post(config('services.siakad.url') . '/api/v1/login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if (!$response->successful()) {
            return back()->withErrors([
                'username' => $response->json('message') ?? 'Kredensial salah atau SIAKAD tidak merespon.',
            ]);
        }

        $token = $response->json('token');

        // 2. Ambil Data Profil (Endpoint Me: api/v1/user/me)
        $profileResponse = Http::withToken($token)
            ->withHeaders(['X-SIMA-KEY' => config('services.siakad.api_key')])
            ->get(config('services.siakad.url') . '/api/v1/user/me');

        if (!$profileResponse->successful()) {
            return back()->withErrors(['username' => 'Gagal mengambil profil dari SIAKAD.']);
        }

        $userData = $profileResponse->json('data');

        // 3. Sinkronisasi Data ke Tabel Local SPMI
        $user = User::updateOrCreate(
            ['siakad_user_id' => $userData['identifier']],
            [
                'name'  => $userData['name'],
                'email' => $userData['identifier'] . '@unmaris.ac.id',
                'password' => bcrypt(Str::random(24)),
            ]
        );

        // 4. Assign Role dengan Pemetaan Aman
        $this->syncUserRole($user, $userData['role']);

        // 5. Login ke Session
        Auth::login($user);

        Notification::make()
            ->title('Selamat Datang, ' . $user->name)
            ->success()
            ->send();

        return redirect()->intended('/admin');
    }

    /**
     * Sinkronisasi role dengan validasi guard dan mapping.
     */
    /**
     * Sinkronisasi role dengan validasi guard dan mapping.
     */
    protected function syncUserRole(User $user, string $siakadRole)
    {
        // Cegah user Super Admin lokal diturunkan derajatnya oleh data SIAKAD
        if ($user->hasRole('Super Admin')) {
            return;
        }

        // Mapping role dari SIAKAD ke Role di Spatie (SPMI)
        $roleMapping = [
            'mahasiswa' => 'Mahasiswa',
            'dosen'     => 'Dosen',
            'admin'     => 'supeadmin',
            'staf'      => 'LPM Admin',
            'superadmin' => 'Super Admin',
        ];

        $targetRoleName = $roleMapping[strtolower($siakadRole)] ?? null;
        if ($targetRoleName) {
            // Gunakan firstOrCreate agar role otomatis dibuat jika tabel roles kosong
            // Pastikan guard_name diset ke 'web' sesuai config auth
            $role = Role::firstOrCreate(
                ['name' => $targetRoleName, 'guard_name' => 'web']
            );

            $user->syncRoles([$role->name]);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
