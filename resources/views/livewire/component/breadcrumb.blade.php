<?php
// Calculate if truncation is needed
$totalBreadcrumbs = count($breadcrumbs);
$shouldTruncate = $totalBreadcrumbs >= 4;

if ($shouldTruncate) {
     // Show first item, last 2 items, and truncate middle
     $visibleBreadcrumbs = [
          $breadcrumbs[0], // First item
     ];

     // Get middle items that will be hidden
     $hiddenBreadcrumbs = array_slice($breadcrumbs, 1, $totalBreadcrumbs - 3);

     // Add last 2 items
     $visibleBreadcrumbs = array_merge($visibleBreadcrumbs, array_slice($breadcrumbs, -2));
} else {
     $visibleBreadcrumbs = $breadcrumbs;
     $hiddenBreadcrumbs = [];
}
?>

<div class="flex items-center w-[75%] flex-wrap" x-data="{ open: false }" @click.away="open = false">
     <a href="{{ route('home') }}">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-7">
               <path fill-rule="evenodd"
                    d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z"
                    clip-rule="evenodd" />
          </svg>
     </a>

     @if (!empty($breadcrumbs))
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
               class="lucide lucide-chevron-right-icon lucide-chevron-right mx-1 text-gray-500">
               <path d="m9 18 6-6-6-6" />
          </svg>
     @endif

     @foreach ($visibleBreadcrumbs as $index => $breadcrumb)
          {{-- Show first breadcrumb --}}
          @if ($index === 0)
               @if ($shouldTruncate && $totalBreadcrumbs > 3)
                    <a href="{{ $breadcrumb['url'] }}" class="hover:underline text-gray-800">
                         {{ $breadcrumb['name'] }}
                    </a>

                    {{-- Add separator and ellipsis --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="lucide lucide-chevron-right-icon lucide-chevron-right mx-1 text-gray-500">
                         <path d="m9 18 6-6-6-6" />
                    </svg>

                    {{-- Ellipsis with Alpine dropdown --}}
                    <div class="relative inline-block">
                         <button @click="open = !open"
                              class="px-3 bg-gray-100 hover:bg-gray-200 rounded-full cursor-pointer transition-colors">
                              &middot;&middot;&middot;
                         </button>

                         {{-- Hidden breadcrumbs dropdown with collapse transition --}}
                         <div x-show="open" x-collapse
                              class="text-[14px]  absolute top-10 left-0 bg-white border border-gray-200 rounded-sm shadow-md z-50 min-w-32 max-w-44 overflow-hidden">
                              @foreach ($hiddenBreadcrumbs as $hiddenBreadcrumb)
                                   <a href="{{ $hiddenBreadcrumb['url'] }}"
                                        class="block px-3 py-1 text-gray-700 truncate hover:bg-gray-100 border-b border-gray-100 last:border-b-0 transition-colors">
                                        {{ $hiddenBreadcrumb['name'] }}
                                   </a>
                              @endforeach
                         </div>
                    </div>
               @else
                    {{-- Not truncated or is last item in non-truncated breadcrumb --}}
                    @if ($loop->last)
                         <p class="text-blue-600 font-medium">{{ $breadcrumb['name'] }}</p>
                    @else
                         <a href="{{ $breadcrumb['url'] }}" class="hover:underline text-gray-800">
                              {{ $breadcrumb['name'] }}
                         </a>
                    @endif
               @endif
          @else
               {{-- Handle last 2 items when truncated --}}
               @if ($loop->last)
                    <p class="text-blue-600 font-medium max-w-60 truncate block">{{ $breadcrumb['name'] }}</p>
               @else
                    <a href="{{ $breadcrumb['url'] }}" class="max-w-36 hover:underline text-gray-800 truncate block">
                         {{ $breadcrumb['name'] }}
                    </a>
               @endif
          @endif

          {{-- Add separator if not last item --}}
          @if (!$loop->last)
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-chevron-right-icon lucide-chevron-right mx-1 text-gray-500">
                    <path d="m9 18 6-6-6-6" />
               </svg>
          @endif
     @endforeach
</div>