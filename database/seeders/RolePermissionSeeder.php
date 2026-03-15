<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Definisikan Permissions (Hak Akses Spesifik)
        $permissions = [
            'view_dashboard_kpi',
            'manage_spmi_standards',
            'manage_ami_audits',
            'conduct_ami_audit', // Khusus untuk Auditor
            'manage_edom',
            'fill_edom',         // Khusus Mahasiswa
            'view_own_edom',     // Khusus Dosen
            'manage_documents',
            'export_accreditation_data',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Definisikan Roles dan berikan Permissions
        
        // LPM Admin (Lembaga Penjaminan Mutu) - Punya akses hampir ke semua fitur operasional
        $lpm = Role::firstOrCreate(['name' => 'LPM Admin']);
        $lpm->givePermissionTo([
            'view_dashboard_kpi', 'manage_spmi_standards', 'manage_ami_audits', 
            'manage_edom', 'manage_documents', 'export_accreditation_data'
        ]);

        // Auditor AMI (Asesor Internal)
        $auditor = Role::firstOrCreate(['name' => 'Auditor']);
        $auditor->givePermissionTo(['view_dashboard_kpi', 'conduct_ami_audit', 'manage_documents']);

        // Kaprodi (Kepala Program Studi) - Bisa melihat KPI dan data akreditasi prodinya
        $kaprodi = Role::firstOrCreate(['name' => 'Kaprodi']);
        $kaprodi->givePermissionTo(['view_dashboard_kpi', 'export_accreditation_data']);

        // Dosen - Hanya bisa melihat hasil evaluasi (EDOM) dirinya sendiri
        $dosen = Role::firstOrCreate(['name' => 'Dosen']);
        $dosen->givePermissionTo(['view_own_edom']);

        // Mahasiswa - Hanya bisa mengisi form EDOM
        $mahasiswa = Role::firstOrCreate(['name' => 'Mahasiswa']);
        $mahasiswa->givePermissionTo(['fill_edom']);

        // Super Admin - Bypass semua (menggunakan Gate::before nantinya)
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);

        // 3. Buat satu user Super Admin sebagai akun master pertama (sebelum SSO jalan)
        $adminUser = User::firstOrCreate(
            ['email' => 'admin.spmi@unmaris.ac.id'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password_unmaris_kuat'), // Ganti dengan password yang aman
                'siakad_user_id' => '0000', // ID Dummy
            ]
        );
        $adminUser->assignRole($superAdmin);
    }
}