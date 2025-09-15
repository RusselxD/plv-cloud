<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="lg:relative min-h-screen">

    <livewire:component.sidebar />
    <main class="lg:ml-72 relative">
        <!-- <nav class="w-full h-28 border bg-red-400 justify-center items-center flex">
            <h1>NAV BAR</h1>
        </nav> -->
        <div class="pt-10 px-10 pb-24 relative">
            {{ $slot }}

            <x-ui.flashes.success-flash/>

        </div>

    </main>
</body>

</html>