<?php

namespace App\Http\Controllers\Item;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Item\Item;
use App\Models\Item\Inventory;
use App\Models\Item\Bundle;
use App\Models\Item\SaleLog;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
                            $inv = $item->grantTo($user);

                            if ($inv->serial >= $item->max_copies) {
                                $item->timestamps = false;
                                $item->is_sold_out = true;
                                $item->save();
                            }
                            $item->creator->increment('currency', round($item->price * config('site.after_tax')));

                            if (in_array($item->type->name, config('site.bundle_item_types'))) {
                                $bundleContents = Bundle::where('bundle_id', $item->id)->get();
                                $toInsert = [];

                                foreach ($bundleContents as $bC) {
                                    $bcHighest = Inventory::where('item_id', $bC->id)
                                                ->orderBy('serial', 'DESC')
                                                ->first();
                                    $bcSerial = $bcHighest?->serial + 1 ?? 1;
                                    array_push($toInsert, [
                                        'user_id' => $user->id,
                                        'item_id' => $bC->item_id,
                                        'serial' => $bcSerial
                                    ]);
                                }

                                Inventory::insert($toInsert);
                            }
                        });
                        $validator->errors()->add('purchaseSuccessful', 'j');
                    }
                }
            }
        } else {
            return redirect(route('login'));
        }

        return redirect()->route('item.profile', ['id' => $id])->withErrors($validator);
    }

    public function createClothing(Request $request)
    { 
        if ($user = Auth()->user()) {
            if ($request->isMethod('GET')) {
                return view('item.create-clothing');
            } else if ($request->isMethod('POST')) {
                $itemTypeIDs = array_flip(config('site.item_types'));
            
                $validated = $request->validate([
                    'file' => 'required|file|mimetypes:image/png|dimensions:ratio=585/830,max_width=585|max:256', // example rules
                    'type_id' => 'required|in:'.$itemTypeIDs['shirt'].','.$itemTypeIDs['pants'].','.$itemTypeIDs['suit'],
                    'name' => 'required|max:20',
                    'description' => 'nullable|max:128',
                    'price' => 'nullable|integer',
                    'is_onsale' => 'nullable|in:1,true,on'
                ]);

                $ulid = Str::ulid();

                try {
                    DB::transaction(function () use ($request, $validated, $user, $ulid) {
                        $newClothing = Item::create([
                            'type_id' => $validated['type_id'],
                            'name' => $validated['name'],
                            'description' => $validated['description'],
                            'creator_id' => $user->id,
                            'price' => $validated['price'],
                            'is_onsale' => $validated['is_onsale'] ?? 0,
                            'is_special' => 0,
                            'is_public' => 1,
                            'render_ulid' => null,
                            'file_ulid' => $ulid,
                            'model_id' => null,
                            'is_name_scrubbed' => 0,
                            'is_description_scrubbed' => 0,
                            'is_sold_out' => 0,
                            'is_accepted' => 0,
                            'is_pending' => 1
                        ]);

                        Storage::disk('public')->put($ulid.'.png', file_get_contents($request->file('file')));
                    });
                } catch (\Exception $e) {
                    Storage::disk('public')->delete($ulid.'.png');
                    return back()->with('success', false);
                };

                return back()->with('success', true);
            }
        } else {
            return redirect(route('login'));
        }
    }
}
