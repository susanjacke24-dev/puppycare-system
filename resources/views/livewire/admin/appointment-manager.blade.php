<div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    @if($isCreating)
        <!-- CREACIÓN DE CITA (Match con Imagen 2) -->
        <div class="p-6 max-w-7xl mx-auto">
            <div class="mb-6">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Dashboard / Citas / Nuevo</p>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Nuevo</h2>
            </div>

            @if (session()->has('message'))
                <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg shadow-sm">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Izquierda: Controles manuales simulando el UI de Buscar disponibilidad -->
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 shadow-sm p-6">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Buscar disponibilidad</h3>
                            <p class="text-sm text-gray-500 mb-4">Encuentra el horario perfecto para tu cita (Ingreso Manual).</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Fecha</label>
                                    <input type="date" wire:model.live="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Hora Inicio</label>
                                    <input type="time" wire:model.live="start_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    @error('start_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Hora Fin</label>
                                    <input type="time" wire:model.live="end_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    @error('end_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Card del veterinario -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 shadow-sm p-6">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Seleccionar veterinario</h3>
                            <div>
                                <select wire:model.live="doctor_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Seleccione un veterinario...</option>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialty ?? 'General' }})</option>
                                    @endforeach
                                </select>
                                @error('doctor_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            @if($doctor_id)
                                @php $selectedDoctor = $doctors->find($doctor_id); @endphp
                                <div class="mt-6 flex items-center border-t border-gray-100 pt-6">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg mr-4">
                                        {{ strtoupper(substr($selectedDoctor->name ?? 'D', 0, 2)) }}
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900">{{ $selectedDoctor->name ?? '' }}</h4>
                                        <p class="text-sm text-blue-600">{{ $selectedDoctor->specialty ?? 'General' }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-sm text-gray-500 mb-2">Horario seleccionado:</p>
                                    @if($start_time)
                                        <div class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white rounded-md text-sm font-medium">
                                            {{ \Carbon\Carbon::parse($start_time)->format('H:i:s') }}
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">Seleccione hora arriba</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Derecha: Resumen de la Cita -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 shadow-sm p-6 h-full flex flex-col">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Resumen de la cita</h3>
                            
                            <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300 flex-grow">
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <span class="font-medium text-gray-500">Veterinario:</span>
                                    <span class="font-semibold text-gray-900 text-right">{{ $doctor_id ? ($doctors->find($doctor_id)->name ?? '') : '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <span class="font-medium text-gray-500">Fecha:</span>
                                    <span class="font-semibold text-gray-900">{{ $date ?: '-' }}</span>
                                </div>
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <span class="font-medium text-gray-500">Horario:</span>
                                    <span class="font-semibold text-gray-900">
                                        {{ $start_time ? \Carbon\Carbon::parse($start_time)->format('H:i:s') : '-' }} - 
                                        {{ $end_time ? \Carbon\Carbon::parse($end_time)->format('H:i:s') : '-' }}
                                    </span>
                                </div>
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <span class="font-medium text-gray-500">Duración:</span>
                                    <span class="font-semibold text-gray-900">15 minutos</span>
                                </div>

                                <div class="pt-4">
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Mascota</label>
                                    <select wire:model.live="patient_id" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="">Seleccione una mascota...</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->pet_display_name }} - Dueño: {{ $patient->owner_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('patient_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div class="pt-4">
                                    <label class="block mb-2 text-sm font-medium text-gray-900">Motivo de la cita</label>
                                    <textarea wire:model="reason" rows="3" class="bg-white border border-blue-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Ej: Chequeo..."></textarea>
                                    @error('reason') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col space-y-3">
                                <button type="submit" class="w-full text-white bg-indigo-500 hover:bg-indigo-600 font-medium rounded-lg text-sm px-5 py-3 text-center transition">
                                    Confirmar cita
                                </button>
                                <button type="button" wire:click="cancel" class="w-full text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 font-medium rounded-lg text-sm px-5 py-3 text-center transition">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @else
        <!-- INDEX DE CITAS (Match con Imagen 1) -->
        <div class="p-6 max-w-7xl mx-auto">
            <!-- Breadcrumb & Title -->
            <div class="flex justify-between items-end mb-6">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Dashboard / Citas</p>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Citas</h2>
                </div>
                <button wire:click="create" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition shadow-sm font-medium text-sm flex items-center">
                    <i class="fas fa-plus mr-2"></i> Nuevo
                </button>
            </div>

            @if (session()->has('message'))
                <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg shadow-sm">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Toolbar -->
            <div class="bg-white rounded-t-lg border border-gray-200 p-4 flex justify-between items-center">
                <div class="w-64">
                    <div class="relative">
                        <input type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" placeholder="Buscar">
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <button class="bg-white border border-gray-300 text-gray-700 font-medium rounded-lg text-sm px-4 py-2 flex items-center">
                        Columnas <i class="fas fa-chevron-down ml-2 text-xs"></i>
                    </button>
                    <select class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg p-2">
                        <option value="10">10</option>
                    </select>
                </div>
            </div>

            <!-- Tabla -->
            <div class="bg-white border-x border-gray-200 overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-500 uppercase border-b border-gray-200 bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap cursor-pointer">
                                <div class="flex items-center justify-between">ID <i class="fas fa-sort text-gray-300"></i></div>
                            </th>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap cursor-pointer">
                                <div class="flex items-center justify-between">PACIENTE <i class="fas fa-sort text-gray-300"></i></div>
                            </th>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap cursor-pointer">
                                <div class="flex items-center justify-between">DOCTOR <i class="fas fa-sort text-gray-300"></i></div>
                            </th>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap cursor-pointer">
                                <div class="flex items-center justify-between">FECHA <i class="fas fa-sort text-gray-300"></i></div>
                            </th>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap cursor-pointer">
                                <div class="flex items-center justify-between">HORA <i class="fas fa-sort text-gray-300"></i></div>
                            </th>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap cursor-pointer">
                                <div class="flex items-center justify-between">HORA FIN <i class="fas fa-sort text-gray-300"></i></div>
                            </th>
                            <th class="px-6 py-4 font-semibold whitespace-nowrap">
                                ESTADO
                            </th>
                            <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">
                                ACCIONES
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-900">{{ $appointment->id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $appointment->patient->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $appointment->doctor->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ $appointment->date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
                                <td class="px-6 py-4 text-gray-900">{{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-900">Programado</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button class="w-8 h-8 rounded bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center transition">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <a href="{{ route('admin.consultations', $appointment->id) }}" class="w-8 h-8 rounded bg-green-500 hover:bg-green-600 text-white flex items-center justify-center transition" title="Atender Cita">
                                            <i class="fas fa-file-alt text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    No se encontraron citas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="bg-white rounded-b-lg border border-gray-200 p-4">
                <span class="text-sm font-normal text-gray-500">Mostrando resultados</span>
            </div>
        </div>
    @endif
</div>
