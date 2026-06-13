@extends('layouts.app')

@section('title', 'Beranda Utama')

@section('content')
<section class="max-w-6xl mx-auto px-6 space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Ruang Kelas Anda</h1>
            <p class="text-xs text-gray-400 mt-0.5 font-medium">Pantau aktivitas pengajaran dan tugas kuliah Anda di sini.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($classes as $class)
            <div onclick="window.location.href='{{ route('classes.show', $class->id) }}'" class="group bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden cursor-pointer hover:shadow-md transition-all duration-300">
                <div class="bg-gradient-to-br {{ $class->banner_gradient ?? 'from-blue-600 to-indigo-700' }} p-5 text-white relative min-h-[125px] flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold truncate tracking-tight group-hover:underline">{{ $class->name }}</h3>
                        <p class="text-xs opacity-85 mt-0.5 truncate font-medium">{{ $class->study_program }}</p>
                    </div>
                    <div class="flex justify-between items-center w-full mt-4">
                        <p class="text-xs opacity-75 truncate max-w-[180px]">Dosen: {{ $class->instructor->name }}</p>
                        <span class="bg-white/20 text-[10px] font-mono px-2 py-0.5 rounded text-white font-bold tracking-wider">CODE: {{ $class->code }}</span>
                    </div>
                </div>
                <div class="p-4 bg-white text-[11px] text-gray-400 font-bold flex justify-between items-center">
                    <span>Lihat aktivitas kelas</span>
                    <span class="text-gray-300 group-hover:text-gray-600 transition-colors">➔</span>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-gray-100 rounded-2xl p-12 text-center text-gray-400 space-y-2">
                <span class="text-3xl block">🏫</span>
                <p class="text-xs font-bold">Belum bergabung atau membuat kelas apapun.</p>
                <p class="text-[11px] text-gray-400">Silakan klik tombol "+" di kanan atas untuk membuat atau masuk ke dalam kelas.</p>
            </div>
        @endforelse
    </div>
</section>
@endsection

@section('modals')
<div id="modal-kelas" class="fixed inset-0 z-[100] bg-black/50 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl space-y-4 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Buat Kelas Baru</h3>
        <form action="{{ route('classes.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Mata Kuliah / Kelas</label>
                <input type="text" name="name" required placeholder="Contoh: Pemrograman Web" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:border-blue-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Program Studi</label>
                <input type="text" name="study_program" placeholder="Contoh: Teknik Informatika" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-xs focus:outline-none focus:border-blue-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Pengajar</label>
                <p class="text-xs font-bold text-gray-800 bg-gray-50 px-4 py-3 rounded-xl border border-gray-100">👤 {{ auth()->user()->name }} (Otomatis)</p>
            </div>
            <div class="flex space-x-3 pt-2">
                <button type="button" onclick="closeModal('modal-kelas')" class="flex-1 border border-gray-200 text-gray-600 rounded-xl py-3 text-xs font-bold hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 bg-blue-600 text-white rounded-xl py-3 text-xs font-bold hover:bg-blue-700">Buat Kelas</button>
            </div>
        </form>
    </div>
</div>
@endsection
