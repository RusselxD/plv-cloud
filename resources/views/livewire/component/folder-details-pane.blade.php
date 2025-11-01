<div class="scrollbar-hide" x-data="{ activeTab: 'contributors', reportedContentsOpen: false }">

    <div class="p-3 relative">

        <div class="absolute inset-0 z-120 bg-black/20" wire:loading wire:target="toggleFolderPublicity">
            <x-ui.general.spinner />
        </div>

        <img src="{{ asset('assets/x.svg') }}" @click="$dispatch('close-details-pane')"
            class="absolute top-3 right-3 hover:bg-gray-200 rounded-full p-1 w-7 cursor-pointer" />
        <h1 class="font-semibold text-lg max-w-[85%] break-words">{{ $folder->name }}</h1>
        <p class="text-xs flex justify-between items-center mt-1 border-b border-gray-400 pb-3">
            <span class=" text-slate-700 font-light">Created {{ $folder->created_at->format('M d, Y') }}</span>
        </p>

        @if ($userIsTheOwner)

            <!-- Owner Interface to modify folder publicity -->
            <div class="flex items-center justify-between mt-3 border-b border-gray-400 pb-3">
                <div class="flex items-center justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" @class([
                            'lucide lucide-users-icon lucide-users w-5',
                            'text-blue-600' => $folder->is_public,
                            'text-gray-400' => !$folder->is_public,
                        ])>
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <circle cx="9" cy="7" r="4" />
                    </svg>
                    <div class="ml-2">
                        <p class="text-sm font-medium">Make Folder Public</p>
                        <p class="text-xs text-slate-700">
                            @if ($folder->is_public)
                                <span>Anyone can upload</span>
                            @else
                                <span>Only contributors can upload</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Toggle Button -->
                <div @class([
                    'relative w-10 h-6 cursor-pointer rounded-full transition-colors duration-150 ease-in-out',
                    'bg-blue-600' => $folder->is_public,
                    'bg-gray-300' => !$folder->is_public,
                ]) wire:click="toggleFolderPublicity">
                    <span @class([
                        'top-1 bottom-1 w-4 bg-white rounded-full absolute transition-transform duration-150 ease-in-out',
                        'translate-x-5' => $folder->is_public,
                        'translate-x-1' => !$folder->is_public,
                    ])></span>
                </div>
            </div>

            @if ($this->reports->isNotEmpty())
                <!-- Reported Contents Section -->
                <div class="rounded-md overflow-hidden mt-3 border border-gray-200 -mx-[0.6rem]">
                    <div class=" flex items-center justify-between p-2 bg-white hover:bg-gray-100 cursor-pointer"
                        @click="reportedContentsOpen = !reportedContentsOpen">
                        <div class="flex items-center justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-triangle-alert-icon lucide-triangle-alert w-5 text-amber-500">
                                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3" />
                                <path d="M12 9v4" />
                                <path d="M12 17h.01" />
                            </svg>
                            <p class="text-sm ml-2">Reported Contents</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chevron-down-icon lucide-chevron-down w-5">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </div>

                    <!-- Reported Contents List -->
                    <div x-show="reportedContentsOpen" x-collapse>
                        @foreach ($this->reports as $report)
                            <div @class([
                                'px-2 py-3 text-xs border-b border-gray-200',
                                'bg-green-50' => $report['is_acknowledged'],
                                'bg-gray-50' => !$report['is_acknowledged'],

                            ])>
                                <div class="flex items-start justify-between">
                                    <p class="text-sm font-medium break-all">
                                        {{ $report['reported_item_name'] }}
                                    </p>
                                    <p class=" text-gray-500 flex-shrink-0 ml-1">{{ $report['reported_date'] }}</p>
                                </div>
                                <p class="text-gray-500 my-1">Reported by {{ $report['username'] }}</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-red-500 break-all">{{ $report['reason'] }}</p>
                                    <button @class([
                                        'px-3 py-1 ml-1 font-medium rounded-md',
                                        'bg-green-100 text-green-600' => $report['is_acknowledged'],
                                        'bg-blue-100 text-blue-600 cursor-pointer' => !$report['is_acknowledged'],
                                    ]) wire:click="acknowledgeReport({{ $report['id'] }})">{{ $report['is_acknowledged'] ? 'Acknowledged' : 'Acknowledge' }}</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            @endif

        @else
            <!-- Non-owner Interface to view folder publicity -->
            <div class="flex items-center justify-between mt-3 border-b border-gray-400 pb-3">
                <div class="flex items-center justify-start">
                    @if ($folder->is_public)
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-folder-open-icon lucide-folder-open w-5 text-green-500">
                            <path
                                d="m6 14 1.5-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.54 6a2 2 0 0 1-1.95 1.5H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H18a2 2 0 0 1 2 2v2" />
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-folder-lock-icon lucide-folder-lock w-5 text-red-500">
                            <rect width="8" height="5" x="14" y="17" rx="1" />
                            <path
                                d="M10 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v2.5" />
                            <path d="M20 17v-2a2 2 0 1 0-4 0v2" />
                        </svg>
                    @endif
                    <div class="ml-2">
                        <p class="text-sm font-medium">{{ $folder->is_public ? 'Public' : 'Private' }} Folder</p>
                        <p class="text-xs text-slate-700">
                            @if ($folder->is_public)
                                <span>Anyone can upload</span>
                            @else
                                <span>Only contributors can upload</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div @class([
                    'px-3 py-1 rounded-full text-sm',
                    'bg-green-200 text-green-800' => $folder->is_public,
                    'bg-red-200 text-red-800' => !$folder->is_public,
                ])>
                    {{ $folder->is_public ? 'Public' : 'Private' }}
                </div>
            </div>

        @endif

        <p class="mt-3 text-sm">Contents</p>
        <div class="grid grid-cols-2 gap-2 mt-1">
            <div class="text-center bg-white rounded-md py-2">
                <p class="font-bold text-lg">{{ $childrenFolderCount }}</p>
                <p class="text-sm text-gray-700">Folders</p>
            </div>
            <div class="text-center bg-white rounded-md py-2">
                <p class="font-bold text-lg">{{ $filesCount }}</p>
                <p class="text-sm text-gray-700">Files</p>
            </div>
        </div>

        @if (!$this->userIsAContributor)
        <!-- Contributor's Tab (not authenticated as contributor) -->
            <p class="mt-3 mb-2 text-sm">Contributors</p>
            <div class="space-y-2">
                <div class="w-full bg-white rounded-md flex items-center justify-start p-3">
                    <img src="{{ $folder->user->profile_picture ? asset('storage/' . $folder->user->profile_picture) : asset('assets/profile_picture/default.jpg') }}"
                        alt="{{ $folder->user->username }}'s profile picture" class="w-8 h-8 object-cover rounded-full flex-shrink-0"/>                    
                    <div class="ml-2 flex-1 overflow-hidden">
                        <p class="text-sm font-medium block truncate max-w-[90%]">{{ $folder->user->username }}</p>
                        <p class="text-xs text-gray-500">Owner</p>
                    </div>
                </div>
                @foreach ($contributors as $contributor)
                    <div class="w-full bg-white rounded-md flex items-center justify-start p-3">
                        <img src="{{ $contributor['profile_picture'] ? asset('storage/' . $contributor['profile_picture']) : asset('assets/profile_picture/default.jpg') }}"    
                            alt="{{ $contributor['username'] }}'s profile picture" class="w-8 h-8 object-cover rounded-full flex-shrink-0"/>
                        <div class="ml-2 flex-1 overflow-hidden">
                            <p class="text-sm font-medium block truncate max-w-[90%]">{{ $contributor['username'] }}</p>
                            <p class="text-xs text-gray-500">Contributor</p>
                        </div>
                    </div>
                @endforeach
            </div>

            @auth
                <!-- Become a Contributor Section -->
                @php
                    // Check if the user has already sent a request
                    $hasRequested = $folder->folderRequests->contains('user_id', auth()->id());
                @endphp

                <div @class([
                    'relative mt-3 border-2 border-dashed py-4 rounded-lg flex flex-col items-center justify-center ',
                    'border-amber-400 bg-amber-100' => $hasRequested,
                    'border-gray-400 bg-gray-50' => !$hasRequested,
                ])>

                    @if ($hasRequested)
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-clock-icon lucide-clock text-amber-400">
                            <path d="M12 6v6l4 2" />
                            <circle cx="12" cy="12" r="10" />
                        </svg>
                        <p class="text-sm mt-1 text-amber-900">Request pending approval</p>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-user-plus-icon lucide-user-plus w-7 text-blue-600">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <line x1="19" x2="19" y1="8" y2="14" />
                            <line x1="22" x2="16" y1="11" y2="11" />
                        </svg>
                        <p class="text-sm font-medium mt-1">Become a Contributor</p>
                        <p class="text-xs text-slate-400">Request access to upload files</p>
                        <button wire:click="sendRequest"
                            class="text-sm mt-3 w-[70%] py-2 bg-blue-500 text-white rounded-md cursor-pointer hover:bg-blue-600">Send
                            Request</button>

                        <div class="absolute inset-0 z-120 bg-black/20" wire:loading wire:target="sendRequest">
                            <x-ui.general.spinner />
                        </div>

                    @endif
                </div>

            @endauth

        @endif
    </div>
    @if ($this->userIsAContributor)
        <!-- Tabs Section (Contributors / Activity) -->
        <div class="grid grid-cols-2 relative ">
            <p @click="activeTab = 'contributors'" @class([
                'text-center py-3 text-sm font-medium transition-all duration-150 ease-in-out cursor-pointer',
            ]) :class="activeTab === 'contributors' ? 'text-blue-600' : 'hover:bg-white/85 border-b border-gray-300'">
                Contributors
            </p>
            <p @click="activeTab = 'activity'" @class([
                'text-center py-3 text-sm font-medium transition-all duration-150 ease-in-out cursor-pointer',
            ]) :class="activeTab === 'activity' ? 'text-blue-600' : 'hover:bg-white/85 border-b border-gray-300'">
                Activity
            </p>
            <span
                class="absolute bottom-0 left-0 w-1/2 border-b-2 border-blue-600 transition-transform duration-150 ease-in-out"
                :class="activeTab === 'contributors' ? 'translate-x-0' : 'translate-x-full'"></span>
        </div>

        <div class="flex-1 px-3 py-2">
            <!-- Contributors Tab -->
            <div class="space-y-2" x-show="activeTab === 'contributors'"
                x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100">
                <div class="w-full bg-white rounded-md flex items-center justify-start p-3">
                    <img src="{{ $folder->user->profile_picture ? asset('storage/' . $folder->user->profile_picture) : asset('assets/profile_picture/default.jpg') }}"
                    alt="{{ $folder->user->username }}'s profile picture" class="w-8 h-8 object-cover rounded-full flex-shrink-0"/>                    
                    <div class="ml-2 flex-1 overflow-hidden">
                        <p class="text-sm font-medium block truncate max-w-[90%]">{{ $folder->user->username }}</p>
                        <p class="text-xs text-gray-500">Owner</p>
                    </div>
                </div>
                @foreach ($contributors as $contributor)
                    <div class="w-full bg-white rounded-md p-3 flex justify-between items-center group">
                        <div class="flex items-center justify-start flex-1">
                            <img src="{{ $contributor['profile_picture'] ? asset('storage/' . $contributor['profile_picture']) : asset('assets/profile_picture/default.jpg') }}"
                    alt="{{ $contributor['username'] }}'s profile picture" class="w-8 h-8 object-cover rounded-full"/>                            
                            <div class="ml-2 flex-1 overflow-hidden">
                                <p class="text-sm font-medium block truncate max-w-[90%]">{{ $contributor['username'] }}</p>
                                <p class="text-xs text-gray-500">Contributor</p>
                            </div>
                        </div>

                        @if ($userIsTheOwner)
                            <button class="hidden group-hover:block text-black cursor-pointer" wire:click="removeAContributor({{ $contributor['id'] }}, '{{ $contributor['username'] }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-circle-x-icon lucide-circle-x w-5 h-5">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="m15 9-6 6" />
                                    <path d="m9 9 6 6" />
                                </svg> 
                            </button>
                        @endif

                    </div>
                @endforeach

                <!-- Pending Requests -->
                @if ($userIsTheOwner)
                    @if ($folder->folderRequests->isEmpty())
                        <div class="mt-2 flex flex-col items-center justify-center py-5 bg-gray-200 rounded-md text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-users-icon lucide-users w-10">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <circle cx="9" cy="7" r="4" />
                            </svg>
                            <p class="mt-3 text-sm">No pending requests</p>
                        </div>
                    @else
                        <div class="mt-2 -mx-2 border-2 border-blue-600 rounded-md overflow-hidden relative">
                            <div class="absolute inset-0 z-120 bg-black/20" wire:loading wire:target="approveOrDeclineRequest">
                                <x-ui.general.spinner />
                            </div>

                            <div class="flex items-center justify-between bg-blue-100 p-2">
                                <p class="text-blue-900 text-sm">Pending Requests</p>
                                <span class="text-xs flex items-center justify-center w-6 h-6 text-white bg-blue-500 rounded-full">
                                    {{ $folder->folderRequests->count() }}
                                </span>
                            </div>
                            @foreach ($folder->folderRequests as $request)
                                <div @class([
                                    'flex items-center justify-between p-2 bg-white',
                                    'border-b border-gray-200' => !$loop->last,
                                ])>
                                    <div class="flex items-center space-x-2">
                                        <img src="{{ $request->user->profile_picture ? asset('storage/' . $request->user->profile_picture) : asset('assets/profile_picture/default.jpg') }}"
                                            alt="{{ $request->user->username }}'s profile picture" class="w-8 h-8 object-cover rounded-full flex-shrink-0"/>                                        
                                        <div>
                                            <p class="text-sm font-medium break-all">{{ $request->user->username }}</p>
                                            <p class="text-xs text-gray-500">Requested {{ $request->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2 ml-1">
                                        <button
                                            class="flex items-center justify-center w-7 h-7 rounded-sm bg-green-300 hover:bg-green-400 cursor-pointer"
                                            wire:click="approveOrDeclineRequest(true, {{ $request->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                class="w-4 text-green-700" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12" />
                                            </svg>
                                        </button>
                                        <button
                                            class="flex items-center justify-center w-7 h-7 rounded-sm bg-red-300 hover:bg-red-400 cursor-pointer"
                                            wire:click="approveOrDeclineRequest(false, {{ $request->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                class="w-4 text-red-700" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M18 6 6 18" />
                                                <path d="m6 6 12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif

            </div>

            <!-- Activity Tab -->
            <div x-show="activeTab === 'activity'" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                @foreach ($logs as $log)
                    <div @class([
                        'border-b border-gray-300' => !$loop->last,
                    ])>
                        <div class="w-full flex items-start justify-start py-3 px-1">
                            <img src="{{ $log['profile_picture'] ? asset('storage/' . $log['profile_picture']) : asset('assets/profile_picture/default.jpg') }}"
                                alt="{{ $log['username'] }}'s profile picture" class="w-6 h-6 object-cover rounded-full flex-shrink-0"/>                            
                            <div class="ml-2 flex-1 overflow-hidden">
                                <p class="text-[13px] block break-words max-w-[90%]">
                                    <span>
                                        @if (auth()->user()->username === $log['username'])
                                            You
                                        @else
                                            {{ $log['username'] }}
                                        @endif
                                    </span>
                                    <span>{{ $log['details'] }}</span>
                                </p>
                                <p class="text-xs text-gray-500">{{ $log['date'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>