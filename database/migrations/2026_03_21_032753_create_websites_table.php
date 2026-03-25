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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->boolean('is_working')->default(true);
            $table->boolean('has_backup')->default(false);
            $table->boolean('is_hacked')->default(false);
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->enum('priority', ['red', 'yellow', 'green'])->default('green');
            $table->enum('website_status', ['working', 'down'])->default('working');
            $table->string('server_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
