<div class=" h-full flex flex-col items-center justify-center">

    <img src="{{ asset('/assets/logo.svg') }}" class=" h-32" />

    <form wire:submit.prevent="submit"
        class="relative overflow-hidden bg-white w-[80%] shadow-[0_0_20px_rgba(0,0,0,0.25)] flex flex-col justify-center items-center p-8 rounded-lg">

        <!-- Mail Icon -->
        <div class="p-3 rounded-full bg-primary mb-3">
            <img src="{{ asset('/assets/mail.svg') }}" class="w-8 h-8" />
        </div>

        <h1 class="text-2xl text-primary font-bold border-b-2 border-primary pb-3 w-full text-center">
            Verify your PLV Email
        </h1>

        <div class="w-full my-10 flex flex-col items-stretch ">
            <label for="email" class="mb-1 text-sm text-primary">Email</label>
            <input id="email" type="text" wire:model="email" placeholder="Enter your @plv.edu.ph email"
                class="px-3 py-2 text-sm rounded-lg border-2 border-primary focus:ring-1 focus:ring-primary focus:border-primary focus:outline-none" />
            @error('email')
                <p
                    class="flex items-center gap-2 text-sm text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-2 mt-2">
                    {{ $message }}
                </p>

            @enderror
        </div>

        <button type="submit" class="px-8 py-3 rounded-full font-medium 
           border-2 border-primary text-primary bg-white
           hover:bg-primary hover:text-white cursor-pointer
           transition-colors duration-200">
            Send Verification Link
        </button>

        <span class="mt-10 text-sm">
            Already have an account?
            <a class="font-bold text-primary" href="{{ route('login') }}">Log in</a>
        </span>

        <div class="absolute inset-0 bg-black/20" wire:loading wire:target="submit">
            <x-ui.general.spinner />
        </div>
    </form>

    <div class="mt-10">
        <x-ui.general.copyright-footer />
    </div>


    @if (session()->has('error'))
        <p class="text-red-500">{{ session('error') }}</p>
    @endif
</div>