<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item\Item;
use App\Models\Model;

class AdminController extends Controller
{
    public function createItem(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'file' => 'required|file|mimes:jpg,png,pdf|max:2048', // example rules
                'type' => 'required|in:1,2',
                'name' => 'required|max:20',
                'description' => 'nullable|max:128',
                'price' => 'nullable|integer',
                'is_onsale' => 'boolean',
                'is_special' => 'boolean',
                'max_copies' => 'nullable|integer',
                'available_from' => 'nullable|date',
                'available_to' => 'nullable|date',
                'is_public' => 'boolean'
            ]);

            $file = $request->file('file');

            $ulid = ulid();
            $ext = $file->getClientOriginalExtension();

            $path = $file->storeAs('public', $ulid.$ext);

            if ($validated['type'] == 0) {
                $model = Model::create([
                    'version' => 1,
                    'data' => `<Mesh src="$ulid.$ext"></Mesh>`
                ]);
            }

            Item::create([
                'type' => $validated['type'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'is_onsale' => $validated['is_onsale'],
                'is_special' => $validated['is_special'],
                'max_copies' => $validated['max_copies'],
                'available_from' => $validated['available_from'],
                'available_to' => $validated['available_to'],
                'is_public' => $validated['is_public'],
                'render_ulid' => $validated['type'] == 0 ? null : $ulid,
                'file_ulid' => $validated['type'] == 0 ? null : $ulid,
                'model_id' => $validated['type'] == 0 ? $model->id : null
            ]);

            return back()->with('success', 'File uploaded successfully!');
        } else {
            return view('admin.create-item');
        }
    }
}
