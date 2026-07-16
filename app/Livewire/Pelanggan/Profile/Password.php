<?php

namespace App\Livewire\Pelanggan\Profile;

use App\Models\User;
use App\Traits\Notifies;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component
{
    use Notifies;

    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function updatePassword()
    {
        $user = User::find(Auth::id());

        $this->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Kata sandi saat ini tidak cocok dengan data kami.');
                }
            }],
            'new_password'     => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Kata sandi lama wajib diisi.',
            'new_password.required'     => 'Kata sandi baru wajib diisi.',
            'new_password.min'          => 'Kata sandi baru minimal harus 8 karakter.',
            'new_password.confirmed'    => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        // Eksekusi enkripsi hash sandi baru ke database
        $user->update([
            'password' => Hash::make($this->new_password)
        ]);

        // Kosongkan form kembali setelah sukses
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        $this->notifySuccess('Kredensial keamanan sandi akun berhasil diganti.', 'SANDI DIPERBARUI');
    }

    public function render()
    {
        return view('livewire.pelanggan.profile.password');
    }
}
