@extends('layouts.app')

@section('title', 'Koreksi Lembar Kerja')
@section('page_name', 'Pemeriksaan Berkas')

@section('content')
<section class="max-w-4xl mx-auto px-6 space-y-6">

    <div class="bg-white p-6 border border-gray-100 rounded-2xl shadow-xs">
        <div class="flex justify-between items-start">
            <div>
                <span class="text-[10px] font-bold uppercase text-gray-400 tracking-wider">Lembar Jawaban Tugas</span>
                <h1 class="text-xl font-black text-gray-900 tracking-tight mt-1">{{ $task->title }}</h1>
                <p class="text-xs text-gray-500 mt-2 font-medium">Mahasiswa: <span class="text-gray-900 font-bold">{{ $student->name }}</span></p>
            </div>
            <button onclick="window.history.back()" class="text-xs font-bold text-gray-500 hover:text-gray-900 bg-gray-50 px-3 py-2 rounded-xl border border-gray-100">
                🗙 Kembali
            </button>
        </div>
        <div class="border-t border-gray-100 mt-4 pt-3 flex justify-between text-[11px] text-gray-400 font-medium">
            <p>Kelas: {{ $task->classRoom->name }}</p>
            <p>Dikirim pada: {{ $submission ? $submission->created_at->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}</p>
        </div>
    </div>

    <div class="bg-white p-6 border border-gray-100 rounded-2xl shadow-xs space-y-4">
        <h3 class="font-black text-sm text-gray-900 tracking-tight">Lampiran Hasil Kerja Terkirim</h3>

        @if($submission)
            <div class="grid grid-cols-1 gap-4 text-xs font-medium">
                @if($submission->file_path)
                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 flex items-center justify-between gap-4">
                        <div class="truncate">
                            <span class="font-bold text-gray-800 block text-xs">📄 Berkas Dokumen Fisik</span>
                            <span class="text-[10px] text-gray-400 block truncate mt-0.5">{{ basename($submission->file_path) }}</span>
                        </div>
                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-blue-700 whitespace-nowrap">
                            Unduh Berkas
                        </a>
                    </div>
                @endif

                @if($submission->link_url)
                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 flex items-center justify-between gap-4">
                        <div class="truncate">
                            <span class="font-bold text-gray-800 block text-xs">🔗 Tautan Repositori / File Luar</span>
                            <span class="text-[10px] text-blue-600 block truncate mt-0.5 hover:underline">{{ $submission->link_url }}</span>
                        </div>
                        <a href="{{ $submission->link_url }}" target="_blank" class="bg-gray-900 text-white px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-black whitespace-nowrap">
                            Buka Tautan
                        </a>
                    </div>
                @endif
            </div>
        @else
            <div class="p-6 bg-red-50 text-red-600 rounded-xl text-xs font-bold text-center border border-red-100">
                Data submission untuk mahasiswa ini tidak ditemukan.
            </div>
        @endif
    </div>
</section>
@endsection
