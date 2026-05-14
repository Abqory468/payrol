<?php

namespace App\Livewire\Attendance;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceManager extends Component
{
    use WithPagination;

    // ── State karyawan yang sedang login ──
    public ?Employee $myEmployee = null;
    public ?Attendance $todayRecord = null;

    // ── Filter (admin) ──
    public string $filterDate   = '';
    public string $filterStatus = '';

    // ── Form manual (admin) ──
    public bool   $showForm     = false;
    public ?int   $editId       = null;
    public string $form_employee_id = '';
    public string $form_date    = '';
    public string $form_status  = 'hadir';
    public string $form_check_in  = '';
    public string $form_check_out = '';
    public string $form_notes   = '';

    public function mount(): void
    {
        $user = Auth::user();

        // Jika karyawan biasa, cari profil employee-nya
        if ($user->role !== 'admin') {
            $this->myEmployee  = Employee::where('user_id', $user->id)->first();
            $this->todayRecord = $this->myEmployee
                ? Attendance::where('employee_id', $this->myEmployee->id)
                             ->where('date', today()->toDateString())
                             ->first()
                : null;
        }

        $this->filterDate = today()->toDateString();
    }

    // ════════════════════════════════════════
    //  CHECK-IN  (karyawan)
    // ════════════════════════════════════════
    public function checkIn(): void
    {
        if (! $this->myEmployee) return;

        $record = Attendance::firstOrCreate(
            ['employee_id' => $this->myEmployee->id, 'date' => today()->toDateString()],
            ['status' => 'hadir']
        );

        if (! $record->check_in) {
            $record->update(['check_in' => now()->format('H:i:s'), 'status' => 'hadir']);
        }

        $this->todayRecord = $record->fresh();
        session()->flash('success', 'Check-in berhasil! Selamat bekerja 💪');
    }

    // ════════════════════════════════════════
    //  CHECK-OUT  (karyawan)
    // ════════════════════════════════════════
    public function checkOut(): void
    {
        if (! $this->myEmployee || ! $this->todayRecord) return;

        if (! $this->todayRecord->check_out) {
            $this->todayRecord->update(['check_out' => now()->format('H:i:s')]);
        }

        $this->todayRecord = $this->todayRecord->fresh();
        session()->flash('success', 'Check-out berhasil! Sampai jumpa besok 👋');
    }

    // ════════════════════════════════════════
    //  ADMIN — buka form tambah / edit
    // ════════════════════════════════════════
    public function openForm(?int $id = null): void
    {
        $this->resetValidation();
        $this->editId = $id;

        if ($id) {
            $att = Attendance::findOrFail($id);
            $this->form_employee_id = $att->employee_id;
            $this->form_date        = $att->date->toDateString();
            $this->form_status      = $att->status;
            $this->form_check_in    = $att->check_in  ?? '';
            $this->form_check_out   = $att->check_out ?? '';
            $this->form_notes       = $att->notes     ?? '';
        } else {
            $this->form_employee_id = '';
            $this->form_date        = today()->toDateString();
            $this->form_status      = 'hadir';
            $this->form_check_in    = '';
            $this->form_check_out   = '';
            $this->form_notes       = '';
        }

        $this->showForm = true;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
        $this->editId   = null;
    }

    // ════════════════════════════════════════
    //  ADMIN — simpan
    // ════════════════════════════════════════
    public function save(): void
    {
        $this->validate([
            'form_employee_id' => 'required|exists:employees,id',
            'form_date'        => 'required|date',
            'form_status'      => 'required|in:hadir,sakit,izin,alpa',
            'form_check_in'    => 'nullable|date_format:H:i',
            'form_check_out'   => 'nullable|date_format:H:i|after:form_check_in',
        ], [
            'form_employee_id.required' => 'Karyawan wajib dipilih.',
            'form_date.required'        => 'Tanggal wajib diisi.',
            'form_status.required'      => 'Status wajib dipilih.',
            'form_check_out.after'      => 'Jam keluar harus setelah jam masuk.',
        ]);

        Attendance::updateOrCreate(
            ['id' => $this->editId],
            [
                'employee_id' => $this->form_employee_id,
                'date'        => $this->form_date,
                'status'      => $this->form_status,
                'check_in'    => $this->form_check_in  ?: null,
                'check_out'   => $this->form_check_out ?: null,
                'notes'       => $this->form_notes     ?: null,
            ]
        );

        session()->flash('success', $this->editId ? 'Data absensi diperbarui.' : 'Absensi berhasil dicatat.');
        $this->closeForm();
    }

    // ════════════════════════════════════════
    //  ADMIN — hapus
    // ════════════════════════════════════════
    public function delete(int $id): void
    {
        Attendance::findOrFail($id)->delete();
        session()->flash('success', 'Data absensi dihapus.');
    }

    // ════════════════════════════════════════
    //  RENDER
    // ════════════════════════════════════════
    public function render()
    {
        $user      = Auth::user();
        $employees = Employee::orderBy('name')->get();

        $query = Attendance::with('employee')->orderBy('date', 'desc')->orderBy('id', 'desc');

        // Karyawan biasa: hanya lihat milik sendiri
        if ($user->role !== 'admin' && $this->myEmployee) {
            $query->where('employee_id', $this->myEmployee->id);
        }

        if ($this->filterDate) {
            $query->where('date', $this->filterDate);
        }
        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        return view('livewire.attendance.attendance-manager', [
            'attendances' => $query->paginate(15),
            'employees'   => $employees,
        ])->layout('layouts.app');
    }
}
