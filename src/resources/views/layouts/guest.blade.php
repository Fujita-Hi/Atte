<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ asset('css/header.css') }}" />
        <title>Atte</title>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <header>
            <h1 class="header-title">Atte</h1>
        </header>
        <main class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">ログイン</a>
            </div>
            <div class="mt-6">
                {{ $slot }}
            </div>
        </main>
        <footer>
            <small class="footer__copyright">Atte,inc.</small>
        </footer>
    </body>
</html>
