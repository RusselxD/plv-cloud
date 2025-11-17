<div class="group relative" x-data="{ menuOpen: false }">
    <!-- Card Content -->
    <div
        class="rounded-xl bg-white shadow-sm hover:shadow-lg border border-gray-200 transition-all duration-300 hover:-translate-y-0.5 overflow-hidden">
        <!-- Colored Top Border -->
        <div class="h-1 bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600"></div>

        <!-- Main Content -->
        <div class="p-4 flex items-center gap-4">
            <!-- File Icon -->
            <div class="flex-shrink-0">
                <div
                    class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <img class="w-7" src="{{ asset($icon) }}" />
                </div>
            </div>

            <!-- File Info -->
            <div class="flex-1 min-w-0">
                <h3
                    class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-600 transition-colors duration-200">
                    {{ $file->name }}
                </h3>
                <div class="flex items-center gap-2 mt-1 text-xs text-gray-500 overflow-hidden">
                    <!-- File Size -->
                    <div class="flex items-center gap-1 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-3 h-3 flex-shrink-0">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="7 10 12 15 17 10" />
                            <line x1="12" x2="12" y1="15" y2="3" />
                        </svg>
                        <span class="font-medium whitespace-nowrap">{{ $file->file_size }}</span>
                    </div>

                    <span class="text-gray-400 flex-shrink-0">•</span>

                    <!-- Download Count -->
                    <div class="flex items-center gap-1 min-w-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-3 h-3 flex-shrink-0">
                            <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4M17 9l-5 5-5-5M12 12.8V2.5" />
                        </svg>
                        <span class="font-medium flex-shrink-0">{{ $file->download_count }}</span>
                        <span class="truncate">{{ $file->download_count === 1 ? 'download' : 'downloads' }}</span>
                    </div>
                </div>
            </div>

            <!-- Kebab Menu Button -->
            <button x-ref="kebabButton" class="flex-shrink-0 p-1.5 hover:bg-gray-100 rounded-lg transition-colors duration-200 group/kebab"
                @click.stop="menuOpen = !menuOpen">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-more-vertical w-5 h-5 text-gray-400 group-hover/kebab:text-gray-600">
                    <circle cx="12" cy="12" r="1" />
                    <circle cx="12" cy="5" r="1" />
                    <circle cx="12" cy="19" r="1" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Kebab Menu -->
    <div class="absolute top-2 right-14 z-50">
        <div x-show="menuOpen" @click.away="menuOpen = false" x-cloak
            x-transition
            x-anchor.bottom-end="$refs.kebabButton"
            x-init="
                $watch('menuOpen', value => {
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
                        @click.stop="menuOpen = false; $wire.unsaveFile()">
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
                        @click.stop="menuOpen = false; $wire.saveFile()">
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
                @click.stop="menuOpen = false; $wire.downloadFile()">
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
                    @click.stop="menuOpen = false; $wire.openRenameModal()">
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
                    @click.stop="menuOpen = false; $wire.openConfirmDeleteModal()">
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

            @if (auth()->id() !== $file->user_id && auth()->check())
                <!-- Divider -->
                <div class="h-px bg-gray-200 my-1"></div>

                <button
                    class="w-full flex items-center gap-3 px-3 py-2.5 hover:bg-orange-50 transition-colors duration-150 text-left group"
                    @click.stop="menuOpen = false; $wire.openReportModal()">
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
    @if ($renameModalIsOpen)
        <div wire:click.stop>
            <livewire:component.modal.rename-modal :targetId="$file->id" :isAFolder="false" :oldName="$file->name" />
        </div>
    @endif

    <!-- Confirm Delete Modal -->
    @if ($confirmDeleteModalIsOpen)
        <div wire:click.stop>
            <livewire:component.modal.confirm-delete-modal :targetId="$file->id" :isAFolder="false" />
        </div>
    @endif

    <!-- Report File Modal -->
    @if ($reportModalIsOpen)
        <div wire:click.stop>
            <livewire:component.modal.report-modal :reportedItemId="$file->id" :isAFolder="false" />
        </div>
    @endif
</div>