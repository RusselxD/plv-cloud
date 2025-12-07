<div class="group relative w-full cursor-pointer" wire:click="goToFolder">

    <!-- Card Content with rounded corners and overflow hidden -->
    <div
        class="rounded-lg sm:rounded-xl bg-white shadow-sm hover:shadow-lg border border-gray-200 transition-all duration-300 hover:-translate-y-0.5 overflow-hidden">
        <!-- Colored Top Border -->
        <div class="h-0.5 sm:h-1 bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600"></div>

        <!-- Main Content -->
        <div class="p-3 sm:p-4 pt-3 sm:pt-4">
            <!-- Header Section -->
            <div class="flex items-start gap-2 sm:gap-3 md:gap-4 mb-2 sm:mb-3">
                <!-- Folder Icon -->
                <div class="flex-shrink-0">
                    <div
                        class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 rounded-lg bg-gradient-to-br from-yellow-50 to-yellow-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-folder text-yellow-600 w-5 h-5 sm:w-6 sm:h-6 md:w-8 md:h-8">
                            <path
                                d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
                        </svg>
                    </div>
                </div>

                <!-- Folder Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-1 sm:gap-2">
                        <div class="flex-1 min-w-0">
                            <h3
                                class="font-semibold text-gray-900 truncate text-sm sm:text-base group-hover:text-yellow-600 transition-colors duration-200">
                                {{ $folder->name }}
                            </h3>
                            <div class="flex items-center gap-1 sm:gap-1.5 mt-1 sm:mt-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-files w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400">
                                    <path d="M20 7h-3a2 2 0 0 1-2-2V2" />
                                    <path d="M9 18a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h7l4 4v10a2 2 0 0 1-2 2Z" />
                                    <path d="M3 7.6v12.8A1.6 1.6 0 0 0 4.6 22h9.8" />
                                </svg>
                                <span class="text-[10px] sm:text-xs text-gray-500 font-medium">{{ $totalContents }}
                                    {{ $totalContents === 1 ? 'item' : 'items' }}</span>
                            </div>
                        </div>

                        <!-- Kebab Menu Button -->
                        <button x-ref="kebabButton"
                            class="flex-shrink-0 p-1 sm:p-1.5 hover:bg-gray-100 rounded-lg transition-colors duration-200 group/kebab"
                            wire:click.stop="clickKebab">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-more-vertical w-4 h-4 sm:w-5 sm:h-5 text-gray-400 group-hover/kebab:text-gray-600">
                                <circle cx="12" cy="12" r="1" />
                                <circle cx="12" cy="5" r="1" />
                                <circle cx="12" cy="19" r="1" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-3 sm:px-4 py-1 border-t border-gray-100 bg-gray-50/50">
            <div class="flex items-center justify-between gap-1 sm:gap-2">
                <!-- Owner Info -->
                <div class="flex items-center gap-1.5 sm:gap-2 py-1 min-w-0 flex-1" wire:click.stop="goToProfile">
                    <div class="flex-shrink-0">
                        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('assets/profile_picture/default.jpg') }}"
                            alt="{{ $user->username }}'s profile picture"
                            class="w-5 h-5 sm:w-6 sm:h-6 object-cover rounded-full ring-2 ring-white shadow-sm" />
                    </div>
                    <span
                        class="text-[10px] sm:text-xs text-gray-600 font-medium truncate hover:text-yellow-600 hover:underline transition-colors duration-200">
                        {{ $folder->user->username }}
                    </span>
                </div>

                <!-- Parent Directory Link -->
                @if ($showParent)
                    <div class="flex items-center gap-1 sm:gap-1.5 min-w-0 flex-shrink-0" wire:click.stop="goToParentDirectory">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-corner-up-left w-2.5 h-2.5 sm:w-3 sm:h-3 text-gray-400">
                            <polyline points="9 14 4 9 9 4" />
                            <path d="M20 20v-7a4 4 0 0 0-4-4H4" />
                        </svg>
                        <span
                            class="text-[10px] sm:text-xs text-gray-500 hover:text-yellow-600 hover:underline cursor-pointer truncate max-w-[80px] sm:max-w-[120px] transition-colors duration-200">
                            {{ $parentName }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- End Card Content -->

    <!-- Kebab Menu -->
    <div x-data="{ open: @entangle('openKebabMenu') }" class="absolute top-2 right-14 z-50">
        <div x-show="open" @click.away="$wire.closeKebabMenu()" x-cloak
            x-transition
            x-init="
                $watch('open', value => {
                    if (value) {
                        $nextTick(() => {
                            const rect = $el.getBoundingClientRect();
                            const spaceBelow = window.innerHeight - rect.top;
                            
                            if (spaceBelow < rect.height) {
                                $el.classList.add('bottom-full', 'mb-2');
                                $el.classList.remove('top-0');
                            } else {
                                $el.classList.add('top-0');
                                $el.classList.remove('bottom-full', 'mb-2');
                            }
                        });
                    }
                });
            "
            class="absolute right-0 top-0 w-48 bg-white rounded-lg border border-gray-200 overflow-visible shadow-xl text-sm">

            @auth
                @if ($isSaved)
                    <button
                        class="w-full flex items-center gap-3 px-3 py-2.5 hover:bg-gray-50 transition-colors duration-150 text-left group"
                        wire:click.stop="unsaveFolder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-4 h-4 text-yellow-500 group-hover:text-yellow-600">
                            <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                        </svg>
                        <span class="text-gray-700 group-hover:text-gray-900 font-medium">Unsave</span>
                    </button>
                @else
                    <button
                        class="w-full flex items-center gap-3 px-3 py-2.5 hover:bg-gray-50 transition-colors duration-150 text-left group"
                        wire:click.stop="saveFolder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-4 h-4 text-gray-500 group-hover:text-yellow-500">
                            <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" />
                        </svg>
                        <span class="text-gray-700 group-hover:text-gray-900 font-medium">Save</span>
                    </button>
                @endif

                <!-- Divider -->
                <div class="h-px bg-gray-200 my-1"></div>
            @endauth

            <button
                class="w-full flex items-center gap-3 px-3 py-2.5 hover:bg-gray-50 transition-colors duration-150 text-left group"
                wire:click.stop="downloadFolder">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="w-4 h-4 text-gray-500 group-hover:text-blue-500">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="7 10 12 15 17 10" />
                    <line x1="12" x2="12" y1="15" y2="3" />
                </svg>
                <span class="text-gray-700 group-hover:text-gray-900 font-medium">Download</span>
            </button>

            @if ($currentUserCanModify)
                <!-- Divider -->
                <div class="h-px bg-gray-200 my-1"></div>

                <button
                    class="w-full flex items-center gap-3 px-3 py-2.5 hover:bg-gray-50 transition-colors duration-150 text-left group"
                    wire:click.stop="openRenameModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-4 h-4 text-gray-500 group-hover:text-blue-500">
                        <path
                            d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                        <path d="m15 5 4 4" />
                    </svg>
                    <span class="text-gray-700 group-hover:text-gray-900 font-medium">Rename</span>
                </button>

                <button
                    class="w-full flex items-center gap-3 px-3 py-2.5 hover:bg-red-50 transition-colors duration-150 text-left group"
                    wire:click.stop="openConfirmDeleteModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-4 h-4 text-gray-500 group-hover:text-red-500">
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        <line x1="10" x2="10" y1="11" y2="17" />
                        <line x1="14" x2="14" y1="11" y2="17" />
                    </svg>
                    <span class="text-gray-700 group-hover:text-red-600 font-medium">Delete</span>
                </button>
            @endif

            @if (auth()->id() !== $folder->user_id && auth()->check())
                <!-- Divider -->
                <div class="h-px bg-gray-200 my-1"></div>

                <button
                    class="w-full flex items-center gap-3 px-3 py-2.5 hover:bg-orange-50 transition-colors duration-150 text-left group"
                    wire:click.stop="openReportModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-4 h-4 text-gray-500 group-hover:text-orange-500">
                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z" />
                        <line x1="4" x2="4" y1="22" y2="15" />
                    </svg>
                    <span class="text-gray-700 group-hover:text-orange-600 font-medium">Report</span>
                </button>
            @endif

        </div>
    </div>

    <!-- Rename Modal -->
    @if($renameModalIsOpen)
        <div wire:click.stop="closeKebabMenu">
            <livewire:component.modal.rename-modal :targetId="$folder->id" :isAFolder="true" :oldName="$folder->name" />
        </div>
    @endif

    <!-- Confirm Delete Modal -->
    @if ($confirmDeleteModalIsOpen)
        <div wire:click.stop>
            <livewire:component.modal.confirm-delete-modal :targetId="$folder->id" :isAFolder="true" />
        </div>
    @endif

    <!-- Report File Modal -->
    @if ($reportModalIsOpen)
        <div wire:click.stop>
            <livewire:component.modal.report-modal :reportedItemId="$folder->id" :isAFolder="true" />
        </div>
    @endif
</div>