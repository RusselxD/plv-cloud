<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-50 to-orange-50 p-4">
    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header with Icon -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 p-8 text-center">
            <div class="flex justify-center mb-4">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="text-white">
                        <circle cx="12" cy="12" r="10" />
                        <path d="m4.9 4.9 14.2 14.2" />
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Account Suspended</h1>
            <p class="text-red-100 text-lg">Your access has been temporarily restricted</p>
        </div>

        <!-- Content -->
        <div class="p-8">
            <!-- Ban Information -->
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg mb-6">
                <div class="flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="text-red-600 flex-shrink-0 mt-1">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3" />
                        <path d="M12 9v4" />
                        <path d="M12 17h.01" />
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-red-900 font-semibold mb-2">Suspension Details</h3>
                        
                        @if($bannedUntil)
                            <div class="mb-3">
                                <p class="text-sm text-red-800 font-medium">Suspended Until:</p>
                                <p class="text-red-900 text-lg font-bold">
                                    {{ $bannedUntil->format('F j, Y \a\t g:i A') }}
                                </p>
                                <p class="text-sm text-red-700 mt-1">
                                    ({{ $bannedUntil->diffForHumans() }})
                                </p>
                            </div>
                        @else
                            <div class="mb-3">
                                <p class="text-red-900 text-lg font-bold">Permanently Banned</p>
                            </div>
                        @endif

                        @if($banReason)
                            <div class="mt-4">
                                <p class="text-sm text-red-800 font-medium mb-1">Reason:</p>
                                <p class="text-red-900">{{ $banReason }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Information Box -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-gray-900 font-semibold mb-3 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 16v-4" />
                        <path d="M12 8h.01" />
                    </svg>
                    What This Means
                </h3>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-start gap-2">
                        <span class="text-red-500 mt-1">•</span>
                        <span>You cannot access any content on the platform during this period</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-red-500 mt-1">•</span>
                        <span>Your account and data remain intact</span>
                    </li>
                    @if($bannedUntil)
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-1">•</span>
                            <span>Access will be automatically restored after the suspension period ends</span>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button wire:click="logout"
                    class="flex-1 bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition-colors duration-200 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" x2="9" y1="12" y2="12" />
                    </svg>
                    Log Out
                </button>
            </div>

            <!-- Help Text -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    If you believe this is a mistake or have questions, please contact the administrator.
                </p>
            </div>
        </div>
    </div>
</div>
