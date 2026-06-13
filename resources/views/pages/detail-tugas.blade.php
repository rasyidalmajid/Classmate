@extends('layouts.app')

@section('title', $task->title)
@section('page_name', 'Detail Tugas')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    <div class="flex items-center space-x-3">
        <a href="{{ route('classes.show', $task->class_room_id ?? $task->class_id ?? $task->classRoom->id) }}" class="text-xs font-bold text-gray-500 hover:text-blue-600 bg-white border border-gray-100 px-3 py-2 rounded-xl shadow-xs transition-all">➔ Kembali ke Kelas</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="md:col-span-2 bg-white border border-gray-100 rounded-3xl p-6 shadow-xs space-y-4">
            <div>
                <h1 class="text-xl font-black text-gray-900 tracking-tight">{{ $task->title }}</h1>
                <p class="text-[10px] text-gray-400 mt-1">Batas Akhir: {{ $task->deadline->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
            <div class="border-t border-gray-50 pt-4">
                <p class="text-xs text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $task->description ?? 'Tidak ada instruksi tertulis khusus dari pengajar.' }}</p>
            </div>
        </div>

        <div class="md:col-span-1 bg-white border border-gray-100 rounded-3xl p-5 shadow-xs h-fit space-y-4">
            <h3 class="text-xs font-black uppercase tracking-wider text-gray-400">Tugas Anda</h3>

            @if($mySubmission)
                <div class="p-3.5 bg-emerald-50 border border-emerald-100 rounded-2xl space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-[9px] font-bold text-emerald-700 bg-white px-2 py-0.5 rounded shadow-2xs">Diserahkan</span>
                        @if(!is_null($mySubmission->grade))
                            <span class="text-[10px] font-bold text-blue-700">Nilai: {{ $mySubmission->grade }}</span>
                        @endif
                    </div>
                    <p class="text-[10px] text-gray-500">Dikirim pada: {{ $mySubmission->created_at->translatedFormat('d M Y, H:i') }} WIB</p>

                    <div class="border-t border-emerald-200/60 pt-2 space-y-1.5">
                        <span class="block text-[9px] font-bold text-emerald-800 uppercase tracking-wider">Berkas Lampiran Anda:</span>

                        @if($mySubmission->file_path)
                            <a href="{{ asset('storage/' . $mySubmission->file_path) }}" target="_blank" class="flex items-center space-x-2 text-[11px] text-emerald-700 hover:text-blue-600 font-medium transition-colors truncate bg-white/60 p-1.5 rounded-lg border border-emerald-100">
                                <span>📁</span>
                                <span class="truncate flex-1">Unduh/Lihat Berkas</span>
                            </a>
                        @endif

                        @if($mySubmission->link_url)
                            <a href="{{ $mySubmission->link_url }}" target="_blank" class="flex items-center space-x-2 text-[11px] text-emerald-700 hover:text-blue-600 font-medium transition-colors truncate bg-white/60 p-1.5 rounded-lg border border-emerald-100">
                                <span>🔗</span>
                                <span class="truncate flex-1">{{ $mySubmission->link_url }}</span>
                            </a>
                        @endif

                        @if($mySubmission->notes)
                            <div class="mt-2 bg-white/40 p-2 rounded-lg border border-emerald-100/50">
                                <span class="block text-[8px] font-bold text-gray-400 uppercase">Catatan Anda:</span>
                                <p class="text-[10px] text-gray-600 whitespace-pre-wrap leading-tight mt-0.5">{{ $mySubmission->notes }}</p>
                            </div>
                        @endif
                    </div>

                    @if($mySubmission->feedback)
                        <div class="border-t border-emerald-200/60 pt-2 mt-1">
                            <span class="block text-[9px] font-bold text-gray-400 uppercase">Catatan Evaluasi Dosen:</span>
                            <p class="text-[10px] text-gray-600 italic leading-normal">"{{ $mySubmission->feedback }}"</p>
                        </div>
                    @endif
                </div>
            @else
                @if($errors->has('upload_error'))
                    <div class="p-3 bg-red-50 border border-red-100 rounded-xl text-[11px] font-bold text-red-600">
                        ⚠️ {{ $errors->first('upload_error') }}
                    </div>
                @endif

                <form action="{{ route('submissions.store', $task->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 mb-1">Link Tautan Tugas (Opsional)</label>
                        <input type="url" name="link_url" placeholder="https://github.com/..." class="w-full border border-gray-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-blue-600 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 mb-1">Unggah Berkas File (Opsional)</label>
                        <input type="file" name="file_path" class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 mb-1">Catatan Tambahan Jawaban</label>
                        <textarea name="notes" rows="3" placeholder="Tulis pesan ringkas atau deskripsi pengerjaan tugas..." class="w-full border border-gray-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-blue-600 resize-none text-gray-700"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-xs transition-colors shadow-sm active:scale-[0.98]">Kirim Tugas</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
