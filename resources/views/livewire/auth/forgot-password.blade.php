<div class="h-full flex flex-col items-center justify-start py-8 min-h-full">

    <x-ui.general.auth-logo />

    <div
        class="relative overflow-hidden bg-white w-[95%] sm:w-[70%] md:w-[60%] lg:w-[80%] shadow-[0_0_10px_rgba(0,0,0,0.25)] flex flex-col justify-center items-center p-8 rounded-lg flex-shrink-0 mt-4">

        @if ($emailSent)
            <div class="w-full text-center">
                <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h1 class="text-2xl text-primary font-bold mt-4">Email Sent!</h1>
                <p class="text-sm text-gray-600 mt-4">
                    We've sent a password reset link to <strong>{{ $email }}</strong>.
                    Please check your inbox and follow the instructions.
                </p>
                <p class="text-xs text-gray-500 mt-2">
                    The link will expire in 24 hours.
                </p>
                <a href="{{ route('login') }}"
                    class="inline-block mt-6 px-8 py-2 rounded-full font-medium border-2 border-primary text-primary bg-white hover:bg-primary hover:text-white transition-colors duration-200">
                    Back to Login
                </a>
            </div>
        @else
            <h1 class="text-2xl text-primary font-bold w-full text-center border-b-2 border-primary pb-3">
                Forgot Password?
            </h1>

            <p class="text-sm text-gray-600 text-center mt-4">
                Enter your email address and we'll send you a link to reset your password.
            </p>

            <form wire:submit.prevent="submit" class="w-full mt-6">
                <div class="w-full flex flex-col items-stretch">
                    <label for="email" class="mb-1 text-sm text-primary">Email Address</label>
                    <input id="email" type="email" wire:model="email"
                        class="px-3 py-2 text-sm rounded-lg border-2 border-primary focus:ring-1 focus:ring-primary focus:border-primary focus:outline-none" />
                    @error('email')
                        <p
                            class="flex items-center gap-2 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-1 mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full mt-6 px-14 py-2 lg:px-16 lg:py-3 rounded-full font-medium border-2 border-primary text-primary bg-white hover:bg-primary hover:text-white cursor-pointer active:bg-primary active:text-white transition-colors duration-200">
                    Send Reset Link
                </button>
            </form>

            <span class="mt-8 text-sm">
                Remember your password?
                <a class="font-bold text-primary hover:underline" href="{{ route('login') }}">Back to Login</a>
            </span>
        @endif

        <div class="absolute inset-0 bg-black/20" wire:loading wire:target="submit">
            <x-ui.general.spinner />
        </div>
    </div>

    <div class="mt-10 pb-5">
        <x-ui.general.copyright-footer />
    </div>

</div>
