<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @livewireStyles
    <style>[x-cloak] { display: none !important; }</style>
</head>

<body>
    @livewire('components.navbar')
    @livewire('components.notify')
    <main>
        {{ $slot }}
    </main>
    @livewireScripts
    <script>
        // Reinisialisasi Alpine.js setelah setiap navigasi wire:navigate
        // Ini mencegah error "Illegal invocation" pada x-data scope yang hilang
        document.addEventListener('livewire:navigated', () => {
            if (window.Alpine) {
                window.Alpine.initTree(document.body);
            }
        });
    </script>
</body>

</html>
