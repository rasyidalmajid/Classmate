@extends('layouts.admin')
@section('title', 'Manajemen Kelas')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-4">Nama Kelas</th>
                    <th class="px-6 py-4">Kode</th>
                    <th class="px-6 py-4">Pengajar</th>
                    <th class="px-6 py-4 text-center">Anggota</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($classes as $kelas)
                <tr class="hover:bg-blue-50/30">
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $kelas->name }}</td>
                    <td class="px-6 py-4 font-mono text-xs">{{ $kelas->code }}</td>
                    <td class="px-6 py-4 text-sm">{{ $kelas->instructor->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">{{ $kelas->students->count() }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.classes.show', $kelas->id) }}" class="text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg text-xs font-bold">Detail</a>
                        <form action="{{ route('admin.classes.destroy', $kelas->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 bg-red-50 px-3 py-1.5 rounded-lg text-xs font-bold" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
