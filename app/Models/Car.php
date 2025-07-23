<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'brand', 'model', 'year', 'price', 'description', 'image', 'published'
    ];
    public function images() {
        return $this->hasMany(CarImage::class);
    }
}
