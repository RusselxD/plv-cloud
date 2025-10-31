<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>402 - Payment Required | {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-[100dvh] bg-white">
    <div class="h-full flex flex-col items-center justify-center p-4">
        <div class="bg-slate-100 rounded-lg p-8 md:p-12 shadow-lg max-w-2xl w-full text-center">
            <!-- 402 Icon -->
            <div class="flex justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    class="text-primary opacity-80">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                </svg>
            </div>

            <!-- Error Code -->
            <h1 class="text-6xl md:text-8xl font-bold text-primary mb-4">402</h1>

            <!-- Error Message -->
            <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-3">Payment Required</h2>
            <p class="text-gray-600 mb-8 text-sm md:text-base">
                This resource requires payment to access.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center items-center">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Back to Home
                </a>

                <button onclick="window.history.back()"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-primary text-primary rounded-lg hover:bg-slate-50 transition-colors font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                    Go Back
                </button>
            </div>
        </div>
    </div>
</body>

</html>