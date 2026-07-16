<div aria-live="polite"
    style="position:fixed;bottom:28px;right:28px;z-index:9999;display:flex;flex-direction:column;gap:10px;pointer-events:none;width:380px;max-width:calc(100vw - 32px)">
    @foreach ($notifications as $n)
        @php
            $styles = match ($n['type']) {
                'success' => ['border' => '#0057ff', 'icon' => 'ti-circle-check', 'color' => '#0057ff'],
                'error' => ['border' => '#e53e3e', 'icon' => 'ti-circle-x', 'color' => '#e53e3e'],
                'warning' => ['border' => '#d97706', 'icon' => 'ti-alert-triangle', 'color' => '#d97706'],
                'info' => ['border' => '#0891b2', 'icon' => 'ti-info-circle', 'color' => '#0891b2'],
                default => ['border' => '#0057ff', 'icon' => 'ti-circle-check', 'color' => '#0057ff'],
            };
        @endphp
        <div wire:key="notify-{{ $n['id'] }}" role="{{ $n['type'] === 'error' ? 'alert' : 'status' }}"
            x-data="{
                show: false,
                timer: null,
                duration: {{ $n['duration'] }},
                start() {
                    this.timer = setTimeout(() => this.close(), this.duration)
                },
                pause() {
                    clearTimeout(this.timer)
                    let bar = this.$refs.bar
                    if (bar) bar.style.animationPlayState = 'paused'
                },
                resume() {
                    this.start()
                    let bar = this.$refs.bar
                    if (bar) bar.style.animationPlayState = 'running'
                },
                close() {
                    this.show = false
                    setTimeout(() => $wire.remove('{{ $n['id'] }}'), 250)
                }
            }" x-init="show = true;
            start()" x-show="show"
            x-transition:enter="transition ease-out duration-250" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-250"
            x-transition:leave-start="opacity-1 translate-x-0" x-transition:leave-end="opacity-0 translate-x-4"
            @mouseenter="pause()" @mouseleave="resume()"
            style="
                pointer-events:all;position:relative;overflow:hidden;
                display:flex;align-items:flex-start;gap:12px;
                padding:14px 16px;background:var(--color-paper);
                border:1px solid var(--color-line);
                border-left:3px solid {{ $styles['border'] }};
                box-shadow:0 8px 20px rgba(0,0,0,.08);
                animation:notify-in .2s ease;
            ">
            <i class="ti {{ $styles['icon'] }}"
                style="font-size:18px;color:{{ $styles['color'] }};flex-shrink:0;margin-top:1px" aria-hidden="true"></i>

            <div style="flex:1;min-width:0">
                <div
                    style="font-size:10px;letter-spacing:3px;text-transform:uppercase;color:{{ $styles['color'] }};font-weight:600;margin-bottom:3px">
                    {{ $n['title'] }}
                </div>
                <div style="font-size:13px;color:var(--color-ink);line-height:1.5;word-break:break-word">
                    {{ $n['message'] }}
                </div>
            </div>

            <button wire:click="remove('{{ $n['id'] }}')"
                style="background:none;border:none;cursor:pointer;color:var(--color-ink-3);padding:2px;font-size:16px;flex-shrink:0;line-height:1"
                aria-label="Tutup notifikasi">
                <i class="ti ti-x" aria-hidden="true"></i>
            </button>

            {{-- Progress bar penanda sisa waktu --}}
            <span x-ref="bar"
                style="
                    position:absolute;bottom:0;left:0;height:2px;
                    background:{{ $styles['color'] }};
                    width:100%;
                    animation:notify-progress {{ $n['duration'] }}ms linear forwards;
                "></span>
        </div>
    @endforeach
</div>

<style>
    @keyframes notify-in {
        from {
            opacity: 0;
            transform: translateX(16px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes notify-progress {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }
</style>
