<?php

namespace App\Models\Bookings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipSlot extends Model
{
    use HasFactory;
    protected $fillable = ['schedule_id', 'date', 'start_time', 'unavailable_slots', 'status'];
}
