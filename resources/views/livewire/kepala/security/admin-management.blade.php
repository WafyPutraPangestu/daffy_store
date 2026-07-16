<div style="padding: 24px;">

    <div class="section-header"
        style="padding: 0 0 16px 0; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 class="rz" style="font-size: 24px; margin: 0; color: var(--color-ink);">MANAJEMEN USER ADMIN</h1>
            <span style="font-size: 11px; color: var(--color-ink-3); letter-spacing: 2px; text-transform: uppercase;">
                >>> SECURITY / ACCESS CONTROL
            </span>
        </div>

        <button wire:click="openCreateModal" class="btn-primary" style="display: flex; align-items: center; gap: 8px;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <line x1="19" y1="8" x2="19" y2="14" />
                <line x1="22" y1="11" x2="16" y2="11" />
            </svg>
            TAMBAH ADMIN
        </button>
    </div>

    <div style="margin-bottom: 24px;">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="CARI NAMA ATAU EMAIL..."
            style="background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px 16px; width: 320px; font-size: 11px; letter-spacing: 2px; outline: none;">
    </div>

    <div style="border: 1px solid var(--color-line);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--color-line); background: var(--color-line-2);">
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        NAMA PENGGUNA</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        KONTAK EMAIL</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600;">
                        TINGKAT AKSES (ROLE)</th>
                    <th
                        style="padding: 16px; font-size: 11px; letter-spacing: 2px; color: var(--color-ink-3); font-weight: 600; text-align: right;">
                        AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->admins as $user)
                    <tr style="border-bottom: 1px solid var(--color-line-2); transition: background 0.15s;"
                        onmouseover="this.style.background='var(--color-line-2)'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 16px;">
                            <strong
                                style="display: block; font-size: 14px; font-weight: 600; color: var(--color-ink);">{{ $user->name }}</strong>
                        </td>
                        <td style="padding: 16px; font-size: 13px; color: var(--color-ink-2);">{{ $user->email }}</td>
                        <td style="padding: 16px;">
                            @if ($user->role === 'kepala')
                                <span class="nav-badge-outline" style="border-color: #3a8fff; color: #3a8fff;">KEPALA
                                    (OWNER)</span>
                            @else
                                <span class="nav-badge-outline" style="border-color: #30a46c; color: #30a46c;">ADMIN
                                    OPERASIONAL</span>
                            @endif
                        </td>
                        <td
                            style="padding: 16px; text-align: right; display: flex; justify-content: flex-end; gap: 8px;">
                            <button wire:click="openEditModal({{ $user->id }})" class="btn-outline"
                                style="padding: 6px 12px; font-size: 10px;">EDIT</button>
                            <button wire:click="confirmDelete({{ $user->id }})" class="btn-outline"
                                style="padding: 6px 12px; font-size: 10px; border-color: #e5484d; color: #e5484d;">HAPUS</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <h2 class="empty-state-title">DATA TIDAK DITEMUKAN</h2>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 24px;">{{ $this->admins->links() }}</div>

    <div x-data="{ show: @entangle('showModal') }" x-show="show"
        style="display: none; position: fixed; inset: 0; z-index: 999; align-items: center; justify-content: center;">
        <div x-show="show" @click="$wire.closeModal()"
            style="position: absolute; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);"></div>
        <div
            style="position: relative; background: var(--color-paper); border: 1px solid var(--color-line); width: 100%; max-width: 500px; padding: 32px; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">

            <h2 class="rz"
                style="font-size: 20px; color: var(--color-ink); margin-top: 0; margin-bottom: 24px; border-bottom: 1px solid var(--color-line); padding-bottom: 12px;">
                {{ $isEditing ? 'EDIT DATA ADMIN' : 'TAMBAH ADMIN BARU' }}
            </h2>

            <form wire:submit="save">
                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 10px; letter-spacing: 2px; color: var(--color-ink-3); margin-bottom: 8px; text-transform: uppercase;">NAMA
                        LENGKAP</label>
                    <input type="text" wire:model="name"
                        style="width: 100%; background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-size: 13px; box-sizing: border-box; outline: none;">
                    @error('name')
                        <span
                            style="color: #e5484d; font-size: 11px; display: block; margin-top: 6px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 10px; letter-spacing: 2px; color: var(--color-ink-3); margin-bottom: 8px; text-transform: uppercase;">EMAIL
                        (UNTUK LOGIN)</label>
                    <input type="email" wire:model="email"
                        style="width: 100%; background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-size: 13px; box-sizing: border-box; outline: none;">
                    @error('email')
                        <span
                            style="color: #e5484d; font-size: 11px; display: block; margin-top: 6px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label
                        style="display: block; font-size: 10px; letter-spacing: 2px; color: var(--color-ink-3); margin-bottom: 8px; text-transform: uppercase;">PASSWORD
                        {{ $isEditing ? '(KOSONGKAN JIKA TIDAK DIUBAH)' : '' }}</label>
                    <input type="password" wire:model="password"
                        style="width: 100%; background: transparent; border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-size: 13px; box-sizing: border-box; outline: none;">
                    @error('password')
                        <span
                            style="color: #e5484d; font-size: 11px; display: block; margin-top: 6px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 32px;">
                    <label
                        style="display: block; font-size: 10px; letter-spacing: 2px; color: var(--color-ink-3); margin-bottom: 8px; text-transform: uppercase;">HAK
                        AKSES (ROLE)</label>
                    <select wire:model="role"
                        style="width: 100%; background: var(--color-paper); border: 1px solid var(--color-line); color: var(--color-ink); padding: 12px; font-size: 13px; outline: none;">
                        <option value="admin">Admin Operasional</option>
                        <option value="kepala">Kepala (Owner)</option>
                    </select>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="button" wire:click="closeModal" class="btn-outline">BATAL</button>
                    <button type="submit" class="btn-primary">SIMPAN DATA</button>
                </div>
            </form>
        </div>
    </div>

    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show"
        style="display: none; position: fixed; inset: 0; z-index: 999; align-items: center; justify-content: center;">
        <div x-show="show" @click="$wire.cancelDelete()"
            style="position: absolute; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);"></div>
        <div
            style="position: relative; background: var(--color-paper); border: 1px solid #e5484d; border-top: 4px solid #e5484d; width: 100%; max-width: 400px; padding: 32px; text-align: center; box-shadow: 0 10px 40px rgba(229, 72, 77, 0.2);">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#e5484d"
                stroke-width="2" style="margin: 0 auto 16px auto;">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                <line x1="12" y1="9" x2="12" y2="13" />
                <line x1="12" y1="17" x2="12.01" y2="17" />
            </svg>
            <h3 class="rz" style="font-size: 20px; color: var(--color-ink); margin: 0 0 8px 0;">CABUT HAK AKSES?
            </h3>
            <p style="color: var(--color-ink-2); font-size: 13px; margin-bottom: 24px;">Akun admin <strong
                    style="color: var(--color-ink);">{{ $deleteName }}</strong> akan dihapus permanen dari sistem.
            </p>

            <div style="display: flex; justify-content: center; gap: 12px;">
                <button wire:click="cancelDelete" class="btn-outline">BATAL</button>
                <button wire:click="delete" class="btn-primary" style="background: #e5484d; color: white;">YA,
                    HAPUS</button>
            </div>
        </div>
    </div>
</div>
