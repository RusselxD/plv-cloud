@props(['user'])

<div
     class="cursor-default z-100 px-4 pt-3 pb-2 rounded-lg bg-white border border-gray-300 shadow-lg min-w-44 flex flex-col items-stretch mb-3">
     <div class="flex items-stretch ">
          <div class=" w-10">
               <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('assets/profile_picture/default.jpg') }}"
                    alt="{{ $user->username }}'s profile picture" class="w-10 h-10 object-cover rounded-full flex-shrink-0"/>
          </div>
          <div class="ml-2 text-gray-900 ">
               <h1 class="font-semibold text-black">&commat;{{ $user->username }}</h1>
               <a href="{{ route('user', ['username' => $user->username]) }}"
                    class="cursor-pointer font-medium rounded-sm text-xs py-1 w-fit whitespace-nowrap hover:text-blue-500 transition-colors duration-100 ease-in-out">View
                    Profile &gt;</a>
          </div>
     </div>

</div>