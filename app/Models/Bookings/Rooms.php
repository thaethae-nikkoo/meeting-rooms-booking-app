<?php

namespace App\Models\Bookings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    use HasFactory;
    protected $fillable = ['room_name'];
    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'room_id');
    }
}
