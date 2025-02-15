<?php

namespace Database\Seeders;

use App\Models\User\User;
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
        // main account
        User::factory()->create([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@example.com',
            'is_name_scrubbed' => 0,
            'is_description_scrubbed' => 0,
            'points' => 0,
            'currency' => 0
        ]);
        User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'is_name_scrubbed' => 0,
            'is_description_scrubbed' => 0,
            'points' => 0,
            'currency' => 1000000,
            'password' => Hash::make('test')
        ]);
        User::factory(10)->create();

        $this->call([
            DatabaseSeeder::class
        ]);
    }
}
