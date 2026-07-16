<?php

namespace App\Livewire\Admin\Customer;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 15;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function customers()
    {
        return User::query()
            ->where('role', 'pelanggan')
            ->with('customerProfile')
            ->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '\%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.customer.index');
    }
}
