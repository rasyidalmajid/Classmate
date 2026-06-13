@extends('layouts.app')

@section('title', 'Daftar Tugas')
@section('page_name', 'Daftar Tugas')

@section('content')
<div class="border-b border-gray-200 bg-white sticky top-16 z-20 px-6">
    <div class="max-w-4xl mx-auto flex space-x-8 text-sm font-bold">
        <button onclick="switchTaskTab('assigned')" id="tab-assigned" class="py-4 border-b-2 border-blue-600 text-blue-600 transition-all focus:outline-none">
            Ditugaskan <span class="ml-1 px-1.5 py-0.5 text-xs bg-blue-50 rounded-md">{{ $assignedTasks->count() }}</span>
        </button>
        <button onclick="switchTaskTab('completed')" id="tab-completed" class="py-4 border-b-2 border-transparent text-gray-500 hover:text-gray-800 transition-all focus:outline-none">
            Selesai <span class="ml-1 px-1.5 py-0.5 text-xs bg-gray-100 text-gray-600 rounded-md">{{ $completedTasks->count() }}</span>
        </button>
    </div>
</div>

<div class="p-6 md:p-8 max-w-4xl mx-auto w-full">

    <div id="content-assigned" class="space-y-4">
        @forelse($assignedTasks as $task)
        <div onclick="window.location.href='{{ route('tasks.show', $task->id) }}'" class="p-5 bg-white border border-gray-100 rounded-2xl hover:shadow-xs cursor-pointer transition-all flex items-center justify-between group hover:border-blue-100">
            <div class="flex items-center space-x-4 min-w-0">
                <div class="w-11 h-11 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl font-bold flex-shrink-0 group-hover:scale-105 transition-transform">💼</div>
                <div class="min-w-0">
                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors truncate">{{ $task->title }}</h4>
                    <p class="text-xs text-gray-500 mt-0.5 font-medium">{{ $task->classRoom->name }} &bull; {{ $task->classRoom->study_program ?? 'Umum' }}</p>
                </div>
            </div>
            <div class="text-right flex-shrink-0 pl-4">
                <span class="text-[11px] font-bold text-red-600 bg-red-50 px-2.5 py-1 rounded-md">
                    {{ $task->deadline->translatedFormat('d M, H:i') }} WIB
                </span>
            </div>
        </div>
        @empty
        <div class="text-center py-12 bg-white border border-dashed border-gray-200 rounded-2xl">
            <span class="text-2xl block mb-2">🎉</span>
            <p class="text-sm text-gray-400 font-medium">Tidak ada tanggungan tugas kuliah saat ini.</p>
        </div>
        @endforelse
    </div>

    <div id="content-completed" class="space-y-4 hidden">
        @forelse($completedTasks as $task)
            @php
                // Mengambil berkas pengumpulan milik user saat ini
                $mySub = $task->submissions->first();
                $isGraded = $mySub && !is_null($mySub->grade);
            @endphp
            <div onclick="window.location.href='{{ route('tasks.show', $task->id) }}'" class="p-5 bg-white border border-gray-100 rounded-2xl flex items-center justify-between hover:border-emerald-200 hover:shadow-xs cursor-pointer transition-all group">
                <div class="flex items-center space-x-4 min-w-0">
                    <div class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl font-bold flex-shrink-0 group-hover:scale-105 transition-transform">✓</div>
                    <div class="min-w-0">
                        <h4 class="text-sm font-bold text-gray-700 truncate group-hover:text-emerald-600 transition-colors">{{ $task->title }}</h4>
                        <p class="text-xs text-gray-400 mt-0.5 font-medium">{{ $task->classRoom->name }}</p>
                    </div>
                </div>

                <div class="text-right flex-shrink-0 pl-4 flex items-center space-x-3">
                    @if($isGraded)
                        <div class="text-right hidden sm:block">
                            <span class="block text-[9px] font-bold text-gray-400 uppercase">Nilai</span>
                            <span class="text-sm font-black text-blue-600">{{ $mySub->grade }}<span class="text-[10px] text-gray-400 font-normal">/100</span></span>
                        </div>
                        <span class="text-[11px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md">
                            Skor: {{ $mySub->grade }}
                        </span>
                    @else
                        <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md">
                            Diserahkan
                        </span>
                    @endif
                </div>
            </div>
        @empty
        <div class="text-center py-12 bg-white border border-dashed border-gray-200 rounded-2xl">
            <p class="text-sm text-gray-400 font-medium">Belum ada histori tugas yang diselesaikan.</p>
        </div>
        @endforelse
    </div>
</div>

<script>
    function switchTaskTab(tab) {
        const btnAssigned = document.getElementById('tab-assigned');
        const btnCompleted = document.getElementById('tab-completed');
        const cAssigned = document.getElementById('content-assigned');
        const cCompleted = document.getElementById('content-completed');

        if (tab === 'assigned') {
            btnAssigned.className = "py-4 border-b-2 border-blue-600 text-blue-600 font-bold transition-all focus:outline-none";
            btnCompleted.className = "py-4 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-bold transition-all focus:outline-none";
            cAssigned.classList.remove('hidden');
            cCompleted.classList.add('hidden');
        } else {
            btnCompleted.className = "py-4 border-b-2 border-blue-600 text-blue-600 font-bold transition-all focus:outline-none";
            btnAssigned.className = "py-4 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-bold transition-all focus:outline-none";
            cCompleted.classList.remove('hidden');
            cAssigned.classList.add('hidden');
        }
    }
</script>
@endsection
