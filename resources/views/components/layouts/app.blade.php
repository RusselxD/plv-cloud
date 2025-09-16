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

        <div class="pt-10 px-10 pb-24 relative min-h-screen">
            {{ $slot }}

            <x-ui.flashes.success-flash/>

        </div>

        

    </main>
</body>

</html>