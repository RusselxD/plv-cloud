<div class="flex items-center gap-3 h-16">

    @auth

    @php
        $user = auth()->user();
    @endphp

        <a href="{{ route('notifications') }}" class="w-10 h-10 p-2 bg-white rounded-full relative">
            <img src="{{ asset('/assets/bell.svg') }}" class="" />
            @if($hasANotif)
                <div class="absolute bg-blue-600 w-3 h-3 rounded-full top-0 right-0">
                </div>
            @endif  
        </a>

        <a href="{{ route('user', ['username' => $user->username]) }}"
            @class([
                ' flex gap-2 p-3 cursor-pointer rounded-lg transition-colors duration-100 ease-in-out',
                'bg-white' => $hasBackground,
                'hover:bg-gray-200' => !$hasBackground
                ])>
            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('assets/profile_picture/default.jpg') }}"
                alt="{{ $user->username }}'s profile picture" class="w-10 h-10 object-cover rounded-full"/>            
            <div>
                <p class="truncate max-w-44">{{ $user->username }}</p>
                <p class="text-xs text-gray-600">{{ $user->first_name }} {{ $user->last_name }}</p>
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