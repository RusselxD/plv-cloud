<div class="flex-1 ">
    <div class="bg-green-200 h-[400px] sm:h-[500px] md:h-[600px] lg:h-[70vh] rounded-lg relative flex items-end px-4 sm:px-6 md:px-8 lg:px-10 banner">
        <div class="absolute left-0 right-0 top-0 flex flex-col sm:flex-row items-end sm:items-center justify-between px-3 sm:px-5 py-3 gap-2 sm:gap-0">
            <!-- NAV BAR -->
            <ul class="flex items-center justify-between sm:pl-7 lg:pl-0 space-x-3 sm:space-x-5 mr-0 sm:mr-10 font-semibold text-white ml-auto sm:ml-0 order-1 sm:order-1">
                <li><a class="hover:bg-white/20 px-2 sm:px-3 py-1 rounded-md font-medium text-sm sm:text-base" href="{{ route('home') }}">Home</a>
                </li>
                <li><a class="hover:bg-white/20 px-2 sm:px-3 py-1 rounded-md font-medium text-sm sm:text-base"
                        href="{{ route('courses') }}">Courses</a></li>
            </ul>

            <div class="order-2 sm:order-2 ml-auto sm:ml-0">
                <livewire:component.profile-with-notif :hasBackground="true"/>
            </div>
        </div>

        <div class="mb-8 sm:mb-10 md:mb-14">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold">Welcome to</h1>
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold">PLV CLOUD</h1>
            <p class="mt-2 mb-4 sm:mb-5 text-sm sm:text-base">Your hub for shared knowledge and resources.</p>
            <a href="{{ route('courses') }}"
                class="inline-block border rounded-md bg-primary text-white px-4 sm:px-5 py-2 cursor-pointer hover:bg-primary/90 text-sm sm:text-base">Explore
                Courses</a>
        </div>
    </div>

    <div class="mt-5 pb-5 pr-2 sm:pr-3 md:pr-4 lg:pr-5">
        @if($highlightFolders->isEmpty() && $highlightFiles->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-12 sm:py-16 md:py-20 px-4">
                <div class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 bg-gray-100 rounded-full flex items-center justify-center mb-4 sm:mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="text-gray-400 w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16">
                        <path
                            d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
                        <path d="M12 10v6" />
                        <path d="m9 13 3 3 3-3" />
                    </svg>
                </div>

                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2 text-center">No content available yet</h3>
                <p class="text-sm sm:text-base text-gray-600 text-center max-w-md mb-4 sm:mb-6 px-4">
                    The platform is just getting started! Be the first to share folders and files with the community.
                </p>

                <a href="{{ route('courses') }}"
                    class="inline-flex items-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors duration-200 font-medium text-sm sm:text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-4 h-4 sm:w-5 sm:h-5">
                        <path
                            d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                        <path d="M22 10v6" />
                        <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
                    </svg>
                    Explore Courses
                </a>
            </div>
        @else
            <!-- Highlight Folders Section -->
            @if($highlightFolders->isNotEmpty())
                <div class="mb-6 sm:mb-8">
                    <div class="flex items-center gap-2 mb-3 sm:mb-4 px-2 sm:px-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600">
                            <path
                                d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
                        </svg>
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900">Top Folders</h2>
                        <span class="text-xs sm:text-sm text-gray-500">• Most content</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 md:gap-6">
                        @foreach ($highlightFolders as $folder)
                            <livewire:component.folder-card :folder="$folder" wire:key="{{ $folder->uuid }}" :showParent="true" />
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Highlight Files Section -->
            @if($highlightFiles->isNotEmpty())
                <div>
                    <div class="flex items-center gap-2 mb-3 sm:mb-4 px-2 sm:px-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                        </svg>
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900">Popular Files</h2>
                        <span class="text-xs sm:text-sm text-gray-500">• Most downloaded</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 md:gap-6">
                        @foreach ($highlightFiles as $file)
                            <livewire:component.file-card :file="$file" wire:key="{{ $file->id }}" />
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>

</div>