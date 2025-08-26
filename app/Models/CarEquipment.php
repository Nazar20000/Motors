<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarEquipment extends Model
{
    use HasFactory;

    protected $table = 'car_equipment';

    protected $fillable = [
        'car_id',
        'name',
        'category',
        'active',
        'sort_order'
    ];

    protected $casts = [
        'active' => 'boolean',
        'sort_order' => 'integer'
    ];

            // Relationships
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

            // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

            // Accessors
    public function getCategoryLabelAttribute()
    {
        return match($this->category) {
                            'general' => 'General',
                'safety' => 'Safety',
                'comfort' => 'Comfort',
                'technology' => 'Technology',
                default => 'Other'
        };
    }
}
