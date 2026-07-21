@extends('layouts.app')

@section('title', 'Data Balita')

@section('content')
<div x-data="{ showModalTambah: false, showModalEdit: false, editData: {} }">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-lg font-bold text-gray-100">Daftar Balita</h2>
                <p class="text-sm text-gray-500">Manajemen data balita posyandu</p>
            </div>
            <button @click="showModalTambah = true" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-sm font-medium transition-colors">
                <i class="fas fa-plus mr-2"></i>Tambah Data
            </button>
        </div>

        <div class="overflow-x-auto">
            <table id="balitasTable" class="w-full text-left text-sm text-gray-400">
                <thead class="text-xs text-gray-300 uppercase bg-gray-800/50 border-b border-gray-700">
                    <tr>
                        <th class="px-4 py-3 rounded-tl-lg">No</th>
                        <th class="px-4 py-3">NIK</th>
                        <th class="px-4 py-3">Nama Balita</th>
                        <th class="px-4 py-3">Orang Tua</th>
                        <th class="px-4 py-3">Jenis Kelamin</th>
                        <th class="px-4 py-3">Tgl Lahir</th>
                        <th class="px-4 py-3 rounded-tr-lg text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($balitas as $item)
                    <tr class="hover:bg-gray-800/20 transition-colors">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium text-gray-200">{{ $item->nik }}</td>
                        <td class="px-4 py-3">{{ $item->nama }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-semibold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2 py-1 rounded-md">
                                Ibu: {{ $item->orangTua->nama_ibu ?? '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($item->jenis_kelamin == 'L')
                                <span class="text-blue-400"><i class="fas fa-mars mr-1"></i> Laki-laki</span>
                            @else
                                <span class="text-pink-400"><i class="fas fa-venus mr-1"></i> Perempuan</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}</td>
                        <td class="px-4 py-3 flex justify-end space-x-2">
                            <a href="{{ route('balitas.show', $item->id) }}" class="p-2 bg-indigo-500/10 text-indigo-400 hover:bg-indigo-500/20 rounded-lg transition-colors" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button @click="editData = {{ json_encode($item) }}; showModalEdit = true" class="p-2 bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 rounded-lg transition-colors" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form id="deleteForm{{ $item->id }}" action="{{ route('balitas.destroy', $item->id) }}" method="POST" class="inline">
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
                    <h3 class="text-lg font-bold text-gray-100" id="modal-title">Tambah Data Balita</h3>
                    <button @click="showModalTambah = false" class="text-gray-400 hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('balitas.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Orang Tua (Nama Ibu)</label>
                        <select name="orang_tua_id" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                            <option value="">-- Pilih Orang Tua --</option>
                            @foreach($orang_tuas as $ot)
                                <option value="{{ $ot->id }}">{{ $ot->nama_ibu }} (KK: {{ $ot->no_kk }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">NIK Balita</label>
                            <input type="text" name="nik" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Nama Balita</label>
                            <input type="text" name="nama" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 [color-scheme:dark] focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
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
                    <h3 class="text-lg font-bold text-gray-100" id="modal-title">Edit Data Balita</h3>
                    <button @click="showModalEdit = false" class="text-gray-400 hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form :action="`/balitas/${editData.id}`" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Orang Tua (Nama Ibu)</label>
                        <select name="orang_tua_id" x-model="editData.orang_tua_id" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                            <option value="">-- Pilih Orang Tua --</option>
                            @foreach($orang_tuas as $ot)
                                <option value="{{ $ot->id }}">{{ $ot->nama_ibu }} (KK: {{ $ot->no_kk }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">NIK Balita</label>
                            <input type="text" name="nik" x-model="editData.nik" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Nama Balita</label>
                            <input type="text" name="nama" x-model="editData.nama" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Jenis Kelamin</label>
                            <select name="jenis_kelamin" x-model="editData.jenis_kelamin" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" x-model="editData.tanggal_lahir" required class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-xl px-4 py-2.5 [color-scheme:dark] focus:border-emerald-500 focus:ring focus:ring-emerald-500/20 transition-all outline-none">
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
@endsection
