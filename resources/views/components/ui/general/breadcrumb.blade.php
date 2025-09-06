@props(['breadcrumbs' => [
     ['Home', '/']
]])

<div class="border border-red-700 my-5 flex items-center">

     @foreach ($breadcrumbs as $breadcrumb)
          @if ($loop->last)
               <p>{{ $breadcrumb[0] }}</p>
          @else
               <a href="{{ $breadcrumb[1] }}" class="hover:underline">
                    {{ $breadcrumb[0] }}
               </a>
          @endif            
          @if (!$loop->last)
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right mx-1 "><path d="m9 18 6-6-6-6"/></svg>
          @endif
     @endforeach

</div>
