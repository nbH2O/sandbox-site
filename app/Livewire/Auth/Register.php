<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User\User;
use App\Models\User\RegisterIP;
use App\Events\UserRegistered;

class Register extends Component
{
    public $size = 'lg';
    public bool $redirect = true;

    #[Validate('required')]
    #[Validate('min:3')]
    #[Validate('max:20')]
    #[Validate('regex:/^(?!_)[^_]*_?[^_]*(?!_)$/', message: 'Cannot have more than one of each special character')]
    #[Validate('regex:/^(?! )[^\ ]* ?[^\ ]*(?! )$/', message: 'Cannot have more than one of each special character')]
    #[Validate('regex:/^(?!-)[^-]*-?[^-]*(?!-)$/', message: 'Cannot have more than one of each special character')]
    #[Validate('regex:/^(?!\.)[^.]*\.?[^.]*(?!\.)$/', message: 'Cannot have more than one of each special character')]
    #[Validate('regex:/^(?!.*[_ .-]{2})[a-zA-Z0-9_ .-]+$/', message: 'Special characters cannot be consecutive')]
    #[Validate('unique:users,name')]
    public $username = '';

    #[Validate('required')]
    #[Validate('email:rfc,dns')]
    #[Validate('unique:users,email')]
    public $email = '';

    #[Validate('required')]
    #[Validate('min:8')]
    #[Validate('confirmed')]
    public $password = '';

    public $password_confirmation = '';

    public bool $remember = false;

    public function submit()
    {
        $this->validate();

        $ip = request()->header('CF-Connecting-IP', request()->ip());
        $previousIP = RegisterIP::where('ip_address', $ip)->orderBy('created_at', 'DESC')->first();

        if ($previousIP) {
            if ($previousIP->created_at >= now()->subDays(1)) {
                abort(429);
            }
        }

        $newUser = User::create([
            'name' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'is_name_scrubbed' => 0,
            'is_description_scrubbed' => 0,
            'currency' => 0,
            'points' => 0,
            'born_at' => now()->subYears(18),
            'rewarded_at' => now()->subDays(1),
            'online_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        RegisterIP::insert([
            'user_id' => $newUser->id,
            'ip_address' => $ip,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Auth::login($newUser);

        UserRegistered::dispatch($newUser);

        $this->redirectRoute('user.profile', ['id' => $newUser->id]);
    }

    public function render()
    {
        return view('livewire.auth.register', [
            'size' => $this->size,
        ]);
    }
}
