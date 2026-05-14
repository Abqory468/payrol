<div>

    {{-- Toast Notification --}}
    @if(session()->has('success'))
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

    <div class="max-w-3xl mx-auto px-6 py-8">

        {{-- Page Header --}}
        <div class="mb-8 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Kalkulator Penggajian</h1>
                <p class="text-sm text-gray-500">Hitung & simpan slip gaji karyawan</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">

            {{-- Form Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-violet-600 to-purple-600 px-6 py-4">
                    <h2 class="text-white font-semibold text-sm">Input Data Penggajian</h2>
                    <p class="text-white/70 text-xs mt-0.5">Isi semua kolom untuk menghitung take home pay</p>
                </div>

                <form wire:submit="savePayroll" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- Pilih Karyawan --}}
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Karyawan</label>
                            <select wire:model="employee_id"
                                    class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 px-3 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition">
                                <option value="">— Pilih Karyawan —</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->nik }} — {{ $emp->name }}</option>
                                @endforeach
                            </select>
                            @error('employee_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Periode Gaji --}}
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Periode Gaji</label>
                            <div class="relative">
                                <input type="text" disabled wire:model="month_year"
                                       class="w-full text-sm rounded-lg border border-gray-200 bg-gray-100 px-3 py-2.5 text-gray-500 cursor-not-allowed">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 bg-gray-200 px-2 py-0.5 rounded-full">Auto</span>
                            </div>
                            @error('month_year') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Gaji Pokok --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Gaji Pokok</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">Rp</span>
                                <input type="number" wire:model.live="basic_salary" min="0"
                                       class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 pl-9 pr-3 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent transition"
                                       placeholder="0">
                            </div>
                            @error('basic_salary') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Tunjangan --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Tunjangan</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-emerald-500 font-medium">+Rp</span>
                                <input type="number" wire:model.live="allowance" min="0"
                                       class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 pl-10 pr-3 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                                       placeholder="0">
                            </div>
                        </div>

                        {{-- Potongan --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Potongan</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-red-400 font-medium">-Rp</span>
                                <input type="number" wire:model.live="deduction" min="0"
                                       class="w-full text-sm rounded-lg border border-gray-200 bg-gray-50 pl-10 pr-3 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent transition"
                                       placeholder="0">
                            </div>
                        </div>

                    </div>

                    {{-- Take Home Pay Result --}}
                    <div class="mt-6 bg-gradient-to-r from-violet-50 to-purple-50 border border-violet-100 rounded-xl p-5 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-violet-500 uppercase tracking-wider">Take Home Pay (THP)</p>
                            <p class="text-xs text-gray-400 mt-0.5">Gaji Pokok + Tunjangan − Potongan</p>
                            {{-- Rincian mini --}}
                            <div class="flex gap-3 mt-2 text-xs text-gray-500">
                                <span class="text-gray-600">Rp {{ number_format($basic_salary ?: 0, 0, ',', '.') }}</span>
                                <span class="text-emerald-500">+{{ number_format($allowance ?: 0, 0, ',', '.') }}</span>
                                <span class="text-red-400">-{{ number_format($deduction ?: 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-extrabold text-violet-700 tabular-nums">
                                Rp {{ number_format($net_salary, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                            wire:loading.attr="disabled"
                            class="mt-5 w-full bg-gradient-to-r from-violet-600 to-purple-600 text-white text-sm font-semibold py-3 rounded-xl shadow-md hover:shadow-lg hover:opacity-90 transition disabled:opacity-50 flex items-center justify-center gap-2">
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