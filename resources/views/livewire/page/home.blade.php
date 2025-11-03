<div class="flex-1 ">
    <div class="bg-green-200 h-[70%] rounded-lg relative flex items-end px-10 banner">
        <div class="absolute left-0 right-0 top-0 flex items-center justify-between px-5 py-3">
            <!-- NAV BAR -->
            <ul class="flex items-center justify-between space-x-5 mr-10 font-semibold text-white">
                <li><a class="hover:bg-white/20 px-3 py-1 rounded-md font-medium" href="{{ route('home') }}">Home</a>
                </li>
                <li><a class="hover:bg-white/20 px-3 py-1 rounded-md font-medium"
                        href="{{ route('courses') }}">Courses</a></li>
            </ul>

            <livewire:component.profile-with-notif :hasBackground="true" />
        </div>

        <div class="mb-14">
            <h1 class="text-4xl font-bold">Welcome to</h1>
            <h1 class="text-7xl font-extrabold">PLV CLOUD</h1>
            <p class="mt-2 mb-5">Your hub for shared knowledge and resources.</p>
            <a href="{{ route('courses') }}"
                class="border rounded-md bg-primary text-white px-5 py-2 cursor-pointer hover:bg-primary/90">Explore
                Courses</a>
        </div>
    </div>

    <div class="mt-5 pb-5 pr-5">
        @if($highlightFolders->isEmpty() && $highlightFiles->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-20 px-4">
                <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="text-gray-400">
                        <path
                            d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
                        <path d="M12 10v6" />
                        <path d="m9 13 3 3 3-3" />
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-900 mb-2">No content available yet</h3>
                <p class="text-gray-600 text-center max-w-md mb-6">
                    The platform is just getting started! Be the first to share folders and files with the community.
                </p>

                <a href="{{ route('courses') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors duration-200 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5">
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
                <div class="mb-8">
                    <div class="flex items-center gap-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-5 h-5 text-yellow-600">
                            <path
                                d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
                        </svg>
                        <h2 class="text-xl font-bold text-gray-900">Top Folders</h2>
                        <span class="text-sm text-gray-500">• Most content</span>
                    </div>
                    <div class="grid grid-cols-3 gap-6">
                        @foreach ($highlightFolders as $folder)
                            <livewire:component.folder-card :folder="$folder" wire:key="{{ $folder->uuid }}" :showParent="true" />
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Highlight Files Section -->
            @if($highlightFiles->isNotEmpty())
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-5 h-5 text-blue-600">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                        </svg>
                        <h2 class="text-xl font-bold text-gray-900">Popular Files</h2>
                        <span class="text-sm text-gray-500">• Most downloaded</span>
                    </div>
                    <div class="grid grid-cols-3 gap-6">
                        @foreach ($highlightFiles as $file)
                            <livewire:component.file-card :file="$file" wire:key="{{ $file->id }}" />
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>

</div>