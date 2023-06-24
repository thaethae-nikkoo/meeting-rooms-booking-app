<?php

namespace App\Models\Bookings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = ['room_id', 'date', 'start_time', 'end_time', 'duration', 'topic', 'booking_person_name', 'link', 'email', 'phone', 'notes', 'status', 'action_by', 'reason'];

    public function rooms()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }
}
