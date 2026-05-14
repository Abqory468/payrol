<div class="min-h-screen bg-slate-50">

    @if (session()->has('success'))
        <div class="mx-6 mt-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ══════════════════ ADMIN VIEW ══════════════════ --}}
    @if($isAdmin)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- ① WELCOME BANNER --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 flex flex-col md:flex-row md:items-center md:justify-between shadow-lg">
            <div>
                <h1 class="text-2xl font-bold text-white">Selamat Datang Kembali, {{ Auth::user()->name }} 👋</h1>
                <p class="text-blue-100 text-sm mt-1">Kelola penggajian, kehadiran, dan karyawan Anda - semuanya di satu tempat.</p>
                <p class="text-blue-200 text-xs mt-1">Periode aktif: <span class="font-semibold text-white">{{ $periodeBulanIni }}</span></p>
            </div>
            <div class="mt-4 md:mt-0 text-right">
                <p id="live-date" class="text-white font-semibold text-lg"></p>
                <p id="live-time" class="text-blue-200 text-sm font-mono"></p>
            </div>
        </div>

        {{-- ② STATS CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            {{-- Total Karyawan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-3.87a4 4 0 10-8 0 4 4 0 008 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Total Karyawan</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalKaryawan }}</p>
                    <p class="text-xs text-blue-500 mt-0.5">Terdaftar di sistem</p>
                </div>
            </div>

            {{-- Total Payroll --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Total Payroll Bulan Ini</p>
                    <p class="text-xl font-bold text-slate-800">Rp {{ number_format($totalGaji, 0, ',', '.') }}</p>
                    <p class="text-xs text-emerald-500 mt-0.5">{{ $periodeBulanIni }}</p>
                </div>
            </div>

            {{-- Hadir Hari Ini --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Hadir Hari Ini</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $hadirHariIni }}</p>
                    <p class="text-xs text-green-500 mt-0.5">Dari {{ $totalKaryawan }} karyawan</p>
                </div>
            </div>

            {{-- Slip Gaji Diterbitkan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center gap-4 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Slip Diterbitkan</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $totalPayslips }}</p>
                    <p class="text-xs text-purple-500 mt-0.5">Bulan ini</p>
                </div>
            </div>

        </div>

        {{-- ③ CHART + NOTIFIKASI --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Payroll Chart (6 bulan terakhir) --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-base font-bold text-slate-800">Pengeluaran Payroll 6 Bulan Terakhir</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Data real dari database</p>
                    </div>
                    <span class="bg-blue-50 text-blue-600 text-xs font-semibold px-3 py-1 rounded-full">Real Data</span>
                </div>

                @php
                    $maxChart = collect($chartData)->max('total') ?: 1;
                @endphp

                <div class="flex items-end gap-3 h-44">
                    @foreach($chartData as $bar)
                        @php $heightPct = $maxChart > 0 ? round(($bar['total'] / $maxChart) * 100) : 0; @endphp
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <span class="text-[10px] text-slate-500 font-medium leading-tight text-center">
                                @if($bar['total'] > 0) Rp{{ number_format($bar['total']/1000000, 1) }}jt @else — @endif
                            </span>
                            <div class="w-full rounded-t-lg transition-all duration-500 hover:opacity-80 {{ $heightPct > 70 ? 'bg-blue-600' : 'bg-blue-200' }}"
                                 style="height: {{ max($heightPct, 4) }}%"></div>
                            <span class="text-xs text-slate-500">{{ $bar['label'] }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 flex items-center gap-4 text-xs text-slate-400">
                    <span class="flex items-center gap-1"><span class="w-3 h-3 bg-blue-600 rounded-sm inline-block"></span> Tertinggi</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 bg-blue-200 rounded-sm inline-block"></span> Normal</span>
                </div>
            </div>

            {{-- Notifikasi --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col">
                <h2 class="text-base font-bold text-slate-800 mb-4">🔔 Notifikasi Sistem</h2>
                <div class="space-y-3 flex-1">

                    {{-- Belum absen --}}
                    @if($belumAbsen > 0)
                        <div class="flex items-start gap-3 p-3 bg-red-50 rounded-xl">
                            <span class="w-2 h-2 rounded-full bg-red-500 mt-1.5 shrink-0"></span>
                            <div>
                                <p class="text-sm font-semibold text-slate-700">{{ $belumAbsen }} karyawan belum absen hari ini</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ now()->format('d M Y') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3 p-3 bg-green-50 rounded-xl">
                            <span class="w-2 h-2 rounded-full bg-green-500 mt-1.5 shrink-0"></span>
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Semua karyawan sudah absen hari ini 🎉</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ now()->format('d M Y') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Slip gaji bulan ini --}}
                    @if($totalPayslips > 0)
                        <div class="flex items-start gap-3 p-3 bg-emerald-50 rounded-xl">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                            <div>
                                <p class="text-sm font-semibold text-slate-700">{{ $totalPayslips }} slip gaji diterbitkan bulan ini</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $periodeBulanIni }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start gap-3 p-3 bg-yellow-50 rounded-xl">
                            <span class="w-2 h-2 rounded-full bg-yellow-400 mt-1.5 shrink-0"></span>
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Belum ada slip gaji bulan ini</p>
                                <p class="text-xs text-slate-400 mt-0.5">Proses payroll sekarang</p>
                            </div>
                        </div>
                    @endif

                    {{-- Karyawan belum punya data --}}
                    @php
                        $noEmployee = \App\Models\User::where('role','user')->whereDoesntHave('employee')->count();
                    @endphp
                    @if($noEmployee > 0)
                        <div class="flex items-start gap-3 p-3 bg-orange-50 rounded-xl">
                            <span class="w-2 h-2 rounded-full bg-orange-400 mt-1.5 shrink-0"></span>
                            <div>
                                <p class="text-sm font-semibold text-slate-700">{{ $noEmployee }} akun belum dihubungkan ke data karyawan</p>
                                <p class="text-xs text-slate-400 mt-0.5">Segera lengkapi di halaman Karyawan</p>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ④ TABEL ABSENSI HARI INI + QUICK ACTIONS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Attendance Table --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-base font-bold text-slate-800">Absensi Hari Ini</h2>
                    <span class="text-xs text-slate-400 bg-slate-100 px-3 py-1 rounded-full">{{ now()->format('d M Y') }}</span>
                </div>

                @if($attendanceHariIni->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-xs text-slate-400 uppercase tracking-wide border-b border-slate-100">
                                <th class="pb-3 text-left font-semibold">Nama Karyawan</th>
                                <th class="pb-3 text-left font-semibold">Jabatan</th>
                                <th class="pb-3 text-left font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($attendanceHariIni as $att)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-3 font-medium text-slate-700">
                                        {{ $att->employee->name ?? '—' }}
                                    </td>
                                    <td class="py-3 text-slate-500 text-xs">{{ $att->employee->position ?? '—' }}</td>
                                    <td class="py-3">
                                        @php
                                            $statusColor = match($att->status) {
                                                'hadir'  => 'bg-green-100 text-green-700',
                                                'sakit'  => 'bg-yellow-100 text-yellow-700',
                                                'izin'   => 'bg-blue-100 text-blue-700',
                                                default  => 'bg-slate-100 text-slate-600',
                                            };
                                            $statusLabel = match($att->status) {
                                                'hadir'  => '✅ Hadir',
                                                'sakit'  => '🤒 Sakit',
                                                'izin'   => '📋 Izin',
                                                default  => ucfirst($att->status),
                                            };
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-slate-400">
                        <svg class="w-12 h-12 mb-3 opacity-30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        <p class="text-sm font-medium">Belum ada data absensi hari ini</p>
                    </div>
                @endif

                {{-- Payslip terbaru bulan ini --}}
                @if($payslipsTerbaru->count() > 0)
                <div class="mt-6 pt-5 border-t border-slate-100">
                    <h3 class="text-sm font-bold text-slate-700 mb-3">Slip Gaji Terbaru — {{ $periodeBulanIni }}</h3>
                    <div class="space-y-2">
                        @foreach($payslipsTerbaru as $ps)
                        <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-2.5">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">{{ $ps->employee->name ?? '—' }}</p>
                                <p class="text-xs text-slate-400">{{ $ps->employee->position ?? '' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-emerald-600">Rp {{ number_format($ps->net_salary, 0, ',', '.') }}</p>
                                <a href="{{ route('payroll.cetak', $ps->id) }}" target="_blank" class="text-xs text-blue-500 hover:underline">Lihat PDF</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h2 class="text-base font-bold text-slate-800 mb-5">⚡ Aksi Cepat</h2>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('employee.index') }}" wire:navigate
                       class="flex items-center gap-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-3 rounded-xl transition-all hover:shadow-md">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Tambah Karyawan
                    </a>
                    <a href="{{ route('payroll.calculator') }}" wire:navigate
                       class="flex items-center gap-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold px-4 py-3 rounded-xl transition-all hover:shadow-md">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Proses Payroll
                    </a>

                    {{-- Ringkasan Absen bulan ini --}}
                    <div class="mt-2 pt-4 border-t border-slate-100">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3">Absensi Bulan Ini</p>
                        @php
                            $thisM = date('m');
                            $thisY = date('Y');
                            $totalHadir = \App\Models\Attendance::whereMonth('date',$thisM)->whereYear('date',$thisY)->where('status','hadir')->count();
                        @endphp
                        <div class="flex items-center justify-between bg-green-50 rounded-xl px-4 py-3">
                            <span class="text-sm text-green-700 font-medium">Total Hadir</span>
                            <span class="text-lg font-bold text-green-700">{{ $totalHadir }}</span>
                        </div>
                        <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3 mt-2">
                            <span class="text-sm text-slate-600 font-medium">Belum Absen Hari Ini</span>
                            <span class="text-lg font-bold {{ $belumAbsen > 0 ? 'text-red-500' : 'text-green-600' }}">{{ $belumAbsen }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /admin wrapper -->

    {{-- ══════════════════ USER VIEW ══════════════════ --}}
    @else
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Profil & Absensi --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Profil Saya</h3>
                @if($employee)
                    <p class="text-gray-600"><strong>Nama:</strong> {{ $employee->name }}</p>
                    <p class="text-gray-600"><strong>NIK:</strong> {{ $employee->nik }}</p>
                    <p class="text-gray-600"><strong>Jabatan:</strong> {{ $employee->position }}</p>
                    @if($employee->ttl)
                        <p class="text-gray-600"><strong>TTL:</strong> {{ $employee->ttl }}</p>
                    @endif
                    <div class="mt-6">
                        @if($sudahAbsen)
                            <div class="bg-green-100 text-green-800 p-3 rounded-xl text-center font-bold">
                                ✅ Anda sudah absen hadir hari ini!
                            </div>
                        @else
                            <button wire:click="absenMasuk" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow transition-colors">
                                👆 Klik Untuk Absen Masuk Hari Ini
                            </button>
                            <p class="text-xs text-red-500 mt-2">*Perhatian: Jika tidak absen, maka akan dihitung Alpa dan memotong gaji bulanan Anda.</p>
                        @endif
                    </div>
                @else
                    <p class="text-red-500">Data karyawan belum dihubungkan. Silakan hubungi Admin.</p>
                @endif
            </div>

            {{-- Slip Gaji --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Slip Gaji Saya</h3>
                @if($employee && count($payrolls) > 0)
                    <div class="flex flex-col gap-3">
                        @foreach($payrolls as $pr)
                            <div class="flex justify-between items-center border-b pb-2">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $pr->month_year }}</p>
                                    <p class="text-sm text-gray-500">Rp {{ number_format($pr->net_salary, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('payroll.cetak', $pr->id) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm border border-blue-600 rounded-lg px-3 py-1">
                                    Unduh PDF
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Belum ada slip gaji.</p>
                @endif
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
        t.textContent = now.toLocaleTimeString('id-ID');
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>