<?php

namespace App\Livewire\Layout;

use App\Livewire\Actions\Logout;
use Livewire\Component;

class AdminLogoutButton extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return <<<'HTML'
        <div x-data="{ showLogoutModal: false }">
            <button @click="showLogoutModal = true" class="w-full flex items-center justify-center gap-2 bg-white border border-slate-200 hover:border-red-200 hover:bg-red-50 hover:text-red-600 text-slate-600 font-bold text-sm py-2.5 rounded-xl transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Keluar
            </button>

            {{-- Logout Confirmation Modal --}}
            <template x-teleport="body">
                <div x-show="showLogoutModal" 
                     class="fixed inset-0 z-[100] overflow-y-auto" 
                     style="display: none;"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity bg-slate-900/40 backdrop-blur-sm" @click="showLogoutModal = false"></div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-3xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            
                            <div class="sm:flex sm:items-start flex-col items-center">
                                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-rose-50 rounded-2xl mb-4">
                                    <svg class="w-8 h-8 text-rose-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:text-center w-full">
                                    <h3 class="text-xl font-extrabold leading-6 text-slate-800">Yakin ingin keluar?</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-slate-500 font-medium">Sesi admin Anda akan berakhir dan Anda perlu masuk kembali.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex flex-col gap-2 sm:flex-row-reverse sm:gap-3">
                                <button type="button" wire:click="logout"
                                        class="inline-flex justify-center w-full px-6 py-3 text-sm font-bold text-white bg-rose-600 border border-transparent rounded-xl shadow-lg shadow-rose-600/20 hover:bg-rose-700 transition-all focus:outline-none active:scale-95">
                                    Ya, Keluar
                                </button>
                                <button type="button" @click="showLogoutModal = false"
                                        class="inline-flex justify-center w-full px-6 py-3 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all focus:outline-none active:scale-95">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        HTML;
    }
}
