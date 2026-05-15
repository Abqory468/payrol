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

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 space-y-6">

        {{-- Page Header --}}
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center shadow-sm shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Kalkulator Penggajian</h1>
                <p class="text-sm text-slate-500">Hitung & simpan slip gaji karyawan bulan ini</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">

            {{-- Form Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                {{-- Card Header --}}
                <div class="bg-slate-50 border-b border-slate-100 px-6 py-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>
                    <div>
                        <h2 class="text-slate-800 font-bold text-sm">Input Data Penggajian</h2>
                        <p class="text-slate-500 text-[11px] mt-0.5">Isi seluruh komponen untuk menghitung Take Home Pay otomatis</p>
                    </div>
                </div>

                <form wire:submit="savePayroll" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- Pilih Karyawan --}}
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Pilih Karyawan</label>
                            <select wire:model="employee_id"
                                    class="w-full text-sm rounded-xl border-slate-200 bg-white px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                                <option value="">— Cari & Pilih Karyawan —</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->nik }} — {{ $emp->name }}</option>
                                @endforeach
                            </select>
                            @error('employee_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Periode Gaji --}}
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Periode Penggajian</label>
                            <div class="relative">
                                <input type="text" disabled wire:model="month_year"
                                       class="w-full text-sm font-semibold rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-500 cursor-not-allowed">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-bold text-blue-600 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-full uppercase tracking-wider">Otomatis</span>
                            </div>
                            @error('month_year') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Gaji Pokok --}}
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Gaji Pokok</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400 font-bold">Rp</span>
                                <input type="number" wire:model.live="basic_salary" min="0"
                                       class="w-full text-sm font-mono tracking-wide rounded-xl border-slate-200 bg-white pl-10 pr-4 py-3 text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                                       placeholder="0">
                            </div>
                            @error('basic_salary') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Tunjangan --}}
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Tunjangan</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-emerald-500 font-bold">+Rp</span>
                                <input type="number" wire:model.live="allowance" min="0"
                                       class="w-full text-sm font-mono tracking-wide rounded-xl border-slate-200 bg-white pl-11 pr-4 py-3 text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                                       placeholder="0">
                            </div>
                        </div>

                        {{-- Potongan --}}
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Potongan</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-rose-400 font-bold">-Rp</span>
                                <input type="number" wire:model.live="deduction" min="0"
                                       class="w-full text-sm font-mono tracking-wide rounded-xl border-slate-200 bg-white pl-11 pr-4 py-3 text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition"
                                       placeholder="0">
                            </div>
                        </div>

                    </div>

                    {{-- Take Home Pay Result --}}
                    <div class="mt-6 bg-blue-50 border border-blue-100 rounded-2xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">Take Home Pay (THP)</p>
                            <p class="text-xs text-slate-500 mt-1">Gaji Pokok + Tunjangan − Potongan</p>
                            {{-- Rincian mini --}}
                            <div class="flex items-center gap-3 mt-2 text-xs font-mono font-medium">
                                <span class="text-slate-600">{{ number_format($basic_salary ?: 0, 0, ',', '.') }}</span>
                                <span class="text-emerald-500">+{{ number_format($allowance ?: 0, 0, ',', '.') }}</span>
                                <span class="text-rose-500">-{{ number_format($deduction ?: 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="sm:text-right">
                            <p class="text-3xl font-extrabold text-blue-700 tracking-tight">
                                Rp {{ number_format($net_salary, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                            wire:loading.attr="disabled"
                            class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-3.5 rounded-xl shadow-sm transition-all disabled:opacity-50 disabled:bg-slate-300 flex items-center justify-center gap-2">
                        <span wire:loading.remove class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                            </svg>
                            Simpan Slip Gaji
                        </span>
                        <span wire:loading class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                            </svg>
                            Menyimpan...
                        </span>
                    </button>

                </form>
            </div>

        </div>
    </div>

</div>