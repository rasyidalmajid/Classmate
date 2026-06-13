@extends('layouts.app')

@section('title', 'Daftar Pengumpulan - ' . $task->title)
@section('page_name', 'Pengumpulan Tugas')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-6">

    <div class="flex items-center justify-between">
    <a href="{{ route('classes.show', $task->class_room_id ?? $task->class_id ?? $task->classRoom->id) }}" class="text-xs font-bold text-gray-500 hover:text-blue-600 bg-white border border-gray-100 px-3 py-2 rounded-xl shadow-xs transition-all">➔ Kembali ke Kelas</a>
        <span class="text-[10px] text-gray-400 font-mono">Tenggat: {{ $task->deadline->translatedFormat('d F Y, H:i') }} WIB</span>
    </div>

    <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-xs space-y-2">
        <span class="text-[9px] bg-blue-50 text-blue-600 px-2.5 py-1 rounded-md font-bold uppercase tracking-wider">Panel Pengajar</span>
        <h1 class="text-xl font-black text-gray-900 tracking-tight">{{ $task->title }}</h1>
        <p class="text-xs text-gray-500 leading-relaxed">{{ Str::limit($task->description, 180, '...') }}</p>
    </div>

    <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-xs space-y-4">
        <h3 class="text-xs font-black text-gray-400 uppercase tracking-wider">Status Pengumpulan Mahasiswa</h3>

        <div class="space-y-2">
            @foreach($submissions as $sub)
                @php
                    $isLate = $sub->created_at->gt($task->deadline);
                    $isGraded = !is_null($sub->grade);
                @endphp
                <div onclick="window.location.href='{{ route('tasks.submissions.show', [$task->id, $sub->id]) }}'" class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border border-gray-50 bg-gray-50/30 hover:bg-blue-50/40 hover:border-blue-200 rounded-2xl transition-all cursor-pointer group gap-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xs uppercase shadow-xs">
                            {{ substr($sub->user->name, 0, 2) }}
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $sub->user->name }}</h4>
                            <p class="text-[10px] text-gray-400 mt-0.5">Diserahkan: {{ $sub->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 self-end sm:self-auto">
                        <span class="text-[9px] font-bold uppercase px-2.5 py-1 rounded-md {{ $isLate ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600' }}">
                            {{ $isLate ? 'Terlambat' : 'Tepat Waktu' }}
                        </span>
                        <span class="text-[9px] font-bold uppercase px-2.5 py-1 rounded-md {{ $isGraded ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                            {{ $isGraded ? 'Nilai: ' . $sub->grade : 'Belum Dinilai' }}
                        </span>
                    </div>
                </div>
            @endforeach

            @foreach($unsubmittedStudents as $student)
                <div class="flex items-center justify-between p-4 border border-gray-100 bg-white rounded-2xl opacity-60">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-gray-100 text-gray-400 flex items-center justify-center text-sm">⏳</div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-500">{{ $student->name }}</h4>
                            <p class="text-[10px] text-gray-400 mt-0.5">Belum menyerahkan berkas lembar kerja</p>
                        </div>
                    </div>
                    <span class="text-[9px] font-bold uppercase text-gray-400 bg-gray-50 px-2.5 py-1 rounded-md">Belum Ada</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
