<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
            $table->tinyInteger('theme')->nullable(); // 1 light 0 dark

            // should really only be nulled for dev, dont wanna render
            // a bajillion avatars
            $table->ulid('render_ulid')->nullable();
            $table->foreignId('avatar_id')->nullable();

            $table->rememberToken();
            $table->timestamp('born_at');
            $table->timestamp('rewarded_at');
            $table->timestamp('online_at');
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
        Schema::dropIfExists('user_ip_logs');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('sessions');
    }
};
