<?php

namespace Database\Seeders;

use Carbon\Carbon;

use App\Models\User\User;
use App\Models\User\UserRole;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('config:clear');

        $this->call([
            ItemTypeSeeder::class,
            RoleSeeder::class
        ]);

        // main account
        User::create([
            'id' => 1,
            'name' => 'admin',
            'email' => 'fake',
            'password' => 'fake',
            'is_name_scrubbed' => 0,
            'is_description_scrubbed' => 0,
            'points' => 0,
            'currency' => 0,
            'born_at' => now()->subYears(100),
            'online_at' => Carbon::parse('2023-01-01'),
            'rewarded_at' => Carbon::parse('2023-01-01')
        ]);
        UserRole::create([
            'user_id' => 1,
            'role_id' => 2 // admin role is 2, owner is 1
        ]);
    }
}
