<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Hisan Makmur' }}</title>
        <link rel="icon" href="{{ asset('logo2.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800">
        
        @if(Auth::check() && Auth::user()->role === 'admin')
            {{-- ════════════════════ ADMIN LAYOUT (SIDEBAR) ════════════════════ --}}
            <div class="flex h-screen overflow-hidden bg-slate-50" x-data="{ sidebarOpen: false }">
                
                <!-- Sidebar Backdrop -->
                <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-20 bg-slate-900/50 lg:hidden" @click="sidebarOpen = false"></div>

                <!-- Sidebar -->
                <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-white text-slate-600 transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col shadow-xl border-r border-slate-100">
                    <!-- Logo -->
                    <div class="flex items-center justify-center h-16 bg-white px-6 shrink-0 border-b border-slate-100">
                        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2 text-slate-800 font-bold text-lg tracking-wide">
                            <img src="../logo.png" alt="" class="w-[100px]">
                        </a>
                    </div>

                    <!-- Nav Links -->
                    <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-2">
                        <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Menu Utama</p>
                        
                        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 font-medium' }}">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>

                        <a href="{{ route('attendance.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('attendance.index') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 font-medium' }}">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('attendance.index') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Absensi
                        </a>

                        <a href="{{ route('employee.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('employee.index') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 font-medium' }}">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('employee.index') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-3.87a4 4 0 10-8 0 4 4 0 008 0z"/></svg>
                            Karyawan
                        </a>

                        <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-8 mb-3">Penggajian</p>
                        
                        <a href="{{ route('payroll.calculator') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('payroll.calculator') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 font-medium' }}">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('payroll.calculator') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            Kalkulator Gaji
                        </a>

                        <a href="{{ route('payroll.history') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('payroll.history') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800 font-medium' }}">
                            <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('payroll.history') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Riwayat Gaji
                        </a>
                    </nav>

                    <!-- User Info & Logout -->
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        <div class="flex items-center gap-3 mb-4 px-3">
                            <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center font-bold text-sm text-blue-700">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">Administrator</p>
                            </div>
                            <a href="{{ route('profile') }}">
                                <div class="p-2 text-blue-600 hover:bg-blue-50 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            </a>
                        </div>
                        
                        <livewire:layout.admin-logout-button />
                    </div>
                </aside>

                <!-- Main Content (Admin) -->
                <div class="flex flex-col flex-1 overflow-hidden h-screen">
                    <!-- Topbar for mobile only -->
                    <header class="flex items-center justify-between h-16 bg-white border-b border-slate-200 px-4 lg:hidden shrink-0">
                        <button @click="sidebarOpen = true" class="text-slate-500 hover:text-slate-700 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <div class="font-bold text-slate-800">Payroll Admin</div>
                        <div class="w-6"></div> <!-- Spacer -->
                    </header>

                    <!-- Page Content (Admin) -->
                    <main class="flex-1 overflow-y-auto bg-slate-50 relative">
                        {{ $slot }}
                    </main>
                </div>
            </div>

        @else
            {{-- ════════════════════ USER LAYOUT (TOP NAV) ════════════════════ --}}
            <div class="min-h-screen bg-slate-50">
                <livewire:layout.navigation />

                <!-- Page Heading (User) -->
                @if (isset($header))
                    <header class="bg-white shadow-sm border-b border-slate-100">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content (User) -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        @endif

    </body>
</html>
