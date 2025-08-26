<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CarModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

            // Relationships
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

            // Accessors and mutators
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $value ?: Str::slug($this->name);
    }

            // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

            // Methods
    public function getFullNameAttribute()
    {
        return $this->brand ? $this->brand->name . ' ' . $this->name : $this->name;
    }

    public function getActiveCarsCount()
    {
        return $this->cars()->where('status', 'available')->count();
    }
}
