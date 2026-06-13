@extends('layouts.app')

@section('title', $class->name)
@section('page_name', 'Mata Kuliah')

@section('content')
<div class="border-b border-gray-200 bg-white sticky top-16 z-20 px-6">
    <div class="max-w-4xl mx-auto flex space-x-8 text-sm font-bold">
        <button onclick="switchSubTab('forum')" id="btn-forum" class="py-4 border-b-2 border-blue-600 text-blue-600">Forum Informasi</button>
        <button onclick="switchSubTab('tugas-kelas')" id="btn-tugas-kelas" class="py-4 border-b-2 border-transparent text-gray-500">Tugas Kelas</button>
        <button onclick="switchSubTab('anggota')" id="btn-anggota" class="py-4 border-b-2 border-transparent text-gray-500">Anggota Kelas</button>
    </div>
</div>

<div class="max-w-4xl mx-auto p-6 space-y-6">

    <div id="class-banner" class="bg-gradient-to-r {{ $class->banner_gradient ?? 'from-blue-600 to-indigo-700' }} rounded-3xl p-6 md:p-8 text-white min-h-[140px] flex flex-col justify-between shadow-xs relative overflow-hidden">
        <div class="absolute right-0 top-0 text-9xl opacity-10 pointer-events-none select-none font-black">CLASS</div>
        <div>
            <span class="text-xs bg-white/20 px-2.5 py-1 rounded-md font-bold tracking-wider uppercase">{{ $class->study_program ?? 'Umum' }}</span>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mt-2">
                <h1 class="text-2xl md:text-3xl font-black tracking-tight">{{ $class->name }}</h1>
                <span class="bg-white/20 text-[10px] font-mono px-2.5 py-1 rounded text-white font-bold tracking-wider self-start md:self-auto">CODE: {{ $class->code }}</span>
            </div>
        </div>
        <p class="text-xs opacity-85 font-medium">Dosen: {{ $class->instructor->name }}</p>
    </div>

    <div id="subcontent-forum" class="space-y-4">
        @if($isInstructor || $isAdmin)
            <div class="flex items-center justify-between bg-white p-4 border border-gray-100 rounded-2xl shadow-xs gap-4">
                <div class="flex items-center space-x-3 flex-1 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-sm flex-shrink-0">💬</div>
                    <span class="text-xs text-gray-400 font-medium truncate">Bagikan pengumuman atau info penting ke mahasiswa...</span>
                </div>
                <button onclick="openModal('modal-pengumuman')" class="bg-gray-900 hover:bg-black text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all active:scale-95 flex-shrink-0">📢 Buat Pengumuman</button>
            </div>
        @endif

        @forelse($class->announcements as $announcement)
            <div class="p-5 bg-white border border-gray-100 rounded-2xl shadow-xs space-y-3">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xs uppercase">
                        {{ substr($class->instructor->name, 0, 2) }}
                    </div>
                    <div>
                        <h5 class="text-xs font-bold text-gray-900">{{ $class->instructor->name }}</h5>
                        <p class="text-[10px] text-gray-400">{{ $announcement->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <p class="text-xs text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $announcement->content }}</p>
            </div>
        @empty
            <div class="text-center py-12 bg-white border border-gray-100 rounded-2xl text-gray-400 text-xs font-medium">
                Belum ada pengumuman disematkan dalam forum ini.
            </div>
        @endforelse
    </div>

    <div id="subcontent-tugas-kelas" class="space-y-4 hidden">
        @if($isInstructor || $isAdmin)
            <div class="flex items-center justify-between bg-white p-4 border border-gray-100 rounded-2xl shadow-xs">
                <span class="text-xs text-gray-400 font-medium">Terbitkan berkas lembar kerja penugasan baru untuk mahasiswa</span>
                <button onclick="openModal('modal-tugas')" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all active:scale-95">📝 Rilis Tugas</button>
            </div>
        @endif

        @forelse($class->tasks as $task)
            <div onclick="window.location.href='{{ route('tasks.show', $task->id) }}'" class="p-4 bg-white border border-gray-100 rounded-2xl hover:border-blue-400 transition-all cursor-pointer flex items-center justify-between shadow-xs group">
                <div class="flex items-center space-x-4 truncate">
                    <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl text-xl font-bold transition-colors group-hover:bg-blue-100">📋</div>
                    <div class="truncate">
                        <h4 class="text-xs font-bold text-gray-900 group-hover:text-blue-600 truncate transition-colors">{{ $task->title }}</h4>
                        <p class="text-[10px] text-gray-400 mt-0.5">Tenggat: {{ $task->deadline->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md shrink-0">Buka ➔</span>
            </div>
        @empty
            <div class="text-center py-12 bg-white border border-gray-100 rounded-2xl text-gray-400 text-xs font-medium">
                Ruang kelas ini belum memiliki lembar penugasan aktif.
            </div>
        @endforelse
    </div>

    <div id="subcontent-anggota" class="hidden bg-white border border-gray-100 rounded-2xl p-6 space-y-6 shadow-xs">
        <div>
            <div class="border-b border-gray-100 pb-2.5 mb-3"><h4 class="text-xs font-bold uppercase tracking-wider text-gray-400">Dosen Pengampu</h4></div>
            <div class="text-xs font-bold text-gray-900 flex items-center space-x-3 py-1">
                <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">👤</div>
                <span>{{ $class->instructor->name }}</span>
            </div>
        </div>

        <div>
            <div class="border-b border-gray-100 pb-2.5 mb-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400">Daftar Mahasiswa ({{ count($class->students) }})</h4>
            </div>
            <div class="space-y-1">
                @forelse($class->students as $student)
                    <div class="flex items-center space-x-3 py-2.5 border-b border-gray-50 last:border-0 text-xs text-gray-700 font-medium">
                        <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] text-gray-400">👤</div>
                        <span>{{ $student->name }}</span>
                    </div>
                @empty
                    <p class="text-[11px] text-gray-400 text-center py-6 font-medium">Belum ada mahasiswa yang masuk atau bergabung menggunakan kode unik.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
@if($isInstructor || $isAdmin)
<div id="modal-pengumuman" class="fixed inset-0 z-[100] bg-black/50 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl space-y-4 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Sematkan Pengumuman Baru</h3>
        <form action="{{ route('announcements.store', $class->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Isi Informasi *</label>
                <textarea name="content" rows="5" required placeholder="Tulis instruksi resmi forum kelas di sini..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-gray-900 resize-none"></textarea>
            </div>
            <div class="flex space-x-3">
                <button type="button" onclick="closeModal('modal-pengumuman')" class="flex-1 border border-gray-200 text-gray-600 rounded-xl py-3 text-xs font-bold hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 bg-gray-900 text-white rounded-xl py-3 text-xs font-bold hover:bg-black">Sematkan</button>
            </div>
        </form>
    </div>
</div>

<div id="modal-tugas" class="fixed inset-0 z-[100] bg-black/50 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl space-y-4 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Rilis Penugasan Baru</h3>
        <form action="{{ route('tasks.store', $class->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Judul Pokok Tugas *</label>
                <input type="text" name="title" required placeholder="Contoh: Implementasi Migrasi Database" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Deskripsi / Detail Aturan Tugas</label>
                <textarea name="description" rows="3" placeholder="Sebutkan langkah dan media pengumpulan berkas..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-600 resize-none"></textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Batas Pengumpulan (Deadline) *</label>
                <input type="datetime-local" name="deadline" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-emerald-600 text-gray-600">
            </div>
            <div class="flex space-x-3">
                <button type="button" onclick="closeModal('modal-tugas')" class="flex-1 border border-gray-200 text-gray-600 rounded-xl py-3 text-xs font-bold hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 bg-emerald-600 text-white rounded-xl py-3 text-xs font-bold hover:bg-emerald-700">Terbitkan Tugas</button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    function switchSubTab(target) {
        ['forum', 'tugas-kelas', 'anggota'].forEach(s => {
            const btn = document.getElementById(`btn-${s}`);
            const content = document.getElementById(`subcontent-${s}`);

            if (s === target) {
                btn.className = "py-4 border-b-2 border-blue-600 text-blue-600";
                content.classList.remove('hidden');
            } else {
                btn.className = "py-4 border-b-2 border-transparent text-gray-500";
                content.classList.add('hidden');
            }
        });

        // Sembunyikan banner utama jika berpindah ke tab Anggota Kelas untuk menghemat ruang
        const banner = document.getElementById('class-banner');
        if (target === 'anggota') {
            banner.classList.add('hidden');
        } else {
            banner.classList.remove('hidden');
        }
    }
</script>
@endsection
