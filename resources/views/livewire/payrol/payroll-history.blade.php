<div>

    {{-- Toast Notification --}}
    @if(session()->has('success'))
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center shadow-sm shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-800 tracking-tight">Riwayat Slip Gaji</h1>
                    <p class="text-sm text-slate-500">Seluruh histori penggajian karyawan perusahaan</p>
                </div>
            </div>

            {{-- Filter Periode --}}
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 18h4v-2h-4v2zM3 6v2h18V6H3zm3 7h12v-2H6v2z"/>
                </svg>
                <select wire:model.live="filterPeriod"
                        class="text-sm border-none bg-transparent text-slate-700 focus:ring-0 cursor-pointer p-0 font-medium w-32">
                    <option value="">Semua Periode</option>
                    @foreach($periods as $period)
                        <option value="{{ $period }}">{{ $period }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">

            {{-- Card Header --}}
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-white">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Data Penggajian</h2>
                    <p class="text-xs text-slate-500 mt-0.5"><span class="font-bold">{{ $payrolls->total() }}</span> record ditemukan</p>
                </div>
                <div class="w-8 h-8 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/>
                    </svg>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-slate-50/50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-4">Karyawan</th>
                            <th class="px-6 py-4">Periode</th>
                            <th class="px-6 py-4 text-right">Gaji Pokok</th>
                            <th class="px-6 py-4 text-right">Tunjangan</th>
                            <th class="px-6 py-4 text-right">Potongan</th>
                            <th class="px-6 py-4 text-right font-extrabold text-slate-500">Take Home Pay</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        @forelse($payrolls as $p)
                            <tr class="hover:bg-slate-50/80 transition-colors group">

                                {{-- Karyawan --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                            {{ strtoupper(substr($p->employee->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 leading-tight">{{ $p->employee->name }}</p>
                                            <p class="text-[11px] text-slate-500 mt-0.5">{{ $p->employee->position }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Periode --}}
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold border border-blue-200 bg-blue-50 text-blue-600">
                                        {{ $p->month_year }}
                                    </span>
                                </td>

                                {{-- Gaji Pokok --}}
                                <td class="px-6 py-4 text-right text-slate-600 font-mono tracking-tight font-medium">
                                    Rp {{ number_format($p->basic_salary, 0, ',', '.') }}
                                </td>

                                {{-- Tunjangan --}}
                                <td class="px-6 py-4 text-right font-mono tracking-tight">
                                    <span class="text-emerald-500 font-medium">+{{ number_format($p->allowance, 0, ',', '.') }}</span>
                                </td>

                                {{-- Potongan --}}
                                <td class="px-6 py-4 text-right font-mono tracking-tight">
                                    <span class="text-rose-500 font-medium">-{{ number_format($p->deduction, 0, ',', '.') }}</span>
                                </td>

                                {{-- THP --}}
                                <td class="px-6 py-4 text-right">
                                    <span class="text-base font-extrabold text-blue-700 font-mono tracking-tight">
                                        Rp {{ number_format($p->net_salary, 0, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-6 py-4 text-center">
                                    @if(Route::has('payroll.cetak'))
                                        <a href="{{ route('payroll.cetak', $p->id) }}" target="_blank"
                                           class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all text-[11px] font-bold uppercase tracking-wider shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                                            </svg>
                                            Cetak
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <div class="w-16 h-16 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-300" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                                            </svg>
                                        </div>
                                        <p class="font-bold text-slate-700">Belum ada riwayat penggajian</p>
                                        <p class="text-xs text-slate-500 mt-1">Coba sesuaikan filter atau 
                                            <a href="{{ route('payroll.calculator') }}" wire:navigate class="text-blue-600 hover:text-blue-700 font-bold hover:underline">Hitung Penggajian Baru</a>.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($payrolls->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $payrolls->links() }}
                </div>
            @endif

        </div>
    </div>

</div>