<?php

namespace App\Livewire\Kepala\Security;

use App\Models\User;
use App\Traits\Notifies;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class AdminManagement extends Component
{
    use WithPagination, Notifies;

    public string $search = '';
    public int $perPage = 10;

    // State Modal Form
    public bool $showModal = false;
    public bool $isEditing = false;
    public ?int $userId = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = 'admin'; // Default role

    // State Modal Konfirmasi Hapus
    public bool $showDeleteModal = false;
    public ?int $deleteId = null;
    public string $deleteName = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal(int $id): void
    {
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = ''; // Kosongkan password saat edit

        $this->isEditing = true;
        $this->showModal = true;
        $this->resetErrorBag();
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'role' => 'required|in:admin,kepala',
        ];

        // Password wajib jika buat baru, opsional jika edit
        $rules['password'] = $this->isEditing ? 'nullable|min:6' : 'required|min:6';

        $validated = $this->validate($rules);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); // Jangan update password jika kosong saat edit
        }

        if ($this->isEditing && $this->userId) {
            User::findOrFail($this->userId)->update($validated);
            $this->notifySuccess('Data admin ' . $this->name . ' berhasil diperbarui.', 'UPDATE BERHASIL');
        } else {
            User::create($validated);
            $this->notifySuccess('Admin baru berhasil ditambahkan.', 'DATA TERSIMPAN');
        }

        $this->closeModal();
    }

    public function confirmDelete(int $id): void
    {
        // Cegah user menghapus dirinya sendiri
        if (Auth::id() === $id) {
            $this->notifyError('Anda tidak bisa menghapus akun Anda sendiri saat sedang login.', 'AKSES DITOLAK');
            return;
        }

        $user = User::findOrFail($id);
        $this->deleteId = $user->id;
        $this->deleteName = $user->name;
        $this->showDeleteModal = true;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->reset(['deleteId', 'deleteName']);
    }

    public function delete(): void
    {
        if ($this->deleteId) {
            User::findOrFail($this->deleteId)->delete();
            $this->notifySuccess('Akun ' . $this->deleteName . ' telah dihapus permanen.', 'AKUN DIHAPUS');
        }
        $this->cancelDelete();
    }

    protected function resetForm(): void
    {
        $this->reset(['userId', 'name', 'email', 'password', 'role']);
        $this->resetErrorBag();
    }

    #[Computed]
    public function admins()
    {
        return User::query()
            ->whereIn('role', ['admin', 'kepala'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.kepala.security.admin-management');
    }
}
