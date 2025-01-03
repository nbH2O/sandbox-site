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
        Schema::create('render_tokens', function (Blueprint $table) {
            $table->id();
            $table->ulid('token');
            $table->integer('renderable_id');
            $table->string('renderable_type');
            $table->timestamp('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('render_tokens');
    }
};
