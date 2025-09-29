<div x-data="{ show: false, message: '' }" x-init="
        @if(session()->has('success'))
            message = @js(session('success'));
            $nextTick(() => {
                show = true;
                setTimeout(() => show = false, 1500);
            });
        @endif
    " x-on:success_flash.window="
        show = true; 
        message = $event.detail.message; 
        setTimeout(() => show = false, 1500)
    " x-show="show" x-transition:enter="transform transition ease-out duration-300"
    x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transform transition ease-in duration-300" x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0"
    class="z-150 max-w-96 text-sm fixed top-5 right-5 px-6 text-white py-3 rounded-xl bg-green-600 border-2 border-green-300 shadow-lg"
    x-text="message"></div>