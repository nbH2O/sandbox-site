<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate; 
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $size = 'lg';
    public bool $redirect = true;

    #[Validate('required')]
    public $username = '';
    #[Validate('required')]
    public $password = '';

    public bool $remember = false;

    public function submit()
    {
        $this->validate();

        $credentials = [
            'name' => $this->username,
            'password' => $this->password
        ];

        if(Auth::attempt($credentials, $this->remember)) {
            session()->regenerate();
            if ($this->redirect) {
                return $this->redirect('/');
            } else {
                $this->js('window.location.reload()'); 
            }
        } else {
            $this->addError('general', __('Incorrect username or password'));
        };
    }

    public function render()
    {
        return view('livewire.auth.login', [
            'size' => $this->size,
        ]);
    }
}
