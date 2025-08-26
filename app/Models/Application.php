<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'buyer_type',
        'first_name',
        'last_name',
        'email',
        'cell_phone',
        'home_phone',
        'date_of_birth',
        'ssn',
        'driver_license',
        'driver_license_state',
        'license_issue_date',
        'license_expiry_date',
        'street_address',
        'city',
        'state',
        'zip_code',
        'housing_type',
        'monthly_rent',
        'years_at_address',
        'months_at_address',
        'employer_name',
        'job_title',
        'employer_phone',
        'monthly_income',
        'years_at_job',
        'months_at_job',
        'previous_addresses',
        'previous_employments',
        'car_id',
        'stock_number',
        'vehicle_year',
        'vehicle_make',
        'vehicle_model',
        'vehicle_price',
        'down_payment',
        'exterior_color',
        'interior_color',
        'has_trade_in',
        'trade_vin',
        'trade_mileage',
        'trade_year',
        'trade_make',
        'trade_model',
        'accepts_terms',
        'status',
        'notes'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'license_issue_date' => 'date',
        'license_expiry_date' => 'date',
        'monthly_rent' => 'decimal:2',
        'monthly_income' => 'decimal:2',
        'vehicle_price' => 'decimal:2',
        'down_payment' => 'decimal:2',
        'has_trade_in' => 'boolean',
        'accepts_terms' => 'boolean'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'license_issue_date' => 'date',
        'license_expiry_date' => 'date',
        'monthly_rent' => 'decimal:2',
        'monthly_income' => 'decimal:2',
        'vehicle_price' => 'decimal:2',
        'down_payment' => 'decimal:2',
        'has_trade_in' => 'boolean',
        'accepts_terms' => 'boolean',
        'previous_addresses' => 'array',
        'previous_employments' => 'array',
    ];

    // Accessor for full name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Accessor for formatted SSN
    public function getFormattedSsnAttribute()
    {
        return substr($this->ssn, 0, 3) . '-' . substr($this->ssn, 3, 2) . '-' . substr($this->ssn, 5, 4);
    }

    // Scope for pending applications
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for approved applications
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Relationship with Car
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
