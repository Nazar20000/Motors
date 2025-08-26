<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hex_code',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

            // Relationships
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

            // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

            // Methods
    public function getActiveCarsCount()
    {
        return $this->cars()->where('status', 'available')->count();
    }

    public function getDisplayNameAttribute()
    {
        return $this->name . ($this->hex_code ? ' (' . $this->hex_code . ')' : '');
    }
}
