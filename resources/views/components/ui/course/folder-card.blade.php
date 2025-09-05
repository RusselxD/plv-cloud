@props(['folder'])

@php
     $totalContents = $folder->files_count + $folder->children_count;
@endphp

<a href="{{ route('folder', ['abbrv' => $folder->course->abbreviation, 'folder' => $folder->name]) }}"
     class="border border-gray-600 w-full rounded-lg">
     <div class="grid grid-cols-[0.5fr_2fr]">
          <div class="flex items-center justify-center aspect-square h-full border-r border-gray-500">
               <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 24 24" fill="gray"
                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder-icon lucide-folder">
                    <path
                         d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
               </svg>
          </div>
          <div class="flex flex-col justify-center p-3 overflow-hidden">
               <p class="font-bold truncate w-full overflow-ellipsis">{{ $folder->name }}</p>
               <p>{{ $totalContents }} contents</p>
          </div>
     </div>
     <div class="flex items-center justify-between space-x-2 p-2 border-t border-gray-600">
          <div class="flex items-center justify-start gap-2">
               <div class="w-5 h-5 bg-gray-500 rounded-full">
               </div>
               <p class="w-28 truncate">{{ $folder->user->username }}</p>
          </div>
          <p class="text-sm text-gray-700">Updated {{ $folder->updated_at->diffForHumans() }}</p>
     </div>
</a>