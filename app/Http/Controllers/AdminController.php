<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Item\Item;
use App\Models\Model;
use App\Jobs\RenderImage;

class AdminController extends Controller
{
    public function createItem(Request $request)
    {
        if ($request->isMethod('post')) {

            $validated = $request->validate([
                'file' => 'required|file|mimes:jpg,png,obj,gltf,glb|max:2048', // example rules
                'type_id' => 'required|in:1,2',
                'name' => 'required|max:20',
                'description' => 'nullable|max:128',
                'price' => 'nullable|integer',
                'is_onsale' => 'nullable|in:1,true,on',
                'is_special' => 'nullable|in:1,true,on',
                'max_copies' => 'nullable|integer',
                'available_from' => 'nullable|date',
                'available_to' => 'nullable|date',
                'is_public' => 'nullable|in:1,true,on'
            ]);

            DB::transaction(function () use ($request, $validated) {

                $file = $request->file('file');
                $ulid = Str::ulid();
                $ext = $file->getClientOriginalExtension();

                Storage::disk('public')->put($ulid.'.'.$ext, file_get_contents($file));
                $modelData = '<Mesh src="'.$ulid.'.'.$ext.'"></Mesh>';
                $itemTypesFlipped = array_flip(config('site.item_types'));

                if (in_array($validated['type_id'], [$itemTypesFlipped['hat']])) {
                    $model = Model::create([
                        'version' => 1,
                        'data' => $modelData
                    ]);
                }
    
                $newItem = Item::create([
                    'type_id' => $validated['type_id'],
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'creator_id' => config('site.main_account_id'),
                    'price' => $validated['price'],
                    'is_onsale' => $validated['is_onsale'] ?? 0,
                    'is_special' => $validated['is_special'] ?? 0,
                    'max_copies' => $validated['max_copies'],
                    'available_from' => $validated['available_from'],
                    'available_to' => $validated['available_to'],
                    'is_public' => $validated['is_public'] ?? 0,
                    'render_ulid' => $validated['type_id'] == $itemTypesFlipped['hat'] ? null : $ulid,
                    'file_ulid' => $validated['type_id'] == $itemTypesFlipped['hat'] ? null : $ulid,
                    'model_id' => $validated['type_id'] == $itemTypesFlipped['hat'] ? $model->id : null,
                    'is_name_scrubbed' => 0,
                    'is_description_scrubbed' => 0,
                    'is_sold_out' => 0,
                    'is_accepted' => 1
                ]);
                
                if (in_array($validated['type_id'], [$itemTypesFlipped['hat']])) {
                    RenderImage::dispatch($newItem, '
                        <Root name="SceneRoot">
                            <Mesh isRenderSubject="true" src="'.url('storage/'.$ulid.'.'.$ext).'"></Mesh>
                        </Root>
                    ');
                }
            });



            return back()->with('success', 'File uploaded successfully!');
        } else {
            return view('admin.item.create');
        }
    }
}
