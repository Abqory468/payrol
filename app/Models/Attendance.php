<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'status',
        'check_in',
        'check_out',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /** Durasi kerja dalam menit */
    public function getDurationAttribute(): ?int
    {
        if ($this->check_in && $this->check_out) {
            $in  = \Carbon\Carbon::createFromTimeString($this->check_in);
            $out = \Carbon\Carbon::createFromTimeString($this->check_out);
            return $in->diffInMinutes($out);
        }
        return null;
    }

    /** Format durasi: "7 jam 30 menit" */
    public function getDurationFormattedAttribute(): string
    {
        $minutes = $this->duration;
        if ($minutes === null) return '—';
        $h = intdiv($minutes, 60);
        $m = $minutes % 60;
        return ($h > 0 ? "{$h} jam " : '') . "{$m} menit";
    }
}
