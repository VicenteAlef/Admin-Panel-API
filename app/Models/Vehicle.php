<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'manufacturer_id',
        'title',
        'model',
        'year',
        'price',
        'mileage',
        'description',
        'cover_image_path',
        'is_sold',
        'is_active'
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function images()
    {
        return $this->hasMany(VehicleImage::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
