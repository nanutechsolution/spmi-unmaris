<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LpmProfile;

class LpmProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Karena ini diasumsikan sebagai "Singleton" (hanya ada 1 profil utama),
        // kita menggunakan updateOrCreate agar aman jika dijalankan berulang kali.
        LpmProfile::updateOrCreate(
            ['id' => 1],
            [
                // Teks Beranda
                'hero_title' => 'Menjamin Mutu Tanpa Kompromi.',
                'hero_description' => 'Lembaga Penjaminan Mutu berkomitmen mengawal standar pendidikan melalui siklus PPEPP yang sistematis untuk mencetak lulusan unggul di Sumba.',
                
                // Visi & Misi
                'vision' => 'Menjadi lembaga penjaminan mutu yang kredibel, akuntabel, dan transparan dalam mewujudkan budaya mutu yang berkelanjutan di Universitas Stella Maris Sumba.',
                'missions' => [
                    [
                        'text' => 'Menyelenggarakan sistem penjaminan mutu internal secara berkelanjutan dan konsisten.', 
                        'icon' => 'target'
                    ],
                    [
                        'text' => 'Meningkatkan kapasitas sumber daya pelaksana penjaminan mutu di tingkat universitas dan prodi.', 
                        'icon' => 'users'
                    ],
                    [
                        'text' => 'Memastikan pemenuhan standar nasional pendidikan tinggi di seluruh unit kerja.', 
                        'icon' => 'check-badge'
                    ],
                    [
                        'text' => 'Mendorong pencapaian akreditasi unggul bagi seluruh program studi.', 
                        'icon' => 'trending-up'
                    ],
                ],
                
                // Struktur Organisasi (Dikosongkan dulu, diisi lewat CMS)
                'org_structure_image' => null,
                
                // Kontak & Sosmed
                'address' => 'Gedung Rektorat Lt. 2, Tambolaka, Sumba Barat Daya',
                'phone' => '+62 812-3456-7890',
                'email' => 'lpm@unmaris.ac.id',
                'social_media' => [
                    [
                        'platform' => 'instagram',
                        'url' => 'https://instagram.com/unmaris'
                    ],
                    [
                        'platform' => 'facebook',
                        'url' => 'https://facebook.com/unmaris'
                    ],
                    [
                        'platform' => 'youtube',
                        'url' => 'https://youtube.com/@unmaris'
                    ]
                ],
            ]
        );
    }
}