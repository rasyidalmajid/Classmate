@extends('layouts.app')

@section('title', 'Detail Tugas')
@section('page_name', 'Lembar Kerja')

@section('content')
<section class="max-w-6xl mx-auto p-6 md:p-8 grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

    <div class="lg:col-span-2 bg-white p-6 border border-gray-100 rounded-2xl shadow-xs space-y-6">
        <div class="flex items-start space-x-4 border-b border-gray-100 pb-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 text-2xl font-bold flex items-center justify-center flex-shrink-0">📋</div>
            <div>
                <h1 class="text-xl font-black text-gray-900 tracking-tight">{{ $task->title }}</h1>
                <p class="text-xs text-gray-400 mt-1 font-medium">
                    {{ $task->classRoom->name }} &bull; Batas Waktu: {{ $task->deadline->translatedFormat('d F Y, H:i') }} WIB
                </p>
            </div>
        </div>
        <div class="space-y-3 text-xs text-gray-600 leading-relaxed">
            <p class="font-bold text-gray-800 text-sm mb-1">Instruksi Pokok Penugasan:</p>
            <div class="bg-gray-50 p-4 rounded-xl text-gray-700 whitespace-pre-line font-medium">
                {{ $task->description ?? 'Tidak ada instruksi deskripsi tertulis dari pengampu.' }}
            </div>
        </div>
    </div>

    <div class="lg:col-span-1 bg-white p-6 border border-gray-100 rounded-2xl shadow-xs space-y-4">
        <div class="flex justify-between items-center border-b border-gray-50 pb-3">
            <h3 class="font-black text-sm text-gray-900 tracking-tight">Status Tugas</h3>
            <span class="text-[10px] font-bold tracking-wide {{ $task->status === 'completed' ? 'text-emerald-700 bg-emerald-50' : 'text-amber-700 bg-amber-50' }} px-2 py-0.5 rounded-md uppercase">
                {{ $task->status === 'completed' ? 'Diserahkan' : 'Belum Selesai' }}
            </span>
        </div>

        @if($errors->any())
        <div class="p-3 bg-red-50 text-red-600 text-[11px] font-bold rounded-xl border border-red-100">
            {{ $errors->first() }}
        </div>
        @endif

        @if($task->status !== 'completed')
            <form action="{{ route('tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Unggah Berkas Jawaban (Opsional)</label>
                    <label class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-blue-400 cursor-pointer transition-colors group flex flex-col items-center justify-center bg-gray-50/50">
                        <input type="file" name="file_assignment" id="file_assignment" class="hidden" onchange="displayFileName()">
                        <div class="text-xl mb-1 group-hover:scale-110 transition-transform" id="upload-icon">📁</div>
                        <p class="text-[11px] font-bold text-gray-700" id="file-label-text">Pilih dokumen atau berkas .zip</p>
                        <p class="text-[9px] text-gray-400 mt-0.5" id="file-size-text">Maksimal ukuran file 20MB</p>
                    </label>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tautan Tugas / Repository URL (Opsional)</label>
                    <input type="url" name="link_url" placeholder="https://github.com/... atau tautan Drive"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-xs focus:outline-none focus:border-blue-600 placeholder:text-gray-300">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-3 rounded-xl transition-all shadow-sm active:scale-95">
                    Serahkan Pekerjaan Sekarang
                </button>
            </form>
        @else
            <div class="space-y-3 bg-gray-50 p-4 rounded-xl border border-gray-100 text-xs font-medium">
                <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider">Lampiran Jawaban Anda:</p>

                @if($task->currentUserSubmission && $task->currentUserSubmission->file_path)
                    <div class="flex items-center space-x-2 text-gray-700 bg-white p-2.5 border border-gray-100 rounded-lg">
                        <span>📄</span>
                        <a href="{{ asset('storage/' . $task->currentUserSubmission->file_path) }}" target="_blank" class="text-blue-600 hover:underline truncate flex-1 font-bold">
                            Lihat Berkas Dokumen Terlampir
                        </a>
                    </div>
                @endif

                @if($task->currentUserSubmission && $task->currentUserSubmission->link_url)
                    <div class="flex items-center space-x-2 text-gray-700 bg-white p-2.5 border border-gray-100 rounded-lg">
                        <span>🔗</span>
                        <a href="{{ $task->currentUserSubmission->link_url }}" target="_blank" class="text-blue-600 hover:underline truncate flex-1 font-bold">
                            {{ $task->currentUserSubmission->link_url }}
                        </a>
                    </div>
                @endif
            </div>

            <button type="button" disabled class="w-full bg-gray-100 text-gray-400 text-xs font-bold py-3 rounded-xl cursor-not-allowed text-center">
                Pekerjaan Berhasil Dikumpulkan ✓
            </button>
        @endif
    </div>

</section>

<script>
    function displayFileName() {
        const fileInput = document.getElementById('file_assignment');
        const labelText = document.getElementById('file-label-text');
        const sizeText = document.getElementById('file-size-text');
        const icon = document.getElementById('upload-icon');

        if (fileInput.files.length > 0) {
            labelText.innerText = fileInput.files[0].name;
            labelText.classList.add('text-blue-600');
            sizeText.innerText = "Berkas siap diunggah";
            icon.innerText = "✅";
        }
    }
</script>
@endsection
