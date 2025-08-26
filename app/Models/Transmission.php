<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
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

            // Methods
    public function getActiveCarsCount()
    {
        return $this->cars()->where('status', 'available')->count();
    }
}
