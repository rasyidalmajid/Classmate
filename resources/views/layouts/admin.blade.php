<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Area | @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex">
    <aside class="w-64 bg-slate-900 h-screen text-white p-6 sticky top-0">
        <h1 class="text-xl font-black text-blue-400 mb-10">ADMIN SYSTEM</h1>
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block p-3 rounded-lg hover:bg-slate-800">📊 Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="block p-3 rounded-lg hover:bg-slate-800">👥 Kelola User</a>
            <a href="{{ route('admin.classes.index') }}" class="block p-3 rounded-lg hover:bg-slate-800">🏫 Kelola Kelas</a>
            <div class="pt-10">
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="block p-3 rounded-lg text-red-400 hover:bg-red-900/20">← Logout</button>
                </form>
            </div>
        </nav>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        @yield('content')
    </main>
</body>
</html>
