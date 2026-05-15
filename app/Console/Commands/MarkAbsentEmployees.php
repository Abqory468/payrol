<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class MarkAbsentEmployees extends Command
{
    protected $signature   = 'attendance:mark-absent';
    protected $description = 'Tandai semua karyawan yang tidak check-in hari ini sebagai Alpa';

    public function handle(): void
    {
        $today = today()->toDateString();

        // Ambil semua karyawan yang BELUM punya record absensi hari ini
        $employeeIds = Employee::pluck('id');

        $alreadyRecorded = Attendance::where('date', $today)
            ->pluck('employee_id')
            ->toArray();

        $notRecorded = $employeeIds->diff($alreadyRecorded);

        $count = 0;
        foreach ($notRecorded as $empId) {
            Attendance::create([
                'employee_id' => $empId,
                'date'        => $today,
                'status'      => 'alpa',
                'check_in'    => null,
                'check_out'   => null,
                'notes'       => 'Otomatis: tidak ada check-in',
            ]);
            $count++;
        }

        $this->info("Selesai. {$count} karyawan ditandai Alpa.");
    }
}
