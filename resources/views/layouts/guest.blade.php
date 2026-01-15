<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Lands And People Coffee Catering') }}</title>

        <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/png" >

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    
        <body class="font-sans antialiased">
            <div class="min-h-screen flex items-center justify-center bg-cover bg-center"
            style="background-image: url('{{ asset('assets/img/bg/bg.avif') }}');">

            <div class="bg-white/90 p-8 rounded-xl shadow-lg w-full max-w-md">
                {{ $slot }}
            </div>

            </div>


        @livewireScripts
    </body>
</html>
