<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'start_time',
        'end_time',
        'break_start',
        'break_end',
    ];

    public function saveAttendance($data)
    {
        return $this->create($data);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 休憩時間合計を計算
    public function totalBreakHours()
    {
        if ($this->break_start && $this->break_end) {
            $breakStart = \Carbon\Carbon::parse($this->break_start);
            $breakEnd = \Carbon\Carbon::parse($this->break_end);
            $diffInMinutes = $breakEnd->diffInMinutes($breakStart);
            $hours = floor($diffInMinutes / 60);
            $minutes = $diffInMinutes % 60;

            return sprintf('%02d:%02d:00', $hours, $minutes);
        }

        return '00:00:00';
    }

    // 勤務時間合計を計算
    public function totalWorkHours()
    {
        if ($this->start_time && $this->end_time) {
            $start = \Carbon\Carbon::parse($this->start_time);
            $end = \Carbon\Carbon::parse($this->end_time);
            $diffInMinutes = $end->diffInMinutes($start);
            $hours = floor($diffInMinutes / 60);
            $minutes = $diffInMinutes % 60;

            return sprintf('%02d:%02d:00', $hours, $minutes);
        }

        return '00:00:00';
    }
}
