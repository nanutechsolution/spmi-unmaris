<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->seo_title ?? $post->title }} - LPM UNMARIS</title>
    <meta name="description" content="{{ $post->seo_description ?? $post->excerpt }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        
        /* Styling khusus untuk konten Rich Editor dari Filament */
        .prose h2 { font-size: 1.5rem; font-weight: 800; margin-top: 2rem; margin-bottom: 1rem; color: #0f172a; }
        .prose h3 { font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 0.75rem; color: #1e293b; }
        .prose p { margin-bottom: 1.25rem; color: #475569; line-height: 1.8; }
        .prose ul { list-style-type: disc; margin-left: 1.5rem; margin-bottom: 1.25rem; color: #475569; }
        .prose ol { list-style-type: decimal; margin-left: 1.5rem; margin-bottom: 1.25rem; color: #475569; }
        .prose a { color: #2563eb; text-decoration: underline; font-weight: 600; }
        .prose img { border-radius: 1.5rem; margin-top: 2rem; margin-bottom: 2rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); width: 100%; height: auto; }
        .prose blockquote { border-left: 4px solid #3b82f6; padding-left: 1rem; font-style: italic; color: #64748b; margin-bottom: 1.25rem; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <!-- NAVIGATION BAR KECIL -->
    <nav class="glass sticky top-0 z-50 border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <a href="{{ route('landing') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-blue-200">
                        <i data-lucide="arrow-left" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h1 class="text-sm font-black leading-none tracking-tight">Kembali ke Beranda</h1>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">LPM UNMARIS</p>
                    </div>
                </a>
            </div>
        </div>
    </nav>

    <!-- HEADER BERITA -->
    <header class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-8 text-center sm:text-left">
        <div class="mb-6 flex flex-wrap justify-center sm:justify-start items-center gap-3 text-xs font-black text-blue-600 uppercase tracking-widest">
            <span class="bg-blue-100 px-3 py-1 rounded-full">
                {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
            </span>
            <span class="text-slate-400">&bull;</span>
            <span class="text-slate-500 flex items-center gap-1">
                <i data-lucide="user" class="w-4 h-4"></i> {{ $post->author->name ?? 'Admin' }}
            </span>
        </div>
        
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 leading-[1.2] mb-10 tracking-tight">
            {{ $post->title }}
        </h1>
        
        @if($post->featured_image)
            <!-- MENGGUNAKAN URL BYPASS AGAR GAMBAR MUNCUL -->
            <img src="{{ url('/berita/image/' . $post->id) }}" alt="{{ $post->title }}" class="w-full h-[300px] sm:h-[450px] object-cover rounded-[2.5rem] shadow-xl mb-12 border border-slate-100">
        @endif
    </header>

    <!-- ISI KONTEN BERITA -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <article class="prose w-full text-lg">
            {!! $post->content !!}
        </article>

        <!-- FOOTER ARTIKEL -->
        <div class="mt-20 pt-10 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-6">
            <div class="text-sm text-slate-500 font-medium text-center sm:text-left">
                Bagikan informasi ini ke rekan Anda.
            </div>
            <div class="flex gap-4">
                <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link disalin!');" class="w-12 h-12 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all shadow-sm">
                    <i data-lucide="link" class="w-5 h-5"></i>
                </button>
                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url()->current()) }}" target="_blank" class="w-12 h-12 bg-[#25D366] text-white rounded-full flex items-center justify-center hover:bg-[#128C7E] transition-all shadow-lg shadow-green-200">
                    <i data-lucide="message-circle" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>