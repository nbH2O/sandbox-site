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
        Schema::create('avatars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained();

            $table->foreignId('face_id')->nullable()->constrained(
                table: 'items', indexName: 'face_id'
            );
            $table->foreignId('head_id')->nullable()->constrained(
                table: 'items', indexName: 'head_id'
            );
            $table->foreignId('torso_id')->nullable()->constrained(
                table: 'items', indexName: 'torso_id'
            );
            $table->foreignId('arm_left_id')->nullable()->constrained(
                table: 'items', indexName: 'arm_left_id'
            );
            $table->foreignId('arm_right_id')->nullable()->constrained(
                table: 'items', indexName: 'arm_right_id'
            );
            $table->foreignId('leg_left_id')->nullable()->constrained(
                table: 'items', indexName: 'leg_left_id'
            );
            $table->foreignId('leg_right_id')->nullable()->constrained(
                table: 'items', indexName: 'leg_right_id'
            );

            $table->foreignId('clothes_array')->nullable();
            $table->foreignId('items_array')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avatars');
    }
};
