<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-cloak x-data="{ darkMode: localStorage.getItem('dark') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
    x-bind:class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}
    <link rel="icon" href="{{ asset('storage/images/logo/teresa_falcon_logo.png') }}" />
    <!-- Scripts -->
    @filamentStyles()
    @stack('styles')
    {{ Vite::useBuildDirectory('vendor/xbigdaddyx/falcon')->withEntryPoints(['resources/css/falcon.css', 'resources/js/falcon.js']) }}
    {{-- @vite('resources/css/app.css', '') --}}
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body
    class="font-sans antialiased fi-body fi-panel-falcon min-h-screen bg-gray-50 font-normal text-gray-950 antialiased dark:bg-gray-950 dark:text-white">
    <main class="h-screen flex-1 items-center justify-center p-4">
        {{ $slot }}
    </main>

    @filamentScripts()
</body>

</html>
