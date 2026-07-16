<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use App\Traits\Notifies;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, Notifies;

    #[Url(history: true)]
    public string $status = '';

    public string $search = '';
    public int $perPage = 15;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function orders()
    {
        return Order::query()
            ->with('user')
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('order_number', 'like', '%' . $this->search . '%'); // FIX: order_number
                });
            })
            ->latest()
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.admin.order.index');
    }
}
