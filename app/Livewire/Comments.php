<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Locked;
use Livewire\WithPagination;

class Comments extends Component
{   
    use WithPagination; 

    // commentable
    #[Locked]
    public $commentable_type;
    #[Locked]
    public $commentable_id;

    public function mount(Model $model)
    {
        // Proper initialization
        $this->commentable_type = get_class($model); 
        $this->commentable_id = $model->id;
    }

    #[Validate('required|min:3|max:255')]
    public $newComment = '';

    public function addNewComment()
    {
        $this->validate();

        if ($user = Auth()->user()) {
            Comment::insert([
                'user_id' => $user->id,
                'content' => $this->newComment,
                'commentable_type' => $this->commentable_type,
                'commentable_id' => $this->commentable_id,
                'created_at' => now(),
            ]);
            $this->newComment = '';
        } else {
            $this->addError('newComment', __("You're session has expired. Please log in"));
        }

        
    }

    public function deleteComment(int $id)
    {
        if (!$id || !Auth()->user())
            return;

        Comment::where('id', $id)
                ->where('user_id', Auth()->user()->id)
                ->delete();
    }

    public function render()
    {
        $comments = Comment::where('commentable_type', $this->commentable_type)
                            ->where('commentable_id', $this->commentable_id)
                            ->orderBy('created_at', 'DESC')
                            ->simplePaginate(8);

        return view('livewire.comments', [
            'comments' => $comments
        ]);
    }
}
