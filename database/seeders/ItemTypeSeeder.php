<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Item\ItemType;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $presets = config('site.item_types');
        $toInsert = [];

        foreach ($presets as $key => $val) {
            array_push($toInsert, [
                'id' => $key,
                'name' => $val,
                'is_public' => 1
            ]);
        }

        if ($toInsert) {
            ItemType::insert($toInsert);
        }
    }
}
