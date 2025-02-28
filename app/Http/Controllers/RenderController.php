<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RenderToken;
use Illuminate\Support\Facades\Storage;

class RenderController extends Controller
{
    public function callback(Request $request)
    {
        $token = $request->token;
        $file = $request->file('file');

        if(!$token || !$file)
            abort(404);

        $sql = RenderToken::where('token', $token)->first();

        if (!$sql)
            abort(404);

        Storage::disk('public')->put($token.'.png', file_get_contents($file));

        Storage::disk('public')->delete($sql->renderable->render_ulid.'.png');

        $sql->renderable->render_ulid = $sql->token;
        $sql->renderable->save();

        return response()->json($sql->renderable->toArray());
    }
}
