<?php

namespace App\Livewire\Components;

use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class Notify extends Component
{
    public array $notifications = [];

    /**
     * Batas notifikasi yang tampil bersamaan.
     * Kalau lebih, notifikasi paling lama otomatis digeser keluar.
     */
    protected int $maxVisible = 4;

    #[On('notify')]
    public function notify(string $message, string $type = 'success', ?string $title = null, int $duration = 4500)
    {
        $this->notifications[] = [
            'id' => (string) Str::uuid(),
            'message' => $message,
            'title' => $title ?? $this->defaultTitle($type),
            'type' => $type,
            'duration' => $duration,
        ];

        if (count($this->notifications) > $this->maxVisible) {
            array_shift($this->notifications);
        }
    }

    public function remove(string $id)
    {
        $this->notifications = array_values(
            array_filter($this->notifications, fn($n) => $n['id'] !== $id)
        );
    }

    protected function defaultTitle(string $type): string
    {
        return match ($type) {
            'success' => 'Berhasil',
            'error' => 'Gagal',
            'warning' => 'Peringatan',
            'info' => 'Informasi',
            default => 'Notifikasi',
        };
    }

    public function render()
    {
        return view('livewire.components.notify');
    }
}
