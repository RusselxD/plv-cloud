@props(['user'])

@php
     $fullName = $user->first_name . ' ' . $user->last_name
@endphp

<div class="z-100 px-4 pt-3 pb-2 rounded-lg bg-white border border-black w-fit flex flex-col items-stretch mb-3">
     <div class="flex items-stretch justify-center">
          <div>
               <div class="w-10 h-10 rounded-full bg-gray-400"></div>
          </div>
          <div class="ml-2 text-gray-900 ">
               <h1 class="text-lg font-bold text-black">&commat;{{ $user->username }}</h1>
               <div class="flex items-center justify-start gap-1 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-id-card-lanyard-icon lucide-id-card-lanyard">
                         <path d="M13.5 8h-3" />
                         <path d="m15 2-1 2h3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h3" />
                         <path d="M16.899 22A5 5 0 0 0 7.1 22" />
                         <path d="m9 2 3 6" />
                         <circle cx="12" cy="15" r="3" />
                    </svg>
                    <p class="text-sm">{{ $user->student_number }}</p>
               </div>
               <div class="flex items-center justify-start gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="#111827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-user-icon lucide-user">
                         <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                         <circle cx="12" cy="7" r="4" />
                    </svg>
                    <p class="whitespace-nowrap">{{ $fullName }}</p>
               </div>               
          </div>
     </div>
     <button class="border border-black mt-3 rounded-sm py-1 cursor-pointer">View Profile</button>
</div>