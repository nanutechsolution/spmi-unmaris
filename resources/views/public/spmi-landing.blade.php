<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->hero_title ?? 'LPM UNMARIS - Lembaga Penjaminan Mutu' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 overflow-x-hidden">

    <!-- --- NAVIGATION --- -->
    <nav class="glass sticky top-0 z-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-blue-200">U</div>
                    <div>
                        <h1 class="text-lg font-black leading-none tracking-tight">LPM UNMARIS</h1>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Penjaminan Mutu Internal</p>
                    </div>
                </div>

                <div class="hidden lg:flex items-center gap-8">
                    <a href="#beranda" class="text-sm font-semibold hover:text-blue-600 transition-colors">Beranda</a>
                    <a href="#visimisi" class="text-sm font-semibold hover:text-blue-600 transition-colors">Visi Misi</a>
                    @if(!empty($profile->org_structure_image))
                        <a href="#struktur" class="text-sm font-semibold hover:text-blue-600 transition-colors">Struktur</a>
                    @endif
                    <a href="#dokumen" class="text-sm font-semibold hover:text-blue-600 transition-colors">Dokumen Mutu</a>
                    <a href="#akreditasi" class="text-sm font-semibold hover:text-blue-600 transition-colors">Akreditasi</a>
                    @if(!empty($latestNews))
                        <a href="#berita" class="text-sm font-semibold hover:text-blue-600 transition-colors">Berita</a>
                    @endif
                    <a href="#siklus" class="text-sm font-semibold hover:text-blue-600 transition-colors">Siklus PPEPP</a>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all flex items-center gap-2">
                        Portal Civitas <i data-lucide="external-link" class="w-4 h-4"></i>
                    </a>
                </div>

                <button class="lg:hidden p-2 text-slate-600">
                    <i data-lucide="menu"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- --- HERO SECTION --- -->
    <section id="beranda" class="relative pt-12 pb-20 lg:pt-24 lg:pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <span class="inline-block py-1.5 px-4 rounded-full bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-widest mb-6 border border-blue-200">
                        Official Quality Portal
                    </span>
                    <h2 class="text-4xl lg:text-6xl font-extrabold text-slate-900 leading-[1.1] mb-6">
                        {{ $heroTitle ?? 'Menjamin Mutu Tanpa Kompromi.' }}
                    </h2>
                    <p class="text-lg text-slate-500 mb-10 leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium">
                        {{ $heroDescription ?? 'Lembaga Penjaminan Mutu berkomitmen mengawal standar pendidikan melalui siklus PPEPP yang sistematis.' }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#dokumen" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold shadow-xl hover:bg-slate-800 transition-all flex items-center justify-center gap-3">
                            <i data-lucide="file-text" class="w-5 h-5"></i> Lihat Dokumen Mutu
                        </a>
                        <a href="#akreditasi" class="px-8 py-4 bg-white border border-slate-200 text-slate-700 rounded-2xl font-bold shadow-sm hover:bg-slate-50 transition-all flex items-center justify-center gap-3">
                            <i data-lucide="award" class="w-5 h-5"></i> Cek Akreditasi
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute -top-10 -left-10 w-64 h-64 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
                    <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-amber-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
                    
                    <div class="relative bg-white p-4 rounded-[3rem] shadow-2xl border border-slate-100">
                        <img 
                            src="{{ $heroImageUrl ?? 'https://images.unsplash.com/photo-1541339907198-e08756ebafe1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80' }}" 
                            alt="Kampus UNMARIS" 
                            class="rounded-[2.5rem] w-full h-[400px] object-cover mb-6 shadow-inner"
                        >
                        <div class="grid grid-cols-2 gap-4 p-2">
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-4">
                                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white">
                                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <div class="text-xl font-bold text-slate-900">{{ $stats['total_standards'] ?? '0' }}</div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Standar Mutu</div>
                                </div>
                            </div>
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex items-center gap-4">
                                <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white">
                                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <div class="text-xl font-bold text-slate-900">{{ $stats['completion_rate'] ?? '0' }}%</div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Tersiklus</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- --- VISI MISI SECTION --- -->
    <section id="visimisi" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-start">
                <div class="p-10 bg-white rounded-[3rem] shadow-xl shadow-blue-50 border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-[100px] -mr-10 -mt-10"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white mb-8">
                            <i data-lucide="sparkles" class="w-7 h-7"></i>
                        </div>
                        <h3 class="text-3xl font-black text-slate-900 mb-6 tracking-tight">Visi LPM</h3>
                        <p class="text-xl text-slate-600 leading-relaxed font-medium italic">
                            "{{ $vision ?? 'Visi belum diatur oleh admin.' }}"
                        </p>
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-3xl font-black text-slate-900 mb-8 tracking-tight">Misi Utama Kami</h3>
                    @forelse($missions ?? [] as $m)
                    <div class="flex gap-6 p-6 bg-white rounded-2xl border border-slate-100 hover:border-blue-200 transition-all group">
                        <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-600 transition-all shrink-0">
                            <i data-lucide="{{ $m['icon'] ?? 'check-circle' }}" class="w-5 h-5"></i>
                        </div>
                        <p class="text-slate-600 font-medium leading-relaxed">{{ $m['text'] ?? $m }}</p>
                    </div>
                    @empty
                        <p class="text-slate-400 italic">Misi belum ditambahkan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- --- STRUKTUR ORGANISASI SECTION --- -->
    @if(!empty($profile->org_structure_image))
    <section id="struktur" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h3 class="text-3xl font-extrabold text-slate-900 mb-4 tracking-tight">Struktur Organisasi</h3>
                <p class="text-slate-500 font-medium">Bagan susunan kepengurusan Lembaga Penjaminan Mutu (LPM).</p>
            </div>
            <div class="bg-slate-50 p-6 md:p-10 rounded-[3rem] shadow-inner border border-slate-100 flex justify-center">
                <img src="{{ $orgStructureUrl }}" alt="Struktur Organisasi LPM" class="max-w-full h-auto rounded-[2rem] shadow-md">
            </div>
        </div>
    </section>
    @endif

    <!-- --- DOKUMEN MUTU --- -->
    <section id="dokumen" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h3 class="text-3xl font-extrabold text-slate-900 mb-4 tracking-tight">Pengendalian Dokumen Mutu</h3>
                <p class="text-slate-500 font-medium">Akses transparansi dokumen penjaminan mutu yang telah disetujui dan berlaku saat ini.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse($publicDocuments ?? [] as $doc)
                <div class="group p-8 bg-white rounded-[2.5rem] border border-transparent hover:border-{{ $doc['color'] ?? 'blue' }}-200 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center mb-8 shadow-sm group-hover:bg-{{ $doc['color'] ?? 'blue' }}-600 group-hover:text-white transition-all duration-500">
                            <i data-lucide="{{ $doc['icon'] ?? 'file-text' }}" class="w-6 h-6"></i>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-3">{{ $doc['title'] }}</h4>
                        <p class="text-sm text-slate-500 mb-8 leading-relaxed font-medium">{{ $doc['description'] ?? '' }}</p>
                    </div>
                    <a href="{{ $doc['url'] ?? '#' }}" class="flex items-center gap-2 text-xs font-bold text-{{ $doc['color'] ?? 'blue' }}-600 uppercase tracking-widest group-hover:gap-3 transition-all mt-auto">
                        Unduh Dokumen <i data-lucide="download" class="w-4 h-4"></i>
                    </a>
                </div>
                @empty
                    <div class="col-span-3 text-center py-10 text-slate-400">Belum ada dokumen publik yang tersedia.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- --- AKREDITASI --- -->
    <section id="akreditasi" class="py-24 bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div>
                    <h3 class="text-3xl font-extrabold text-white mb-4">Status Akreditasi Nasional</h3>
                    <p class="text-slate-400 font-medium">Pemantauan berkala status akreditasi BAN-PT dan Lembaga Akreditasi Mandiri.</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-slate-500 uppercase">Update Terakhir</p>
                        <p class="text-sm font-bold text-blue-400">{{ date('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 backdrop-blur-xl rounded-[2.5rem] border border-white/10 overflow-hidden">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Program Studi</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Peringkat</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400">Masa Berlaku</th>
                            <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Sertifikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse($accreditations ?? [] as $item)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="font-bold text-white text-lg">{{ $item['name'] }}</div>
                                <div class="text-[10px] font-bold text-slate-500 uppercase mt-1">{{ $item['level'] ?? 'Strata Satu (S1)' }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-{{ $item['color'] ?? 'blue' }}-500/20 text-{{ $item['color'] ?? 'blue' }}-400 border border-{{ $item['color'] ?? 'blue' }}-500/30">
                                    {{ $item['rank'] }}
                                </span>
                            </td>
                            <td class="px-8 py-6 font-mono text-sm text-slate-400 font-bold">{{ $item['expiry_year'] }}</td>
                            <td class="px-8 py-6 text-center">
                                <a href="{{ $item['certificate_url'] ?? '#' }}" class="text-slate-500 hover:text-white transition-colors block">
                                    <i data-lucide="external-link" class="w-5 h-5 mx-auto"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-10 text-center text-slate-500 italic">Data akreditasi belum tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- --- BERITA & PENGUMUMAN SECTION --- -->
    @if(!empty($latestNews))
    <section id="berita" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-900 mb-4 tracking-tight">Berita & Pengumuman</h3>
                    <p class="text-slate-500 font-medium">Informasi terbaru seputar kegiatan penjaminan mutu universitas.</p>
                </div>
                <a href="#" class="text-blue-600 font-bold hover:text-blue-700 flex items-center gap-2 transition-colors">
                    Lihat Semua Berita <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($latestNews as $news)
                <div class="bg-slate-50 rounded-[2rem] overflow-hidden shadow-sm border border-slate-100 hover:shadow-xl transition-all group flex flex-col">
                    <!-- Thumbnail Berita -->
                    <a href="{{ $news['url'] }}" class="block h-48 overflow-hidden relative bg-slate-200">
                        @if($news['image'])
                            <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center group-hover:scale-105 transition-transform duration-500">
                                <i data-lucide="newspaper" class="w-12 h-12 text-blue-200"></i>
                            </div>
                        @endif
                    </a>

                    <div class="p-8 flex-grow flex flex-col">
                        <div class="text-xs font-bold text-blue-600 mb-4 tracking-widest uppercase">{{ $news['date'] }}</div>
                        <h4 class="text-xl font-bold text-slate-900 mb-4 group-hover:text-blue-600 transition-colors line-clamp-2">
                            <a href="{{ $news['url'] }}">{{ $news['title'] }}</a>
                        </h4>
                        <p class="text-slate-500 text-sm leading-relaxed mb-8 line-clamp-3">
                            {{ $news['excerpt'] }}
                        </p>
                        <a href="{{ $news['url'] }}" class="mt-auto inline-flex items-center gap-2 text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                            Baca Selengkapnya <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- --- SIKLUS PPEPP --- -->
    <section id="siklus" class="py-24 {{ !empty($latestNews) ? 'bg-slate-50' : 'bg-white' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h3 class="text-4xl font-extrabold text-slate-900 mb-8 leading-tight">Implementasi Budaya Mutu <br><span class="text-blue-600">Siklus PPEPP</span></h3>
                    <p class="text-lg text-slate-500 mb-12 font-medium leading-relaxed">Sistem penjaminan mutu internal kami dijalankan secara berkelanjutan untuk memastikan peningkatan kualitas di setiap aspek.</p>
                    
                    <div class="space-y-8">
                        @forelse($ppeppSteps ?? [] as $step)
                        <div class="flex gap-6 group">
                            <div class="w-12 h-12 bg-white border-2 border-slate-200 rounded-2xl flex items-center justify-center text-blue-600 font-black shadow-sm group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all duration-300 shrink-0">
                                {{ $step['short'] }}
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900 mb-1">{{ $step['title'] }}</h4>
                                <p class="text-sm text-slate-400 font-medium leading-relaxed">{{ $step['description'] }}</p>
                            </div>
                        </div>
                        @empty
                            <p class="text-slate-400 italic">Data siklus belum dikonfigurasi.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-blue-600 rounded-[3rem] p-12 text-white shadow-2xl shadow-blue-200 relative overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                    <i data-lucide="sparkles" class="w-16 h-16 text-white/20 mb-8"></i>
                    <h4 class="text-3xl font-extrabold mb-6 leading-tight">Laporkan Keluhan & <br>Saran Perbaikan Mutu</h4>
                    <p class="text-blue-100 mb-10 text-lg font-medium leading-relaxed">Portal survei kami terbuka untuk mahasiswa, dosen, dan mitra untuk memberikan feedback demi kemajuan UNMARIS.</p>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-3 bg-white text-blue-600 px-8 py-4 rounded-2xl font-bold hover:bg-blue-50 transition-all shadow-xl">
                        Akses Portal Survei <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- --- FOOTER --- -->
    <footer class="bg-white border-t border-slate-200 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold">U</div>
                        <h1 class="text-xl font-black">LPM UNMARIS</h1>
                    </div>
                    <p class="text-slate-500 max-w-sm mb-8 font-medium">Lembaga Penjaminan Mutu Universitas Stella Maris Sumba. Berkomitmen pada transparansi dan peningkatan mutu berkelanjutan.</p>
                    <div class="flex gap-4">
                        @if(isset($socials['instagram']))
                            <a href="{{ $socials['instagram'] }}" class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all"><i data-lucide="instagram" class="w-5 h-5"></i></a>
                        @endif
                        @if(isset($socials['facebook']))
                            <a href="{{ $socials['facebook'] }}" class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all"><i data-lucide="facebook" class="w-5 h-5"></i></a>
                        @endif
                        @if(isset($contact['email']))
                            <a href="mailto:{{ $contact['email'] }}" class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-all"><i data-lucide="mail" class="w-5 h-5"></i></a>
                        @endif
                    </div>
                </div>
                <div>
                    <h5 class="font-bold text-slate-900 mb-6">Tautan Cepat</h5>
                    <ul class="space-y-4 text-sm text-slate-500 font-medium">
                        @if(!empty($profile->org_structure_image))
                            <li><a href="#struktur" class="hover:text-blue-600 transition-colors">Struktur Organisasi</a></li>
                        @endif
                        <li><a href="#dokumen" class="hover:text-blue-600 transition-colors">Dokumen Mutu</a></li>
                        <li><a href="#akreditasi" class="hover:text-blue-600 transition-colors">Status Akreditasi</a></li>
                        @if(!empty($latestNews))
                            <li><a href="#berita" class="hover:text-blue-600 transition-colors">Berita Terkini</a></li>
                        @endif
                        <li><a href="#siklus" class="hover:text-blue-600 transition-colors">Siklus PPEPP</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-blue-600 transition-colors">Portal Civitas</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold text-slate-900 mb-6">Kontak Kami</h5>
                    <ul class="space-y-4 text-sm text-slate-500 font-medium">
                        <li class="flex gap-3"><i data-lucide="map-pin" class="w-5 h-5 text-blue-600 shrink-0"></i> {{ $contact['address'] ?? 'Gedung Rektorat Lt. 2, Tambolaka, Sumba Barat Daya' }}</li>
                        <li class="flex gap-3"><i data-lucide="phone" class="w-5 h-5 text-blue-600 shrink-0"></i> {{ $contact['phone'] ?? '+62 812-xxxx-xxxx' }}</li>
                    </ul>
                </div>
            </div>
            <div class="pt-10 border-t border-slate-100 text-center">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">&copy; {{ date('Y') }} Universitas Stella Maris Sumba. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>