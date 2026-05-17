<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Breadcrumb & Title -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Dashboard / Veterinarios</p>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Veterinarios</h2>
        </div>
        <button wire:click="create" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition">
            <i class="fas fa-plus mr-2"></i> Nuevo veterinario
        </button>
    </div>

    <!-- Toolbar -->
    <div class="bg-white dark:bg-gray-800 rounded-t-lg border border-gray-200 dark:border-gray-700 p-4 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="w-full md:w-1/3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" wire:model.live="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Buscar por nombre, email, DNI o especialidad">
            </div>
        </div>
        <div class="flex items-center space-x-3 w-full md:w-auto">
            <button class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2 flex items-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                Columnas <i class="fas fa-chevron-down ml-2 text-xs"></i>
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 border-x border-gray-200 dark:border-gray-700 overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 font-semibold">Nombre</th>
                    <th scope="col" class="px-6 py-3 font-semibold">Email</th>
                    <th scope="col" class="px-6 py-3 font-semibold">ID profesional</th>
                    <th scope="col" class="px-6 py-3 font-semibold">Teléfono</th>
                    <th scope="col" class="px-6 py-3 font-semibold">Especialidad</th>
                    <th scope="col" class="px-6 py-3 font-semibold text-center" style="position: sticky; right: 0; z-index: 10; background: inherit;">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($doctors as $doctor)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $doctor->name }}</td>
                        <td class="px-6 py-4">{{ $doctor->email }}</td>
                        <td class="px-6 py-4">{{ $doctor->id_number ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $doctor->phone ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                {{ $doctor->specialty ?? 'General' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap" style="position: sticky; right: 0; z-index: 5; background: inherit; min-width: 240px;">
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                <button type="button" wire:click="edit({{ $doctor->id }})" title="Editar veterinario" aria-label="Editar veterinario" style="display: inline-flex; align-items: center; gap: 6px; min-width: 86px; padding: 8px 12px; border: 0; border-radius: 8px; background: #2563eb; color: #ffffff; font-size: 12px; font-weight: 700; cursor: pointer;">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width: 16px; height: 16px; flex-shrink: 0;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125 16.875 4.5M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    Editar
                                </button>
                                <a href="{{ route('admin.doctors.schedule', $doctor->id) }}" title="Gestionar horario" aria-label="Gestionar horario" style="display: inline-flex; align-items: center; gap: 6px; min-width: 94px; padding: 8px 12px; border-radius: 8px; background: #16a34a; color: #ffffff; font-size: 12px; font-weight: 700; text-decoration: none;">
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" style="width: 16px; height: 16px; flex-shrink: 0;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25m10.5-2.25v2.25M3.75 8.25h16.5M5.25 5.25h13.5A1.5 1.5 0 0 1 20.25 6.75v12A1.5 1.5 0 0 1 18.75 20.25H5.25A1.5 1.5 0 0 1 3.75 18.75v-12A1.5 1.5 0 0 1 5.25 5.25Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 12h3.75l-2.25 3.75h4.5" />
                                    </svg>
                                    Horario
                                </a>
                                <button type="button" onclick="confirmDelete({{ $doctor->id }})" title="Eliminar veterinario" aria-label="Eliminar veterinario" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; padding: 8px; border: 0; border-radius: 8px; background: #dc2626; color: #ffffff; cursor: pointer;">
                                    <i class="fa-solid fa-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400 italic">
                            No se encontraron veterinarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="bg-white dark:bg-gray-800 rounded-b-lg border border-gray-200 dark:border-gray-700 p-4">
        {{ $doctors->links() }}
    </div>

    <!-- Modal Form (Alpine.js + Livewire) -->
    @if($isOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('isOpen', false)"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-middle bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">
                <form wire:submit.prevent="save">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-center mb-4 border-b pb-2 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $isEditMode ? 'Editar veterinario' : 'Nuevo veterinario' }}
                            </h3>
                            <button type="button" wire:click="$set('isOpen', false)" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre Completo</label>
                                <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <input type="email" wire:model="email" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID profesional</label>
                                    <input type="text" wire:model="id_number" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    @error('id_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña {{ $isEditMode ? '(Dejar en blanco para no cambiar)' : '' }}</label>
                                <input type="password" wire:model="password" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                                    <input type="text" wire:model="phone" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Especialidad</label>
                                    <input type="text" wire:model="specialty" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Ej: Cardiología">
                                    @error('specialty') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dirección</label>
                                <input type="text" wire:model="address" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                            {{ $isEditMode ? 'Actualizar' : 'Guardar' }}
                        </button>
                        <button type="button" wire:click="$set('isOpen', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 transition">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', id);
                }
            })
        }
    </script>
</div>
