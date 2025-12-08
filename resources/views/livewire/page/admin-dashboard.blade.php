<div class="p-6">
    <!-- Navigation Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex space-x-8">
            <button wire:click="switchView('dashboard')"
                class="pb-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ $currentView === 'dashboard' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-layout-dashboard w-5 h-5">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    Dashboard
                </div>
            </button>

            <button wire:click="switchView('reports')"
                class="pb-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ $currentView === 'reports' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-flag w-5 h-5">
                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z" />
                        <line x1="4" x2="4" y1="22" y2="15" />
                    </svg>
                    Reports
                    @if($pendingReports > 0)
                        <span
                            class="ml-2 px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-800 rounded-full">{{ $pendingReports }}</span>
                    @endif
                </div>
            </button>

            <button wire:click="switchView('users')"
                class="pb-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ $currentView === 'users' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-users w-5 h-5">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    Users
                </div>
            </button>
        </nav>
    </div>

    @if($currentView === 'dashboard')
        <!-- Dashboard View -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Users Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalUsers) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-users text-blue-600 w-6 h-6">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Courses Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Courses</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalCourses) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-book-open text-purple-600 w-6 h-6">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Folders Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Folders</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalFolders) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-folder text-green-600 w-6 h-6">
                            <path
                                d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Files Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Files</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalFiles) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-file text-orange-600 w-6 h-6">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Storage and Recent Users Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Storage Usage Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Storage Used</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $this->formatBytes($storageUsed) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-hard-drive text-indigo-600 w-6 h-6">
                            <line x1="22" x2="2" y1="12" y2="12" />
                            <path
                                d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z" />
                            <line x1="6" x2="6.01" y1="16" y2="16" />
                            <line x1="10" x2="10.01" y1="16" y2="16" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Recent Users Section -->
            <div class="md:col-span-2 bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Users</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Joined</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentUsers as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <img src="{{ $user->profile_picture ? $user->profile_picture : asset('assets/profile_picture/default.jpg') }}"
                                                    alt="{{ $user->username }}'s profile picture" class="w-8 h-8 rounded-full object-cover"/>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->username }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No users found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @elseif($currentView === 'reports')
        <!-- Reports View -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Reports Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Reports</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalReports }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-flag text-blue-600 w-6 h-6">
                            <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z" />
                            <line x1="4" x2="4" y1="22" y2="15" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Reports Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-3xl font-bold text-red-600 mt-2">{{ $pendingReports }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-alert-circle text-red-600 w-6 h-6">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="8" y2="12" />
                            <line x1="12" x2="12.01" y1="16" y2="16" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Acknowledged Reports Card -->
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Acknowledged</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $acknowledgedReports }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-check-circle text-green-600 w-6 h-6">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <path d="m9 11 3 3L22 4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reported Items Section -->
        <div class="bg-white rounded-lg shadow">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-800">Reported Items</h2>
                <p class="text-sm text-gray-600 mt-1">Review and manage reported files and folders</p>
            </div>

            <!-- Reports List -->
            <div class="divide-y divide-gray-200">
                @forelse ($reports as $report)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-start justify-between">
                            <!-- Report Details -->
                            <div class="flex-1">
                                <!-- File/Folder Name -->
                                <div class="flex items-center gap-3 mb-2">
                                    @if ($report->reported_file_id)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-file text-blue-600 w-5 h-5">
                                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $report->reportedFile ? $report->reportedFile->name : '[Deleted File]' }}
                                        </h3>
                                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                                            File
                                        </span>
                                        @if(!$report->reportedFile)
                                            <span class="px-2 py-1 text-xs font-medium bg-gray-200 text-gray-700 rounded">
                                                Deleted
                                            </span>
                                        @endif
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-folder text-yellow-600 w-5 h-5">
                                            <path
                                                d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z" />
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $report->reportedFolder ? $report->reportedFolder->name : '[Deleted Folder]' }}
                                        </h3>
                                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">
                                            Folder
                                        </span>
                                        @if(!$report->reportedFolder)
                                            <span class="px-2 py-1 text-xs font-medium bg-gray-200 text-gray-700 rounded">
                                                Deleted
                                            </span>
                                        @endif
                                    @endif
                                </div>

                                <!-- Location -->
                                <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-map-pin w-4 h-4">
                                        <path
                                            d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <span class="font-medium">Location:</span>
                                    @if ($report->reported_file_id && $report->reportedFile)
                                        @if ($report->reportedFile->folder)
                                            <a href="{{ route('folder', ['uuid' => $report->reportedFile->folder->uuid]) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                Folder: {{ $report->reportedFile->folder->name }}
                                            </a>
                                        @elseif($report->reportedFile->course)
                                            <a href="{{ route('course', ['courseSlug' => $report->reportedFile->course->slug]) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                Course: {{ $report->reportedFile->course->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">Unknown</span>
                                        @endif
                                    @elseif ($report->reported_folder_id && $report->reportedFolder)
                                        @if ($report->reportedFolder->folder)
                                            <a href="{{ route('folder', ['uuid' => $report->reportedFolder->folder->uuid]) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                Parent Folder: {{ $report->reportedFolder->folder->name }}
                                            </a>
                                        @elseif($report->reportedFolder->course)
                                            <a href="{{ route('course', ['courseSlug' => $report->reportedFolder->course->slug]) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                                Course: {{ $report->reportedFolder->course->name }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">Unknown</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">Item deleted</span>
                                    @endif
                                </div>

                                <!-- Reporter -->
                                <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-user w-4 h-4">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    <span class="font-medium">Reported by:</span>
                                    <span>{{ $report->user->username }} ({{ $report->user->email }})</span>
                                </div>

                                <!-- Reason -->
                                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-medium text-gray-700 mb-1">Reason:</p>
                                    <p class="text-sm text-gray-600">{{ $report->reason }}</p>
                                </div>

                                <!-- Timestamp -->
                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-clock w-4 h-4">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg>
                                    <span>{{ $report->created_at->format('F j, Y h:i A') }}</span>
                                    <span class="text-gray-400">•</span>
                                    <span>{{ $report->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <!-- Status & Actions -->
                            <div class="ml-6 flex flex-col items-end gap-3">
                                <!-- Status Badge -->
                                <div>
                                    @if ($report->is_acknowledged)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="lucide lucide-check-circle w-4 h-4 mr-1">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                                <path d="m9 11 3 3L22 4" />
                                            </svg>
                                            Acknowledged
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="lucide lucide-alert-circle w-4 h-4 mr-1">
                                                <circle cx="12" cy="12" r="10" />
                                                <line x1="12" x2="12" y1="8" y2="12" />
                                                <line x1="12" x2="12.01" y1="16" y2="16" />
                                            </svg>
                                            Pending
                                        </span>
                                    @endif
                                </div>

                                <!-- Toggle Button -->
                                <button wire:click="toggleAcknowledgment({{ $report->id }})"
                                    class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ $report->is_acknowledged ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                                    {{ $report->is_acknowledged ? 'Mark as Pending' : 'Mark as Acknowledged' }}
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-inbox w-16 h-16 mx-auto text-gray-400 mb-4">
                            <polyline points="22 12 16 12 14 15 10 15 8 12 2 12" />
                            <path
                                d="M5.45 5.11 2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No reports yet</h3>
                        <p class="text-gray-600">There are currently no reported items to review.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @elseif($currentView === 'users')
        <!-- Users View -->
        <div>
            <!-- Users Header -->
            <div class="bg-white rounded-lg shadow mb-6 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">User Management</h2>
                        <p class="text-gray-600 mt-1">Manage user accounts and permissions</p>
                    </div>
                    <div class="bg-blue-100 px-4 py-2 rounded-lg">
                        <p class="text-sm text-gray-600">Total Users</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($totalUsersCount) }}</p>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Username
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Course
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Joined
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img src="{{ $user->profile_picture ? $user->profile_picture : asset('assets/profile_picture/default.jpg') }}"
                                                    alt="{{ $user->username }}'s profile picture" 
                                                    class="w-10 h-10 rounded-full object-cover"/>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $user->first_name }} {{ $user->last_name }}
                                                </div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ '@' . $user->username }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $user->course->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $user->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->isBanned())
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <path d="m4.9 4.9 14.2 14.2" />
                                                </svg>
                                                Banned
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                                    <polyline points="22 4 12 14.01 9 11.01" />
                                                </svg>
                                                Active
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($user->isBanned())
                                            <button wire:click="unbanUser({{ $user->id }})"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                                    <polyline points="22 4 12 14.01 9 11.01" />
                                                </svg>
                                                Unban
                                            </button>
                                        @else
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    wire:click="banUser({{ $user->id }}, 1, 'Banned for 1 day by administrator')"
                                                    class="px-3 py-1.5 bg-yellow-500 text-white text-xs font-medium rounded-md hover:bg-yellow-600 transition-colors duration-200">
                                                    1 Day
                                                </button>
                                                <button
                                                    wire:click="banUser({{ $user->id }}, 7, 'Banned for 7 days by administrator')"
                                                    class="px-3 py-1.5 bg-orange-500 text-white text-xs font-medium rounded-md hover:bg-orange-600 transition-colors duration-200">
                                                    7 Days
                                                </button>
                                                <button
                                                    wire:click="banUser({{ $user->id }}, 30, 'Banned for 30 days by administrator')"
                                                    class="px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded-md hover:bg-red-700 transition-colors duration-200">
                                                    30 Days
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-users w-16 h-16 mx-auto text-gray-400 mb-4">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                                        <p class="text-gray-600">There are currently no registered users.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>