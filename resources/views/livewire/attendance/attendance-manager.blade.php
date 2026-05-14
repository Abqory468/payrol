<div>

    {{-- Toast Notification --}}
    @if(session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-emerald-500 text-white px-5 py-3 rounded-xl shadow-2xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-6 py-8 space-y-6">

        {{-- ══════════════════ PAGE HEADER ══════════════════ --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Absensi Kehadiran</h1>
                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>

            @if(Auth::user()->role === 'admin')
                <button wire:click="openForm()"
                        class="flex items-center gap-2 bg-gradient-to-r from-teal-500 to-cyan-600 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow hover:opacity-90 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    Catat Absensi Manual
                </button>
            @endif
        </div>

        {{-- ══════════════════ KARTU CHECK-IN/OUT (KARYAWAN) ══════════════════ --}}
        @if(Auth::user()->role !== 'admin')
            @if($myEmployee)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
                        <p class="text-white/80 text-xs font-semibold uppercase tracking-wider">Absensi Hari Ini</p>
                        <h2 class="text-white font-bold text-lg mt-0.5">{{ $myEmployee->name }}</h2>
                        <p class="text-white/70 text-sm">{{ $myEmployee->position }}</p>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                            {{-- Status --}}
                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Status</p>
                                @if($todayRecord)
                                    @php
                                        $statusMap = ['hadir'=>['Hadir','bg-emerald-100 text-emerald-700'],'sakit'=>['Sakit','bg-yellow-100 text-yellow-700'],'izin'=>['Izin','bg-blue-100 text-blue-700'],'alpa'=>['Alpa','bg-red-100 text-red-700']];
                                        [$label,$cls] = $statusMap[$todayRecord->status] ?? [$todayRecord->status,'bg-gray-100 text-gray-700'];
                                    @endphp
                                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ $cls }}">{{ $label }}</span>
                                @else
                                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-500">Belum absen</span>
                                @endif
                            </div>
                            {{-- Check In --}}
                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Jam Masuk</p>
                                <p class="text-2xl font-bold {{ $todayRecord?->check_in ? 'text-teal-600' : 'text-gray-300' }}">
                                    {{ $todayRecord?->check_in ? \Carbon\Carbon::createFromTimeString($todayRecord->check_in)->format('H:i') : '—' }}
                                </p>
                            </div>
                            {{-- Check Out --}}
                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Jam Keluar</p>
                                <p class="text-2xl font-bold {{ $todayRecord?->check_out ? 'text-cyan-600' : 'text-gray-300' }}">
                                    {{ $todayRecord?->check_out ? \Carbon\Carbon::createFromTimeString($todayRecord->check_out)->format('H:i') : '—' }}
                                </p>
                            </div>
                        </div>

                        {{-- Durasi --}}
                        @if($todayRecord?->duration !== null)
                            <div class="bg-teal-50 border border-teal-100 rounded-xl px-4 py-3 text-center mb-5">
                                <p class="text-teal-700 text-sm font-semibold">
                                    ⏱ Durasi kerja: <span class="font-bold">{{ $todayRecord->duration_formatted }}</span>
                                </p>
                            </div>
                        @endif

                        {{-- Tombol Check-In / Check-Out --}}
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button wire:click="checkIn"
                                    @disabled($todayRecord?->check_in !== null)
                                    class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-teal-500 to-cyan-600 text-white font-semibold py-3 rounded-xl shadow hover:opacity-90 transition disabled:opacity-40 disabled:cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/>
                                </svg>
                                {{ $todayRecord?->check_in ? 'Sudah Check-In' : 'Check In Sekarang' }}
                            </button>

                            <button wire:click="checkOut"
                                    @disabled(!$todayRecord?->check_in || $todayRecord?->check_out !== null)
                                    class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-orange-400 to-rose-500 text-white font-semibold py-3 rounded-xl shadow hover:opacity-90 transition disabled:opacity-40 disabled:cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                                </svg>
                                {{ $todayRecord?->check_out ? 'Sudah Check-Out' : 'Check Out Sekarang' }}
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-amber-50 border border-amber-200 text-amber-700 px-5 py-4 rounded-xl text-sm font-medium">
                    ⚠️ Profil karyawan Anda belum terhubung ke akun ini. Hubungi admin.
                </div>
            @endif
        @endif

        {{-- ══════════════════ FILTER ══════════════════ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-5 py-4 flex flex-wrap gap-4 items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/></svg>
            <div class="flex flex-wrap gap-3 flex-1">
                <input type="date" wire:model.live="filterDate"
                       class="text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                <select wire:model.live="filterStatus"
                        class="text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                    <option value="">Semua Status</option>
                    <option value="hadir">Hadir</option>
                    <option value="sakit">Sakit</option>
                    <option value="izin">Izin</option>
                    <option value="alpa">Alpa</option>
                </select>
                <button wire:click="$set('filterDate', '')" class="text-xs text-gray-400 hover:text-gray-600 transition px-2">Reset</button>
            </div>
            <p class="text-xs text-gray-400">{{ $attendances->total() }} data</p>
        </div>

        {{-- ══════════════════ TABEL RIWAYAT ══════════════════ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-bold text-gray-800">Riwayat Kehadiran</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-5 py-3 text-left">Karyawan</th>
                            <th class="px-5 py-3 text-left">Tanggal</th>
                            <th class="px-5 py-3 text-center">Status</th>
                            <th class="px-5 py-3 text-center">Jam Masuk</th>
                            <th class="px-5 py-3 text-center">Jam Keluar</th>
                            <th class="px-5 py-3 text-center">Durasi</th>
                            @if(Auth::user()->role === 'admin')
                                <th class="px-5 py-3 text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($attendances as $att)
                            @php
                                $statusConfig = [
                                    'hadir' => ['Hadir',  'bg-emerald-100 text-emerald-700'],
                                    'sakit' => ['Sakit',  'bg-yellow-100 text-yellow-700'],
                                    'izin'  => ['Izin',   'bg-blue-100 text-blue-700'],
                                    'alpa'  => ['Alpa',   'bg-red-100 text-red-700'],
                                ];
                                [$sLabel, $sCls] = $statusConfig[$att->status] ?? [$att->status, 'bg-gray-100 text-gray-700'];
                            @endphp
                            <tr class="hover:bg-teal-50/30 transition-colors">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                            {{ strtoupper(substr($att->employee->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 leading-tight">{{ $att->employee->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $att->employee->position }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-gray-600">
                                    {{ $att->date->translatedFormat('d M Y') }}
                                    @if($att->date->isToday())
                                        <span class="ml-1 text-xs bg-teal-100 text-teal-600 px-1.5 py-0.5 rounded-full font-medium">Hari ini</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $sCls }}">{{ $sLabel }}</span>
                                </td>
                                <td class="px-5 py-3.5 text-center font-mono text-teal-600 font-semibold">
                                    {{ $att->check_in ? \Carbon\Carbon::createFromTimeString($att->check_in)->format('H:i') : '—' }}
                                </td>
                                <td class="px-5 py-3.5 text-center font-mono text-orange-500 font-semibold">
                                    {{ $att->check_out ? \Carbon\Carbon::createFromTimeString($att->check_out)->format('H:i') : '—' }}
                                </td>
                                <td class="px-5 py-3.5 text-center text-gray-500 text-xs">
                                    {{ $att->duration_formatted }}
                                </td>
                                @if(Auth::user()->role === 'admin')
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center justify-center gap-1">
                                            <button wire:click="openForm({{ $att->id }})"
                                                    class="p-1.5 rounded-lg text-blue-500 hover:bg-blue-100 transition" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                </svg>
                                            </button>
                                            <button wire:click="delete({{ $att->id }})"
                                                    wire:confirm="Yakin hapus data absensi ini?"
                                                    class="p-1.5 rounded-lg text-red-400 hover:bg-red-100 transition" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3 text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 opacity-30" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                                        </svg>
                                        <p class="font-medium text-sm">Tidak ada data absensi</p>
                                        <p class="text-xs">Coba ubah filter tanggal atau status.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($attendances->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ══════════════════ MODAL FORM (ADMIN) ══════════════════ --}}
    @if(Auth::user()->role === 'admin')
        <div x-data="{ show: @entangle('showForm') }"
             x-show="show"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
             style="display:none;">

            <div @click.outside="$wire.closeForm()"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">

                {{-- Modal Header --}}
                <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-white font-bold">{{ $editId ? 'Edit Absensi' : 'Catat Absensi Manual' }}</h3>
                    <button wire:click="closeForm" class="text-white/70 hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <form wire:submit="save" class="p-6 space-y-4">

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Karyawan</label>
                        <select wire:model="form_employee_id"
                                class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                            <option value="">— Pilih Karyawan —</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->nik }} — {{ $emp->name }}</option>
                            @endforeach
                        </select>
                        @error('form_employee_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tanggal</label>
                            <input type="date" wire:model="form_date"
                                   class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                            @error('form_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Status</label>
                            <select wire:model="form_status"
                                    class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                                <option value="hadir">Hadir</option>
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                                <option value="alpa">Alpa</option>
                            </select>
                            @error('form_status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Jam Masuk</label>
                            <input type="time" wire:model="form_check_in"
                                   class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                            @error('form_check_in') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Jam Keluar</label>
                            <input type="time" wire:model="form_check_out"
                                   class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                            @error('form_check_out') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Catatan (Opsional)</label>
                        <input type="text" wire:model="form_notes" placeholder="Mis: Izin dokter, terlambat, dll"
                               class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                    </div>

                    <div class="flex gap-3 pt-1">
                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="flex-1 bg-gradient-to-r from-teal-500 to-cyan-600 text-white text-sm font-semibold py-2.5 rounded-xl shadow hover:opacity-90 transition disabled:opacity-50 flex items-center justify-center gap-2">
                            <span wire:loading.remove>{{ $editId ? 'Perbarui' : 'Simpan' }}</span>
                            <span wire:loading class="flex items-center gap-1">
                                <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                </svg>
                                Menyimpan...
                            </span>
                        </button>
                        <button type="button" wire:click="closeForm"
                                class="flex-1 bg-gray-100 text-gray-600 text-sm font-semibold py-2.5 rounded-xl hover:bg-gray-200 transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
