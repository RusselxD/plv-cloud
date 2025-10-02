@props(['name', 'route', 'path'])

@php
     $activeIcons = [
          'home' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 468 468" class="w-5" > <path d="M 228 68 L 88 208 C 78 218 72 230 72 244 L 72 244 L 72 360 C 72 373 83 384 96 384 L 180 384 C 193 384 204 373 204 360 L 204 300 C 204 287 215 276 228 276 L 240 276 C 253 276 264 287 264 300 L 264 360 C 264 373 275 384 288 384 L 372 384 C 385 384 396 373 396 360 L 396 244 C 396 230 390 218 380 208 L 240 68 C 234 62 228 62 228 68 Z" fill="currentColor" stroke="#000000" stroke-width="24" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
          'notifications' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell-icon lucide-bell w-5"> <path d="M10.268 21a2 2 0 0 0 3.464 0" /> <path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" /></svg>',
          'saved' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bookmark-icon lucide-bookmark w-5"> <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" /> </svg>',
     ];
     $noneActiveIcons = [
          'home' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 468 468" class="w-5" > <path d="M 228 68 L 88 208 C 78 218 72 230 72 244 L 72 244 L 72 360 C 72 373 83 384 96 384 L 180 384 C 193 384 204 373 204 360 L 204 300 C 204 287 215 276 228 276 L 240 276 C 253 276 264 287 264 300 L 264 360 C 264 373 275 384 288 384 L 372 384 C 385 384 396 373 396 360 L 396 244 C 396 230 390 218 380 208 L 240 68 C 234 62 228 62 228 68 Z" fill="none" stroke="#000000" stroke-width="35" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
          'notifications' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell-icon lucide-bell w-5"> <path d="M10.268 21a2 2 0 0 0 3.464 0" /> <path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" /></svg>',
          'saved' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bookmark-icon lucide-bookmark w-5"> <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z" /> </svg>',
     ];
     $currentPage = request()->path();
     $isActive = $currentPage == $path;          
@endphp

@if ($isActive)
     <div class="flex items-center justify-start px-3 py-2 rounded-md gap-2 bg-gray-200">
          {!! $activeIcons[$route] !!}
          <p>{{ $name }}</p>
     </div>
@else
     <a href="{{ route($route) }}"
          class="flex items-center justify-start cursor-pointer px-3 py-2 rounded-md gap-2 hover:bg-gray-200">
          {!! $noneActiveIcons[$route] !!}
          <p>{{ $name }}</p>
     </a>
@endif