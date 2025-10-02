<div class="hidden lg:flex fixed top-0 left-0 bottom-0 w-64 py-8 pl-3 pr-8 flex-col">
    @auth
        <div class="flex flex-col justify-between flex-1">
            <div>
                <div class="flex items-center justify-start mb-10">
                    <img class="h-10" src="{{ asset('/assets/logo.svg') }}" />
                    <p class="font-semibold text-xl ml-2">PLV Cloud</p>
                </div>

                <p class="text-gray-600 text-sm mb-2">Menu</p>
                <div class="space-y-1">
                    <x-ui.sidebar.link name="Home" route="home" path="/" />
                    <x-ui.sidebar.link name="Notifications" route="notifications" path="notifications" />
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
        <div class="flex flex-col">

            <div class="flex items-center justify-start mb-10">
                <img class="h-10" src="{{ asset('/assets/logo.svg') }}" />
                <p class="font-semibold text-xl ml-2">PLV Cloud</p>
            </div>

            <p class="text-gray-600 text-sm mb-2">Menu</p>
            <x-ui.sidebar.link name="Home" route="home" path="/" />
            
        </div>
    @endguest
</div>