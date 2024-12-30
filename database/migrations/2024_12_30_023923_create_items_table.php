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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained(
                table: 'users', indexName: 'creator_id'
            );
            $table->foreignId('type_id')->constrained();

            $table->string('name');
            $table->text('description');
            $table->boolean('is_name_scrubbed');
            $table->boolean('is_description_scrubbed');

            $table->boolean('is_special');
            $table->integer('average_price')->nullable();

            $table->integer('max_copies');
            $table->timestamp('available_from');
            $table->timestamp('available_to');

            $table->ulid('render_ulid');
            $table->ulid('file_ulid');

            $table->boolean('is_public');
            $table->boolean('is_accepted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
