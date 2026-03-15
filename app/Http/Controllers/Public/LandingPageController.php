<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Ami\AmiSchedule;
use App\Models\Ami\Schedule;
use App\Models\Spmi\Standard;
use App\Models\LpmProfile;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class LandingPageController extends Controller
{
    /**
     * Menampilkan halaman landing publik SPMI dengan data dinamis & di-cache.
     */
    public function index()
    {
        // Tentukan durasi cache (contoh: 30 menit). 
        $cacheDuration = now()->addMinutes(30);

        // 1. Mengambil Profil Website (Dengan Caching - V2 untuk bypass cache lama)
        $profile = Cache::remember('public_lpm_profile_v2', $cacheDuration, function () {
            return LpmProfile::first() ?? new LpmProfile([
                'hero_title' => 'Menjamin Mutu Tanpa Kompromi.',
                'hero_description' => 'Sistem Penjaminan Mutu Internal Universitas Stella Maris Sumba.',
                'vision' => 'Visi belum diatur oleh admin.',
                'missions' => [],
                'ppepp_steps' => [],
                'address' => 'Gedung Rektorat Lt. 2, Tambolaka, Sumba Barat Daya',
                'phone' => '+62 812-xxxx-xxxx',
                'email' => 'lpm@unmaris.ac.id',
                'social_media' => [],
                'org_structure_image' => null,
                'hero_image' => null,
            ]);
        });

        // Menyiapkan URL aman untuk gambar agar tidak error 404/403
        $orgStructureUrl = !empty($profile->org_structure_image) ? url('/struktur-organisasi/image') : null;
        $heroImageUrl = !empty($profile->hero_image) ? url('/hero-image/file') : null;

        // 2. Data Statistik (Dengan Caching - V2)
        $stats = Cache::remember('public_spmi_stats_v2', $cacheDuration, function () {
            return [
                'total_standards' => Standard::count() ?: 0,
                'completion_rate' => $this->calculateCompletionRate(),
            ];
        });

        // Format Ulang Sosmed untuk view Blade
        $socials = [];
        if (is_array($profile->social_media)) {
            foreach ($profile->social_media as $social) {
                $socials[$social['platform']] = $social['url'];
            }
        }

        // 3. MENGAMBIL DATA DOKUMEN MUTU (Dengan Caching - V2)
        $publicDocuments = Cache::remember('public_spmi_documents_v2', $cacheDuration, function () {
            $documents = Document::where('status', 'approved')
                ->where(function ($query) {
                    $query->whereNull('valid_until')
                        ->orWhere('valid_until', '>=', now());
                })
                ->latest()
                ->take(6)
                ->get();

            return $documents->map(function ($doc) {
                return [
                    'title' => $doc->title,
                    'description' => 'Kategori: ' . ucfirst($doc->category) . ' | Versi: ' . $doc->version . ' | No: ' . $doc->document_number,
                    'icon' => match (strtolower($doc->category)) {
                        'kebijakan' => 'book-open',
                        'manual' => 'shield-check',
                        'standar' => 'award',
                        'formulir' => 'clipboard-document-list',
                        default => 'file-text'
                    },
                    'color' => match (strtolower($doc->category)) {
                        'kebijakan' => 'blue',
                        'manual' => 'emerald',
                        'standar' => 'amber',
                        'formulir' => 'purple',
                        default => 'slate'
                    },
                    'url' => $doc->file_path ? url('/dokumen/download/' . $doc->id) : '#',
                ];
            })->toArray();
        });

        // 4. Data Akreditasi (Dengan Caching - V2)
        $accreditations = Cache::remember('public_accreditations_v2', $cacheDuration, function () {
            if (Schema::hasTable('accreditations')) {
                return \App\Models\Accreditation::all()->map(function ($acc) {
                    return [
                        'name' => $acc->prodi_name,
                        'level' => $acc->level,
                        'rank' => $acc->rank,
                        'expiry_year' => $acc->expiry_year,
                        'color' => $acc->color,
                        'certificate_url' => $acc->certificate_file ? url('/akreditasi/download/' . $acc->id) : '#',
                    ];
                })->toArray();
            }
            return [];
        });

        // 5. Modul Berita / Pengumuman Terbaru (Dengan Caching - V2)
        $latestNews = Cache::remember('public_latest_news_v2', $cacheDuration, function () {
            // Mengecek apakah tabel posts/berita sudah dibuat
            if (Schema::hasTable('posts')) {
                // Menggunakan scope published() agar mengecek status toggle publikasi DAN tanggal rilis
                return \App\Models\Post::published()
                    ->latest()
                    ->take(3)
                    ->get()
                    ->map(function ($post) {
                        return [
                            'id' => $post->id,
                            'title' => $post->title,
                            'excerpt' => Str::limit(strip_tags($post->content), 100),
                            // Jika ada tgl rilis khusus, pakai itu, jika tidak pakai tgl dibuat
                            'date' => $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y'),
                            'url' => url('/berita/' . $post->slug),
                            'image' => $post->featured_image ? url('/berita/image/' . $post->id) : null,
                        ];
                    })->toArray();
            }
            return [];
        });

        // 6. Langkah Siklus PPEPP
        $ppeppSteps = !empty($profile->ppepp_steps)
            ? $profile->ppepp_steps
            : [
                ['short' => 'P', 'title' => 'Penetapan', 'description' => 'Penyusunan standar mutu universitas.'],
                ['short' => 'P', 'title' => 'Pelaksanaan', 'description' => 'Penerapan standar dalam aktivitas akademik.'],
                ['short' => 'E', 'title' => 'Evaluasi', 'description' => 'Audit Mutu Internal (AMI) secara periodik.'],
                ['short' => 'P', 'title' => 'Pengendalian', 'description' => 'Tinjauan Manajemen untuk perbaikan.'],
                ['short' => 'P', 'title' => 'Peningkatan', 'description' => 'Peningkatan standar mutu ke level baru.'],
            ];

        // Return Data ke View Blade
        return view('public.spmi-landing', [
            'profile' => $profile,
            'orgStructureUrl' => $orgStructureUrl,
            'heroImageUrl' => $heroImageUrl,
            'latestNews' => $latestNews,
            'vision' => $profile->vision,
            'missions' => $profile->missions,
            'heroTitle' => $profile->hero_title,
            'heroDescription' => $profile->hero_description,
            'contact' => [
                'address' => $profile->address,
                'phone' => $profile->phone,
                'email' => $profile->email,
            ],
            'socials' => $socials,
            'stats' => $stats,
            'publicDocuments' => $publicDocuments,
            'accreditations' => $accreditations,
            'ppeppSteps' => $ppeppSteps,
        ]);
    }

    /**
     * Menampilkan halaman baca berita secara penuh
     */
    public function showPost($slug)
    {
        // Cari berita berdasarkan slug yang sudah di-publish
        $post = \App\Models\Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('public.post-show', compact('post'));
    }

    /**
     * Menampilkan gambar thumbnail berita secara aman.
     */
    public function showPostImage($id)
    {
        $post = \App\Models\Post::findOrFail($id);

        if (empty($post->featured_image)) {
            abort(404, 'Gambar berita tidak ditemukan.');
        }

        return $this->serveImageBypass($post->featured_image);
    }

    /**
     * Menampilkan gambar Hero Banner secara aman.
     */
    public function showHeroImage()
    {
        $profile = LpmProfile::first();

        if (!$profile || empty($profile->hero_image)) {
            abort(404, 'Gambar Hero belum diunggah oleh Admin.');
        }

        return $this->serveImageBypass($profile->hero_image);
    }

    /**
     * Menampilkan gambar struktur organisasi secara aman.
     */
    public function showOrgStructureImage()
    {
        $profile = LpmProfile::first();

        if (!$profile || empty($profile->org_structure_image)) {
            abort(404, 'Gambar struktur organisasi belum diunggah oleh Admin.');
        }

        return $this->serveImageBypass($profile->org_structure_image);
    }

    /**
     * Fungsi helper (internal) untuk melayani render gambar
     */
    private function serveImageBypass($rawPath)
    {
        $filePath = str_replace(['public/', 'storage/'], '', $rawPath);

        $disk = 'public';
        if (!Storage::disk($disk)->exists($filePath)) {
            $disk = 'local';
        }

        if (Storage::disk($disk)->exists($filePath)) {
            $file = Storage::disk($disk)->get($filePath);
            $type = Storage::disk($disk)->mimeType($filePath);

            return response($file, 200)->header('Content-Type', $type);
        }

        abort(404, "File fisik gambar tidak ditemukan di server.");
    }

    /**
     * Mengunduh dokumen secara aman
     */
    public function downloadDocument($id)
    {
        $document = Document::where('status', 'approved')->find($id);

        if (!$document) {
            abort(404, 'Data dokumen tidak ditemukan di database atau status belum disetujui (Approved).');
        }

        $filePath = str_replace(['public/', 'storage/'], '', $document->file_path);

        $disk = 'public';
        if (!Storage::disk($disk)->exists($filePath)) {
            $disk = 'local';
        }

        if (Storage::disk($disk)->exists($filePath)) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $cleanFilename = Str::slug($document->document_number . '-' . $document->title) . '.' . ($extension ?: 'pdf');

            return Storage::disk($disk)->download($filePath, $cleanFilename);
        }

        abort(404, "File fisik tidak ditemukan di server pada path: " . $filePath);
    }

    /**
     * Mengunduh sertifikat akreditasi secara aman
     */
    public function downloadAccreditation($id)
    {
        $accreditation = \App\Models\Accreditation::find($id);

        if (!$accreditation || empty($accreditation->certificate_file)) {
            abort(404, 'Data akreditasi tidak ditemukan atau sertifikat belum diunggah.');
        }

        $filePath = str_replace(['public/', 'storage/'], '', $accreditation->certificate_file);

        $disk = 'public';
        if (!Storage::disk($disk)->exists($filePath)) {
            $disk = 'local';
        }

        if (Storage::disk($disk)->exists($filePath)) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $cleanFilename = Str::slug('Sertifikat-' . $accreditation->prodi_name . '-' . $accreditation->rank) . '.' . ($extension ?: 'pdf');

            return Storage::disk($disk)->download($filePath, $cleanFilename);
        }

        abort(404, "File fisik sertifikat tidak ditemukan di server pada path: " . $filePath);
    }

    /**
     * Menghitung persentase penyelesaian audit berdasarkan jadwal (AmiSchedule).
     */
    private function calculateCompletionRate()
    {
        $total = Schedule::count();

        if ($total == 0) return 0;

        $completed = AmiSchedule::where('status', 'completed')->count();

        return round(($completed / $total) * 100);
    }
}
