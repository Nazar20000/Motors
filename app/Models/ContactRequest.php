<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'type',
        'status',
        'car_id',
        'admin_notes',
        'processed_at'
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

            // Relationships
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

            // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

            // Accessors
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
                            'new' => 'New',
                'in_progress' => 'In Progress',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
                default => 'Unknown'
        };
    }

    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'contact' => 'General question',
            'test_drive' => 'Test drive',
            'quote' => 'Price request',
            'apply_online' => 'Online application',
            default => 'Unknown'
        };
    }

    // Methods
    public function markAsInProgress()
    {
        $this->update(['status' => 'in_progress']);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'processed_at' => now()
        ]);
    }

    public function markAsCancelled()
    {
        $this->update(['status' => 'cancelled']);
    }

    public function isNew()
    {
        return $this->status === 'new';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}
