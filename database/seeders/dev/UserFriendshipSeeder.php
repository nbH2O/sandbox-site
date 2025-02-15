<?php

namespace Database\Seeders\Dev;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User\UserFriendship;

class UserFriendshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $new = [];

        for ($i = 0; $i <= 10; $i++) {
            array_push($new, [
                'receiver_id' => rand(1, 11),
                'sender_id' => rand(1, 11),
                'is_accepted' => rand(0, 1)
            ]);
        }

        UserFriendship::insert($new);
    }
}
