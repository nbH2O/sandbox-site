<?php

namespace App\Http\Controllers\Item;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Item\Item;
use App\Models\Item\Inventory;

use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function profile(int $id)
    {
        return view('item.profile', [
            'item' => Item::with('creator')->where('id', $id)->firstOrFail()
        ]);
    }

    public function purchase(Request $request, int $id)
    {
        $validator = Validator::make([], []);

        if ($user = $request->user()) {
            $item = Item::find($id);

            if ($item) {
                if (!$item->isOwnedBy($user->id)) {
                    if ($request->input('price') != $item->price) {
                        $validator->errors()->add('unexpectedPrice', 'j');
                    } else if ($item->price > $user->currency) {
                        $validator->errors()->add('highPrice', 'j');
                    } else {
                        DB::transaction(function () use ($user, $item) {
                            $user->decrement('currency', $item->price);
                            $highest = Inventory::where('item_id', $item->id)
                                                ->orderBy('serial', 'DESC')
                                                ->first();
                            $serial = $highest?->serial + 1 ?? 1;
                            Inventory::insert([
                                'user_id' => $user->id,
                                'item_id' => $item->id,
                                'serial' => $serial
                            ]);
                            if ($serial >= $item->max_copies) {
                                $item->timestamps = false;
                                $item->is_sold_out = true;
                                $item->save();
                            }
                            $item->creator->increment('currency', round($item->price * config('site.after_tax')));
                        });
                        $validator->errors()->add('purchaseSuccessful', 'j');
                    }
                }
            }
        } else {
            return redirect(route('login'));
        }

        return redirect('/$'.$id)->withErrors($validator);
    }
}
