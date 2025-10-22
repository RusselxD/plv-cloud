<div class="space-y-3 flex-1 flex flex-col">
    
    <div class="bg-slate-50 w-full rounded-lg flex justify-between items-center py-2 px-4">
        <form wire:submit.prevent="submitSearch"
            class="border border-gray-600 rounded-md flex justify-center items-stretch bg-white overflow-hidden w-96 h-12">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Start typing to search."
                class="px-3 flex-1 focus:outline-none focus:ring-0 border-none text-sm" />
            <button class="p-3 h-full cursor-pointer hover:bg-gray-200" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-search-icon lucide-search">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>
            </button>
        </form>

        <livewire:component.profile-with-notif />
    </div>

    <div class="bg-slate-50/85 rounded-lg py-8 px-10 flex-1">
        <h1 class="text-3xl font-bold">Notifications</h1>
        <p class="text-gray-800 mt-2">Stay updated with your recent activities.</p>

        <div class="flex justify-between items-center my-6 text-sm">
            <div class="flex space-x-2">
                <button @class([
                        'py-2 px-5 rounded-lg border',
                        'bg-blue-600 text-white border-blue-500' => $showAll,
                        'border-gray-400 cursor-pointer' => !$showAll
                    ]) wire:click="toggleShowAll">All ({{ $allNotifsCount }})</button>
                <button @class([
                        'py-2 px-5 rounded-lg border',
                        'bg-blue-600 text-white border-blue-500' => !$showAll,
                        'border-gray-400 cursor-pointer' => $showAll
                    ]) wire:click="showUnread">Unread ({{ $unreadNotifsCount }})</button>
            </div>
            @if ($unreadNotifsCount != 0)
                <div class="flex items-center space-x-2 text-blue-600 cursor-pointer" wire:click="markAllAsRead">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                    <span>Mark all as read</span>
                </div>
            @endif            
        </div>
        
        @if ($notifications->isEmpty())

            <div class="flex items-center justify-center flex-col p-10 border bg-white rounded-md border-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell-icon lucide-bell w-16 h-16 text-gray-400"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/></svg>
                <p class="text-xl font-medium my-2">No Notifications</p>
                <p class="text-sm text-gray-600">You're all caught up!</p>
            </div>       
        
        @else

            @foreach ($notifications as $notification)
                <a href="{{ $notification->url }}" @class([
                    'border rounded-lg p-4 flex items-start justify-start group relative mb-4 shadow-sm hover:shadow-md transition-colors duration-150 ease-in-out',
                    'border-gray-300 bg-white' => $notification->is_read,
                    'border-blue-500 bg-blue-50' => !$notification->is_read
                    ])>
                    <div class="mr-5">
                        <div class="{{ $bgColors[$notification->type] }} w-10 h-10 rounded-md flex items-center justify-center">
                            <img src="{{ $icons[$notification->type] }}"/>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium">{{ $notification->title }}</p>
                        <p class="text-sm text-gray-700 mb-2 mt-1">{{ $notification->message }}</p>
                        <span class="flex items-center justify-start text-sm text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock-icon lucide-clock w-5 h-5 mr-1"><path d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                            <span class="text-xs">{{ $notification->created_at->diffForHumans() }}</span>
                        </span>
                    </div>

                    <div class="absolute top-2 right-4 group-hover:block hidden">
                        @if (!$notification->is_read)
                            <button class="p-2 rounded-md hover:bg-gray-200 cursor-pointer" title="Mark as read" wire:click.prevent.stop="markAsRead({{ $notification->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-icon lucide-check w-5 h-5 text-gray-600"><path d="M20 6 9 17l-5-5"/></svg>
                            </button>
                        @endif                        

                        <button class="p-2 rounded-md hover:bg-gray-200 cursor-pointer" title="Delete" wire:click.prevent.stop="deleteNotification({{ $notification->id }})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash w-5 h-5 text-gray-600"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </button>
                    </div>
                </a>
            @endforeach

        @endif        

    </div>
</div>
