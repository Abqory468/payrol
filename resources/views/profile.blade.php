<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
        
        {{-- Profile Hero Section --}}
        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm relative overflow-hidden flex flex-col md:flex-row items-center gap-8">
            <div class="absolute top-0 right-0 w-64 h-full bg-blue-50/50 -skew-x-12 translate-x-20"></div>
            
            {{-- Avatar Placeholder --}}
            <div class="relative shrink-0">
                <div class="w-24 h-24 rounded-3xl bg-blue-600 flex items-center justify-center text-white text-4xl font-extrabold shadow-xl shadow-blue-600/30">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-500 border-4 border-white rounded-full"></div>
            </div>

            <div class="relative text-center md:text-left">
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ auth()->user()->name }}</h1>
                <p class="text-slate-500 font-medium flex items-center justify-center md:justify-start gap-2 mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v10a2 2 0 002 2z"/></svg>
                    {{ auth()->user()->email }}
                </p>
                <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-2">
                    <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold border border-blue-100 uppercase tracking-wider">
                        {{ auth()->user()->role ?? 'User' }}
                    </span>
                    <span class="px-3 py-1 rounded-full bg-slate-50 text-slate-500 text-xs font-bold border border-slate-100 uppercase tracking-wider">
                        ID: #{{ auth()->user()->id }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Navigation Sidebar (Visual only for now) --}}
            <div class="lg:col-span-3 space-y-2">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-4 mb-4">Pengaturan Akun</p>
                <nav class="space-y-1">
                    <a href="#personal-info" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-600 rounded-2xl font-bold transition-all border border-blue-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Informasi Pribadi
                    </a>
                    <a href="#security" class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-50 rounded-2xl font-bold transition-all group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Keamanan Akun
                    </a>
                    <a href="#danger-zone" class="flex items-center gap-3 px-4 py-3 text-rose-500 hover:bg-rose-50 rounded-2xl font-bold transition-all group">
                        <svg class="w-5 h-5 text-rose-400 group-hover:text-rose-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus Akun
                    </a>
                </nav>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-9 space-y-8">
                {{-- Personal Info --}}
                <div id="personal-info" class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-600/20">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-slate-800">Informasi Pribadi</h2>
                            <p class="text-xs text-slate-500 font-medium">Perbarui informasi profil dan alamat email Anda.</p>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="max-w-xl">
                            <livewire:profile.update-profile-information-form />
                        </div>
                    </div>
                </div>

                {{-- Security --}}
                <div id="security" class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 text-white flex items-center justify-center shadow-lg shadow-slate-800/20">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-slate-800">Keamanan Akun</h2>
                            <p class="text-xs text-slate-500 font-medium">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk tetap aman.</p>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="max-w-xl">
                            <livewire:profile.update-password-form />
                        </div>
                    </div>
                </div>

                {{-- Delete Account --}}
                <div id="danger-zone" class="bg-white rounded-3xl shadow-sm border border-rose-200 overflow-hidden bg-rose-50/5">
                    <div class="px-8 py-6 border-b border-rose-100 flex items-center gap-4 bg-rose-50/30">
                        <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center shadow-lg shadow-rose-600/20">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold text-rose-800">Hapus Akun</h2>
                            <p class="text-xs text-rose-600/70 font-medium">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</p>
                        </div>
                    </div>
                    <div class="p-8">
                        <div class="max-w-xl">
                            <livewire:profile.delete-user-form />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
