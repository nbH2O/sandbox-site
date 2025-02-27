<?php

namespace Database\Seeders;

use Carbon\Carbon;

use App\Models\User\User;
use App\Models\User\UserRole;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

// php artisan db:seed --force
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * Called seeders should represent 'hardcoded' data...
     * that would need to be the same no matter which environment
     * and will usually need hard coding in other places
     * (such as shop sort)
     */
    public function run(): void
    {
        Artisan::call('config:clear');

        DB::table('item_types')->truncate();
        DB::table('roles')->truncate();

        $this->call([
            ItemTypeSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
