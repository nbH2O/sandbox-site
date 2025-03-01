<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Staudenmeir\LaravelMergedRelations\Facades\Schema as MSchema;

use App\Models\User\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->nullable()->constrained(
                table: 'users', indexName: 'sender_id'
            );
            $table->foreignId('receiver_id')->nullable()->constrained(
                table: 'users', indexName: 'receiver_id'
            );
            $table->boolean('is_accepted');
            $table->timestamps();
        });
        MSchema::createMergeView(
            'friends_view',
            [(new User())->acceptedFriendsTo(), (new User())->acceptedFriendsFrom()]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_friendships');
        MSchema::dropView('friends_view');
    }
};
