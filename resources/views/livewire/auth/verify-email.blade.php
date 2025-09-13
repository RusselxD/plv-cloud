<div>
    <form wire:submit.prevent="submit">

        <p>Verify your PLV Email</p>

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" wire:model="email" />
        </div>

        <button type="submit">Send Verification Link</button>
    </form>
    @error('email')
        <p class="text-red-500">{{ $message }}</p>
    @enderror
    @if (session()->has('message'))
        <p class="text-green-500">{{ session('message') }}</p>
    @endif
    @if (session()->has('error'))
        <p class="text-red-500">{{ session('error') }}</p>    
    @endif

    <div wire:loading wire:target="submit" class="flex items-center text-blue-600">
        <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        Loading...
    </div>

</div>