<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Item\Item;
use App\Models\Item\Bundle;
use App\Models\Model;
use App\Models\Site\SoftMaintenance;
use App\Jobs\RenderImage;

class AdminController extends Controller
{
    public function siteMaintenance(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'message' => 'nullable',
                'min_power' => 'nullable|min:1|max:255',
            ]);

            SoftMaintenance::create([
                'message' => $validated['message'],
                'is_bypassable' => 1,
                'min_power' => $validated['min_power'] ?? 255
            ]);

            return back()->with('success', 'Maintenance enabled successfully!');
        } else if ($request->isMethod('delete')) {
            SoftMaintenance::query()->delete();
            return back();
        } else {
            return view('admin.site.maintenance', [
                'info' => SoftMaintenance::select('message', 'min_power')->orderBy('id', 'DESC')->first()
            ]);
        }
    }

    public function createItem(Request $request)
    {
        if ($request->isMethod('post')) {

            $itemTypeIDs = array_flip(config('site.item_types'));
            
            $validated = $request->validate([
                'file' => 'required|file|mimes:png,glb|max:2048', // example rules
                'type_id' => 'required|in:'.$itemTypeIDs['face'].','.$itemTypeIDs['hat'],
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
                    'render_ulid' => $validated['type_id'] == $itemTypesFlipped['face'] ? $ulid : null,
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
                            <Mesh isRenderSubject="true" src="'.config('site.local_url').'storage/'.$ulid.'.'.$ext.'"></Mesh>
                        </Root>
                    ');
                }
            });



            return back()->with('success', 'File uploaded successfully!');
        } else {
            return view('admin.item.create');
        }
    }

    public function createFigure(Request $request)
    {
        if ($request->isMethod('post')) {
            $itemTypeIDs = array_flip(config('site.item_types'));
            
            $validated = $request->validate([
                'torso_file' => 'nullable|file|max:2048',
                'arm_left_file' => 'nullable|file|max:2048',
                'arm_right_file' => 'nullable|file|max:2048',
                'leg_left_file' => 'nullable|file|max:2048',
                'leg_right_file' => 'nullable|file|max:2048',

                'name' => 'required|max:20',
                'description' => 'nullable|max:128',
                'price' => 'nullable|integer',
                'is_onsale' => 'nullable|in:1,true,on',
                'max_copies' => 'nullable|integer',
                'available_from' => 'nullable|date',
                'available_to' => 'nullable|date',
                'is_public' => 'nullable|in:1,true,on'
            ]);

            DB::transaction(function () use ($request, $validated, $itemTypeIDs) {

                $files = [
                    'torso' => $request->file('torso_file') ?? null,
                    'arm_left' => $request->file('arm_left_file') ?? null,
                    'arm_right' => $request->file('arm_right_file') ?? null,
                    'leg_left' => $request->file('leg_left_file') ?? null,
                    'leg_right' => $request->file('leg_right_file') ?? null,
                ];

                $ulids = [];
                $bodyPartIDs = [];

                foreach ($files as $key => $val) {
                    if (isset($val)) {
                        $ulid = Str::ulid();
                                                        // better hope they uploaded an obj!
                        Storage::disk('public')->put($ulid.'.obj', file_get_contents($val));

                        $ulids[$key] = $ulid;

                        $newItem = Item::create([
                            'name' => $validated['name'].' '.ucwords(str_replace('_', ' ', $key)),
                            'creator_id' => config('site.main_account_id'),
                            'type_id' => $itemTypeIDs[$key],
                            'description' => 'g',
                            'price' => 0,
                            'is_onsale' => 0,
                            'is_special' => 0,
                            'is_public' => 1,
                            'file_ulid' => $ulid,
                            'is_name_scrubbed' => 0,
                            'is_description_scrubbed' => 0,
                            'is_sold_out' => 0,
                            'is_accepted' => 1
                        ]);

                        array_push($bodyPartIDs, $newItem->id);

                        RenderImage::dispatch($newItem, '
                            <Root name="SceneRoot">
                                <Humanoid 
                                    setRenderSubject="'.$key.'"

                                    face="'.config('site.local_url').'storage/default/rig/face.png'.'"
                                    head="'.config('site.local_url').'storage/default/rig/head.obj'.'"
                                    torso="'.(($key == 'torso') ? config('site.local_url').'storage/'.$ulid.'.obj' : config('site.local_url').'storage/default/rig/torso.obj' ).'"
                                    armLeft="'.(($key == 'arm_left') ? config('site.local_url').'storage/'.$ulid.'.obj' : config('site.local_url').'storage/default/rig/armLeft.obj' ).'"
                                    armRight="'.(($key == 'arm_right') ? config('site.local_url').'storage/'.$ulid.'.obj' : config('site.local_url').'storage/default/rig/armRight.obj' ).'"
                                    legLeft="'.(($key == 'leg_left') ? config('site.local_url').'storage/'.$ulid.'.obj' : config('site.local_url').'storage/default/rig/legLeft.obj' ).'"
                                    legRight="'.(($key == 'leg_right') ? config('site.local_url').'storage/'.$ulid.'.obj' : config('site.local_url').'storage/default/rig/legRight.obj' ).'"

                                    headColor="#D3D3D3"
                                    torsoColor="#D3D3D3"
                                    armLeftColor="#D3D3D3"
                                    armRightColor="#D3D3D3"
                                    legLeftColor="#D3D3D3"
                                    legRightColor="#D3D3D3"
                                >
                                </Humanoid>
                            </Root>
                        ');
                    } else {
                        unset($files[$key]);
                    }
                }

                $ulid = Str::ulid();

                $newFigure = Item::create([
                    'type_id' => $itemTypeIDs['figure'],
                    'name' => $validated['name'],
                    'description' => $validated['description'],
                    'creator_id' => config('site.main_account_id'),
                    'price' => $validated['price'],
                    'is_onsale' => $validated['is_onsale'] ?? 0,
                    'is_special' => 0,
                    'max_copies' => $validated['max_copies'],
                    'available_from' => $validated['available_from'],
                    'available_to' => $validated['available_to'],
                    'is_public' => $validated['is_public'] ?? 0,
                    'file_ulid' => $ulid,
                    'is_name_scrubbed' => 0,
                    'is_description_scrubbed' => 0,
                    'is_sold_out' => 0,
                    'is_accepted' => 1
                ]);

                $bundleInserts = [];
                foreach ($bodyPartIDs as $bpID) {
                    array_push($bundleInserts, [
                        'bundle_id' => $newFigure->id,
                        'item_id' => $bpID
                    ]);
                }
                Bundle::insert($bundleInserts);

                RenderImage::dispatch($newFigure, '
                    <Root name="SceneRoot">
                        <Humanoid 
                            isRenderSubject="true"

                            face="'.config('site.local_url').'storage/default/rig/face.png'.'"
                            head="'.config('site.local_url').'storage/default/rig/head.obj'.'"
                            torso="'.( isset($ulids['torso']) ? config('site.local_url').'storage/'.$ulids['torso'].'.obj' : config('site.local_url').'storage/default/rig/torso.obj' ).'"
                            armLeft="'.( isset($ulids['arm_left']) ? config('site.local_url').'storage/'.$ulids['arm_left'].'.obj' : config('site.local_url').'storage/default/rig/armLeft.obj' ).'"
                            armRight="'.( isset($ulids['arm_right']) ? config('site.local_url').'storage/'.$ulids['arm_right'].'.obj' : config('site.local_url').'storage/default/rig/armRight.obj' ).'"
                            legLeft="'.( isset($ulids['leg_left']) ? config('site.local_url').'storage/'.$ulids['leg_left'].'.obj' : config('site.local_url').'storage/default/rig/legLeft.obj' ).'"
                            legRight="'.( isset($ulids['leg_right']) ? config('site.local_url').'storage/'.$ulids['leg_right'].'.obj' : config('site.local_url').'storage/default/rig/legRight.obj' ).'"

                            headColor="#D3D3D3"
                            torsoColor="#D3D3D3"
                            armLeftColor="#D3D3D3"
                            armRightColor="#D3D3D3"
                            legLeftColor="#D3D3D3"
                            legRightColor="#D3D3D3"
                        >
                        </Humanoid>
                    </Root>
                ');
            });

            return back()->with('success', 'File uploaded successfully!');
        } else {
            return view('admin.item.create-figure');
        }
    }
}
