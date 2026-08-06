<?php

namespace App\Livewire\Components;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public int $cartCount = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    // Mengambil rincian data keranjang beserta produknya untuk ditampilkan di Modal Mini Cart
    #[Computed]
    public function cartData()
    {
        if (Auth::check()) {
            return Cart::with('items.product')->where('user_id', Auth::id())->first();
        }
        return null;
    }

    // Jumlah notifikasi yang belum dibaca (hanya untuk admin)
    #[Computed]
    public function unreadCount(): int
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return Auth::user()->unreadNotifications()->count();
        }
        return 0;
    }

    // 5 notifikasi terbaru untuk ditampilkan di dropdown
    #[Computed]
    public function recentNotifications()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return Auth::user()->notifications()->latest()->take(5)->get();
        }
        return collect();
    }

    // Tandai satu notifikasi sebagai sudah dibaca
    public function markAsRead(string $notificationId): void
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            unset($this->unreadCount);
            unset($this->recentNotifications);
        }
    }

    // Tandai semua notifikasi sebagai sudah dibaca
    public function markAllRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead();
        unset($this->unreadCount);
        unset($this->recentNotifications);
    }
    #[On('cartUpdated')]
    public function updateCartCount()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            $this->cartCount = $cart ? $cart->items()->sum('quantity') : 0;

            // Me-reset cache computed property agar data modal mini-cart juga ter-update real-time
            unset($this->cartData);
        } else {
            $this->cartCount = 0;
        }
    }

    public function logout()
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return $this->redirect('/auth/login', navigate: true);
    }

    public function render()
    {
        return view('livewire.components.navbar', [
            'unreadCount'         => $this->unreadCount,
            'recentNotifications' => $this->recentNotifications,
        ]);
    }
}
