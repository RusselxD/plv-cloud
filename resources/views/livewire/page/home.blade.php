<div class="space-y-3 flex-1">

    <!-- HEADER -->
    <!-- <div class="flex flex-col items-center justify-center banner rounded-xl pt-10 pb-8">
        <img src="{{ asset('/assets/logo.svg') }}" class="w-40" />

        <p class="mt-4 mb-6 text-gray-800 font-medium">Your ultimate platform for sharing and accessing academic resources.</p>
        <form wire:submit.prevent="submitSearch"
            class="border border-gray-600 rounded-md flex justify-center items-stretch bg-white overflow-hidden w-96">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Start typing to search."
                class="px-3 flex-1 focus:outline-none focus:ring-0 border-none" />
            <button class="p-3 h-full cursor-pointer hover:bg-gray-200" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-search-icon lucide-search">
                    <path d="m21 21-4.34-4.34" />
                    <circle cx="11" cy="11" r="8" />
                </svg>
            </button>
        </form>
    </div> -->

    <div class="bg-slate-50 w-full rounded-lg flex justify-between items-center p-2 h-20">
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

        <livewire:component.profile-with-notif/>
    </div>



    <div class="bg-slate-50/85 rounded-lg p-5">

        @if (empty($search))
            <livewire:component.breadcrumb />
            <div class="gap-5 xl:gap-6 grid xl:grid-cols-2">
                <!-- Default list (courses) -->
                @foreach ($result as $r)
                    <a href="{{ route('course', ['courseSlug' => $r->slug]) }}" class="relative overflow-hidden p-6 rounded-lg shadow-[0_0_5px_rgba(0,0,0,0.20)]
                                         hover:shadow-[0_0_15px_rgba(0,0,0,0.15)] hover:scale-101 bg-white
                                         flex items-center justify-start
                                         transition-all duration-100 ease-in-out">
                        <div class="font-bold">{{ $r->name }}</div>
                        <div class="absolute left-1 top-[0.40rem] bottom-[0.40rem] rounded-full w-2 bg-primary"></div>
                    </a>
                @endforeach
            </div>
        @else
            <div>hey</div>
        @endif
    </div>

</div>