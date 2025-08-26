<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            if (!Schema::hasColumn('applications', 'previous_addresses')) {
                $table->json('previous_addresses')->nullable()->after('months_at_address');
            }
            if (!Schema::hasColumn('applications', 'previous_employments')) {
                $table->json('previous_employments')->nullable()->after('months_at_job');
            }
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            if (Schema::hasColumn('applications', 'previous_addresses')) {
                $table->dropColumn('previous_addresses');
            }
            if (Schema::hasColumn('applications', 'previous_employments')) {
                $table->dropColumn('previous_employments');
            }
        });
    }
};


