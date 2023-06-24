<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupSlot2 extends Model
{
    use HasFactory;
    protected $fillable = ['schedule_id', 'date', 'start_time', 'unavailable_slots', 'status'];
}
