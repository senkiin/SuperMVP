<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Manage Company Form Fields
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <x-button wire:click="newField">Add New Field</x-button>
            </div>

            <!-- Fields List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Label</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Internal Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($fields as $field)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $field->order }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $field->label }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-mono">{{ $field->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($field->type) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($field->is_active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                Active
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-100">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4">
                                        <button wire:click="edit({{ $field->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">Edit</button>
                                        <button wire:click="confirmFieldDeletion({{ $field->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No fields defined. Click "Add New Field" to get started.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Field Modal -->
    @if($showModal)
    <x-dialog-modal wire:model.live="showModal">
        <x-slot name="title">{{ $editingId ? 'Edit Field' : 'Create New Field' }}</x-slot>
        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <x-label for="label" value="Label (Visible to user)" />
                    <x-input id="label" type="text" class="mt-1 block w-full" wire:model.defer="state.label" />
                    <x-input-error for="state.label" class="mt-2" />
                </div>
                <div>
                    <x-label for="name" value="Name (Internal key, lowercase_with_underscores)" />
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" placeholder="example_field_name" />
                    <x-input-error for="state.name" class="mt-2" />
                </div>
                <div>
                    <x-label for="type" value="Field Type" />
                    <select id="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" wire:model.live="state.type">
                        <option value="text">Short Text</option>
                        <option value="textarea">Text Area</option>
                        <option value="select">Select</option>
                    </select>
                </div>
                @if(isset($state['type']) && $state['type'] === 'select')
                <div>
                    <x-label for="options" value="Options (one per line)" />
                    <textarea id="options" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" wire:model.defer="state.options" rows="3"></textarea>
                    <p class="mt-1 text-xs text-gray-500">Each line will become an option in the dropdown.</p>
                </div>
                @endif
                <div>
                    <x-label for="order" value="Order" />
                    <x-input id="order" type="number" class="mt-1 block w-full" wire:model.defer="state.order" />
                    <x-input-error for="state.order" class="mt-2" />
                </div>
                 <div class="flex items-center">
                    <x-checkbox id="is_active" wire:model.defer="state.is_active" />
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Active (visible in the company form)</span>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showModal', false)">Cancel</x-secondary-button>
            <x-button class="ml-2" wire:click="save">Save Field</x-button>
        </x-slot>
    </x-dialog-modal>
    @endif

    <!-- Delete Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingFieldDeletion">
        <x-slot name="title">
            Delete Field
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete this field? This action cannot be undone.
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingFieldDeletion', false)" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-danger-button class="ml-3" wire:click="deleteField" wire:loading.attr="disabled">
                Delete Field
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
