<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Hisan Makmur | Manajemen Payroll Modern</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .glass {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }
            .hero-gradient {
                background: radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.05) 0%, rgba(255, 255, 255, 0) 50%);
            }
            @keyframes fade-in {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes fade-in-up {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in {
                animation: fade-in 1s ease-out;
            }
            .animate-fade-in-up {
                animation: fade-in-up 1s ease-out;
            }
            .animate-bounce-slow {
                animation: bounce 3s infinite;
            }
            @keyframes bounce {
                0%, 100% { transform: translateY(-5%); animation-timing-function: cubic-bezier(0.8, 0, 1, 1); }
                50% { transform: translateY(0); animation-timing-function: cubic-bezier(0, 0, 0.2, 1); }
            }
        </style>
    </head>
    <body class="antialiased bg-white text-slate-900 overflow-x-hidden" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        
        {{-- Navbar --}}
        <nav :class="scrolled ? 'bg-white/80 backdrop-blur-lg shadow-sm border-b border-slate-100 py-3' : 'bg-transparent py-5'"
             class="fixed top-0 w-full z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mt-5">
                    <!-- Logo -->
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('logo.png') }}" alt="HM Logo" class="h-10 w-auto">
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#home" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Beranda</a>
                        <a href="#features" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Fitur</a>
                        <a href="#about" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Tentang Kami</a>
                        <a href="#contact" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors">Kontak</a>
                    </div>

                    <!-- Auth Links -->
                    <div class="flex items-center gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 active:scale-95">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors px-4">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-bold text-white bg-slate-900 rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/20 active:scale-95">
                                        Mulai Sekarang
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        {{-- Hero Section --}}
        <section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-gradient">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <!-- Abstract Shapes -->
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-100/50 rounded-full blur-3xl -z-10"></div>
                <div class="absolute top-1/2 -left-24 w-72 h-72 bg-indigo-50/50 rounded-full blur-3xl -z-10"></div>

                <div class="text-center max-w-3xl mx-auto mb-16">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider mb-6 animate-fade-in">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                        </span>
                        Payroll Generasi Terbaru
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 leading-[1.1] mb-8 tracking-tight">
                        Sistem Manajemen <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Payroll</span> Modern
                    </h1>
                    <p class="text-lg lg:text-xl text-slate-500 font-medium mb-10 leading-relaxed">
                        Kelola gaji, absensi, dan laporan gaji karyawan secara efisien dalam satu platform. Dibangun untuk bisnis modern yang mengutamakan kecepatan dan akurasi.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/25 active:scale-95 group">
                            Mulai Sekarang
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="#features" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-bold text-slate-700 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 transition-all active:scale-95">
                            Pelajari Selengkapnya
                        </a>
                    </div>
                </div>

                <!-- Dashboard Mockup -->
                <div class="relative max-w-5xl mx-auto mt-10 rounded-3xl overflow-hidden shadow-2xl border border-slate-100 bg-white p-2 group animate-fade-in-up">
                    <div class="rounded-2xl overflow-hidden border border-slate-50 relative">
                        <img src="{{ asset('payroll_dashboard_preview_1778813971461.png') }}" alt="Dashboard Preview" class="w-full h-auto">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 to-transparent pointer-events-none"></div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Features Section --}}
        <section id="features" class="py-24 bg-slate-50/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-20">
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mb-4">Fitur Unggulan</h2>
                    <p class="text-slate-500 font-medium">Semua yang Anda butuhkan untuk mengelola tenaga kerja dan payroll dalam satu pengalaman yang mulus.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="p-8 rounded-3xl bg-white border border-slate-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-600/5 transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-3.87a4 4 0 10-8 0 4 4 0 008 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Manajemen Karyawan</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Database terpusat untuk semua data, dokumen, dan riwayat profesional karyawan.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-8 rounded-3xl bg-white border border-slate-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-600/5 transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Pencatatan Kehadiran</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Pelacakan masuk/keluar otomatis dengan pelaporan real-time dan manajemen cuti.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-8 rounded-3xl bg-white border border-slate-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-600/5 transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Otomatisasi Payroll</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Hitung gaji, pajak, dan potongan secara otomatis berdasarkan data kehadiran.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="p-8 rounded-3xl bg-white border border-slate-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-600/5 transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Pembuat Slip Gaji</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Buat slip gaji PDF profesional dan distribusikan ke karyawan secara instan.</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="p-8 rounded-3xl bg-white border border-slate-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-600/5 transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Laporan & Analitik</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Dapatkan wawasan tentang biaya tenaga kerja dan kinerja karyawan dengan bagan data visual.</p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="p-8 rounded-3xl bg-white border border-slate-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-600/5 transition-all duration-300 group">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Sistem Data Aman</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">Keamanan dan enkripsi tingkat perusahaan untuk melindungi data keuangan dan karyawan yang sensitif.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Benefits Section --}}
        <section class="py-24 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center gap-16">
                    <div class="flex-1">
                        <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mb-6 leading-tight">Mengapa Memilih HM PayRoll?</h2>
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900">Pemrosesan Gaji Cepat</h4>
                                    <p class="text-slate-500">Kurangi pekerjaan manual dan proses gaji dalam hitungan menit, bukan hari.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900">Perhitungan Gaji Akurat</h4>
                                    <p class="text-slate-500">Hilangkan kesalahan manusia dengan logika pajak dan potongan otomatis.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900">Manajemen Karyawan Mudah</h4>
                                    <p class="text-slate-500">Kembangkan bisnis Anda dengan mudah dengan alat yang skalabel untuk jumlah karyawan berapa pun.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-slate-900">Sistem Aman dan Terpercaya</h4>
                                    <p class="text-slate-500">Tenang saja mengetahui data keuangan Anda dilindungi dengan standar keamanan terbaru.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 relative">
                        <div class="absolute inset-0 bg-blue-600/10 rounded-[3rem] rotate-3 -z-10"></div>
                        <div class="bg-white p-8 rounded-[3rem] shadow-2xl border border-slate-100 relative">
                            <div class="space-y-6">
                                <div class="h-4 bg-slate-100 rounded-full w-2/3"></div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="h-24 bg-blue-50 rounded-2xl"></div>
                                    <div class="h-24 bg-slate-50 rounded-2xl"></div>
                                </div>
                                <div class="h-4 bg-slate-100 rounded-full w-1/2"></div>
                                <div class="h-24 bg-slate-50 rounded-2xl w-full"></div>
                                <div class="h-4 bg-slate-100 rounded-full w-3/4"></div>
                            </div>
                            <!-- Small Floating Card -->
                            <div class="absolute -bottom-6 -right-6 bg-white p-6 rounded-2xl shadow-xl border border-slate-100 animate-bounce-slow">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Status</p>
                                        <p class="text-sm font-extrabold text-slate-800">Gaji Berhasil</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- About Section --}}
        <section id="about" class="py-20 border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="max-w-xl mx-auto">
                    <h2 class="text-2xl font-bold text-slate-900 mb-4">PT. Hisan Makmur</h2>
                    <p class="text-slate-500 font-medium leading-relaxed">
                        Kami adalah perusahaan teknologi yang berdedikasi untuk membangun solusi digital yang memberdayakan bisnis untuk beroperasi lebih efisien. 
                        Hisan Makmur adalah sistem payroll unggulan kami yang dirancang untuk perusahaan Indonesia modern.
                    </p>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer id="contact" class="bg-slate-900 text-slate-400 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                    <div class="col-span-1 md:col-span-1">
                        <div class="flex items-center gap-2 mb-6">
                            <img src="{{ asset('logo.png') }}" alt="HM Logo" class="h-8 w-auto brightness-0 invert">
                        </div>
                        <p class="text-sm leading-relaxed mb-6">
                            Menyederhanakan manajemen payroll untuk bisnis dari semua ukuran dengan solusi yang aman dan otomatis.
                        </p>
                        <div class="flex items-center gap-4">
                            <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition-colors">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 transition-colors">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.335 3.608 1.31.975.975 1.248 2.242 1.31 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.335 2.633-1.31 3.608-.975.975-2.242 1.248-3.608 1.31-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.335-3.608-1.31-.975-.975-1.248-2.242-1.31-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.335-2.633 1.31-3.608.975-.975 2.242-1.248 3.608-1.31 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.337 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.337-.2 6.78-2.618 6.98-6.98.058-1.281.072-1.689.072-4.948s-.014-3.667-.072-4.947c-.2-4.337-2.618-6.78-6.98-6.98-1.28-.058-1.689-.072-4.948-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-6">Solusi</h4>
                        <ul class="space-y-4 text-sm">
                            <li><a href="#" class="hover:text-white transition-colors">Pemrosesan Gaji</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Pencatatan Kehadiran</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Kepatuhan Pajak</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Layanan Mandiri Karyawan</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-6">Perusahaan</h4>
                        <ul class="space-y-4 text-sm">
                            <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Karir</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Kontak</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-6">Kontak</h4>
                        <ul class="space-y-4 text-sm">
                            <li class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                support@hisantech.id
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                +62 (21) 1234-5678
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-medium">
                    <p>© 2026 PT. Hisan Makmur. Hak cipta dilindungi undang-undang.</p>
                    <div class="flex items-center gap-6">
                        <a href="#" class="hover:text-white transition-colors">Ketentuan Layanan</a>
                        <a href="#" class="hover:text-white transition-colors">Kebijakan Cookie</a>
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>
