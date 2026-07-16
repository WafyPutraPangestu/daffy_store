<?php

namespace App\Livewire\Pelanggan\Transaction;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;


    #[Url(history: true)]
    public string $status = '';


    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function orders()
    {
        return Order::with(['items.product'])
            ->where('user_id', Auth::id())
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.pelanggan.transaction.index');
    }
}
