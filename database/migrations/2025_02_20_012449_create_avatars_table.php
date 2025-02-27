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

            $table->string('head_color')->nullable();
            $table->string('torso_color')->nullable();
            $table->string('arm_left_color')->nullable();
            $table->string('arm_right_color')->nullable();
            $table->string('leg_left_color')->nullable();
            $table->string('leg_right_color')->nullable();
        });

        Schema::create('avatar_item', function (Blueprint $table) {
            $table->id();

            $table->foreignId('avatar_id')->constrained();
            $table->foreignId('item_id')->constrained();

            $table->decimal('position_x_adjust', 5, 2)->nullable();
            $table->decimal('position_y_adjust', 5, 2)->nullable();
            $table->decimal('position_z_adjust', 5, 2)->nullable();

            $table->smallInteger('rotation_x')->nullable();
            $table->smallInteger('rotation_y')->nullable();
            $table->smallInteger('rotation_z')->nullable();

            $table->decimal('scale', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avatar_item');
        Schema::dropIfExists('avatars');
    }
};
