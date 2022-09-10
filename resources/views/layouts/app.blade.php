<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gacha</title>
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://use.fontawesome.com/b42362407e.js"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
        {{-- @vite(['resources/css/app.css']) --}}
        <livewire:styles />
    </head>
    <body class="bg-slate-100">
        {{ $slot }}
        <livewire:scripts />
        {{-- @vite(['resources/js/app.js']) --}}
    </body>
</html>
