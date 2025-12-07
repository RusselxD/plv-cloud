<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/logo.svg') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

</head>

<body class="h-[100dvh] relative">

    <div class="lg:grid lg:grid-cols-[1fr_0.7fr] h-full">
        <div class="hidden lg:block rounded-[2rem] h-full max-h-screen relative">
            <div class="banner absolute inset-5 rounded-[2rem]">
            </div>
        </div>
        <div class="overflow-y-auto scrollbar-hide">
            {{ $slot }}

            <!-- For flash messages -->
            <x-ui.flashes.success-flash />
            <x-ui.flashes.error-flash />
        </div>
    </div>

    <!-- Verification Sent Modal -->
    @if (session()->has('verification_sent'))
        <livewire:component.modal.verification-sent-modal :email="session('verification_sent')" />
    @endif

    @livewireScripts
</body>

</html>