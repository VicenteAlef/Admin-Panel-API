<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['vehicle_id', 'name', 'email', 'phone', 'message'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
