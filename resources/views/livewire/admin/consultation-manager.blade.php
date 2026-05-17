<div x-data="{ tab: 'consulta', showHistory: false }" class="p-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header / Breadcrumb placeholder (handled by layout) -->
    
    <!-- Encabezado Principal -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $appointment->patient->pet_display_name }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Dueño: <span class="font-medium text-gray-700 dark:text-gray-300">{{ $appointment->patient->owner_name }}</span></p>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $appointment->patient->species ?? 'Especie no registrada' }} {{ $appointment->patient->breed ? '- '.$appointment->patient->breed : '' }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button @click="showHistory = true; $wire.loadHistory()" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700 transition">
                <i class="fas fa-history mr-2 text-blue-600"></i> Consultas Anteriores
            </button>
        </div>
    </div>

    <!-- Contenedor Principal de la Consulta -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                <li class="mr-2">
                    <button @click="tab = 'consulta'" :class="tab === 'consulta' ? 'border-blue-600 text-blue-600 border-b-2' : 'border-transparent hover:text-gray-600 hover:border-gray-300'" class="inline-block p-4 rounded-t-lg transition">
                        <i class="fas fa-file-medical mr-2"></i> Consulta
                    </button>
                </li>
                <li class="mr-2">
                    <button @click="tab = 'receta'" :class="tab === 'receta' ? 'border-blue-600 text-blue-600 border-b-2' : 'border-transparent hover:text-gray-600 hover:border-gray-300'" class="inline-block p-4 rounded-t-lg transition">
                        <i class="fas fa-prescription mr-2"></i> Receta
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tabs Content -->
        <div class="p-6">
            <!-- Pestaña Consulta -->
            <div x-show="tab === 'consulta'" class="space-y-6">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="diagnosis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diagnóstico <span class="text-red-600">*</span></label>
                        <textarea id="diagnosis" wire:model="diagnosis" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Describa el diagnostico de la mascota..."></textarea>
                        @error('diagnosis') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="treatment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tratamiento / Instrucciones <span class="text-red-600">*</span></label>
                        <textarea id="treatment" wire:model="treatment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Plan de tratamiento e indicaciones..."></textarea>
                        @error('treatment') <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="notes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Notas adicionales</label>
                        <textarea id="notes" wire:model="notes" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Observaciones internas..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Pestaña Receta -->
            <div x-show="tab === 'receta'" class="space-y-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Prescripcion de medicamentos</h3>
                    <button type="button" wire:click="addMedicine" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 transition">
                        <i class="fas fa-plus mr-2"></i> Añadir medicamento
                    </button>
                </div>

                <div class="relative overflow-x-auto shadow-sm sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Medicamento</th>
                                <th scope="col" class="px-6 py-3">Dosis</th>
                                <th scope="col" class="px-6 py-3">Frecuencia</th>
                                <th scope="col" class="px-6 py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($medicines as $index => $medicine)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        <input type="text" wire:model="medicines.{{ $index }}.name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ej: Paracetamol 500mg">
                                        @error("medicines.$index.name") <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" wire:model="medicines.{{ $index }}.dosage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ej: 1 tableta">
                                        @error("medicines.$index.dosage") <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" wire:model="medicines.{{ $index }}.frequency" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Ej: Cada 8 horas">
                                        @error("medicines.$index.frequency") <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <button type="button" wire:click="removeMedicine({{ $index }})" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900 transition">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 italic">
                                        No se han agregado medicamentos. Haz clic en "Añadir medicamento" para comenzar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer / Save Button -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button type="button" wire:click="saveConsultation" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-lg text-base px-6 py-3.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 shadow-md transition">
                    Finalizar consulta
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de Historial Clínico (Alpine.js) -->
    <div x-show="showHistory" 
         class="fixed inset-0 z-[60] overflow-y-auto" 
         style="display: none;"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showHistory = false">
                <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Panel -->
            <div class="inline-block align-middle bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Historial de consultas: {{ $appointment->patient->pet_display_name }}</h3>
                    <button @click="showHistory = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div class="p-6 bg-gray-50 dark:bg-gray-900 max-h-[70vh] overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($pastAppointments as $past)
                            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">{{ $past->date->format('d/m/Y') }}</span>
                                    <span class="text-[10px] text-gray-500">Vet. {{ $past->doctor->name }}</span>
                                </div>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-2 line-clamp-1" title="{{ $past->diagnosis }}">Dx: {{ $past->diagnosis }}</h4>
                                <div class="space-y-1">
                                    <p class="text-xs text-gray-600 dark:text-gray-400"><strong>Tratamiento:</strong> {{ Str::limit($past->treatment, 80) }}</p>
                                    @if($past->medicines)
                                        <div class="pt-2">
                                            <p class="text-[10px] font-bold text-gray-400 uppercase">Medicamentos:</p>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @foreach($past->medicines as $med)
                                                    <span class="bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-[10px] px-2 py-0.5 rounded border border-blue-100 dark:border-blue-800">
                                                        {{ $med['name'] }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-folder-open text-4xl mb-4 opacity-20"></i>
                                <p>No se encontraron registros de consultas previas para esta mascota.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                    <button @click="showHistory = false" type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        Cerrar historial
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
