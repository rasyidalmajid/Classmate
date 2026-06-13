@extends('layouts.app')

@section('title', $class->name)
@section('page_name', 'Mata Kuliah')

@section('content')
<div class="border-b border-gray-200 bg-white sticky top-16 z-20 px-6">
    <div class="max-w-4xl mx-auto flex space-x-8 text-sm font-bold">
        <button onclick="switchSubTab('forum')" id="btn-forum" class="py-4 border-b-2 border-blue-600 text-blue-600">Forum Informasi</button>
        <button onclick="switchSubTab('tugas-kelas')" id="btn-tugas-kelas" class="py-4 border-b-2 border-transparent text-gray-500">Tugas Kelas</button>
        <button onclick="switchSubTab('anggota')" id="btn-anggota" class="py-4 border-b-2 border-transparent text-gray-500">Anggota</button>
    </div>
</div>

<div class="max-w-4xl mx-auto p-6 space-y-6">

    <div id="class-banner" class="bg-gradient-to-r {{ $class->banner_gradient }} rounded-3xl p-6 md:p-8 text-white min-h-[140px] flex flex-col justify-between shadow-xs relative overflow-hidden">
        <div class="absolute right-0 top-0 text-9xl opacity-10 pointer-events-none select-none font-black">CLASS</div>
        <div>
            <span class="text-xs bg-white/20 px-2.5 py-1 rounded-md font-bold tracking-wider uppercase">{{ $class->study_program ?? 'Umum' }}</span>
            <h1 class="text-2xl md:text-3xl font-black tracking-tight mt-2">{{ $class->name }}</h1>
        </div>
        <p class="text-xs opacity-85 font-medium">Dosen: {{ $class->instructor_name }}</p>
    </div>

    <div id="subcontent-forum" class="space-y-4">
        <div class="flex items-center justify-between bg-white p-4 border border-gray-100 rounded-2xl shadow-xs gap-4">
            <div class="flex items-center space-x-3 flex-1 min-w-0">
                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-sm flex-shrink-0">💬</div>
                <span class="text-xs text-gray-400 font-medium truncate">Bagikan pengumuman atau info penting ke mahasiswa...</span>
            </div>
            <button onclick="openModal('modal-pengumuman')" class="bg-gray-900 hover:bg-black text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all active:scale-95 flex-shrink-0">📢 Buat Pengumuman</button>
        </div>

        @forelse($class->announcements as $announcement)
        <div class="p-5 bg-white border border-gray-100 rounded-2xl shadow-xs space-y-3">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xs uppercase">
                    {{ substr($class->instructor_name, 0, 2) }}
                </div>
                <div>
                    <h5 class="text-xs font-bold text-gray-900">{{ $class->instructor_name }}</h5>
                    <p class="text-[10px] text-gray-400">{{ $announcement->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $announcement->content }}</p>
        </div>
        @empty
        <div class="text-center py-12 bg-white border border-gray-100 rounded-2xl text-gray-400 text-xs">
            Belum ada pengumuman disematkan dalam forum ini.
        </div>
        @endforelse
    </div>

    <div id="subcontent-tugas-kelas" class="space-y-4 hidden">
        <div class="flex items-center justify-between bg-white p-4 border border-gray-100 rounded-2xl shadow-xs">
            <span class="text-xs text-gray-400 font-medium">Terbitkan berkas lembar kerja penugasan baru</span>
            <button onclick="openModal('modal-tugas')" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all active:scale-95">📝 Rilis Tugas</button>
        </div>

        @forelse($class->tasks as $task)
        <div onclick="window.location.href='{{ route('tasks.show', $task->id) }}'" class="p-4 bg-white border border-gray-100 rounded-2xl hover:border-emerald-200 transition-all cursor-pointer flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="p-2.5 {{ $task->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : 'bg-blue-50 text-blue-600' }} rounded-xl text-xl font-bold">📋</div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900">{{ $task->title }}</h4>
                    <p class="text-[11px] text-gray-400 mt-0.5">Tenggat: {{ $task->deadline->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
            </div>
            <span class="text-[10px] font-bold uppercase px-2.5 py-1 rounded-md {{ $task->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                {{ $task->status === 'completed' ? 'Selesai' : 'Aktif' }}
            </span>
        </div>
        @empty
        <div class="text-center py-12 bg-white border border-gray-100 rounded-2xl text-gray-400 text-xs">
            Ruang kelas ini belum memiliki lembar penugasan.
        </div>
        @endforelse
    </div>

    <div id="subcontent-anggota" class="hidden bg-white p-6 border border-gray-100 rounded-2xl space-y-4">
        <div class="border-b border-gray-100 pb-2"><h4 class="text-sm font-bold text-gray-900">Pengajar / Pengampu Utama</h4></div>
        <div class="text-xs font-bold text-blue-600 flex items-center space-x-2"><span>👨‍🏫</span> <span>{{ $class->instructor_name }}</span></div>
    </div>
</div>
@endsection

@section('modals')
<div id="modal-pengumuman" class="fixed inset-0 z-[100] bg-black/50 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl space-y-4 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Sematkan Pengumuman Baru</h3>
        <form action="{{ route('announcements.store', $class->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Isi Informasi *</label>
                <textarea name="content" rows="5" required placeholder="Tulis instruksi resmi forum kelas di sini..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gray-900"></textarea>
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
                <input type="text" name="title" required placeholder="Contoh: Implementasi Migrasi Database" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Deskripsi / Detail Aturan Tugas</label>
                <textarea name="description" rows="3" placeholder="Sebutkan langkah dan media pengumpulan berkas..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-600"></textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Batas Pengumpulan (Deadline) *</label>
                <input type="datetime-local" name="deadline" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-600 text-gray-600">
            </div>
            <div class="flex space-x-3">
                <button type="button" onclick="closeModal('modal-tugas')" class="flex-1 border border-gray-200 text-gray-600 rounded-xl py-3 text-xs font-bold hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 bg-emerald-600 text-white rounded-xl py-3 text-xs font-bold hover:bg-emerald-700">Terbitkan Tugas</button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchSubTab(target) {
        ['forum', 'tugas-kelas', 'anggota'].forEach(s => {
            document.getElementById(`btn-${s}`).className = s === target ? "py-4 border-b-2 border-blue-600 text-blue-600" : "py-4 border-b-2 border-transparent text-gray-500";
            if(s === target) document.getElementById(`subcontent-${s}`).classList.remove('hidden');
            else document.getElementById(`subcontent-${s}`).classList.add('hidden');
        });
        if(target !== 'forum') document.getElementById('class-banner').classList.add('hidden');
        else document.getElementById('class-banner').classList.remove('hidden');
    }
</script>
@endsection
