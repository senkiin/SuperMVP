<div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">

    <!-- Sección de Uso de Tokens -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Uso de Tokens</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Plan actual: <span class="font-bold">{{ Auth::user()->isAdmin() ? 'Administrador' : ($userPlan->name ?? 'Ninguno') }}</span>.
            Has consumido {{ $tokens_used }} de {{ $token_limit }} tokens.
        </p>
        @if(!Auth::user()->isAdmin())
            <div class="w-full bg-gray-200 rounded-full h-4 mt-2 dark:bg-gray-700">
                @php $percentage = is_numeric($token_limit) && $token_limit > 0 ? ($tokens_used / $token_limit) * 100 : 0; @endphp
                <div class="bg-indigo-600 h-4 rounded-full" style="width: {{ $percentage }}%"></div>
            </div>
        @endif
    </div>

    <!-- Sección del Formulario de Subida de Documentos -->
    @if(Auth::user()->isAdmin() || ($userPlan && $userPlan->name !== 'Gratis'))
        <x-form-section submit="saveDocument">
            <x-slot name="title">Subir Documento</x-slot>
            <x-slot name="description">Sube un nuevo documento y clasifícalo en una categoría.</x-slot>
            <x-slot name="form">
                <!-- Selector de Categoría -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="category" value="Categoría" />
                    <select wire:model="document_category_id" id="category" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="">Selecciona una categoría...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="document_category_id" class="mt-2" />
                </div>

                <!-- Input de Archivo -->
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="file" value="Documento" />
                    <input type="file" wire:model="file" id="file" class="mt-1 block w-full text-gray-900 dark:text-gray-100">
                    <div wire:loading wire:target="file">Uploading...</div>
                    <x-input-error for="file" class="mt-2" />
                </div>
            </x-slot>
            <x-slot name="actions">
                <x-button>Guardar</x-button>
            </x-slot>
        </x-form-section>
    @else
        <!-- Mensaje para usuarios del plan Gratis -->
        <div class="mt-10 sm:mt-0">
             <div class="md:grid md:grid-cols-3 md:gap-6">
                <x-section-title>
                    <x-slot name="title">Subir Documento</x-slot>
                    <x-slot name="description">Sube un nuevo documento y clasifícalo en una categoría.</x-slot>
                </x-section-title>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Función no disponible</h3>
                        <div class="mt-2 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                            <p>La subida de documentos no está disponible en el plan Gratuito. Por favor, mejora tu plan para acceder a esta funcionalidad.</p>
                        </div>
                        <div class="mt-5">
                            <x-button onclick="window.location.href='/ruta-a-planes'">
                                Ver Planes
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Lista de Documentos -->
    <x-section-border />
    <div class="mt-10 sm:mt-0">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Tus Documentos</h2>
        <div class="mt-4 flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="shadow overflow-hidden border-b border-gray-200 dark:border-gray-700 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Categoría</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                                @forelse($documents as $doc)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ \Illuminate\Support\Str::limit($doc->original_filename, 40) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $doc->category->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if ($doc->status === 'uploaded')
                                                <button wire:click="startAnalysis({{ $doc->id }})" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                                    Analizar
                                                </button>
                                            @elseif ($doc->status === 'processing')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100">
                                                    Procesando...
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($doc->status == 'processed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100
                                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100 @endif">
                                                    {{ ucfirst($doc->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $doc->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="downloadDocument({{ $doc->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200 mr-3 font-semibold">Descargar</button>
                                            <button wire:click="confirmDocumentDeletion({{ $doc->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200 font-semibold">Eliminar</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Todavía no has subido ningún documento.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Borrado -->
    <x-confirmation-modal wire:model.live="confirmingDocumentDeletion">
        <x-slot name="title">Eliminar Documento</x-slot>
        <x-slot name="content">¿Estás seguro de que quieres eliminar este documento? Esta acción no se puede deshacer.</x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingDocumentDeletion')">Cancelar</x-secondary-button>
            <x-danger-button class="ms-3" wire:click="deleteDocument">Eliminar</x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Notificación Toast -->
    <div 
        x-data="{ show: false, message: '', type: 'success' }"
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
        class="fixed bottom-5 right-5 w-full max-w-xs p-4 rounded-lg shadow-lg text-white"
        :class="{ 'bg-green-600': type === 'success', 'bg-red-600': type === 'error', 'bg-blue-500': type === 'info' }"
        style="display: none;"
    >
        <div class="flex items-center">
            <p class="text-sm font-medium" x-text="message"></p>
        </div>
    </div>
</div>
