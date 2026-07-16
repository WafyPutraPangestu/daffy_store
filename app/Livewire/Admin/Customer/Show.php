<?php

namespace App\Livewire\Admin\Customer;

use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public User $user;

    public function mount(User $user)
    {
        // Load relasi profile dan orders milik user ini
        $this->user = $user->load(['customerProfile', 'orders' => function ($query) {
            $query->latest();
        }]);
    }

    public function render()
    {
        return view('livewire.admin.customer.show');
    }
}
