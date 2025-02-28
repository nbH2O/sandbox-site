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
         Schema::create('item_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_public'); // if shows in shop
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained(
                table: 'users', indexName: 'creator_id'
            );
            $table->foreignId('type_id')->constrained(
                table: 'item_types', indexName: 'type_id'
            );

            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('price')->nullable();
            $table->boolean('is_name_scrubbed');
            $table->boolean('is_description_scrubbed');

            $table->boolean('is_onsale');
            $table->boolean('is_special');
            $table->integer('average_price')->nullable();

            $table->integer('max_copies')->nullable();
            $table->boolean('is_sold_out');
            $table->timestamp('available_from')->nullable();
            $table->timestamp('available_to')->nullable();

            $table->ulid('render_ulid')->nullable();
            $table->ulid('file_ulid')->nullable(); // for faces
            $table->foreignId('model_id')->nullable()->constrained(); // for hats

            $table->boolean('is_public');
            $table->boolean('is_accepted');
            $table->timestamps();
        });

        // can theoretically be expanded to include outfits
        // at a later time
        Schema::create('item_bundle_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_id')->constrained(
                table: 'items', indexName: 'bundle_id'
            );
            $table->foreignId('item_id')->constrained();
        });

        Schema::create('item_sale_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained();

            // null if its not a resale purchase
            $table->foreignId('reseller_id')->nullable()->constrained(
                table: 'users', indexName: 'seller_id'
            );
            $table->foreignId('buyer_id')->constrained(
                table: 'users', indexName: 'buyer_id'
            );

            $table->integer('price');

            $table->timestamps();
        });

        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('item_id');

            // these are only for specials obvisouslsly
            $table->boolean('is_for_trade')->nullable(); // 1 wanna trade 0 no, null whatever
            $table->integer('resale_price')->nullable();
            $table->integer('serial');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('item_types');
        Schema::dropIfExists('item_bundle_contents');
        Schema::dropIfExists('inventories');
    }
};
