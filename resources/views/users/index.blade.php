@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div x-data="{ showModalTambah: false, showModalEdit: false, editData: {} }">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-100">Daftar User</h2>
                <p class="text-sm text-gray-500">Manajemen data akses pengguna</p>
            </div>
            <button @click="showModalTambah = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-sm font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>Tambah User
            </button>
        </div>

        <div class="overflow-x-auto">
            <table id="usersTable" class="w-full text-left text-sm text-gray-400">
                <thead class="text-xs text-gray-300 uppercase bg-gray-800/50 border-b border-gray-700">
                    <tr>
                        <th class="px-4 py-3 rounded-tl-lg">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3 rounded-tr-lg text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($users as $item)
                    <tr class="hover:bg-gray-800/20 transition-colors">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-gray-200 font-medium">{{ $item->name }}</td>
                        <td class="px-4 py-3">{{ $item->email }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                                {{ $item->roles->first()->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 flex justify-end space-x-2">
                            <button @click="editData = {{ json_encode($item) }}; editData.role = '{{ $item->roles->first()->name ?? '' }}'; showModalEdit = true" class="p-2 bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 rounded-lg transition-colors" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form id="deleteForm{{ $item->id }}" action="{{ route('users.destroy', $item->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('{{ $item->id }}')" class="p-2 bg-red-500/10 text-red-400 hover:bg-red-500/20 rounded-lg transition-colors" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div x-show="showModalTambah" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModalTambah" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" aria-hidden="true" @click="showModalTambah = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showModalTambah" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-2xl overflow-hidden text-left align-middle transition-all transform bg-gray-900 border border-gray-800 rounded-2xl shadow-xl sm:my-8 sm:align-middle">

                <div class="px-6 py-5 border-b border-gray-800 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-100" id="modal-title">Tambah User</h3>
                    <button @click="showModalTambah = false" class="text-gray-400 hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                            <input type="password" name="password" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Role Akses</label>
                            <select name="role" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                                <option value="">-- Pilih Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="showModalTambah = false" class="px-5 py-2.5 text-sm font-medium text-gray-300 hover:text-gray-100 hover:bg-gray-800 rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-emerald-500/30">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div x-show="showModalEdit" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModalEdit" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" aria-hidden="true" @click="showModalEdit = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showModalEdit" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-2xl overflow-hidden text-left align-middle transition-all transform bg-gray-900 border border-gray-800 rounded-2xl shadow-xl sm:my-8 sm:align-middle">

                <div class="px-6 py-5 border-b border-gray-800 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-100" id="modal-title">Edit User</h3>
                    <button @click="showModalEdit = false" class="text-gray-400 hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form :action="`/users/${editData.id}`" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" x-model="editData.name" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" x-model="editData.email" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Password Baru <span class="text-xs text-gray-500">(Opsional)</span></label>
                            <input type="password" name="password" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none" placeholder="Kosongkan jika tidak diubah">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Role Akses</label>
                            <select name="role" x-model="editData.role" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                                <option value="">-- Pilih Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="showModalEdit = false" class="px-5 py-2.5 text-sm font-medium text-gray-300 hover:text-gray-100 hover:bg-gray-800 rounded-xl transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-xl transition-colors shadow-lg shadow-blue-500/30">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
            },
            dom: '<"flex flex-col md:flex-row justify-between items-center mb-4"lf>rt<"flex flex-col md:flex-row justify-between items-center mt-4"ip>',
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data user ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#4b5563',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#111827',
            color: '#f3f4f6'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + id).submit();
            }
        });
    }
</script>
@endpush
@endsection
