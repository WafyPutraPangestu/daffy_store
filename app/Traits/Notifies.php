<?php

namespace App\Traits;

/**
 * Trait ini didesain untuk dipakai di dalam Livewire Component,
 * yang secara native sudah punya method dispatch().
 *
 * @method void dispatch(string $event, mixed ...$params)
 */
trait Notifies
{
  protected function notifySuccess(string $message, ?string $title = null): void
  {
    $this->dispatch('notify', message: $message, type: 'success', title: $title);
  }

  protected function notifyError(string $message, ?string $title = null): void
  {
    $this->dispatch('notify', message: $message, type: 'error', title: $title);
  }

  protected function notifyWarning(string $message, ?string $title = null): void
  {
    $this->dispatch('notify', message: $message, type: 'warning', title: $title);
  }

  protected function notifyInfo(string $message, ?string $title = null): void
  {
    $this->dispatch('notify', message: $message, type: 'info', title: $title);
  }
}
