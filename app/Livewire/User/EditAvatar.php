<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User\User;
use App\Jobs\RenderImage;

class EditAvatar extends Component
{
    public $query = null;

    public function render()
    {
        $user = Auth()->user();

        $inventory = $user->inventory()->with('item')->simplePaginate(8);
        $avatar = $user->getAvatar();

        dd($avatar->equipped);


        return view('livewire.user.edit-avatar', [
            'inventory' => $inventory,
            'equipped' => $equipped
        ]);
    }

    public function saveAvatar()
    {
        if (! $user = Auth()->user())
            return;

        $user = Auth()->user();

        $avatar = $user->avatar();

        RenderImage::dispatch($user, '
            <Root name="SceneRoot">
                <Humanoid
                    face="'.( false ? url('storage/'.$avatar->face->file_ulid.'.png') : url('storage/default/rig/face.png') ).'"
                    head="'.( false ? url('storage/'.$avatar->head->file_ulid.'.obj') : url('storage/default/rig/head.obj') ).'"
                    torso="'.( false ? url('storage/'.$avatar->head->file_ulid.'.obj') : url('storage/default/rig/torso.obj') ).'"
                    armLeft="'.( false ? url('storage/'.$avatar->head->file_ulid.'.obj') : url('storage/default/rig/armLeft.obj') ).'"
                    armRight="'.( false ? url('storage/'.$avatar->head->file_ulid.'.obj') : url('storage/default/rig/armRight.obj') ).'"
                    legLeft="'.( false ? url('storage/'.$avatar->head->file_ulid.'.obj') : url('storage/default/rig/legLeft.obj') ).'"
                    legRight="'.( false ? url('storage/'.$avatar->head->file_ulid.'.obj') : url('storage/default/rig/legRight.obj') ).'"
                >
                    <Mesh src="'.( false ? '' : url('storage/default/rig/testhat.glb') ).'" position="0,2,0"></Mesh>
                </Humanoid>
            </Root>
        ');
    }
}
