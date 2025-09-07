@props(['folder'])

@php
     $totalContents = $folder->files_count + $folder->children_count;
@endphp

<div class="border border-gray-600 w-full rounded-lg cursor-pointer hover:shadow-md overflow-hidden">
     <div class="grid grid-cols-[0.5fr_2fr]">
          <div class="flex items-center justify-center aspect-square h-full border-r border-gray-500">
               <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="gray"
                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-icon lucide-folder">
                    <path
                         d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
               </svg>
          </div>
          <div class="flex flex-col justify-center p-3 overflow-hidden">
               <p class="font-bold truncate w-full overflow-ellipsis">{{ $folder->name }}</p>
               <p class="text-slate-600 text-sm">{{ $totalContents }} contents</p>
          </div>
     </div>
     <div class="flex items-center justify-between pr-2  border-t border-gray-600 text-sm">
          <a href="{{ route('user', ['username' => $folder->user->username]) }}"
               class="flex items-center justify-start gap-2 group py-[0.40rem] px-2 hover:bg-slate-100">
               <div class="w-5 h-5 bg-gray-500 rounded-full">
                    <!-- Profile Picture -->
               </div>
               <p class="max-w-22 truncate group-hover:underline">{{ $folder->user->username }}</p>
          </a>
          <p class="text-slate-600 text-xs">Created {{ $folder->created_at->diffForHumans() }}</p>
     </div>
</div>