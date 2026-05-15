<div class="min-h-screen bg-slate-50/50">

    @if (session()->has('success'))
        <div class="mx-6 mt-4 bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm animate-fade-in-down">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- ══════════════════ ADMIN VIEW ══════════════════ --}}
    @if($isAdmin)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- ① WELCOME BANNER --}}
        <div class="bg-blue-600 rounded-2xl p-8 flex flex-col md:flex-row md:items-center md:justify-between shadow-lg shadow-blue-600/10 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
            <div class="relative z-10">
                <p class="text-blue-100 font-medium mb-1">Halo, Selamat Datang 👋</p>
                <h1 class="text-3xl font-bold text-white tracking-tight">{{ Auth::user()->name }}</h1>
                <p class="text-blue-100 text-sm mt-2 flex items-center gap-2">
                    <span class="bg-blue-500/50 px-2.5 py-1 rounded-md text-xs font-semibold backdrop-blur-sm border border-blue-400/30">Periode Aktif</span>
                    <span>{{ $periodeBulanIni }}</span>
                </p>
            </div>
            <div class="relative z-10 mt-6 md:mt-0 bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/10 text-center min-w-[200px]">
                <p id="live-date" class="text-blue-50 font-medium text-sm mb-1"></p>
                <p id="live-time" class="text-2xl font-bold text-white tracking-wider font-mono"></p>
            </div>
        </div>

        {{-- ② STATS CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            {{-- Total Karyawan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center shrink-0 border border-slate-100">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-3.87a4 4 0 10-8 0 4 4 0 008 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-0.5">Total Karyawan</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalKaryawan }}</p>
                </div>
            </div>

            {{-- Total Payroll --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0 border border-blue-100">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-0.5">Total Payroll</p>
                    <p class="text-xl font-bold text-slate-800">Rp {{ number_format($totalGaji, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Hadir Hari Ini --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0 border border-emerald-100">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-0.5">Hadir Hari Ini</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $hadirHariIni }} <span class="text-xs font-medium text-slate-400 normal-case">/ {{ $totalKaryawan }}</span></p>
                </div>
            </div>

            {{-- Slip Gaji Diterbitkan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0 border border-indigo-100">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-0.5">Slip Terbit</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalPayslips }}</p>
                </div>
            </div>

        </div>

        {{-- ③ CHART + NOTIFIKASI --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Payroll Chart (6 bulan terakhir) --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-base font-bold text-slate-800">Tren Pengeluaran Payroll</h2>
                        <p class="text-sm text-slate-500 mt-0.5">6 Bulan Terakhir</p>
                    </div>
                </div>

                <div class="relative h-64 w-full">
                    <canvas id="payrollChart"></canvas>
                </div>
            </div>

            {{-- Script for Chart.js --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('livewire:navigated', () => {
                    initPayrollChart();
                });

                document.addEventListener('DOMContentLoaded', () => {
                    initPayrollChart();
                });

                function initPayrollChart() {
                    const ctx = document.getElementById('payrollChart');
                    if (!ctx) return;

                    // Clean up existing chart if any
                    const existingChart = Chart.getChart(ctx);
                    if (existingChart) {
                        existingChart.destroy();
                    }

                    const labels = @json(collect($chartData)->pluck('label'));
                    const dataValues = @json(collect($chartData)->pluck('total'));

                    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
                    gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Gaji',
                                data: dataValues,
                                borderColor: '#2563eb',
                                borderWidth: 3,
                                backgroundColor: gradient,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#2563eb',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: '#1e293b',
                                    titleFont: { size: 12, weight: 'bold' },
                                    bodyFont: { size: 12 },
                                    padding: 12,
                                    displayColors: false,
                                    callbacks: {
                                        label: function(context) {
                                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        display: true,
                                        color: '#f1f5f9',
                                        drawBorder: false
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + 'M';
                                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                        },
                                        color: '#94a3b8',
                                        font: { size: 11 }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#94a3b8',
                                        font: { size: 11 }
                                    }
                                }
                            }
                        }
                    });
                }
            </script>

            {{-- Notifikasi --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col">
                <h2 class="text-base font-bold text-slate-800 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    Pusat Informasi
                </h2>
                <div class="space-y-3 flex-1">

                    {{-- Belum absen --}}
                    @if($belumAbsen > 0)
                        <div class="flex items-start gap-3 p-3.5 bg-rose-50 border border-rose-100 rounded-xl">
                            <div class="w-8 h-8 rounded-full bg-white text-rose-500 flex items-center justify-center shrink-0 shadow-sm border border-rose-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $belumAbsen }} karyawan belum absen</p>
                                <p class="text-xs text-slate-500 mt-0.5">Batas waktu hari ini</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3 p-3.5 bg-emerald-50 border border-emerald-100 rounded-xl">
                            <div class="w-8 h-8 rounded-full bg-white text-emerald-500 flex items-center justify-center shrink-0 shadow-sm border border-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Semua absen lengkap</p>
                                <p class="text-xs text-slate-500 mt-0.5">Kehadiran 100%</p>
                            </div>
                        </div>
                    @endif

                    {{-- Slip gaji bulan ini --}}
                    @if($totalPayslips > 0)
                        <div class="flex items-start gap-3 p-3.5 bg-blue-50 border border-blue-100 rounded-xl">
                            <div class="w-8 h-8 rounded-full bg-white text-blue-500 flex items-center justify-center shrink-0 shadow-sm border border-blue-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $totalPayslips }} Slip Terbit</p>
                                <p class="text-xs text-slate-500 mt-0.5">Bulan {{ $periodeBulanIni }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3 p-3.5 bg-slate-50 border border-slate-200 rounded-xl">
                            <div class="w-8 h-8 rounded-full bg-white text-slate-400 flex items-center justify-center shrink-0 shadow-sm border border-slate-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Payroll Belum Diproses</p>
                                <p class="text-xs text-slate-500 mt-0.5">Untuk bulan ini</p>
                            </div>
                        </div>
                    @endif

                    {{-- Karyawan belum punya data --}}
                    @php
                        $noEmployee = \App\Models\User::where('role','user')->whereDoesntHave('employee')->count();
                    @endphp
                    @if($noEmployee > 0)
                        <div class="flex items-start gap-3 p-3.5 bg-orange-50 border border-orange-100 rounded-xl">
                            <div class="w-8 h-8 rounded-full bg-white text-orange-500 flex items-center justify-center shrink-0 shadow-sm border border-orange-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">{{ $noEmployee }} Akun Menganggur</p>
                                <p class="text-xs text-slate-500 mt-0.5">Belum ditautkan ke data karyawan</p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ④ TABEL ABSENSI HARI INI + QUICK ACTIONS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Attendance Table --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-800">Log Kehadiran Hari Ini</h2>
                    <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">{{ now()->format('d M Y') }}</span>
                </div>

                @if($attendanceHariIni->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="text-xs text-slate-400 uppercase tracking-wider bg-slate-50/50">
                                <th class="px-6 py-4 font-semibold">Karyawan</th>
                                <th class="px-6 py-4 font-semibold text-center">Status</th>
                                <th class="px-6 py-4 font-semibold text-center">Jam Masuk</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($attendanceHariIni as $att)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 font-bold flex items-center justify-center text-xs">
                                                {{ strtoupper(substr($att->employee->name ?? '?', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-800">{{ $att->employee->name ?? '—' }}</p>
                                                <p class="text-xs text-slate-500">{{ $att->employee->position ?? '—' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusConfig = [
                                                'hadir'  => ['Hadir', 'bg-emerald-50 text-emerald-600 border-emerald-200'],
                                                'telat'  => ['Telat', 'bg-orange-50 text-orange-600 border-orange-200'],
                                                'sakit'  => ['Sakit', 'bg-amber-50 text-amber-600 border-amber-200'],
                                                'izin'   => ['Izin',  'bg-blue-50 text-blue-600 border-blue-200'],
                                                'alpa'   => ['Alpa',  'bg-rose-50 text-rose-600 border-rose-200'],
                                            ];
                                            [$sLabel, $sCls] = $statusConfig[$att->status] ?? [ucfirst($att->status), 'bg-slate-100 text-slate-600 border-slate-200'];
                                        @endphp
                                        <span class="inline-flex px-2.5 py-1 rounded-md text-xs font-semibold border {{ $sCls }}">
                                            {{ $sLabel }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-mono text-slate-600">
                                        {{ $att->check_in ? \Carbon\Carbon::createFromTimeString($att->check_in)->format('H:i') : '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="flex flex-col items-center justify-center py-16 text-slate-400">
                        <svg class="w-12 h-12 mb-4 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        <p class="text-sm font-medium text-slate-500">Belum ada aktivitas kehadiran hari ini</p>
                    </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col">
                <h2 class="text-base font-bold text-slate-800 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Akses Cepat
                </h2>
                
                <div class="grid grid-cols-1 gap-3 mb-6">
                    <a href="{{ route('attendance.index') }}" wire:navigate
                       class="group flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-blue-500 hover:bg-blue-50 transition-all">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Absensi</p>
                            <p class="text-xs text-slate-500">Urus Absensi Karyawan</p>
                        </div>
                    </a>

                    <a href="{{ route('payroll.calculator') }}" wire:navigate
                       class="group flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-blue-500 hover:bg-blue-50 transition-all">
                        <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Proses Payroll</p>
                            <p class="text-xs text-slate-500">Hitung & terbitkan slip gaji</p>
                        </div>
                    </a>

                    <a href="{{ route('employee.index') }}" wire:navigate
                       class="group flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:border-blue-500 hover:bg-blue-50 transition-all">
                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Kelola Karyawan</p>
                            <p class="text-xs text-slate-500">Tambah data pegawai baru</p>
                        </div>
                    </a>
                </div>

                {{-- Payslip terbaru --}}
                @if($payslipsTerbaru->count() > 0)
                <div class="mt-auto pt-5 border-t border-slate-100">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Slip Terbaru</p>
                    <div class="space-y-2">
                        @foreach($payslipsTerbaru->take(3) as $ps)
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                <span class="text-slate-600 font-medium">{{ $ps->employee->name ?? '—' }}</span>
                            </div>
                            <span class="font-bold text-slate-800">Rp {{ number_format($ps->net_salary, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div><!-- /admin wrapper -->

    {{-- ══════════════════ USER VIEW ══════════════════ --}}
    @else
    <div class="max-w-88xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        
        {{-- Banner Welcome User --}}
        <div class="bg-white rounded-3xl p-8 flex flex-col md:flex-row md:items-center md:justify-between shadow-sm border border-slate-200 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-full bg-gradient-to-l from-blue-50 to-transparent"></div>
            
            <div class="relative z-10">
                <p class="text-slate-500 font-medium mb-1">Halo, Selamat Datang 👋</p>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">{{ Auth::user()->name }}</h1>
                @if($employee)
                    <p class="mt-3 flex items-center gap-3">
                        <span class="bg-blue-50 text-blue-700 border border-blue-100 px-3 py-1 rounded-lg text-xs font-bold">{{ $employee->position }}</span>
                        <span class="text-sm text-slate-500 font-medium">NIK: {{ $employee->nik }}</span>
                    </p>
                @endif
            </div>
            
            <div class="relative z-10 mt-6 md:mt-0 text-right min-w-[200px]">
                <p id="live-date" class="text-slate-500 font-medium text-sm mb-1"></p>
                <p id="live-time" class="text-3xl font-bold text-blue-600 tracking-wider font-mono"></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Kolom Kiri: Status Hari Ini & Aksi --}}
            <div class="space-y-8">
                
                {{-- Status Absensi Widget --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden relative">
                    <div class="p-6">
                        <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Status Hari Ini
                        </h2>
                        
                        @if($employee)
                            <div class="space-y-5">
                                @if($sudahAbsen)
                                    @php
                                        // Cek detail kehadiran hari ini
                                        $todayRecord = \App\Models\Attendance::where('employee_id', $employee->id)->where('date', date('Y-m-d'))->first();
                                    @endphp
                                    
                                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            @if($todayRecord && $todayRecord->status === 'telat')
                                                <div class="w-12 h-12 rounded-xl bg-orange-50 border border-orange-100 text-orange-500 flex items-center justify-center shrink-0">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-800">Tercatat Telat</p>
                                                    <p class="text-xs font-medium text-slate-500 mt-0.5">{{ \Carbon\Carbon::createFromTimeString($todayRecord->check_in)->format('H:i') }} WIB</p>
                                                </div>
                                            @elseif($todayRecord && $todayRecord->status === 'sakit')
                                                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-500 flex items-center justify-center shrink-0">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-800">Tercatat Sakit</p>
                                                    <p class="text-xs font-medium text-slate-500 mt-0.5">Semoga lekas sembuh</p>
                                                </div>
                                            @else
                                                <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-500 flex items-center justify-center shrink-0">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-800">Hadir Tepat Waktu</p>
                                                    <p class="text-xs font-medium text-slate-500 mt-0.5">{{ $todayRecord && $todayRecord->check_in ? \Carbon\Carbon::createFromTimeString($todayRecord->check_in)->format('H:i') . ' WIB' : 'Tercatat' }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-4">
                                        <div class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <div>
                                                <p class="text-sm font-semibold text-blue-800 leading-tight">Kehadiran tercatat!</p>
                                                <p class="text-xs text-blue-600/80 mt-1">Jangan lupa melakukan Check-out saat selesai bekerja.</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center bg-slate-50 border border-slate-200 rounded-2xl p-6 text-center">
                                        <div class="w-14 h-14 bg-white border border-slate-200 rounded-xl flex items-center justify-center mb-4">
                                            <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        </div>
                                        <p class="text-base font-bold text-slate-800">Belum Check-in</p>
                                        <p class="text-xs text-slate-500 mt-1 mb-5">Batas waktu check-in adalah pukul 08:30 WIB.</p>
                                        
                                        <a href="{{ route('attendance.index') }}" wire:navigate class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                                            <span>Lakukan Check-in</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    </div>
                                @endif
                                
                                <div class="pt-2">
                                    <a href="{{ route('attendance.index') }}" wire:navigate class="w-full flex items-center justify-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold py-3 px-4 rounded-xl transition-colors group">
                                        <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Lihat Menu Absensi
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="bg-amber-50 border border-amber-200 p-5 rounded-2xl flex flex-col items-center text-center">
                                <svg class="w-10 h-10 text-amber-500 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <p class="text-sm font-bold text-amber-800">Profil Belum Terhubung</p>
                                <p class="text-xs text-amber-700 mt-1">Akun ini belum tertaut dengan data karyawan. Silakan hubungi Administrator HR.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan: Payslips --}}
            <div class="lg:col-span-2 space-y-8">
                
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200 h-full flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Slip Gaji Terakhir
                        </h3>
                        <span class="bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1 rounded-full border border-slate-200">{{ count($payrolls) }} Dokumen</span>
                    </div>

                    @if($employee && count($payrolls) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($payrolls as $index => $pr)
                                <div class="group relative bg-white border border-slate-200 hover:border-blue-300 rounded-2xl p-5 transition-all hover:shadow-md flex flex-col justify-between {{ $index === 0 ? 'md:col-span-2 bg-blue-50/30' : '' }}">
                                    
                                    @if($index === 0)
                                        <div class="absolute top-0 right-0 bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-bl-xl rounded-tr-xl border-b border-l border-blue-200">Terbaru</div>
                                    @endif

                                    <div class="flex items-start gap-4 mb-4">
                                        <div class="w-12 h-12 rounded-xl {{ $index === 0 ? 'bg-blue-100 text-blue-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 {{ $index === 0 ? 'text-lg' : '' }}">{{ $pr->month_year }}</p>
                                            <p class="text-sm text-slate-500 mt-1">Take Home Pay</p>
                                            <p class="font-extrabold text-slate-800 {{ $index === 0 ? 'text-2xl mt-1 text-blue-600' : 'text-lg mt-0.5' }}">Rp {{ number_format($pr->net_salary, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="pt-4 border-t border-slate-100">
                                        <a href="{{ route('payroll.cetak', $pr->id) }}" target="_blank" class="flex items-center justify-center gap-2 w-full {{ $index === 0 ? 'bg-blue-600 hover:bg-blue-700 text-white border-transparent' : 'bg-white hover:bg-slate-50 text-slate-700 border-slate-200' }} border font-medium py-2.5 px-4 rounded-xl transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                            Unduh Slip Gaji PDF
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center py-10 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-sm border border-slate-100 mb-4">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                            </div>
                            <p class="text-base font-bold text-slate-800">Belum Ada Riwayat Gaji</p>
                            <p class="text-sm text-slate-500 mt-1 max-w-xs text-center">Slip gaji Anda akan otomatis muncul di sini setelah Admin memproses Payroll.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    @endif

</div>

<script>
    function updateClock() {
        const d = document.getElementById('live-date');
        const t = document.getElementById('live-time');
        if (!d || !t) return;
        const now = new Date();
        d.textContent = now.toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
        t.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>