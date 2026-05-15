<?php

namespace App\Livewire\Payrol;

use Livewire\Component;
use App\Models\Payroll;
use Livewire\WithPagination;

use Livewire\Attributes\Title;

#[Title('Riwayat Gaji | Hisan Makmur')]
class PayrollHistory extends Component
{
    use WithPagination;
    public string $filterPeriod = '';

    public function mount()
    {
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
    }

    // Reset ke halaman 1 setiap kali dropdown filter berubah   
    public function updatingFilterPeriod(): void
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $query = Payroll::with('employee')->orderBy('created_at', 'desc');
        // $query HARUS di-assign ulang — where() mengembalikan instance baru
        if ($this->filterPeriod){
            $query =$query->where('month_year', $this->filterPeriod);
        }
        return view('livewire.payrol.payroll-history',[
            'payrolls'=> $query->paginate(10),
            'periods' => Payroll::select('month_year')
            ->distinct()
            ->orderBy('month_year', 'desc')
            ->pluck('month_year'),
        ])->layout('layouts.app');
    }
}
