<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-cloak x-data="{ darkMode: localStorage.getItem('dark') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
    x-bind:class="{ 'dark': darkMode }" data-theme="beverly">

<head>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('storage/images/logo/teresa_falcon_logo.png') }}" />
    <!-- Scripts -->


    {{-- @filamentStyles --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- {{ Vite::useBuildDirectory('vendor/xbigdaddyx/falcon')->withEntryPoints(['resources/css/falcon.css', 'resources/js/falcon.js']) }} --}}
    <style>
        html {
            -webkit-print-color-adjust: exact;
        }
    </style>
    {{-- @vite('resources/css/app.css', '') --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body class="font-sans antialiased ">
    {{ $slot }}
</body>

</html>
