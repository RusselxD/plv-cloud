<div>
    <form class="flex flex-row" wire:submit.prevent="submit">

        <div>
            <label for="username">Username</label>
            <input id="username" type="text" wire:model="userName"/>
        </div>
        
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" wire:model="password"/>
        </div>

        <button type="submit">Login</button>

        @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
    </form>
    <a href="{{ route('register') }}">Sign Up</a>
</div>  