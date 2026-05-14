<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // firstOrCreate: aman dijalankan berkali-kali, tidak error jika email sudah ada
        User::firstOrCreate(
            ['email' => 'admin@payroll.test'],
            [
                'name'              => 'Admin Payroll',
                'password'          => Hash::make('password'),
                'role'              => 'admin',
                'email_verified_at' => now(), // ← wajib! tanpa ini admin tidak bisa login jika verifikasi email aktif
            ]
        );
    }
}
