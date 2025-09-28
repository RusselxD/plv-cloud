@props(['role' => 'Contributor', 'username'])

<div class="w-full bg-white rounded-md flex items-center justify-start p-3">
     <div class="rounded-full bg-gray-400 w-8 h-8"></div>
     <div class="ml-2">
          <p class="text-sm font-medium">{{ $username }}</p>
          <p class="text-xs text-gray-500">{{ $role }}</p>
     </div>
</div>