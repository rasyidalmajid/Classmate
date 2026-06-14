@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <h1 class="text-2xl font-black mb-6">Overview Sistem</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-2xl border shadow-sm">
            <p class="text-xs font-bold text-gray-500 uppercase">Total Users</p>
            <h3 class="text-3xl font-black text-blue-600">{{ $stats['total_users'] }}</h3>
        </div>
        <div class="bg-white p-6 rounded-2xl border shadow-sm">
            <p class="text-xs font-bold text-gray-500 uppercase">Total Kelas</p>
            <h3 class="text-3xl font-black text-indigo-600">{{ $stats['total_classes'] }}</h3>
        </div>
    </div>
</div>
@endsection
