<div class="flex items-center gap-2 sm:gap-3 h-12 sm:h-16">

    @auth

    @php
        $user = auth()->user();
    @endphp

        <a href="{{ route('notifications') }}" class="w-8 h-8 sm:w-10 sm:h-10 p-1.5 sm:p-2 bg-white rounded-full relative flex-shrink-0">
            <img src="{{ asset('/assets/bell.svg') }}" class="" />
            @if($hasANotif)
                <div class="absolute bg-blue-600 w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full top-0 right-0">
                </div>
            @endif  
        </a>

        <a href="{{ route('user', ['username' => $user->username]) }}"
            @class([
                'flex gap-1.5 sm:gap-2 p-2 sm:p-3 cursor-pointer rounded-lg transition-colors duration-100 ease-in-out',
                'bg-white' => $hasBackground,
                'hover:bg-gray-200' => !$hasBackground
                ])>
            <img src="{{ $user->profile_picture ? $user->profile_picture : asset('assets/profile_picture/default.jpg') }}"
                alt="{{ $user->username }}'s profile picture" class="w-8 h-8 sm:w-10 sm:h-10 object-cover rounded-full flex-shrink-0"/>            
            <div class="hidden sm:block">
                <p class="truncate max-w-32 sm:max-w-44 text-sm sm:text-base">{{ $user->username }}</p>
                <p class="text-xs text-gray-600">{{ $user->first_name }} {{ $user->last_name }}</p>
                </p>
            </div>
        </a>
    @endauth

    @guest
        <a href="{{ route('login') }}"
            class="bg-blue-500 hover:bg-blue-600 cursor-pointer transition-colors duration-100 ease-in-out px-4 sm:px-8 py-1.5 sm:py-2 rounded-lg text-white flex items-center justify-center text-sm sm:text-base">
            Log in
        </a>
    @endguest

</div>