<div style="padding:32px;max-width:1100px;margin:0 auto">

    {{-- Header --}}
    <div
        style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:24px;gap:16px;flex-wrap:wrap">
        <div>
            <div
                style="font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--color-ink-3);margin-bottom:4px">
                Manajemen Katalog
            </div>
            <h1 style="font-size:24px;font-weight:700;color:var(--color-ink);margin:0">Kategori Produk</h1>
        </div>
        <button wire:click="openCreateModal"
            style="display:inline-flex;align-items:center;gap:6px;padding:10px 16px;border:none;background:#0057ff;color:#fff;font-size:13px;font-weight:600;cursor:pointer">
            <i class="ti ti-plus"></i> Tambah Kategori
        </button>
    </div>

    {{-- Search --}}
    <div style="margin-bottom:20px">
        <div style="position:relative;max-width:340px">
            <i class="ti ti-search"
                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--color-ink-3);font-size:16px"></i>
            <input type="text" wire:model.live.debounce.400ms="search" placeholder="Cari nama atau slug kategori..."
                style="width:100%;padding:10px 12px 10px 36px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
        </div>
    </div>

    {{-- Table --}}
    <div style="border:1px solid var(--color-line);background:var(--color-paper);overflow-x:auto">
        <table style="width:100%;border-collapse:collapse;font-size:13px">
            <thead>
                <tr style="border-bottom:1px solid var(--color-line)">
                    <th
                        style="text-align:left;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Nama</th>
                    <th
                        style="text-align:left;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Slug</th>
                    <th
                        style="text-align:left;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Deskripsi</th>
                    <th
                        style="text-align:center;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Jumlah Produk</th>
                    <th
                        style="text-align:right;padding:12px 16px;color:var(--color-ink-3);font-size:11px;letter-spacing:1px;text-transform:uppercase">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($this->categories as $category)
                    <tr wire:key="category-{{ $category->id }}" style="border-bottom:1px solid var(--color-line)">
                        <td style="padding:12px 16px;color:var(--color-ink);font-weight:600">{{ $category->name }}</td>
                        <td style="padding:12px 16px;color:var(--color-ink-3);font-family:monospace">
                            {{ $category->slug }}</td>
                        <td
                            style="padding:12px 16px;color:var(--color-ink-3);max-width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ $category->description ?: '—' }}
                        </td>
                        <td style="padding:12px 16px;text-align:center">
                            <span
                                style="padding:3px 10px;font-size:11px;font-weight:700;background:rgba(0,87,255,.1);color:#0057ff">
                                {{ $category->products_count }}
                            </span>
                        </td>
                        <td style="padding:12px 16px;text-align:right">
                            <div style="display:flex;gap:8px;justify-content:flex-end">
                                <button wire:click="openEditModal({{ $category->id }})"
                                    style="background:none;border:none;cursor:pointer;color:var(--color-ink-3);padding:0"
                                    title="Edit">
                                    <i class="ti ti-edit" style="font-size:17px"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $category->id }})"
                                    style="background:none;border:none;cursor:pointer;color:#e53e3e;padding:0"
                                    title="Hapus">
                                    <i class="ti ti-trash" style="font-size:17px"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:40px;text-align:center;color:var(--color-ink-3)">
                            @if ($search)
                                Tidak ada kategori yang cocok dengan pencarian "{{ $search }}".
                            @else
                                Belum ada kategori. Klik "Tambah Kategori" untuk membuat yang pertama.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px">
        {{ $this->categories->links() }}
    </div>

    {{-- Modal: Tambah / Edit Kategori --}}
    @if ($showModal)
        <div x-data x-init="$el.focus()" tabindex="-1" @keydown.escape.window="$wire.closeModal()"
            style="position:fixed;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:9998;padding:16px">
            <div wire:click.outside="closeModal"
                style="background:var(--color-paper);border:1px solid var(--color-line);width:100%;max-width:460px;padding:24px">

                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
                    <h3 style="margin:0;font-size:16px;font-weight:700;color:var(--color-ink)">
                        {{ $isEditing ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
                    </h3>
                    <button wire:click="closeModal"
                        style="background:none;border:none;cursor:pointer;color:var(--color-ink-3);font-size:18px;padding:0">
                        <i class="ti ti-x"></i>
                    </button>
                </div>

                <form wire:submit="save">
                    <div style="margin-bottom:14px">
                        <label
                            style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:6px">Nama
                            Kategori</label>
                        <input type="text" wire:model.live="name" placeholder="Contoh: Jaring Pancing" autofocus
                            style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px">
                        @error('name')
                            <div style="font-size:12px;color:#e53e3e;margin-top:4px">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom:14px">
                        <label
                            style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:6px">Slug</label>
                        <input type="text" wire:model="slug" placeholder="Jaring-Pancing"
                            style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px;font-family:monospace">
                        @error('slug')
                            <div style="font-size:12px;color:#e53e3e;margin-top:4px">{{ $message }}</div>
                        @enderror
                        <div style="font-size:11px;color:var(--color-ink-3);margin-top:4px">Terisi otomatis dari nama,
                            bisa diubah manual.</div>
                    </div>

                    <div style="margin-bottom:20px">
                        <label
                            style="display:block;font-size:12px;font-weight:600;color:var(--color-ink);margin-bottom:6px">Deskripsi
                            (Opsional)</label>
                        <textarea wire:model="description" rows="3" placeholder="Deskripsi singkat kategori..."
                            style="width:100%;padding:10px 12px;border:1px solid var(--color-line);background:var(--color-paper);color:var(--color-ink);font-size:13px;resize:vertical"></textarea>
                        @error('description')
                            <div style="font-size:12px;color:#e53e3e;margin-top:4px">{{ $message }}</div>
                        @enderror
                    </div>

                    <div
                        style="display:flex;gap:10px;justify-content:flex-end;border-top:1px solid var(--color-line);padding-top:16px">
                        <button type="button" wire:click="closeModal"
                            style="padding:9px 16px;border:1px solid var(--color-line);background:none;color:var(--color-ink);font-size:13px;font-weight:600;cursor:pointer">
                            Batal
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="save"
                            style="padding:9px 16px;border:none;background:#0057ff;color:#fff;font-size:13px;font-weight:600;cursor:pointer">
                            <span wire:loading.remove
                                wire:target="save">{{ $isEditing ? 'Simpan Perubahan' : 'Simpan Kategori' }}</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal: Konfirmasi Hapus --}}
    @if ($showDeleteModal)
        <div x-data x-init="$el.focus()" tabindex="-1" @keydown.escape.window="$wire.cancelDelete()"
            style="position:fixed;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;z-index:9999;padding:16px">
            <div wire:click.outside="cancelDelete"
                style="background:var(--color-paper);border:1px solid var(--color-line);width:100%;max-width:400px;padding:24px">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                    <i class="ti ti-alert-triangle" style="font-size:22px;color:#e53e3e"></i>
                    <h3 style="margin:0;font-size:16px;font-weight:700;color:var(--color-ink)">Hapus Kategori?</h3>
                </div>
                <p style="font-size:13px;color:var(--color-ink-3);line-height:1.6;margin-bottom:20px">
                    Kategori <strong style="color:var(--color-ink)">{{ $deleteName }}</strong> akan dihapus
                    permanen. Tindakan ini tidak bisa dibatalkan.
                </p>
                <div style="display:flex;gap:10px;justify-content:flex-end">
                    <button wire:click="cancelDelete"
                        style="padding:9px 16px;border:1px solid var(--color-line);background:none;color:var(--color-ink);font-size:13px;font-weight:600;cursor:pointer">
                        Batal
                    </button>
                    <button wire:click="delete"
                        style="padding:9px 16px;border:none;background:#e53e3e;color:#fff;font-size:13px;font-weight:600;cursor:pointer">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
