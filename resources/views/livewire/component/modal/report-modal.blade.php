<div 
    class="fixed inset-0 bg-black/20 flex justify-center items-center z-[100] cursor-default"
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
        class="w-[calc(100%-2rem)] sm:w-[90%] md:w-[80%] lg:w-[45rem] max-w-[45rem] h-fit border-2 bg-white rounded-lg sm:rounded p-3 sm:p-4 absolute mx-4 sm:mx-0 max-h-[90vh] overflow-y-auto"
        @click.stop
    >

        <img src="{{ asset('/assets/x.svg') }}" class="absolute right-2 top-2 w-8 h-8 sm:w-9 sm:h-9 p-1.5 sm:p-2 cursor-pointer hover:bg-gray-200 rounded-full transition-colors"
                @click.stop="show = false; $wire.closeModal()" />

        <p class="text-gray-600 text-xs sm:text-sm mb-3 sm:mb-4 pr-8 sm:pr-0">
            Please select the reason for reporting this {{ $isAFolder ? 'folder' : 'file' }}:
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 text-xs sm:text-sm gap-2 sm:gap-3">
            @foreach ($options as $option)
                @php $optId = $option['id']; @endphp
                <label 
                    class="flex items-center p-3 sm:p-4 rounded-md border transition-colors duration-200 cursor-pointer select-none focus:outline-none"
                    :class="selectedReason === '{{ $optId }}' 
                        ? 'border-blue-500 bg-blue-100' 
                        : 'border-gray-300 hover:border-blue-300'"
                >
                    <input 
                        id="report-option-{{ $optId }}"
                        type="radio" 
                        class="w-4 h-4 accent-blue-500 focus:ring-0 focus:outline-none flex-shrink-0"
                        x-model="selectedReason"
                        value="{{ $optId }}" 
                        name="option"
                    />
                    <span class="mx-2 text-base sm:text-lg">{{ $option['icon'] }}</span>
                    <span class="flex-1">{{ $labels[$optId] }}</span>
                </label>
            @endforeach
        </div>        
        <div class="mt-2 sm:mt-3" x-data="{ charCount: 0 }" @init="charCount = $wire.otherDetails.length">
            <div x-show="selectedReason === 'other'" x-cloak class="mt-3">
                <label for="report-other" class="block text-xs sm:text-sm text-primary mb-2">Please specify</label>
                <textarea id="report-other" rows="4"
                    class="w-full border-2 rounded-md p-2 sm:p-3 text-xs sm:text-sm focus:ring-0 resize-none transition-colors"
                    :class="$wire.errors.has('otherDetails') ? 'border-red-500 focus:border-red-500' : 'border-gray-300 focus:border-primary'"
                    wire:model="otherDetails"
                    @input="charCount = $el.value.length"
                    maxlength="100"
                    placeholder="Please provide additional details..."
                ></textarea>
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-0 mt-2">
                    <div class="w-full sm:w-auto">
                        @error('otherDetails')
                            <p class="flex items-center gap-2 text-xs text-red-700 bg-red-100 border border-red-300 rounded-md px-2 sm:px-3 py-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-alert-circle flex-shrink-0 w-3.5 h-3.5 sm:w-4 sm:h-4"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span class="break-words">{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                    <span class="text-xs text-gray-500 flex-shrink-0" x-text="`${charCount}/100`"></span>
                </div>
            </div>
        </div>
        <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 sm:gap-3 mt-4 sm:mt-2">
            <button type="button" class="w-full sm:w-auto px-4 py-2 rounded-md border border-gray-300 bg-white text-xs sm:text-sm cursor-pointer hover:bg-gray-100 transition-colors" @click="show = false; $wire.closeModal()">Cancel</button>
            <button type="button" class="w-full sm:w-auto px-4 py-2 rounded-md bg-primary text-white text-xs sm:text-sm disabled:opacity-50 transition-colors"
                :class="selectedReason ? 'opacity-100 hover:bg-primary/90 cursor-pointer' : 'opacity-50 cursor-not-allowed'"
                @click="selectedReason && $wire.submitReport()"
            >
                Submit
            </button>
        </div>
    </div>
</div>
