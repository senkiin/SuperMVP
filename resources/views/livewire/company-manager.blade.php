<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Manage Companies
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <x-button wire:click="newCompany">Add New Company</x-button>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($companies as $company)
                        <li class="p-4 sm:p-6 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div>
                                <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $company->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $company->manual_data['elevator_pitch'] ?? 'No summary provided.' }}</p>
                            </div>
                            <div class="flex space-x-4">
                                <x-button wire:click="edit({{ $company->id }})">Edit</x-button>
                                <!-- Delete Button -->
                                <x-danger-button wire:click="confirmCompanyDeletion({{ $company->id }})">Delete</x-danger-button>
                            </div>
                        </li>
                    @empty
                        <li class="p-6 text-center text-gray-500 dark:text-gray-400">
                            You haven't added any companies yet.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Create/Edit Company Modal -->
    @if($showModal)
    <x-dialog-modal wire:model.live="showModal">
        <x-slot name="title">
            {{ $editing->exists ? 'Edit Company' : 'Create New Company' }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                @foreach($formFields as $field)
                    <div>
                        <x-label for="{{ $field->name }}" value="{{ $field->label }}" />
                        
                        @if($field->type === 'text')
                            <x-input id="{{ $field->name }}" type="text" class="mt-1 block w-full" wire:model.defer="state.{{ $field->name }}" />
                        @elseif($field->type === 'textarea')
                            <textarea id="{{ $field->name }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" wire:model.defer="state.{{ $field->name }}" rows="4"></textarea>
                        @elseif($field->type === 'select')
                            <select id="{{ $field->name }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" wire:model.defer="state.{{ $field->name }}">
                                <option value="">Select an option...</option>
                                @if(is_array($field->options))
                                    @foreach($field->options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                @endif
                            </select>
                        @endif

                        <x-input-error for="state.{{ $field->name }}" class="mt-2" />
                    </div>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showModal', false)">Cancel</x-secondary-button>
            <x-button class="ml-2" wire:click="save">Save Company</x-button>
        </x-slot>
    </x-dialog-modal>
    @endif

    <!-- Delete Company Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingCompanyDeletion">
        <x-slot name="title">
            Delete Company
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete this company? All associated data, including documents, will be permanently removed. This action cannot be undone.
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingCompanyDeletion', false)" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="deleteCompany" wire:loading.attr="disabled">
                Delete Company
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
