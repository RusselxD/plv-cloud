<div class="flex items-center gap-3 h-full">

    @auth
        <div class="w-10 h-10 p-2 bg-white rounded-full relative">
            <img src="{{ asset('/assets/bell.svg') }}" class="" />
            @if($hasANotif)
                <div class="absolute bg-blue-600 w-3 h-3 rounded-full top-0 right-0">
                </div>
            @endif  
        </div>

        <a href="{{ route('user', ['username' => auth()->user()->username]) }}"
            class="hover:bg-gray-200 flex gap-2 p-3 cursor-pointer rounded-lg transition-colors duration-100 ease-in-out">
            <div class="border border-green-900 bg-green-300 rounded-full w-10 h-10"></div>
            <div>
                <p class="">{{ auth()->user()->username }}</p>
                <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
                </p>
            </div>
        </a>
    @endauth

    @guest
        <a href="{{ route('login') }}"
            class="bg-blue-500 hover:bg-blue-600 cursor-pointer transition-colors duration-100 ease-in-out px-8 py-2 rounded-lg text-white flex items-center justify-center">
            Log in
        </a>
    @endguest

</div>