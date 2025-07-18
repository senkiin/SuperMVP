{{-- Gestor de Documentos Moderno --}}
<div class="min-h-screen bg-gradient-to-br from-gray-50 mt-12 to-gray-100 dark:from-gray-900 dark:to-gray-800">

    {{-- Header Section --}}
    <div class="bg-white dark:bg-gray-800 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border-b border-gray-200/50 dark:border-gray-700/50">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/25">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Document Manager</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Upload, analyze and manage your documents</p>
                    </div>
                </div>

                {{-- Token Usage Display --}}
                <div class="flex items-center space-x-4">
                    <div class="bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm rounded-2xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ Auth::user()->isAdmin() ? 'Unlimited' : ($userPlan->name ?? 'Free') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $tokens_used }} / {{ Auth::user()->isAdmin() ? '∞' : $token_limit }} tokens
                                </p>
                            </div>
                        </div>
                        @if(!Auth::user()->isAdmin())
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2 mt-2">
                                @php $percentage = is_numeric($token_limit) && $token_limit > 0 ? min(($tokens_used / $token_limit) * 100, 100) : 0; @endphp
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full transition-all duration-300"
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Documents</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $documents->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Processed</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $documents->where('status', 'processed')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Processing</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $documents->where('status', 'processing')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $documents->where('status', 'uploaded')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.238 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Upload Section --}}
        @if(Auth::user()->isAdmin() || ($userPlan && $userPlan->name !== 'Gratis'))
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50 overflow-hidden mb-8">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/10 dark:to-purple-900/10">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Upload Document</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Select category and upload your document for analysis</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <form wire:submit="saveDocument" class="space-y-6">
                        {{-- Category Selection --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                            <select wire:model="document_category_id"
                                    class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
                                <option value="">Select a category...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('document_category_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- File Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Document</label>
                            <div class="relative">
                                <input type="file"
                                       wire:model="file"
                                       class="w-full px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-all duration-200 hover:border-indigo-400 dark:hover:border-indigo-500"
                                       accept=".pdf,.doc,.docx,.txt">
                                <div wire:loading wire:target="file" class="absolute inset-0 bg-white/80 dark:bg-gray-800/80 rounded-xl flex items-center justify-center">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-indigo-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        <span class="text-indigo-600 dark:text-indigo-400 font-medium">Uploading...</span>
                                    </div>
                                </div>
                            </div>
                            @error('file') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Upload Document
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            {{-- Upgrade Notice --}}
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-8 text-white mb-8 shadow-lg shadow-indigo-500/25">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Upgrade Required</h3>
                            <p class="text-white/80">Document upload is not available on the Free plan. Upgrade to unlock this feature.</p>
                        </div>
                    </div>
                    <button onclick="window.location.href='/ruta-a-planes'"
                            class="px-6 py-3 bg-white text-indigo-600 rounded-xl font-medium hover:bg-gray-100 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg">
                        View Plans
                    </button>
                </div>
            </div>
        @endif

        {{-- Documents List --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg shadow-gray-500/10 dark:shadow-gray-900/20 border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Your Documents</h2>
            </div>

            <div wire:poll.5s>
                @if($documents->count() > 0)
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($documents as $doc)
                            <div class="group p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        {{-- Document Icon --}}
                                        <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>

                                        {{-- Document Info --}}
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    {{ \Illuminate\Support\Str::limit($doc->original_filename, 40) }}
                                                </h3>

                                                {{-- Status Badge --}}
                                                @if ($doc->status === 'uploaded')
                                                    <button wire:click="startAnalysis({{ $doc->id }})"
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 hover:bg-yellow-200 dark:hover:bg-yellow-900/50 transition-colors">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                        </svg>
                                                        Analyze
                                                    </button>
                                                @elseif ($doc->status === 'processing')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                                        <svg class="w-3 h-3 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                        </svg>
                                                        Processing...
                                                    </span>
                                                @elseif ($doc->status === 'processed')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Processed
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        {{ ucfirst($doc->status) }}
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                                <span class="flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                    </svg>
                                                    <span>{{ $doc->category->name ?? 'Uncategorized' }}</span>
                                                </span>
                                                <span class="flex items-center space-x-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span>{{ $doc->created_at->format('M j, Y') }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button wire:click="downloadDocument({{ $doc->id }})"
                                                class="px-4 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl font-medium hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-all duration-200 hover:scale-105 active:scale-95">
                                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download
                                        </button>
                                        <button wire:click="confirmDocumentDeletion({{ $doc->id }})"
                                                class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-xl transition-all duration-200 hover:scale-105 active:scale-95">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="flex flex-col items-center justify-center py-16 px-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-indigo-400 dark:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No documents yet</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-center mb-6">Upload your first document to get started with analysis</p>
                        @if(Auth::user()->isAdmin() || ($userPlan && $userPlan->name !== 'Gratis'))
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Use the upload form above to add your first document
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modern Delete Confirmation Modal --}}
    @if($confirmingDocumentDeletion)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block w-full max-w-md p-6 my-8 text-left align-middle transition-all transform bg-white dark:bg-gray-800 shadow-2xl rounded-2xl border border-gray-200/50 dark:border-gray-700/50">

                {{-- Warning Icon --}}
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-red-100 dark:bg-red-900/30 rounded-full">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.238 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>

                {{-- Content --}}
                <div class="text-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Document</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Are you sure you want to delete this document? This action cannot be undone.
                    </p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center space-x-3">
                    <button wire:click="deleteDocument"
                            class="flex-1 px-6 py-3 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition-all duration-200 hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl">
                        Delete Document
                    </button>
                    <button wire:click="$set('confirmingDocumentDeletion', false)"
                            class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 hover:scale-105 active:scale-95">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Modern Toast Notification --}}
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:show-toast.window="
            message = $event.detail.message;
            type = $event.detail.type || 'success';
            show = true;
            setTimeout(() => show = false, 4000);"
         x-show="show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-5 right-5 w-full max-w-sm p-4 rounded-2xl shadow-2xl text-white z-50"
         :class="{
            'bg-gradient-to-r from-green-500 to-emerald-600': type === 'success',
            'bg-gradient-to-r from-red-500 to-red-600': type === 'error',
            'bg-gradient-to-r from-indigo-500 to-purple-600': type === 'info'
         }"
         style="display: none;">
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <svg x-show="type === 'success'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <svg x-show="type === 'error'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.238 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <svg x-show="type === 'info'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium" x-text="message"></p>
            </div>
            <button @click="show = false" class="flex-shrink-0 p-1 hover:bg-white/20 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    <style>
    /* Animaciones para el drag and drop */
    .drag-over {
        border-color: #10b981;
        background-color: rgba(16, 185, 129, 0.1);
    }

    /* Efectos de hover mejorados */
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .dark .hover-lift:hover {
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
    }

    /* Animaciones de progreso */
    .progress-bar {
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        background-size: 200% 100%;
        animation: gradientMove 2s ease infinite;
    }

    @keyframes gradientMove {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* Efectos de pulsación */
    .pulse-ring {
        animation: pulse-ring 1.25s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }

    @keyframes pulse-ring {
        0% {
            transform: scale(0.33);
        }
        40%, 50% {
            opacity: 0;
        }
        100% {
            opacity: 0;
            transform: scale(1.2);
        }
    }

    /* Scroll suave */
    html {
        scroll-behavior: smooth;
    }

    /* Mejoras responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .upload-section {
            padding: 1rem;
        }
    }
</style>

</div>

