<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classmate - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .layout-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen overflow-x-hidden">

    <header class="fixed top-0 left-0 w-full h-16 bg-white border-b border-gray-100 px-6 flex items-center justify-between z-50 shadow-sm">
        <div class="flex items-center space-x-4">
            <button onclick="toggleSidebarLayout()" class="p-2 rounded-xl text-gray-600 hover:bg-gray-50 active:scale-95 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <div class="flex items-center space-x-2 font-bold text-lg">
                <span class="text-blue-600 text-xl">👥</span><span class="tracking-tight text-black">Classmate</span>
            </div>
            <span class="hidden sm:inline-block text-gray-300">|</span>
            <h2 class="hidden sm:inline-block text-sm font-semibold text-gray-500">@yield('page_name')</h2>
        </div>

        <div class="flex items-center space-x-4 relative">
            @yield('navbar_actions')

            <div class="relative inline-block text-left id-nav-plus-container">
                <button onclick="togglePlusMenu(event)" class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-blue-600 bg-gray-50 hover:bg-blue-50 rounded-xl text-xl font-bold transition-all active:scale-95">
                    +
                </button>
                <div id="plus-dropdown" class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 hidden z-50">
                    <button onclick="closePlusMenu(); openModal('modal-gabung')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-gray-50 flex items-center space-x-2">
                        <span>🚪</span> <span>Gabung Kelas</span>
                    </button>
                    <button onclick="closePlusMenu(); openModal('modal-kelas')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-gray-50 flex items-center space-x-2">
                        <span>🏫</span> <span>Buat Kelas Baru</span>
                    </button>
                </div>
            </div>

            <div class="relative id-profile-container">
                <button onclick="toggleProfileDropdown(event)" class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-xs hover:bg-blue-700 transition-colors focus:ring-4 focus:ring-blue-100 active:scale-95">
                    {{ substr(Auth::user()->name ?? 'M', 0, 1) }}
                </button>

                <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 hidden opacity-0 scale-95 origin-top-right transition-all duration-200 z-50">
                    <div class="px-4 py-2 border-b border-gray-50">
                        <p class="text-xs font-black text-gray-900 truncate">{{ Auth::user()->name ?? 'User Classmate' }}</p>
                        <p class="text-[10px] text-gray-400 truncate">{{ Auth::user()->email ?? 'user@classmate.id' }}</p>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2.5 text-xs font-bold text-red-600 hover:bg-red-50/50 transition-colors flex items-center space-x-2 group">
                            <span class="text-sm group-hover:translate-x-0.5 transition-transform">🚪</span>
                            <span>Keluar Aplikasi</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <aside id="sidebar-nav" class="layout-transition fixed left-0 top-16 w-64 h-[calc(100vh-4rem)] bg-white border-r border-gray-100 p-4 z-40 overflow-y-auto transform -translate-x-full md:translate-x-0">
        <nav class="space-y-1">
            <a href="{{ route('dashboard.home') }}" class="flex items-center space-x-3 px-4 py-3 {{ Request::routeIs('dashboard.home') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl transition-all">
                <span class="text-xl">🏠</span><span class="sidebar-label text-sm whitespace-nowrap">Beranda</span>
            </a>
            <a href="{{ route('tugas.index') }}" class="flex items-center space-x-3 px-4 py-3 {{ Request::routeIs('tugas.index') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-500 hover:bg-gray-50' }} rounded-xl transition-all">
                <span class="text-xl">📋</span><span class="sidebar-label text-sm whitespace-nowrap">Daftar Tugas</span>
            </a>
        </nav>
    </aside>

    <main id="main-viewport" class="layout-transition pt-16 md:ml-64 min-h-screen">
        @if($errors->has('join_error'))
            <div class="max-w-6xl mx-auto px-6 mt-6 -mb-2">
                <div class="p-4 bg-red-50 border border-red-100 rounded-2xl text-xs font-bold text-red-600 flex items-center space-x-2">
                    <span>⚠️</span>
                    <span>{{ $errors->first('join_error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @yield('modals')

    <div id="modal-gabung" class="fixed inset-0 z-[100] bg-black/50 backdrop-blur-xs hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl space-y-4 border border-gray-100">
            <h3 class="text-xl font-black text-gray-900 tracking-tight">Gabung Kelas</h3>
            <form action="{{ route('classes.join') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kode Unik Kelas (6 Digit)</label>
                    <input type="text" name="code" required maxlength="6" placeholder="Contoh: aB3xY9" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600 tracking-widest text-center font-bold text-gray-800">
                </div>
                <div class="flex space-x-3">
                    <button type="button" onclick="closeModal('modal-gabung')" class="flex-1 border border-gray-200 text-gray-600 rounded-xl py-3 text-xs font-bold hover:bg-gray-50">Batal</button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white rounded-xl py-3 text-xs font-bold hover:bg-blue-700">Masuk Kelas</button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div id="global-toast" class="fixed bottom-5 right-5 bg-gray-900 text-white text-xs font-bold px-5 py-3.5 rounded-2xl shadow-2xl z-[150] flex items-center space-x-2 border border-gray-800 transition-all duration-300 transform translate-y-0 opacity-100">
        <span class="text-emerald-400">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <script>
        function toggleSidebarLayout() {
            const sidebar = document.getElementById('sidebar-nav');
            const mainViewport = document.getElementById('main-viewport');
            if (window.innerWidth < 768) {
                sidebar.classList.toggle('translate-x-0');
                sidebar.classList.toggle('-translate-x-full');
            } else {
                sidebar.classList.toggle('md:w-20');
                sidebar.classList.toggle('md:w-64');
                mainViewport.classList.toggle('md:ml-20');
                mainViewport.classList.toggle('md:ml-64');
                document.querySelectorAll('.sidebar-label').forEach(l => l.classList.toggle('hidden'));
            }
        }

        function togglePlusMenu(e) {
            e.stopPropagation();
            document.getElementById('plus-dropdown').classList.toggle('hidden');
        }

        function closePlusMenu() {
            document.getElementById('plus-dropdown').classList.add('hidden');
        }

        function toggleProfileDropdown(e) {
            e.stopPropagation();
            const d = document.getElementById('profile-dropdown');
            if (d.classList.contains('hidden')) {
                d.classList.remove('hidden');
                setTimeout(() => d.classList.remove('opacity-0', 'scale-95'), 10);
            } else {
                closeProfileDropdown();
            }
        }

        function closeProfileDropdown() {
            const d = document.getElementById('profile-dropdown');
            d.classList.add('opacity-0', 'scale-95');
            setTimeout(() => d.classList.add('hidden'), 200);
        }

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Global Event Click Dismissal
        window.addEventListener('click', (e) => {
            if (!e.target.closest('.id-profile-container')) closeProfileDropdown();
            if (!e.target.closest('.id-nav-plus-container')) closePlusMenu();
        });

        // Auto-dismiss Toast Logic
        const toast = document.getElementById('global-toast');
        if(toast) {
            setTimeout(() => {
                toast.classList.add('translate-y-4', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
    </script>
</body>
</html>
