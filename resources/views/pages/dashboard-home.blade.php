@extends('layouts.app')

@section('title', 'Beranda')
@section('page_name', 'Beranda')

@section('navbar_actions')
    <button onclick="openModal('modal-kelas')" class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-blue-600 bg-gray-50 hover:bg-blue-50 rounded-xl text-xl font-bold transition-all active:scale-95" title="Buat Kelas Baru">+</button>
@endsection

@section('content')
<section class="p-6 md:p-8 max-w-7xl mx-auto w-full space-y-8">
    <div class="flex flex-col space-y-1">
        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Kelas Anda</h1>
        <p class="text-sm text-gray-500">Akses cepat seluruh ruang studi aktif Anda.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($classes as $class)
        <div onclick="window.location.href='{{ route('classes.show', $class->id) }}'" class="bg-white border border-gray-100 rounded-2xl shadow-xs hover:shadow-md cursor-pointer transition-all duration-300 flex flex-col justify-between overflow-hidden group hover:-translate-y-1">
            <div class="bg-gradient-to-br {{ $class->banner_gradient }} p-5 text-white relative min-h-[125px] flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-bold truncate tracking-tight group-hover:underline">{{ $class->name }}</h3>
                    <p class="text-xs opacity-85 mt-0.5 truncate font-medium">{{ $class->study_program }}</p>
                </div>
                <p class="text-xs opacity-75 truncate">{{ $class->instructor_name }}</p>
            </div>
            <div class="p-5 pt-6 flex-1 bg-white text-xs text-gray-400">
                Aktivitas ruang kelas berjalan aktif. Masuk untuk berdiskusi.
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-white border border-dashed border-gray-200 rounded-3xl">
            <p class="text-sm text-gray-400">Belum ada kelas terdaftar. Silakan buat kelas baru menggunakan tombol + di atas. 👥</p>
        </div>
        @endforelse
    </div>
</section>
@endsection

@section('modals')
<div id="modal-kelas" class="fixed inset-0 z-[100] bg-black/50 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl space-y-5 border border-gray-100">
        <h3 class="text-xl font-black text-gray-900 tracking-tight">Buat Kelas Baru</h3>
        <form action="{{ route('classes.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Mata Kuliah / Kelas *</label>
                <input type="text" name="name" required placeholder="Contoh: Pemrograman Framework" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kategori / Program Studi</label>
                <input type="text" name="study_program" placeholder="Contoh: S1 Informatika" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Dosen Pengampu *</label>
                <input type="text" name="instructor_name" required placeholder="Nama Lengkap Beserta Gelar" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-blue-600">
            </div>
            <div class="flex space-x-3 pt-2">
                <button type="button" onclick="closeModal('modal-kelas')" class="flex-1 border border-gray-200 text-gray-600 rounded-xl py-3 text-xs font-bold hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 bg-blue-600 text-white rounded-xl py-3 text-xs font-bold hover:bg-blue-700">Simpan Kelas</button>
            </div>
        </form>
    </div>
</div>
@endsection
