<div class="hidden lg:flex fixed top-0 left-0 bottom-0 w-64 py-8 pl-3 pr-8 flex-col justify-between">
    @auth

        <img class="border border-black w-40" src="{{ asset('/assets/logo.svg') }}"/>

        <button wire:click="logout" class="cursor-pointer w-full flex items-center justify-start gap-3 px-3 py-2 rounded-lg transition-colors duration-100 ease-in-out hover:bg-gray-300">
            <img src="{{ asset('/assets/log-out.svg') }}"/>
            <p>Log out</p>
        </button>
    @endauth

    @guest

    @endguest
</div>