<?php

namespace App\Http\Controllers\Item;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Item\Item;

class ItemController extends Controller
{
    public function profile(int $id)
    {
        return view('item.profile', [
            'item' => Item::with('creator')->where('id', $id)->firstOrFail()
        ]);
    }
}
