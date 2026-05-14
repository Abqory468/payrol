<?php

use Illuminate\Support\Facades\Route;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;

Route::view('/', 'welcome');

Route::get('dashboard', \App\Livewire\Dashboard\Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

//✅ Route ini HANYA bisa diakses jika sudah login
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('employee', \App\Livewire\Employee\EmployeeManager::class)->name('employee.index');
    Route::get('/attendance', \App\Livewire\Attendance\AttendanceManager::class)->name('attendance.index');
    Route::get('/payroll', \App\Livewire\Calculator\PayrollCalculator::class)->name('payroll.calculator');
    Route::get('/payroll-history', \App\Livewire\Payrol\PayrollHistory::class)->name('payroll.history');
    Route::get('/cetak-slip/{id}', function ($id) {
    $payroll = Payroll::with('employee')->findOrFail($id);
    $pdf = Pdf::loadView('pdf.slip-gaji', ['data' => $payroll]);
    return $pdf->stream('Slip_Gaji_' . $payroll->employee->nik . '.pdf');
})->name('payroll.cetak');
});


require __DIR__ . '/auth.php';
