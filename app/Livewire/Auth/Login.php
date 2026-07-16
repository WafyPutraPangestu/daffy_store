<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected array $rules = [
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ];

    protected array $messages = [
        'email.required'    => 'Email wajib diisi.',
        'email.email'       => 'Format email tidak valid.',
        'password.required' => 'Password wajib diisi.',
        'password.min'      => 'Password minimal 6 karakter.',
    ];

    public function login()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->dispatch('notify', message: 'Email atau password salah.', type: 'error');
            return;
        }

        session()->regenerate();
        $this->dispatch('notify', message: 'Selamat datang, ' . Auth::user()->name . '!', type: 'success');

        return match (Auth::user()->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'kepala' => redirect()->route('kepala.dashboard'),
            default  => redirect()->route('home'),
        };
    }
    public function render()
    {
        return view('livewire.auth.login');
    }
}
