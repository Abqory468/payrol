<div>

    {{-- Toast Notification --}}
    @if(session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-emerald-50 border border-emerald-100 text-emerald-800 px-5 py-3 rounded-xl shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd"/>
            </svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        {{-- ══════════════════ PAGE HEADER ══════════════════ --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-800 tracking-tight">Absensi Kehadiran</h1>
                    <p class="text-sm text-slate-500">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>

            @if(Auth::user()->role === 'admin')
                <button wire:click="openForm()"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl shadow-sm transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    Catat Absensi Manual
                </button>
            @endif
        </div>

        {{-- ══════════════════ KARTU CHECK-IN/OUT (KARYAWAN) ══════════════════ --}}
        @if(Auth::user()->role !== 'admin')
            @if($myEmployee)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-blue-600 px-6 py-5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <p class="text-blue-100 text-[11px] font-bold uppercase tracking-wider">Absensi Hari Ini</p>
                            <h2 class="text-white font-bold text-xl mt-0.5">{{ $myEmployee->name }}</h2>
                            <p class="text-blue-100/80 text-sm mt-0.5">{{ $myEmployee->position }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl px-4 py-2 text-right">
                            <p class="text-blue-100 text-[11px] font-bold uppercase tracking-wider">Batas Check-in</p>
                            <p class="text-white font-bold text-xl">{{ $lateThreshold }}</p>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                            {{-- Status --}}
                            <div class="bg-slate-50 rounded-xl p-5 text-center border {{ $todayRecord?->status === 'telat' ? 'border-orange-200 bg-orange-50' : 'border-slate-100' }}">
                                <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mb-2">Status</p>
                                @if($todayRecord)
                                    @php
                                        $statusMap = [
                                            'hadir'=>['Hadir','bg-emerald-50 border-emerald-200 text-emerald-600'],
                                            'telat'=>['Telat','bg-orange-50 border-orange-200 text-orange-600'],
                                            'sakit'=>['Sakit','bg-amber-50 border-amber-200 text-amber-600'],
                                            'izin'=>['Izin','bg-blue-50 border-blue-200 text-blue-600'],
                                            'alpa'=>['Alpa','bg-rose-50 border-rose-200 text-rose-600']
                                        ];
                                        [$label,$cls] = $statusMap[$todayRecord->status] ?? [$todayRecord->status,'bg-slate-50 border-slate-200 text-slate-600'];
                                    @endphp
                                    <span class="inline-flex px-3 py-1 rounded-md border text-sm font-bold {{ $cls }}">{{ $label }}</span>
                                @else
                                    <span class="inline-flex px-3 py-1 rounded-md border border-slate-200 text-sm font-bold bg-white text-slate-500 shadow-sm">Belum Absen</span>
                                @endif
                            </div>
                            {{-- Check In --}}
                            <div class="bg-slate-50 rounded-xl p-5 text-center border border-slate-100">
                                <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mb-2">Jam Masuk</p>
                                <p class="text-3xl font-bold font-mono tracking-tight {{ $todayRecord?->check_in ? ($todayRecord->status === 'telat' ? 'text-orange-500' : 'text-blue-600') : 'text-slate-300' }}">
                                    {{ $todayRecord?->check_in ? \Carbon\Carbon::createFromTimeString($todayRecord->check_in)->format('H:i') : '—' }}
                                </p>
                            </div>
                            {{-- Check Out --}}
                            <div class="bg-slate-50 rounded-xl p-5 text-center border border-slate-100">
                                <p class="text-[11px] text-slate-500 font-bold uppercase tracking-wider mb-2">Jam Keluar</p>
                                <p class="text-3xl font-bold font-mono tracking-tight {{ $todayRecord?->check_out ? 'text-slate-800' : 'text-slate-300' }}">
                                    {{ $todayRecord?->check_out ? \Carbon\Carbon::createFromTimeString($todayRecord->check_out)->format('H:i') : '—' }}
                                </p>
                            </div>
                        </div>

                        {{-- Durasi --}}
                        @if($todayRecord?->duration !== null)
                            <div class="bg-blue-50 border border-blue-100 rounded-xl px-5 py-4 text-center mb-6">
                                <p class="text-blue-800 text-sm">
                                    Total Durasi Kerja Hari Ini: <span class="font-bold font-mono">{{ $todayRecord->duration_formatted }}</span>
                                </p>
                            </div>
                        @endif

                        {{-- Section Action (Hanya jika belum check-out) --}}
                        @if(! $todayRecord?->check_out)
                            <div class="flex flex-col md:flex-row gap-5 items-end bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                                
                                {{-- Tombol Check In (aktif jika belum check-in) --}}
                                @if(! $todayRecord?->check_in)
                                    <div class="flex-1 w-full space-y-2">
                                        <label class="block text-xs font-bold text-slate-600">Pilih Status Kehadiran:</label>
                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <select wire:model="checkInType" class="rounded-xl border-slate-200 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500 flex-1 py-3 px-4">
                                                <option value="hadir">Hadir Bekerja</option>
                                                <option value="sakit">Sedang Sakit</option>
                                            </select>
                                            <button wire:click="checkIn"
                                                    class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-sm transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/>
                                                </svg>
                                                Lakukan Check In
                                            </button>
                                        </div>
                                        @if(now()->format('H:i') > $lateThreshold)
                                            <p class="text-xs text-orange-600 font-medium flex items-center gap-1.5 mt-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                Sudah lewat batas pukul {{ $lateThreshold }}. Anda akan tercatat "Telat".
                                            </p>
                                        @endif
                                    </div>
                                @else
                                    <div class="flex-1 w-full text-center py-4 bg-slate-50 rounded-xl border border-slate-100">
                                        <p class="text-sm font-medium text-slate-500">✅ Anda sudah berhasil Check-in hari ini.</p>
                                    </div>
                                @endif

                                {{-- Tombol Check Out (aktif jika sudah check-in tapi belum check-out) --}}
                                <div class="flex-1 w-full">
                                    <button wire:click="checkOut"
                                            @disabled(! $todayRecord?->check_in)
                                            class="w-full flex items-center justify-center gap-2 bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 rounded-xl shadow-sm transition-all disabled:opacity-50 disabled:bg-slate-300 disabled:cursor-not-allowed">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                                        </svg>
                                        Lakukan Check Out
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- State Selesai Kerja --}}
                            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl px-6 py-8 text-center mt-2">
                                <div class="w-14 h-14 bg-white shadow-sm text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 border border-emerald-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-lg text-emerald-800">Selesai Pekerjaan Hari Ini</h3>
                                <p class="text-sm text-emerald-600 mt-1 max-w-sm mx-auto">Anda sudah melengkapi absensi check-in dan check-out hari ini. Selamat beristirahat!</p>
                            </div>
                        @endif

                    </div>
                </div>
            @else
                <div class="bg-amber-50 border border-amber-200 text-amber-800 px-6 py-5 rounded-2xl text-sm flex gap-4 items-center shadow-sm">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shrink-0 shadow-sm border border-amber-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-base">Profil Belum Terhubung</p>
                        <p class="mt-0.5 opacity-90">Akun Anda belum ditautkan ke data Karyawan manapun. Silakan hubungi Administrator.</p>
                    </div>
                </div>
            @endif
        @endif

        {{-- ══════════════════ FILTER ══════════════════ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-6 py-5 flex flex-wrap gap-4 items-center justify-between">
            <div class="flex items-center gap-4 w-full sm:w-auto">
                <div class="w-8 h-8 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor"><path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/></svg>
                </div>
                <div class="flex flex-1 sm:flex-none gap-3">
                    <input type="date" wire:model.live="filterDate"
                           class="w-full sm:w-auto text-sm rounded-xl border-slate-200 bg-white px-4 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm">
                    <select wire:model.live="filterStatus"
                            class="w-full sm:w-auto text-sm rounded-xl border-slate-200 bg-white px-4 py-2.5 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm">
                        <option value="">Semua Status</option>
                        <option value="hadir">Hadir</option>
                        <option value="telat">Telat</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                        <option value="alpa">Alpa</option>
                    </select>
                </div>
                <button wire:click="$set('filterDate', '')" class="text-[11px] font-bold text-slate-400 hover:text-slate-600 transition uppercase tracking-wide">Reset</button>
            </div>
            <p class="text-xs text-slate-500 font-medium bg-slate-50 px-3.5 py-2 rounded-lg border border-slate-100">
                Total: <span class="font-bold text-slate-800">{{ $attendances->total() }}</span> record
            </p>
        </div>

        {{-- ══════════════════ TABEL RIWAYAT ══════════════════ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h2 class="text-base font-bold text-slate-800">Riwayat Kehadiran</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-slate-50/50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-4">Karyawan</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Check In</th>
                            <th class="px-6 py-4 text-center">Check Out</th>
                            <th class="px-6 py-4 text-center">Durasi</th>
                            @if(Auth::user()->role === 'admin')
                                <th class="px-6 py-4 text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($attendances as $att)
                            @php
                                $statusConfig = [
                                    'hadir' => ['Hadir',  'bg-emerald-50 text-emerald-600 border-emerald-200'],
                                    'telat' => ['Telat',  'bg-orange-50 text-orange-600 border-orange-200'],
                                    'sakit' => ['Sakit',  'bg-amber-50 text-amber-600 border-amber-200'],
                                    'izin'  => ['Izin',   'bg-blue-50 text-blue-600 border-blue-200'],
                                    'alpa'  => ['Alpa',   'bg-rose-50 text-rose-600 border-rose-200'],
                                ];
                                [$sLabel, $sCls] = $statusConfig[$att->status] ?? [$att->status, 'bg-slate-100 text-slate-600 border-slate-200'];
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                            {{ strtoupper(substr($att->employee->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 leading-tight">{{ $att->employee->name }}</p>
                                            <p class="text-[11px] text-slate-500 mt-0.5">{{ $att->employee->position }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-700 font-medium">{{ $att->date->translatedFormat('d M Y') }}</span>
                                    @if($att->date->isToday())
                                        <span class="block text-[10px] uppercase font-bold text-blue-500 mt-1 tracking-wider">Hari ini</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2.5 py-1 rounded-md text-[11px] font-bold border {{ $sCls }}">{{ $sLabel }}</span>
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-bold tracking-tight {{ $att->status === 'telat' ? 'text-orange-500' : 'text-slate-600' }}">
                                    {{ $att->check_in ? \Carbon\Carbon::createFromTimeString($att->check_in)->format('H:i') : '—' }}
                                </td>
                                <td class="px-6 py-4 text-center font-mono font-bold tracking-tight text-slate-600">
                                    {{ $att->check_out ? \Carbon\Carbon::createFromTimeString($att->check_out)->format('H:i') : '—' }}
                                </td>
                                <td class="px-6 py-4 text-center text-slate-500 text-xs font-medium">
                                    {{ $att->duration_formatted ?: '—' }}
                                </td>
                                @if(Auth::user()->role === 'admin')
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button wire:click="openForm({{ $att->id }})"
                                                    class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 border border-transparent hover:border-blue-100 transition" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                            </button>
                                            <button wire:click="delete({{ $att->id }})"
                                                    wire:confirm="Yakin hapus data absensi ini?"
                                                    class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-100 transition" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-300" viewBox="0 0 24 24" fill="currentColor"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
                                        </div>
                                        <p class="font-bold text-slate-700">Tidak ada riwayat kehadiran</p>
                                        <p class="text-xs text-slate-500 mt-1">Belum ada data yang tercatat sesuai filter.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($attendances->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>

    </div>

    {{-- ══════════════════ MODAL FORM (ADMIN) ══════════════════ --}}
    @if(Auth::user()->role === 'admin')
        <div x-data="{ show: @entangle('showForm') }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
             style="display:none;">

            <div @click.outside="$wire.closeForm()"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-slate-100">

                <div class="bg-slate-50 px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-slate-800 font-bold text-lg">{{ $editId ? 'Edit Absensi' : 'Catat Absensi Manual' }}</h3>
                    <button wire:click="closeForm" class="w-8 h-8 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                    </button>
                </div>

                <form wire:submit="save" class="p-6 space-y-5">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Karyawan</label>
                        <select wire:model="form_employee_id"
                                class="w-full text-sm rounded-xl border-slate-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            <option value="">— Pilih Karyawan —</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->nik }} — {{ $emp->name }}</option>
                            @endforeach
                        </select>
                        @error('form_employee_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tanggal</label>
                            <input type="date" wire:model="form_date"
                                   class="w-full text-sm rounded-xl border-slate-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            @error('form_date') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Status</label>
                            <select wire:model="form_status"
                                    class="w-full text-sm rounded-xl border-slate-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                <option value="hadir">Hadir</option>
                                <option value="telat">Telat</option>
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                                <option value="alpa">Alpa</option>
                            </select>
                            @error('form_status') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jam Masuk</label>
                            <input type="time" wire:model="form_check_in"
                                   class="w-full text-sm font-mono tracking-wide rounded-xl border-slate-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            @error('form_check_in') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jam Keluar</label>
                            <input type="time" wire:model="form_check_out"
                                   class="w-full text-sm font-mono tracking-wide rounded-xl border-slate-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                            @error('form_check_out') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Catatan Khusus (Opsional)</label>
                        <input type="text" wire:model="form_notes" placeholder="Mis: Cuti tahunan, Izin setengah hari, dll"
                               class="w-full text-sm rounded-xl border-slate-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="flex-1 bg-blue-600 text-white hover:bg-blue-700 text-sm font-bold py-3.5 rounded-xl shadow-sm transition-all disabled:opacity-50 flex items-center justify-center gap-2">
                            <span wire:loading.remove>{{ $editId ? 'Perbarui Absensi' : 'Simpan Absensi' }}</span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                                </svg>
                                Menyimpan...
                            </span>
                        </button>
                        <button type="button" wire:click="closeForm"
                                class="flex-1 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-sm font-bold py-3.5 rounded-xl transition-all">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
