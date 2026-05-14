<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'nik',
        'name',
        'phone',
        'position',
        'ttl',
        'address',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    // Satu karyawan bisa punya banyak slip gaji
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
