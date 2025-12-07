<div class="space-y-3 flex-1 flex flex-col">

    <div class="bg-slate-50 sm:pl-12 lg:pl-0 w-full rounded-lg flex flex-col sm:flex-row justify-between items-stretch sm:items-center py-3 sm:py-2 px-3 sm:px-4 gap-3 sm:gap-0">
        <form wire:submit.prevent="submitSearch"
            class="border border-gray-600 rounded-md flex justify-center items-stretch bg-white overflow-hidden w-full sm:w-80 md:w-96 h-10 sm:h-12 order-2 sm:order-1">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Start typing to search."
                class="px-2 sm:px-3 flex-1 focus:outline-none focus:ring-0 border-none text-xs sm:text-sm" />
            <button class="p-2 sm:p-3 h-full cursor-pointer hover:bg-gray-200" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-search-icon lucide-search sm:w-6 sm:h-6">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>
            </button>
        </form>

        <div class="order-1 sm:order-2 ml-auto">
            <livewire:component.profile-with-notif />
        </div>
    </div>

    <div class="bg-slate-50/85 rounded-lg p-3 sm:p-4 md:p-5 flex-1 flex items-start">

        @if ($search == '' || !$result->isEmpty())
            <div class="gap-3 sm:gap-4 md:gap-5 xl:gap-6 grid grid-cols-1 lg:grid-cols-2 flex-1 content-start">
                @foreach ($result as $r)
                    <a href="{{ route('course', ['courseSlug' => $r->slug]) }}"
                        class="group relative overflow-hidden rounded-xl shadow-md hover:shadow-xl bg-white transition-all duration-300 ease-in-out hover:-translate-y-1">

                        <!-- Accent Bar -->
                        <div
                            class="absolute left-0 top-0 bottom-0 w-1 sm:w-1.5 bg-gradient-to-b from-blue-500 to-blue-600 group-hover:w-2 transition-all duration-300">
                        </div>

                        <!-- Content -->
                        <div class="px-4 sm:px-5 md:px-6 py-4 sm:py-5 pl-6 sm:pl-7 md:pl-8">
                            <!-- Header Section -->
                            <div class="flex items-start justify-between mb-3 sm:mb-4">
                                <div class="flex-1">
                                    <!-- Course Abbreviation Badge -->
                                    <div
                                        class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-2 sm:mb-3 group-hover:bg-blue-100 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-graduation-cap w-3 h-3 mr-1 sm:mr-1.5">
                                            <path
                                                d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                                            <path d="M22 10v6" />
                                            <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
                                        </svg>
                                        {{ $r->abbreviation }}
                                    </div>

                                    <!-- Course Name -->
                                    <h3
                                        class="text-base sm:text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 leading-tight">
                                        {{ $r->name }}
                                    </h3>
                                </div>

                                <!-- Arrow Icon -->
                                <div
                                    class="ml-3 sm:ml-4 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-200 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4 sm:w-5 sm:h-5">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Stats Section -->
                            <div class="flex items-center gap-4 sm:gap-6 text-xs sm:text-sm text-gray-600">
                                <!-- Folders Count -->
                                <div class="flex items-center gap-1.5 sm:gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-folder w-3.5 h-3.5 sm:w-4 sm:h-4 text-yellow-500">
                                        <path
                                            d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
                                    </svg>
                                    <span class="font-medium">{{ $r->folders->count() }}</span>
                                    <span class="text-gray-500 hidden sm:inline">folder{{ $r->folders->count() !== 1 ? 's' : '' }}</span>
                                </div>

                                <!-- Files Count -->
                                <div class="flex items-center gap-1.5 sm:gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-file w-3.5 h-3.5 sm:w-4 sm:h-4 text-blue-500">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                    </svg>
                                    <span class="font-medium">{{ $r->files->count() }}</span>
                                    <span class="text-gray-500 hidden sm:inline">file{{ $r->files->count() !== 1 ? 's' : '' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Bottom Border -->
                        <div
                            class="h-0.5 sm:h-1 bg-gradient-to-r from-blue-50 via-blue-100 to-blue-50 group-hover:from-blue-100 group-hover:via-blue-200 group-hover:to-blue-100 transition-all duration-300">
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        @if ($search && $result->isEmpty())
            <div class="flex flex-col items-center w-full flex-1 py-12 sm:py-16 md:py-22 px-4">
                <!-- Empty result of search -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-search-icon lucide-search w-16 h-16 sm:w-20 sm:h-20">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>

                <p class="text-lg sm:text-xl font-medium my-3 sm:my-4">No courses found</p>
                <p class="text-sm sm:text-base text-gray-700 text-center break-all max-w-[90%] sm:max-w-[80%]">No courses
                    "<strong>{{ $search }}</strong>".</p>
                <p class="text-sm sm:text-base text-gray-700 text-center mt-2 sm:mt-3"> Try searching with different keywords.</p>
                <button wire:click="clearSearch"
                    class="py-2 sm:py-3 px-4 sm:px-5 mt-3 sm:mt-4 rounded-lg hover:bg-gray-200 border border-gray-400 transition-colors duration-150 ease-in-out cursor-pointer text-sm sm:text-base">Clear
                    Search</button>
            </div>
        @endif
    </div>
</div>