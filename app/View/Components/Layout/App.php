<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\Site\Message;

class App extends Component
{
    public $messages = [];
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $msgs = Message::limit(6)->get()->toArray();
        foreach ($msgs as $msg) {
            array_push($this->messages, $msg);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.app', [
            'messages' => $this->messages
        ]);
    }
}
