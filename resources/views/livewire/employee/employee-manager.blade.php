<div>

{{-- Flash Notification --}}
@if (session()->has('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-2xl">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
        </svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
@endif

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- Page Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-1">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Karyawan</h1>
                <p class="text-sm text-gray-500">Kelola data karyawan perusahaan Anda</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- FORM PANEL --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Form Header --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <div class="flex items-center gap-2">
                        @if($isEditMode)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/80" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                            </svg>
                            <h2 class="text-white font-semibold">Edit Karyawan</h2>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white/80" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                            </svg>
                            <h2 class="text-white font-semibold">Tambah Karyawan</h2>
                        @endif
                    </div>
                    <p class="text-white/70 text-xs mt-1">Isi semua kolom yang diperlukan</p>
                </div>

                {{-- Form Body --}}
                <form wire:submit="store" class="p-6 space-y-4">

                    {{-- Hubungkan Akun --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Akun User</label>
                        <select wire:model="user_id"
                                class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">— Buat Akun Otomatis —</option>
                            @foreach($unlinked_users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-xs text-gray-400 mt-1">Kosongkan untuk buat akun baru secara otomatis.</p>
                    </div>

                    {{-- NIK --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nomor Induk (NIK)</label>
                        <input type="text" wire:model.blur="nik" placeholder="Contoh: 001234"
                               class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        @error('nik') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" wire:model.blur="name" placeholder="Masukkan nama lengkap"
                               class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- No. Telepon --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">No. Telepon</label>
                        <input type="text" wire:model.blur="phone" placeholder="08xxxxxxxxxx"
                               class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Jabatan</label>
                        <select wire:model="position"
                                class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">— Pilih Jabatan —</option>
                            <option value="Staff IT">Staff IT</option>
                            <option value="HRD / Personalia">HRD / Personalia</option>
                            <option value="Keuangan">Keuangan</option>
                            <option value="Office Boy/Girl">Office Boy/Girl</option>
                        </select>
                        @error('position') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Alamat</label>
                        <textarea wire:model.blur="address" rows="3" placeholder="Masukkan alamat lengkap"
                                  class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"></textarea>
                        @error('address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-2 pt-1">
                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold py-2.5 rounded-lg shadow-md hover:shadow-lg hover:opacity-90 transition disabled:opacity-50 flex items-center justify-center gap-2">
                            <span wire:loading.remove>
                                {{ $isEditMode ? 'Perbarui Data' : 'Simpan Karyawan' }}
                            </span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                </svg>
                                Menyimpan...
                            </span>
                        </button>
                        @if($isEditMode)
                            <button type="button" wire:click="resetForm"
                                    class="flex-1 bg-gray-100 text-gray-600 text-sm font-semibold py-2.5 rounded-lg hover:bg-gray-200 transition">
                                Batal
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE PANEL --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Table Header --}}
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-gray-800">Daftar Karyawan</h2>
                        <p class="text-xs text-gray-400">Total {{ $employees->count() }} karyawan terdaftar</p>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/>
                        </svg>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="px-5 py-3 text-left">NIK</th>
                                <th class="px-5 py-3 text-left">Nama</th>
                                <th class="px-5 py-3 text-left">Jabatan</th>
                                <th class="px-5 py-3 text-left">No. Telepon</th>
                                <th class="px-5 py-3 text-left">Alamat</th>
                                <th class="px-5 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($employees as $item)
                                <tr class="hover:bg-blue-50/40 transition-colors group">
                                    <td class="px-5 py-3.5">
                                        <span class="font-mono text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-md">{{ $item->nik }}</span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>
                                            <span class="font-semibold text-gray-800">{{ $item->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                            {{ $item->position === 'Staff IT' ? 'bg-blue-100 text-blue-700' :
                                               ($item->position === 'HRD / Personalia' ? 'bg-purple-100 text-purple-700' :
                                               ($item->position === 'Keuangan' ? 'bg-emerald-100 text-emerald-700' :
                                               'bg-orange-100 text-orange-700')) }}">
                                            {{ $item->position }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-600">{{ $item->phone }}</td>
                                    <td class="px-5 py-3.5 text-gray-500 max-w-[160px] truncate" title="{{ $item->address }}">
                                        {{ $item->address }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center justify-center gap-1">
                                            <button wire:click="edit({{ $item->id }})"
                                                    class="p-1.5 rounded-lg text-blue-500 hover:bg-blue-100 transition" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                </svg>
                                            </button>
                                            <button wire:click="delete({{ $item->id }})"
                                                    wire:confirm="Yakin ingin menghapus karyawan {{ $item->name }}?"
                                                    class="p-1.5 rounded-lg text-red-400 hover:bg-red-100 transition" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3 text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 opacity-30" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                            </svg>
                                            <p class="font-medium text-sm">Belum ada data karyawan</p>
                                            <p class="text-xs">Tambahkan karyawan menggunakan form di sebelah kiri.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
</div>