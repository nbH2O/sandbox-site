<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

class Comments extends Component
{   
    // commentable
    private Model $model;

    public function mount(Model $model)
    {
        $this->model = $model; // Proper initialization
    }

    public function render()
    {
        $comments = Comment::where('commentable_type', get_class($this->model))
                            ->where('commentable_id', $this->model->id)
                            ->paginate(8);

        return view('livewire.comments', [
            'comments' => $comments
        ]);
    }
}
