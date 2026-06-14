<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classmate - Autentikasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

@php
    // Deteksi akurat: Apakah user sedang berada di fase Signup?
    $isSignupState = session('open_signup') || $errors->has('name') || $errors->has('password_confirmation') || old('name');
@endphp

<body class="bg-gray-50 font-sans antialiased min-h-screen flex items-center justify-center p-4">

    <div id="auth-card" class="bg-white rounded-[2rem] shadow-2xl overflow-hidden w-full max-w-5xl min-h-[650px] grid grid-cols-1 md:grid-cols-2 transition-all duration-500">

        <div id="form-section" class="p-8 md:p-12 flex flex-col justify-center transition-all duration-500 {{ $isSignupState ? 'md:order-2' : 'order-1' }}">

            <div id="signin-view" class="space-y-6 {{ $isSignupState ? 'hidden' : '' }}">
                <div class="space-y-2">
                    <h2 class="text-4xl md:text-5xl font-black text-black tracking-tight">Sign in</h2>
                    <p class="text-xs text-gray-400 font-medium">Selamat datang kembali! Masuk untuk memantau tugas kuliah.</p>
                </div>

                @if ($errors->any() && !$isSignupState)
                <div id="signin-errors" class="p-3.5 bg-red-50 border border-red-100 rounded-2xl text-xs text-red-600 font-medium">
                    {{ $errors->first() }}
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan Email"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-600 focus:outline-none text-sm transition-all placeholder:text-gray-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password" id="signin-password" name="password" required placeholder="Masukkan Password"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-600 focus:outline-none text-sm transition-all placeholder:text-gray-400">
                            <button type="button" onclick="togglePassword('signin-password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black transition-colors focus:outline-none">
                                👁️
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center text-xs font-medium pt-1">
                        <label class="flex items-center space-x-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-[#000d8a] border-gray-300 rounded focus:ring-blue-100">
                            <span class="text-gray-500">Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-[#000d8a] text-white py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-blue-900 active:scale-[0.98] transition-all shadow-md shadow-blue-900/10">
                        Sign In
                    </button>
                </form>
                <p class="text-center text-xs text-gray-500 font-medium">Don't have an account? <button onclick="switchState('signup')" class="text-blue-800 font-bold hover:underline focus:outline-none">Sign Up</button></p>
            </div>

            <div id="signup-view" class="space-y-6 {{ $isSignupState ? '' : 'hidden' }}">
                <div class="space-y-2">
                    <h2 class="text-4xl md:text-5xl font-black text-black tracking-tight">Sign Up</h2>
                    <p class="text-xs text-gray-400 font-medium">Buat akun akademismu untuk mulai bergabung ke kelas.</p>
                </div>

                @if ($errors->any() && $isSignupState)
                <div id="signup-errors" class="p-3.5 bg-red-50 border border-red-100 rounded-2xl text-xs text-red-600 font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form action="{{ route('signup') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Username / Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan Username"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-600 focus:outline-none text-sm transition-all placeholder:text-gray-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan Email"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-600 focus:outline-none text-sm transition-all placeholder:text-gray-400">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password" id="signup-password" name="password" required placeholder="Masukkan Password"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-600 focus:outline-none text-sm transition-all placeholder:text-gray-400">
                            <button type="button" onclick="togglePassword('signup-password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black transition-colors focus:outline-none">
                                👁️
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                        <input type="password" id="signup-password-conf" name="password_confirmation" required placeholder="Ulangi Password"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-600 focus:outline-none text-sm transition-all placeholder:text-gray-400">
                    </div>

                    <button type="submit" class="w-full bg-[#000d8a] text-white py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider hover:bg-blue-900 active:scale-[0.98] transition-all shadow-md shadow-blue-900/10 pt-2">
                        Sign Up
                    </button>
                </form>
                <p class="text-center text-xs text-gray-500 font-medium">Already have an account? <button onclick="switchState('signin')" class="text-blue-800 font-bold hover:underline focus:outline-none">Sign In</button></p>
            </div>
        </div>

        <div id="banner-section" class="bg-[#000d8a] p-8 md:p-12 flex flex-col justify-center items-center text-white text-center transition-all duration-500 relative overflow-hidden {{ $isSignupState ? 'md:order-1' : 'order-2' }}">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.08),transparent)] pointer-events-none"></div>

            <div class="max-w-sm space-y-4 relative z-10">
                <div class="flex items-center justify-center space-x-2 text-sm font-black tracking-widest uppercase opacity-90">
                    <span class="text-xl">👥</span>
                    <span>Classmate</span>
                </div>
                <h1 id="banner-title" class="text-4xl md:text-5xl font-black tracking-widest leading-tight uppercase">
                    {{ $isSignupState ? 'WELCOME' : 'WELCOME BACK' }}
                </h1>
                <div class="w-12 h-1 bg-white/20 mx-auto rounded-full"></div>
                <p class="text-xs opacity-75 font-light leading-relaxed max-w-xs mx-auto">
                    Kelola tugas kuliah, kumpulkan informasi materi, dan pantau progres akademik dengan ruang kelas terintegrasi.
                </p>
            </div>
        </div>

    </div>

    <script>
        function switchState(state) {
            const signinView = document.getElementById('signin-view');
            const signupView = document.getElementById('signup-view');
            const bannerTitle = document.getElementById('banner-title');
            const formSection = document.getElementById('form-section');
            const bannerSection = document.getElementById('banner-section');

            // Elemen Notifikasi Error
            const signinErrors = document.getElementById('signin-errors');
            const signupErrors = document.getElementById('signup-errors');

            // Helper untuk mengosongkan input form (mengabaikan token CSRF)
            const resetFormFields = (viewElement) => {
                const inputs = viewElement.querySelectorAll('input:not([name="_token"])');
                inputs.forEach(input => {
                    if (input.type === 'checkbox') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
            };

            // Reset error dari kedua tampilan ketika berpindah
            if (signinErrors) signinErrors.classList.add('hidden');
            if (signupErrors) signupErrors.classList.add('hidden');

            if (state === 'signup') {
                signinView.classList.add('hidden');
                signupView.classList.remove('hidden');
                bannerTitle.innerText = "WELCOME";
                formSection.classList.remove('order-1');
                formSection.classList.add('md:order-2');
                bannerSection.classList.remove('order-2');
                bannerSection.classList.add('md:order-1');

                // Kosongkan form Sign In karena user pindah ke Sign Up
                resetFormFields(signinView);
            } else {
                signupView.classList.add('hidden');
                signinView.classList.remove('hidden');
                bannerTitle.innerText = "WELCOME BACK";
                formSection.classList.remove('md:order-2');
                formSection.classList.add('order-1');
                bannerSection.classList.remove('md:order-1');
                bannerSection.classList.add('order-2');

                // Kosongkan form Sign Up karena user pindah ke Sign In
                resetFormFields(signupView);
            }
        }

        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
