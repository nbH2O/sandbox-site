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
        return view('livewire.user.edit-avatar');
    }

    public function saveAvatar()
    {
        if (! $user = Auth()->user())
            return;

        RenderImage::dispatch(Auth()->user(), '
            <Root name="SceneRoot">
                <Humanoid>
                    <Mesh src="http://bhlol.test/storage/default/rig/testhat.glb" position="0,2,0"></Mesh>
                </Humanoid>
            </Root>
        ');
    }
}
