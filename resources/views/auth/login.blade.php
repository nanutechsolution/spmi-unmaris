<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SPMI - Universitas Stella Maris Sumba</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="h-full flex items-center justify-center p-6">

    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl border border-gray-100">
        <!-- Logo & Header -->
        <div class="text-center">
            <div class="mx-auto h-20 w-20 rounded-full flex items-center justify-center mb-4 shadow-lg shadow-blue-200">
                <!-- Placeholder Logo - Ganti dengan asset() logo UNMARIS jika sudah ada -->
                <img src="{{ asset('logo-unmaris.png') }}"
                    alt="Logo UNMARIS"
                    class="h-12 w-12 object-contain">

            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                SPMI UNMARIS
            </h2>
            <p class="mt-2 text-sm text-gray-600 font-medium">
                Sistem Penjaminan Mutu Internal
            </p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        {{ $errors->first() }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Login Form -->
        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">NIM / NIDN</label>
                    <input id="username" name="username" type="text" required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm transition-all"
                        placeholder="Masukkan NIM atau NIDN Anda">
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password SIAKAD</label>
                    <input id="password" name="password" type="password" required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-400 text-gray-900 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm transition-all"
                        placeholder="••••••••">
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-lg shadow-blue-200">
                    Masuk ke Sistem
                </button>
            </div>
        </form>

        <!-- Footer Info -->
        <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">
                Gunakan akun yang terdaftar pada <strong>SIAKAD UNMARIS</strong> untuk masuk.
                <br>Lupa password? Silakan hubungi bagian IT/Akademik.
            </p>
            <p class="mt-8 text-[10px] text-gray-400 uppercase tracking-widest font-bold">
                &copy; {{ date('Y') }} Universitas Stella Maris Sumba
            </p>
        </div>
    </div>

</body>

</html>