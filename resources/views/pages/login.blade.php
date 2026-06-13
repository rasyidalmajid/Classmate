<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classmate - Masuk Aplikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white border border-gray-100 rounded-3xl p-6 md:p-8 shadow-xl space-y-6">

        <div class="text-center space-y-2">
            <div class="inline-flex items-center space-x-2 font-bold text-2xl justify-center">
                <span class="text-blue-600 text-3xl">👥</span>
                <span class="tracking-tight text-black">Classmate</span>
            </div>
            <p class="text-xs text-gray-500">Silakan masukkan email dan kata sandi akun Anda.</p>
        </div>

        @if ($errors->any())
        <div class="p-3.5 bg-red-50 border border-red-100 rounded-xl text-xs text-red-600 font-medium">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: rasyid@student.classmate"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-50 transition-all placeholder:text-gray-400">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-50 transition-all placeholder:text-gray-400">
            </div>

            <div class="flex items-center justify-between text-xs font-medium">
                <label class="flex items-center space-x-2 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-50">
                    <span class="text-gray-500">Ingat sesi saya di perangkat ini</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-3.5 rounded-xl transition-all shadow-sm active:scale-95">
                Masuk Ke Dashboard
            </button>
        </form>

        <div class="text-center pt-2 border-t border-gray-50">
            <p class="text-xs text-gray-500">Belum tergabung?
                <a href="{{ route('signup') }}" class="text-blue-600 font-bold hover:underline">Buat akun baru</a>
            </p>
        </div>
    </div>

</body>
</html>
