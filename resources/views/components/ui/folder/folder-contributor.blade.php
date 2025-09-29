@props(['role' => 'Contributor', 'username'])

<div class="w-full bg-white rounded-md flex items-center justify-start p-3">
     <div class="rounded-full bg-gray-400 w-8 h-8 flex-shrink-0"></div>
     <div class="ml-2 flex-1 overflow-hidden">
          <p class="text-sm font-medium block truncate max-w-[90%]">{{ $username }}</p>
          <p class="text-xs text-gray-500">{{ $role }}</p>
     </div>
</div>