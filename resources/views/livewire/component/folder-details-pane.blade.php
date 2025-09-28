<div class="scrollbar-hide">
    <div class="p-3 relative">
        <img src="{{ asset('assets/x.svg') }}" wire:click="closeDetailsPane"
            class="absolute top-3 right-3 hover:bg-gray-200 rounded-full p-1 w-7 cursor-pointer" />
        <h1 class="font-semibold text-lg max-w-[85%] break-words">{{ $folder->name }}</h1>
        <p class="text-xs flex justify-between items-center mt-1">
            <span class=" text-slate-700 font-light">Created {{ $folder->created_at->format('M d, Y') }}</span>
        </p>
        <p class="mt-3 text-sm">Contents</p>
        <div class="grid grid-cols-2 gap-2 mt-1">
            <div class="text-center bg-white rounded-md py-2">
                <p class="font-bold text-lg">100</p>
                <p class="text-sm text-gray-700">Folders</p>
            </div>
            <div class="text-center bg-white rounded-md py-2">
                <p class="font-bold text-lg">100</p>
                <p class="text-sm text-gray-700">Files</p>
            </div>
        </div>

        @if (!$this->userIsAContributor)
            <p class="mt-3 mb-2 text-sm">Contributors</p>
            <div class="space-y-2">
                <x-ui.cards.folder-contributor :username="$folder->user->username" role="Owner" />
                @foreach ($folder->folderContributors as $contributor)
                    <x-ui.cards.folder-contributor :username="$contributor->user->username" role="Contributor" />
                @endforeach
            </div>
        @endif
    </div>
    @if ($this->userIsAContributor)
        <!-- Tabs Section (Contributors / Activity) -->
        <div class="grid grid-cols-2 relative ">
            <p @class([
                'text-center py-3 text-sm font-medium transition-all duration-150 ease-in-out',
                'text-blue-600' => $contributorsTabIsActive,
                'hover:bg-white/85 cursor-pointer border-b border-gray-300' => !$contributorsTabIsActive,
            ]) wire:click="setOpenTabToContributors(true)">
                Contributors
            </p>
            <p @class([
                'text-center py-3 text-sm font-medium transition-all duration-150 ease-in-out',
                'text-blue-600' => !$contributorsTabIsActive,
                'hover:bg-white/85 cursor-pointer border-b border-gray-300' => $contributorsTabIsActive,
            ]) wire:click="setOpenTabToContributors(false)">
                Activity
            </p>
            <span @class([
                'absolute bottom-0 left-0 w-1/2 border-b-2 border-blue-600 transition-transform duration-150 ease-in-out',
                'translate-x-0' => $contributorsTabIsActive,
                'translate-x-full' => !$contributorsTabIsActive,
            ])></span>
        </div>

        <div class="flex-1 px-3 py-2">
            @if ($contributorsTabIsActive)
                <!-- Contributors Tab -->
                <div class="space-y-2">
                    <x-ui.cards.folder-contributor :username="$folder->user->username" role="Owner" />
                    @foreach ($folder->folderContributors as $contributor)
                        <x-ui.cards.folder-contributor :username="$contributor->user->username" role="Contributor" />
                    @endforeach
                </div>

            @else
            @endif
        </div>
    @endif
</div>