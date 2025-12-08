<div class=" h-full flex flex-col items-center justify-start pb-8 pt-20 sm:pb-8 sm:pt-8 min-h-screen">

    <x-ui.general.auth-logo/>

    <form wire:submit.prevent="submit"
        class="relative overflow-hidden bg-white w-[95%] sm:w-[70%] md:w-[60%] lg:w-[80%] shadow-[0_0_10px_rgba(0,0,0,0.25)] flex flex-col justify-center items-center flex-shrink-0 p-5 sm:p-8  sm:mt-4 rounded-lg">

        <!-- Mail Icon -->
        <div class="p-2 sm:p-3 rounded-full bg-primary mb-2 sm:mb-3">
            <img src="{{ asset('/assets/auth/mail.svg') }}" class="w-6 h-6 sm:w-8 sm:h-8" />
        </div>

        <h1 class="text-xl sm:text-2xl text-primary font-bold border-b-2 border-primary pb-3 w-full text-center">
            Verify your PLV Email
        </h1>

        <div class="w-full my-6 sm:my-10 flex flex-col items-stretch ">
            <label for="email" class="mb-1 text-xs sm:text-sm text-primary">Email</label>
            <input autofocus id="email" type="text" wire:model="email" placeholder="Enter your @plv.edu.ph email"
                class="px-3 py-2 text-xs sm:text-sm rounded-lg border-2 border-primary focus:ring-1 focus:ring-primary focus:border-primary focus:outline-none" />
            @error('email')
                <p
                    class="flex items-center gap-2 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-1 mt-2">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <button type="submit" class="px-6 sm:px-8 py-2 sm:py-3 rounded-full text-sm sm:text-base font-medium 
           border-2 border-primary text-primary bg-white
           hover:bg-primary hover:text-white cursor-pointer
           active:bg-primary active:text-white
           transition-colors duration-200">
            Send Verification Link
        </button>

        <span class="mt-6 sm:mt-10 text-xs sm:text-sm">
            Already have an account?
            <a class="font-bold text-primary" href="{{ route('login') }}">Log in</a>
        </span>

        <div class="absolute inset-0 bg-black/20" wire:loading wire:target="submit">
            <x-ui.general.spinner />
        </div>
    </form>

    <div class="mt-10 pb-5">
        <x-ui.general.copyright-footer />
    </div>

    @if (session()->has('error'))
        <p class="text-red-500">{{ session('error') }}</p>
    @endif

    @if (session()->has('error_flash'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent('error_flash', {
                        detail: {
                            message: @js(session('error_flash'))
                        }
                    }));
                }, 100);
            });
        </script>
    @endif
</div>