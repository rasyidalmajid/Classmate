@extends('layouts.app')

@section('title', 'Karya ' . $submission->user->name)
@section('page_name', 'Evaluasi Jawaban Siswa')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    <div class="flex items-center">
        <a href="{{ route('tasks.show', $task->id) }}" class="text-xs font-bold text-gray-500 hover:text-blue-600 bg-white border border-gray-100 px-3 py-2 rounded-xl shadow-xs transition-all">➔ Kembali ke Daftar Siswa</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-4">

            <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-xs space-y-4">
                <div>
                    <span class="text-[9px] bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-md font-bold uppercase tracking-wider">Siswa: {{ $submission->user->name }}</span>
                    <h1 class="text-xl font-black text-gray-900 tracking-tight mt-2">{{ $task->title }}</h1>
                    <p class="text-[10px] text-gray-400 mt-1">Dikirim pada: {{ $submission->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
                <div class="border-t border-gray-50 pt-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase mb-1.5">Instruksi Pokok Tugas:</h4>
                    <p class="text-xs text-gray-500 leading-relaxed bg-gray-50/50 p-4 rounded-2xl mb-4">{{ $task->description ?? 'Tidak ada deskripsi acuan.' }}</p>

                    <h4 class="text-xs font-bold text-gray-400 uppercase mb-1.5">Catatan / Jawaban Mahasiswa:</h4>
                    <p class="text-xs text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-2xl whitespace-pre-wrap">{{ $submission->notes ?? 'Siswa tidak menyertakan catatan tertulis.' }}</p>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-xs space-y-4">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-wider">Berkas Lampiran Pengumpulan</h3>

                <div class="grid grid-cols-1 gap-3">
                    @if($submission->file_path)
                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="flex items-center space-x-3 p-4 border border-blue-100 bg-blue-50/30 hover:bg-blue-50 text-blue-600 rounded-2xl transition-all font-bold text-xs group">
                            <span class="text-xl">📁</span>
                            <span class="truncate flex-1">Buka / Unduh Berkas Dokumen Tugas</span>
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity">➔</span>
                        </a>
                    @endif

                    @if($submission->link_url)
                        <a href="{{ $submission->link_url }}" target="_blank" class="flex items-center space-x-3 p-4 border border-purple-100 bg-purple-50/30 hover:bg-purple-50 text-purple-600 rounded-2xl transition-all font-bold text-xs group">
                            <span class="text-xl">🔗</span>
                            <span class="truncate flex-1">{{ $submission->link_url }}</span>
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity">➔</span>
                        </a>
                    @endif

                    @if(!$submission->file_path && !$submission->link_url)
                        <p class="text-xs text-gray-400 text-center py-4">Siswa tidak melampirkan berkas file atau tautan link luar.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="md:col-span-1">
            <form action="{{ route('submissions.grade', $submission->id) }}" method="POST" class="bg-white border border-gray-100 rounded-3xl p-5 shadow-xs space-y-4 sticky top-24">
                @csrf
                <h3 class="text-xs font-black uppercase tracking-wider text-gray-400">Evaluasi & Nilai</h3>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1.5">Berikan Skor Nilai (0 - 100)</label>
                    <input type="number" name="grade" min="0" max="100" value="{{ $submission->grade }}" placeholder="Contoh: 85" required class="w-full border border-gray-200 rounded-xl p-3 font-bold text-sm focus:outline-none focus:border-blue-600 text-gray-800">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1.5">Feedback / Komentar Tambahan</label>
                    <textarea name="feedback" rows="5" placeholder="Tulis masukan konstruktif untuk pengerjaan tugas mahasiswa di sini..." class="w-full border border-gray-200 rounded-xl p-3 text-xs focus:outline-none focus:border-blue-600 resize-none text-gray-700">{{ $submission->feedback }}</textarea>
                </div>

                <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white font-bold py-3 rounded-xl text-xs transition-colors shadow-sm">Simpan Nilai & Masukan</button>
            </form>
        </div>
    </div>
</div>
@endsection
