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
        Schema::table('cars', function (Blueprint $table) {
            // Add new fields for foreign keys
            $table->foreignId('brand_id')->nullable()->after('id');
            $table->foreignId('car_model_id')->nullable()->after('brand_id');
            $table->foreignId('color_id')->nullable()->after('model');
            $table->foreignId('body_type_id')->nullable()->after('color_id');
            $table->foreignId('transmission_id')->nullable()->after('body_type_id');
            
            // Add new fields
            $table->integer('mileage')->unsigned()->nullable()->after('year');
            $table->enum('status', ['available', 'sold', 'reserved', 'hidden'])->default('available')->after('published');
            $table->string('vin')->nullable()->after('status');
            $table->string('engine_size')->nullable()->after('vin');
            $table->integer('horsepower')->nullable()->after('engine_size');
            $table->string('fuel_type')->nullable()->after('horsepower');
            
            // Remove old text fields
            $table->dropColumn(['brand', 'model']);
        });

        // Add foreign key constraints only if tables exist
        if (Schema::hasTable('brands')) {
            Schema::table('cars', function (Blueprint $table) {
                $table->foreign('brand_id')->references('id')->on('brands');
            });
        }
        
        if (Schema::hasTable('car_models')) {
            Schema::table('cars', function (Blueprint $table) {
                $table->foreign('car_model_id')->references('id')->on('car_models');
            });
        }
        
        if (Schema::hasTable('colors')) {
            Schema::table('cars', function (Blueprint $table) {
                $table->foreign('color_id')->references('id')->on('colors');
            });
        }
        
        if (Schema::hasTable('body_types')) {
            Schema::table('cars', function (Blueprint $table) {
                $table->foreign('body_type_id')->references('id')->on('body_types');
            });
        }
        
        if (Schema::hasTable('transmissions')) {
            Schema::table('cars', function (Blueprint $table) {
                $table->foreign('transmission_id')->references('id')->on('transmissions');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // Remove foreign keys
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['car_model_id']);
            $table->dropForeign(['color_id']);
            $table->dropForeign(['body_type_id']);
            $table->dropForeign(['transmission_id']);
            
            // Remove new fields
            $table->dropColumn([
                'brand_id', 'car_model_id', 'color_id', 'body_type_id', 'transmission_id',
                'mileage', 'status', 'vin', 'engine_size', 'horsepower', 'fuel_type'
            ]);
            
            // Restore old fields
            $table->string('brand')->after('id');
            $table->string('model')->after('brand');
        });
    }
};
