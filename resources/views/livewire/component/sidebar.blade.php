<div class="hidden lg:flex fixed bg-blue-500 top-0 left-0 bottom-0 w-72 p-10 flex-col justify-between">
    @auth

        <div class="bg-white w-full h-20" wire:click="goToProfile">
        </div>

        <button wire:click="logout">log out</button>
    @endauth

    @guest

    @endguest
</div>