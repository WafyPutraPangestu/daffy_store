<?php

namespace App\Livewire\Kepala\Security;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class SessionAudit extends Component
{
    use WithPagination;

    #[Computed]
    public function sessions()
    {
        // Mengambil data langsung dari tabel bawaan laravel (sessions)
        return DB::table('sessions')
            ->leftJoin('users', 'sessions.user_id', '=', 'users.id')
            ->select('sessions.*', 'users.name', 'users.email', 'users.role')
            ->orderBy('sessions.last_activity', 'desc')
            ->paginate(15);
    }

    public function render()
    {
        return view('livewire.kepala.security.session-audit');
    }
}
