<div class="h-full flex flex-col items-center justify-start py-8 min-h-full">

    <x-ui.general.auth-logo />

    <form wire:submit.prevent="submit"
        class="relative overflow-hidden bg-white w-[95%] sm:w-[70%] md:w-[60%] lg:w-[80%] shadow-[0_0_10px_rgba(0,0,0,0.25)] flex flex-col justify-center items-center p-8 rounded-lg flex-shrink-0 mt-4">

        <h1 class="text-2xl text-primary font-bold w-full text-center border-b-2 border-primary pb-3">
            Log In
        </h1>

        <div class="w-full flex flex-col items-stretch mt-5">
            <label for="login" class="mb-1 text-sm text-primary">Username or Email</label>
            <input id="login" type="text" wire:model="login"
                class="px-3 py-2 text-sm rounded-lg border-2 border-primary focus:ring-1 focus:ring-primary focus:border-primary focus:outline-none" />
            @error('login')
                <p
                    class="flex items-center gap-2 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-1 mt-2">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="w-full flex flex-col items-stretch mt-5">
            <label for="password" class="mb-1 text-sm text-primary">Password</label>
            <div class="relative" x-data="{ show: false }">
                <input id="password" :type="show ? 'text' : 'password'" wire:model="password"
                    class="px-3 py-2 pr-10 text-sm rounded-lg border-2 border-primary focus:ring-1 focus:ring-primary focus:border-primary focus:outline-none w-full" />
                <div @click="show = !show"
                    class="absolute cursor-pointer inset-y-0 right-0 flex items-center pr-3 text-primary hover:text-primary/70">
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                        </path>
                    </svg>
                </div>
            </div>
            @error('password') <p
                class="flex items-center gap-2 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-1 mt-2">
                {{ $message }}
            </p> @enderror
        </div>

        <div class="flex justify-between items-center w-full my-5">
            <label class="flex items-center text-sm text-primary cursor-pointer">
                <input type="checkbox" wire:model="remember"
                    class="mr-2 rounded border-primary text-primary focus:ring-primary cursor-pointer">
                Remember Me
            </label>
            <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline cursor-pointer">
                Forgot Password?
            </a>
        </div>

        <button type="submit" class="w-full py-2 lg:px-16 lg:py-3 rounded-full font-semibold
           border-2 border-primary text-primary bg-white
           hover:bg-primary hover:text-white cursor-pointer
           active:bg-primary active:text-white
           transition-colors duration-200">
            Login

        </button>

        <p class="relative w-full flex items-center justify-center my-3 text-gray-500">
            <span class="text-center bg-white px-5 z-10">or</span>
            <span class="absolute border-t left-0 right-0 top-1/2 transform -translate-y-1/2 z-5"></span>
        </p>

        <button wire:click.stop="guestLogin" class="w-full border-2 border-gray-300 flex items-center justify-center py-3 rounded-xl hover:bg-gray-100 hover:border-gray-400 cursor-pointer transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-user-icon lucide-user">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                <circle cx="12" cy="7" r="4" />
            </svg>
            <span class="ml-2">Continue as Guest</span>
        </button>

        <span class="mt-10 text-sm">
            Don't have an account?
            <a class="font-bold text-primary" href="{{ route('register') }}">Sign up</a>
        </span>

        <div class="absolute inset-0 z-20 bg-black/20" wire:loading wire:target="submit">
            <x-ui.general.spinner />
        </div>
    </form>

    <div class="mt-10 pb-5">
        <x-ui.general.copyright-footer />
    </div>

</div>