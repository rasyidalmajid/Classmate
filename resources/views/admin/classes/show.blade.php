@extends('layouts.admin')
@section('title', 'Detail Kelas')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8 space-y-6">
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex justify-between items-center">
        <div>
            <h2 class="text-xl font-black text-gray-900">{{ $kelas->name }}</h2>
            <p class="text-xs text-gray-500">
                Kode: <span class="font-bold">{{ $kelas->code }}</span> |
                Pengajar: {{ $kelas->instructor->name ?? 'Tidak ada' }}
            </p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-6 py-4">Nama Siswa</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas->students as $siswa)
                <tr class="border-t border-gray-100">
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $siswa->name }}</td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.classes.removeMember', [$kelas->id, $siswa->id]) }}" method="POST" onsubmit="return confirm('Hapus siswa dari kelas?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada siswa di kelas ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('modals')
<div id="modal-add-member" class="fixed inset-0 z-[100] bg-black/50 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white p-6 rounded-3xl w-full max-w-sm shadow-2xl">
        <h3 class="font-bold mb-4">Tambah Siswa</h3>
        <form action="{{ route('admin.classes.addMember', $kelas->id) }}" method="POST">
            @csrf
            <select name="user_id" class="w-full border border-gray-200 rounded-xl p-3 mb-4 focus:ring-2 focus:ring-blue-600 outline-none">
                @foreach($allUsers as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
            <div class="flex gap-3">
                <button type="button" onclick="closeModal('modal-add-member')" class="flex-1 border border-gray-200 rounded-xl py-3 text-xs font-bold text-gray-600">Batal</button>
                <button type="submit" class="flex-1 bg-blue-600 text-white rounded-xl py-3 text-xs font-bold">Tambahkan</button>
            </div>
        </form>
    </div>
</div>
@endsection
