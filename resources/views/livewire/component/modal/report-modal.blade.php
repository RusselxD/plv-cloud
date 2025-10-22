<div 
    class="fixed inset-0 bg-black/20 flex justify-center items-center z-150 cursor-default"
    x-data="{ 
        show: true, 
        selectedReason: @entangle('reason') 
    }"
    x-show="show"
    x-transition
    @close-rename-modal.window="show = false"
    @keydown.escape.window="show = false; $wire.closeModal()"
    @click.self="show = false; $wire.closeModal()"
    tabindex="0"
>
    <div 
        class="w-[45rem] h-fit border-2 bg-white rounded p-4 absolute"
        @click.stop
    >

        <img src="{{ asset('/assets/x.svg') }}" class="absolute right-2 top-2 w-9 p-2 cursor-pointer hover:bg-gray-200 rounded-full"
                @click.stop="show = false; $wire.closeModal()" />

        <p class="text-gray-600 text-sm mb-4">
            Please select the reason for reporting this file:
        </p>

        <div class="grid grid-cols-2 text-sm gap-3">
            @foreach ($options as $option)
                @php $optId = $option['id']; @endphp
                <label 
                    class="flex items-center p-4 rounded-md border transition-colors duration-200 cursor-pointer select-none focus:outline-none"
                    :class="selectedReason === '{{ $optId }}' 
                        ? 'border-blue-500 bg-blue-100' 
                        : 'border-gray-300 hover:border-blue-300'"
                >
                    <input 
                        id="report-option-{{ $optId }}"
                        type="radio" 
                        class="w-4 h-4 accent-blue-500 focus:ring-0 focus:outline-none"
                        x-model="selectedReason"
                        value="{{ $optId }}" 
                        name="option"
                    />
                    <span class="mx-2">{{ $option['icon'] }}</span>
                    <span>{{ $labels[$optId] }}</span>
                </label>
            @endforeach
        </div>        
        <div class="mt-2" x-data="{ charCount: 0 }" @init="charCount = $wire.otherDetails.length">
            <div x-show="selectedReason === 'other'" x-cloak class="mt-3">
                <label for="report-other" class="block text-sm text-primary mb-2">Please specify</label>
                <textarea id="report-other" rows="4"
                    class="w-full border-2 rounded-md p-3 text-sm focus:ring-0 resize-none transition-colors"
                    :class="$wire.errors.has('otherDetails') ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-primary'"
                    wire:model="otherDetails"
                    @input="charCount = $el.value.length"
                    maxlength="100"
                    placeholder="Please provide additional details..."
                ></textarea>
                <div class="flex justify-between items-center mt-2">
                    <div>
                        @error('otherDetails')
                            <p class="flex items-center gap-2 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md px-3 py-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-alert-circle"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <span class="text-xs text-gray-500" x-text="`${charCount}/100`"></span>
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-2">
            <button type="button" class="px-4 py-2 rounded-md border border-gray-300 bg-white text-sm cursor-pointer hover:bg-gray-100" @click="show = false; $wire.closeModal()">Cancel</button>
            <button type="button" class="px-4 py-2 rounded-md bg-primary text-white text-sm disabled:opacity-50"
                :class="selectedReason ? 'opacity-100 hover:bg-primary/90 cursor-pointer' : 'opacity-50 cursor-not-allowed'"
                @click="selectedReason && $wire.submitReport()"
            >
                Submit
            </button>
        </div>
    </div>
</div>
