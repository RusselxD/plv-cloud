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
    @livewireStyles

</head>

<body class="lg:grid lg:grid-cols-[1fr_0.7fr] min-h-[100dvh] relative">
    <div class="pl-5 py-5">
        <div class="w-full h-full bg-gray-500 rounded-4xl">

        </div>
    </div>
    <div>
        {{ $slot }}
    </div>

    <!-- Verification Sent Modal -->
    @if (session()->has('verification_sent'))
        <livewire:component.verification-sent-modal :email="session('verification_sent')" />
    @endif

    <!-- For flash messages -->
    <x-ui.general.flash />

    @livewireScripts
</body>

</html>