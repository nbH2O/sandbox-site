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
        $privates = config('site.private_item_types');
        $toInsert = [];

        foreach ($presets as $key => $val) {
            if ($key != 0) {
                array_push($toInsert, [
                    'id' => $key,
                    'name' => $val,
                    'is_public' => in_array($val, $privates) ? 0 : 1
                ]);
            }
        }

        foreach ($toInsert as $tI) {
            $id = $tI['id'];
            unset($tI['id']);
            ItemType::updateOrInsert(
                ['id' => $id],
                $tI
            );
        } 
    }
}
