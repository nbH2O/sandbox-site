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


        return view('livewire.user.edit-avatar', [
            'inventory' => $inventory,
            'equipped' => $avatar->equipped
        ]);
    }

    public function saveAvatar()
    {
        if (! $user = Auth()->user())
            dd('no login');

        $avatar = $user->getAvatar();

        $models = '';
        foreach ($avatar->equipped as $ei) {
            $xml = $ei->model->data;

            $doc = new \DOMDocument();
            $doc->loadXML($xml);
            $root = $doc->documentElement; // Get the first (root) element
            $root->setAttribute('position', '0,2,0');

            // Get all elements in the document
            $elements = $doc->getElementsByTagName('*');

            // Iterate over all elements and check for the 'src' attribute
            foreach ($elements as $element) {
                if ($element->hasAttribute('src')) {
                    $element->setAttribute('src', url($element->getAttribute('src')));
                }
            }
            
            $doc->formatOutput = false;
            $res = $doc->saveXML($root);
            // fix self-closing tag crap
            $models .=  preg_replace('/<(\w+)([^>]*?)\s*\/>/', '<$1$2></$1>', $res);
        }

        RenderImage::dispatch($user, '
            <Root name="SceneRoot">
                <Humanoid
                    isRenderSubject="true"

                    face="'.( isset($avatar->body->face) ? url('storage/'.$avatar->body->face->file_ulid.'.png') : url('storage/default/rig/face.png') ).'"
                    head="'.( isset($avatar->body->head) ? url('storage/'.$avatar->body->head->file_ulid.'.obj') : url('storage/default/rig/head.obj') ).'"
                    torso="'.( isset($avatar->body->torso) ? url('storage/'.$avatar->body->torso->file_ulid.'.obj') : url('storage/default/rig/torso.obj') ).'"
                    armLeft="'.( isset($avatar->body->arm_left) ? url('storage/'.$avatar->body->arm_left->file_ulid.'.obj') : url('storage/default/rig/armLeft.obj') ).'"
                    armRight="'.( isset($avatar->body?->arm_right) ? url('storage/'.$avatar->body->arm_right->file_ulid.'.obj') : url('storage/default/rig/armRight.obj') ).'"
                    legLeft="'.( isset($avatar->body->leg_left) ? url('storage/'.$avatar->body->leg_left->file_ulid.'.obj') : url('storage/default/rig/legLeft.obj') ).'"
                    legRight="'.( isset($avatar->body->leg_right) ? url('storage/'.$avatar->body->leg_right->file_ulid.'.obj') : url('storage/default/rig/legRight.obj') ).'"

                    headColor="'.($avatar->properties->head_color ?? '#D3D3D3').'"
                    torsoColor="'.($avatar->properties->torso_color ?? '#D3D3D3').'"
                    armLeftColor="'.($avatar->properties->arm_left_color ?? '#D3D3D3').'"
                    armRightColor="'.($avatar->properties->arm_right_color ?? '#D3D3D3').'"
                    legLeftColor="'.($avatar->properties->leg_left_color ?? '#D3D3D3').'"
                    legRightColor="'.($avatar->properties->leg_right_color ?? '#D3D3D3').'"
                >
                    '.$models.'
                </Humanoid>
            </Root>
        ');
    }
}
