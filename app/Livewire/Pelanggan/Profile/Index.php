<?php

namespace App\Livewire\Pelanggan\Profile;

use App\Models\User;
use App\Traits\Notifies;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    use Notifies;

    public string $name = '';
    public string $email = '';

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile()
    {
        $user = User::find(Auth::id());

        $validated = $this->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique'   => 'Alamat email sudah digunakan oleh akun lain.',
        ]);

        $user->update($validated);

        $this->notifySuccess('Informasi profil dasar berhasil diperbarui.', 'PROFIL TERSIMPAN');
    }

    public function render()
    {
        return view('livewire.pelanggan.profile.index');
    }
}
