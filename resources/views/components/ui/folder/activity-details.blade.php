@props(['details', 'username', 'created_at'])

<div class="w-full flex items-start justify-start py-3 px-1">
     <div class="rounded-full bg-gray-400 w-6 h-6 flex-shrink-0"></div>
     <div class="ml-2 flex-1 overflow-hidden">
          <p class="text-[13px] block break-words max-w-[90%]">
               <span>
                    {{ $username }}
               </span>
               <span>{{ $details }}</span>
          </p>
          <p class="text-xs text-gray-500">{{ $created_at }}</p>
     </div>
</div>