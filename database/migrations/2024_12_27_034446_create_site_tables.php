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
        Schema::create('feature_statuses', function (Blueprint $table) {
            $table->id();
            // route name
            $table->string('name')->unique();
            $table->boolean('is_enabled');
            $table->text('message')->nullable();
        });

        Schema::create('site_messages', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('color');
            $table->text('message');
        });

        Schema::create('site_maintenance', function (Blueprint $table) {
            $table->id()->unique(); // always ensure is 1 so table is constrained to single row
            $table->text('message')->nullable();
            $table->boolean('is_bypassable');
            $table->integer('min_power')->nullable(); // minimum role power to bypass the maintenance - if bypassable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_statuses');
        Schema::dropIfExists('site_messages');
        Schema::dropIfExists('site_maintenance');
    }
};
