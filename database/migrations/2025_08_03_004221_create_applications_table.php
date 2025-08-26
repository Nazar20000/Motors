<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            
            // Buyer Type
            $table->enum('buyer_type', ['buyer', 'co-buyer'])->default('buyer');
            
            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('cell_phone');
            $table->string('home_phone')->nullable();
            $table->date('date_of_birth');
            $table->string('ssn');
            $table->string('driver_license')->nullable();
            $table->string('driver_license_state')->nullable();
            $table->date('license_issue_date')->nullable();
            $table->date('license_expiry_date')->nullable();
            
            // Residential Information
            $table->string('street_address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->enum('housing_type', ['own', 'rent', 'live-with-family', 'other']);
            $table->decimal('monthly_rent', 10, 2);
            $table->string('years_at_address');
            $table->string('months_at_address')->nullable();
            
            // Employment Information
            $table->string('employer_name');
            $table->string('job_title');
            $table->string('employer_phone');
            $table->decimal('monthly_income', 10, 2);
            $table->string('years_at_job');
            $table->string('months_at_job')->nullable();
            
            // Vehicle Information
            $table->string('stock_number')->nullable();
            $table->string('vehicle_year')->nullable();
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->decimal('vehicle_price', 10, 2)->nullable();
            $table->decimal('down_payment', 10, 2)->nullable();
            $table->string('exterior_color')->nullable();
            $table->string('interior_color')->nullable();
            
            // Trade-In Information
            $table->boolean('has_trade_in')->default(false);
            $table->string('trade_vin')->nullable();
            $table->string('trade_mileage')->nullable();
            $table->string('trade_year')->nullable();
            $table->string('trade_make')->nullable();
            $table->string('trade_model')->nullable();
            
            // Terms
            $table->boolean('accepts_terms')->default(false);
            
            // Status
            $table->enum('status', ['pending', 'approved', 'rejected', 'in_review'])->default('pending');
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
