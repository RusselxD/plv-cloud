<div x-data="{ messages: [] }" x-init="
        @if(session()->has('error'))
            const id = Date.now();
            messages.push({ id, text: @js(session('error')), show: true });
            setTimeout(() => {
                let m = messages.find(m => m.id === id);
                if (m) m.show = false;
                setTimeout(() => { messages = messages.filter(x => x.id !== id) }, 300);
            }, 3000);
        @endif
    " x-on:error_flash.window="
        const id = Date.now();
        messages.push({ id, text: $event.detail.message, show: false });
        $nextTick(() => {
            let m = messages.find(m => m.id === id);
            if (m) m.show = true;
        });
        setTimeout(() => {
            let m = messages.find(m => m.id === id);
            if (m) m.show = false;
            setTimeout(() => { messages = messages.filter(x => x.id !== id) }, 300);
        }, 3000);
    " class="fixed top-5 left-1/2 transform -translate-x-1/2 flex flex-col items-center space-y-2 z-150">
    <template x-for="msg in messages" :key="msg.id">
        <div x-show="msg.show" x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="-translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="-translate-y-full opacity-0"
            class="max-w-96 flex items-center gap-2 text-sm px-4 py-3 rounded-xl bg-white border-2 border-red-500 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-circle-alert-icon lucide-circle-alert text-red-500 w-6 h-6 flex-shrink-0">
                <circle cx="12" cy="12" r="10" />
                <line x1="12" x2="12" y1="8" y2="12" />
                <line x1="12" x2="12.01" y1="16" y2="16" />
            </svg>
            <span x-text="msg.text" class="mx-1"></span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-x-icon lucide-x w-4 h-4 flex-shrink-0 text-gray-500 hover:text-gray-700 cursor-pointer"
                @click="msg.show = false; setTimeout(() => { messages = messages.filter(x => x.id !== msg.id) }, 300);">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
        </div>
    </template>
</div>