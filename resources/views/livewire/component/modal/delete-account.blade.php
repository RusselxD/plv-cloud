<div class="fixed inset-0 bg-black/20 flex justify-center items-center z-[150] cursor-auto" x-data="{ show: true }"
    x-show="show" x-transition @keydown.escape.window="show = false; $wire.closeModal()"
    @click.self="show = false; $wire.closeModal()" tabindex="0" x-init="$el.focus()">
    <div class="w-[450px] h-fit bg-white rounded-lg p-6 flex flex-col items-center relative">
        <img src="{{ asset('/assets/x.svg') }}" @click="show = false; $wire.closeModal()"
            class="absolute right-3 top-3 cursor-pointer hover:bg-gray-200 rounded-full p-2 w-9 transition-colors duration-100 ease-in-out" />

        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-alert-triangle w-16 h-16 p-3 rounded-full bg-red-100 mb-3">
            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3" />
            <path d="M12 9v4" />
            <path d="M12 17h.01" />
        </svg>

        <h1 class="font-bold text-xl mb-2">Delete Account</h1>
        <p class="text-sm text-gray-600 text-center mb-4">
            This action cannot be undone. All your data, including folders and files, will be permanently deleted.
        </p>

        <div class="w-full mb-4">
            <label class="text-sm font-medium text-gray-700 mb-2 block">Enter your password to confirm:</label>
            <div class="relative" x-data="{ showPassword: false }">
                <input :type="showPassword ? 'text' : 'password'" wire:model="passwordConfirmation"
                    class="border rounded-lg px-3 pr-10 w-full py-2 @error('passwordConfirmation') border-red-500 @enderror"
                    placeholder="Password" />
                <div @click="showPassword = !showPassword"
                    class="absolute cursor-pointer inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-gray-800">
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21">
                        </path>
                    </svg>
                </div>
            </div>
            @error('passwordConfirmation')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-stretch justify-between w-full gap-3 text-sm font-medium">
            <button @click="show = false; $wire.closeModal()"
                class="transition-colors duration-100 ease-in-out hover:bg-gray-400 hover:text-white cursor-pointer border border-gray-400 w-full rounded-md py-2">Cancel</button>
            <button wire:click="deleteAccount"
                class="transition-colors duration-100 ease-in-out hover:bg-red-700 cursor-pointer border text-white border-red-600 bg-red-600 w-full rounded-md py-2">Delete
                Account</button>
        </div>

        <div class="absolute inset-0 bg-black/20 rounded-lg" wire:loading wire:target="deleteAccount">
            <x-ui.general.spinner />
        </div>
    </div>
</div>