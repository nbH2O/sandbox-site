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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->text('description')->nullable();
            $table->boolean('is_name_scrubbed');
            $table->boolean('is_description_scrubbed');
            $table->integer('currency');
            $table->integer('points');
            $table->tinyInteger('theme'); // 1 light 0 dark
            $table->foreignId('primary_group_id')->nullable()->constrained(
                table: 'groups', indexName: 'primary_group_id'
            );
            $table->ulid('render_ulid');

            $table->rememberToken();
            $table->timestamp('born_at');
            $table->timestamp('rewarded_at');
            $table->timestamp('online_at');
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('icon');
            $table->string('color'); // hex
            $table->integer('power'); // can be null for random roles - but 'admin' should be higher than 'tester' for instance
            $table->boolean('is_public'); // visible on profile/comment/forum/etc
        });
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id');
            $table->foreignId('user_id');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('user_ip_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->ipAddress();
        });

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

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('user_ip_logs');
        Schema::dropIfExists('user_friendships');
        MSchema::dropView('friends_view');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('sessions');
    }
};
