<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $presets = config('site.roles');

        if ($presets) {
            foreach ($presets as $preset) {
                $id = $preset['id'];
                unset($preset['id']);
                Role::updateOrInsert(
                    ['id' => $id],
                    $preset
                );
            }
        }
    }
}
