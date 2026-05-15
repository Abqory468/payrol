<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Setiap hari pukul 23:59 — tandai karyawan tanpa check-in sebagai Alpa
Schedule::command('attendance:mark-absent')->dailyAt('23:59');
