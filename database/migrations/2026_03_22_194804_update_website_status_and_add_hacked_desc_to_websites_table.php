<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->text('hacked_description')->nullable()->after('is_hacked');
        });

        // Add new values to enum
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE websites MODIFY COLUMN website_status ENUM('operativa', 'suspendida', 'working', 'down') DEFAULT 'operativa'");

        // Update existing records
        \Illuminate\Support\Facades\DB::table('websites')->where('website_status', 'working')->update(['website_status' => 'operativa']);
        \Illuminate\Support\Facades\DB::table('websites')->where('website_status', 'down')->update(['website_status' => 'suspendida']);

        // Remove old values from enum
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE websites MODIFY COLUMN website_status ENUM('operativa', 'suspendida') DEFAULT 'operativa'");
    }

    public function down(): void
    {
        // Add back old enum values
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE websites MODIFY COLUMN website_status ENUM('operativa', 'suspendida', 'working', 'down') DEFAULT 'working'");

        // Revert records
        \Illuminate\Support\Facades\DB::table('websites')->where('website_status', 'operativa')->update(['website_status' => 'working']);
        \Illuminate\Support\Facades\DB::table('websites')->where('website_status', 'suspendida')->update(['website_status' => 'down']);

        // Remove new enum values
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE websites MODIFY COLUMN website_status ENUM('working', 'down') DEFAULT 'working'");

        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn('hacked_description');
        });
    }
};
