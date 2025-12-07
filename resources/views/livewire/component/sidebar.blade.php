<div x-data="{ open: false }" @keydown.escape.window="open = false">
    <!-- Mobile Menu Button -->
    <button @click="open = !open" class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow-lg hover:bg-gray-100 transition-colors" x-show="!open">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" x2="21" y1="6" y2="6"/>
            <line x1="3" x2="21" y1="12" y2="12"/>
            <line x1="3" x2="21" y1="18" y2="18"/>
        </svg>
    </button>

    <!-- Overlay -->
    <div x-show="open" @click="open = false" class="lg:hidden fixed inset-0 bg-black/50 z-40" x-cloak x-transition:enter="transition-opacity ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <!-- Sidebar -->
    <div :class="open ? 'translate-x-0' : '-translate-x-full'" class="fixed top-0 left-0 bottom-0 w-64 py-8 pl-3 pr-8 flex-col bg-white z-40 transition-transform duration-300 ease-in-out lg:translate-x-0 flex">
        <!-- Close Button (Mobile Only, Inside Sidebar) -->
        <button @click="open = false" class="lg:hidden absolute top-4 right-4 p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" x2="6" y1="6" y2="18"/>
                <line x1="6" x2="18" y1="6" y2="18"/>
            </svg>
        </button>

    @auth
        <div class="flex flex-col justify-between flex-1">
            <div>
                <div class="flex items-center justify-start mb-10">
                    <img class="h-10" src="{{ asset('/assets/logo.svg') }}" />
                    <p class="font-semibold text-xl ml-2">PLV Cloud</p>
                </div>

                <p class="text-gray-600 text-sm mb-2">Menu</p>
                <div class="space-y-1">
                    <x-ui.sidebar.link name="Home" route="home" path="home" />
                    <x-ui.sidebar.link name="Courses" route="courses" path="courses" />
                    <x-ui.sidebar.link name="Notifications" route="notifications" path="notifications"
                        :notif_count="$notifs_count" />
                    <x-ui.sidebar.link name="Saved" route="saved" path="saved" />
                </div>

            </div>

            <div wire:click="logout"
                class="flex items-center justify-start cursor-pointer px-3 py-2 rounded-md gap-2 hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-log-out-icon lucide-log-out w-5">
                    <path d="m16 17 5-5-5-5" />
                    <path d="M21 12H9" />
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                </svg>
                <p>Log out</p>
            </div>
        </div>

    @endauth

    @guest
        <div class="flex flex-col flex-1">

            <div class="flex items-center justify-start mb-10">
                <img class="h-10" src="{{ asset('/assets/logo.svg') }}" />
                <p class="font-semibold text-xl ml-2">PLV Cloud</p>
            </div>

            <p class="text-gray-600 text-sm mb-2">Menu</p>
            <div class="space-y-1">
                <x-ui.sidebar.link name="Home" route="home" path="home" />
                <x-ui.sidebar.link name="Courses" route="courses" path="courses" />
            </div>
        </div>
    @endguest
    </div>
</div>