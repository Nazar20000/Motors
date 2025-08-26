<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    use HasFactory;
    
    protected $fillable = ['car_id', 'image_path'];
    
    public function car() {
        return $this->belongsTo(Car::class);
    }
    
            // Scope for sorting images by ID (first added will be first)
    public function scopeOrdered($query)
    {
        return $query->orderBy('id', 'asc');
    }
}