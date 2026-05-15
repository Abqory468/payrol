<div>

{{-- Flash Notification --}}
@if (session()->has('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-emerald-50 border border-emerald-100 text-emerald-800 px-5 py-3 rounded-xl shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
        </svg>
        <span class="font-medium text-sm">{{ session('success') }}</span>
    </div>
@endif

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Karyawan</h1>
                <p class="text-sm text-slate-500">Kelola master data karyawan perusahaan Anda</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- FORM PANEL --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                {{-- Form Header --}}
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        @if($isEditMode)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                            </svg>
                            <h2 class="text-slate-800 font-bold">Edit Data Karyawan</h2>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                            </svg>
                            <h2 class="text-slate-800 font-bold">Tambah Karyawan Baru</h2>
                        @endif
                    </div>
                    <p class="text-slate-500 text-xs mt-1">Lengkapi form di bawah ini</p>
                </div>

                {{-- Form Body --}}
                <form wire:submit="store" class="p-6 space-y-4">

                    {{-- Hubungkan Akun --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Hubungkan Akun User</label>
                        <select wire:model="user_id"
                                class="w-full text-sm rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm">
                            <option value="">— Buat Akun Otomatis —</option>
                            @foreach($unlinked_users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        <p class="text-[11px] text-slate-400 mt-1.5">Kosongkan untuk membuat akun baru secara otomatis berdasarkan NIK.</p>
                    </div>

                    {{-- NIK --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nomor Induk (NIK)</label>
                        <input type="text" wire:model.blur="nik" placeholder="Contoh: 100234"
                               class="w-full text-sm rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm">
                        @error('nik') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                        <input type="text" wire:model.blur="name" placeholder="John Doe"
                               class="w-full text-sm rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm">
                        @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- No. Telepon --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nomor Telepon</label>
                        <input type="text" wire:model.blur="phone" placeholder="08xxxxxxxxxx"
                               class="w-full text-sm rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm">
                        @error('phone') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jabatan --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Posisi / Jabatan</label>
                        <select wire:model="position"
                                class="w-full text-sm rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm">
                            <option value="">— Pilih Jabatan —</option>
                            <option value="Staff IT">Staff IT</option>
                            <option value="HRD / Personalia">HRD / Personalia</option>
                            <option value="Keuangan">Keuangan</option>
                            <option value="Office Boy/Girl">Office Boy/Girl</option>
                        </select>
                        @error('position') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Alamat Tempat Tinggal</label>
                        <textarea wire:model.blur="address" rows="3" placeholder="Masukkan alamat lengkap..."
                                  class="w-full text-sm rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm resize-none"></textarea>
                        @error('address') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2 disabled:opacity-50">
                            <span wire:loading.remove>
                                {{ $isEditMode ? 'Simpan Perubahan' : 'Tambah Karyawan' }}
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
                                    class="flex-1 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-bold py-2.5 rounded-xl transition-all">
                                Batal Edit
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE PANEL --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden h-full flex flex-col">

                {{-- Table Header --}}
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-white">
                    <div>
                        <h2 class="text-base font-bold text-slate-800">Daftar Karyawan</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Total {{ $employees->count() }} karyawan aktif terdaftar</p>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-50/50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="px-6 py-4">Data Karyawan</th>
                                <th class="px-6 py-4">Kontak & Jabatan</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($employees as $item)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold border border-blue-100 shrink-0">
                                                {{ strtoupper(substr($item->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800">{{ $item->name }}</p>
                                                <p class="font-mono text-xs text-slate-500 mt-0.5">NIK: {{ $item->nik }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold border
                                            {{ $item->position === 'Staff IT' ? 'bg-blue-50 text-blue-600 border-blue-200' :
                                               ($item->position === 'HRD / Personalia' ? 'bg-purple-50 text-purple-600 border-purple-200' :
                                               ($item->position === 'Keuangan' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' :
                                               'bg-orange-50 text-orange-600 border-orange-200')) }}">
                                            {{ $item->position }}
                                        </span>
                                        <p class="text-xs text-slate-500 mt-1.5 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            {{ $item->phone }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button wire:click="edit({{ $item->id }})"
                                                    class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 transition-all" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                </svg>
                                            </button>
                                            <button wire:click="delete({{ $item->id }})"
                                                    wire:confirm="Yakin ingin menghapus karyawan {{ $item->name }}?"
                                                    class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition-all" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-300" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                                </svg>
                                            </div>
                                            <p class="font-bold text-slate-700">Belum ada data karyawan</p>
                                            <p class="text-xs text-slate-500 mt-1 max-w-[250px]">Silakan tambahkan karyawan baru menggunakan form di sebelah kiri layar.</p>
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