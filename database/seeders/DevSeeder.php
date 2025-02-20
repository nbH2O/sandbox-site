<?php

namespace Database\Seeders;

use App\Models\User\User;
use App\Models\User\UserRole;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// php artisan migrate:fresh --seed --seeder=DevSeeder
class DevSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {       
        $this->call([
            DatabaseSeeder::class,
        ]);

        User::factory()->create([
            'id' => 2,
            'name' => 'test',
            'email' => 'test@example.com',
            'is_name_scrubbed' => 0,
            'is_description_scrubbed' => 0,
            'points' => 0,
            'currency' => 1000000,
            'password' => Hash::make('test')
        ]);
        UserRole::create([
            'user_id' => 2,
            'role_id' => 1 // owner role
        ]);
    }
}
