<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function absenMasuk()
    {
        $user = Auth::user();
        if ($user->role !== 'user' || !$user->employee) {
            return;
        }

        Attendance::firstOrCreate([
            'employee_id' => $user->employee->id,
            'date'        => date('Y-m-d'),
        ], [
            'status' => 'hadir',
        ]);

        session()->flash('success', 'Berhasil Absen Masuk hari ini!');
    }

    public function render()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $periodeBulanIni = Carbon::now()->locale('id')->isoFormat('MMMM YYYY');
            $today           = date('Y-m-d');
            $thisMonth       = date('m');
            $thisYear        = date('Y');

            // Stats
            $totalKaryawan  = Employee::count();
            $totalGaji      = Payroll::where('month_year', $periodeBulanIni)->sum('net_salary');
            $hadirHariIni   = Attendance::where('date', $today)->where('status', 'hadir')->count();
            $totalPayslips  = Payroll::where('month_year', $periodeBulanIni)->count();

            // Attendance today detail (for table)
            $attendanceHariIni = Attendance::with('employee')
                ->where('date', $today)
                ->latest()
                ->get();

            // 6-month payroll chart data
            $chartData = [];
            for ($i = 5; $i >= 0; $i--) {
                $carbon   = Carbon::now()->subMonths($i);
                $label    = $carbon->locale('id')->isoFormat('MMM');
                $period   = $carbon->locale('id')->isoFormat('MMMM YYYY');
                $total    = Payroll::where('month_year', $period)->sum('net_salary');
                $chartData[] = ['label' => $label, 'total' => $total];
            }

            // Notifications: employees with no attendance today
            $belumAbsen = Employee::whereDoesntHave('attendances', function ($q) use ($today) {
                $q->where('date', $today);
            })->count();

            // Latest 5 payslips generated this month
            $payslipsTerbaru = Payroll::with('employee')
                ->where('month_year', $periodeBulanIni)
                ->latest()
                ->take(5)
                ->get();

            return view('livewire.dashboard.dashboard', [
                'isAdmin'          => true,
                'totalKaryawan'    => $totalKaryawan,
                'totalGaji'        => $totalGaji,
                'hadirHariIni'     => $hadirHariIni,
                'totalPayslips'    => $totalPayslips,
                'attendanceHariIni'=> $attendanceHariIni,
                'chartData'        => $chartData,
                'belumAbsen'       => $belumAbsen,
                'payslipsTerbaru'  => $payslipsTerbaru,
                'periodeBulanIni'  => $periodeBulanIni,
            ])->layout('layouts.app');
        }

        // ── USER VIEW ──────────────────────────────────────────
        $employee   = $user->employee;
        $sudahAbsen = false;
        $payrolls   = [];

        if ($employee) {
            $sudahAbsen = Attendance::where('employee_id', $employee->id)
                ->where('date', date('Y-m-d'))
                ->exists();

            $payrolls = Payroll::where('employee_id', $employee->id)
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('livewire.dashboard.dashboard', [
            'isAdmin'    => false,
            'employee'   => $employee,
            'sudahAbsen' => $sudahAbsen,
            'payrolls'   => $payrolls,
        ])->layout('layouts.app');
    }
}
