<div class="p-6 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Breadcrumb & Title -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Dashboard / Horarios / Gestión</p>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Horarios - Vet. {{ $doctor->name }}</h2>
        </div>
        <a href="{{ route('admin.doctors.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 transition">
            <i class="fas fa-arrow-left mr-2"></i> Volver a veterinarios
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Formulario para Añadir Nuevo Turno -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 border-b pb-2 dark:border-gray-700">
                    <i class="fas fa-plus-circle mr-2 text-blue-600"></i> Añadir Turno Laboral
                </h3>
                
                <form wire:submit.prevent="addRange" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Día de la Semana</label>
                        <select wire:model="new_day" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @foreach($days as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hora Inicio</label>
                            <input type="time" wire:model="new_start" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @error('new_start') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hora Fin</label>
                            <input type="time" wire:model="new_end" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @error('new_end') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            Registrar Turno
                        </button>
                    </div>
                </form>

                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg text-xs text-blue-700 dark:text-blue-300">
                    <p class="font-bold mb-1"><i class="fas fa-info-circle mr-1"></i> Tip:</p>
                    Puedes registrar múltiples turnos para un mismo día (ej: turno mañana y turno tarde).
                </div>
            </div>
        </div>

        <!-- Visualización de la Agenda Semanal -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Configuración Actual</h3>
                </div>

                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($days as $day)
                        <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                            <div class="w-32">
                                <span class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">{{ $day }}</span>
                            </div>
                            
                            <div class="flex-1 flex flex-wrap gap-2">
                                @if(isset($schedules[$day]))
                                    @foreach($schedules[$day] as $range)
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 group">
                                            <i class="fas fa-clock mr-2 text-xs opacity-70"></i>
                                            {{ \Carbon\Carbon::parse($range['start_time'])->format('h:i A') }} - {{ \Carbon\Carbon::parse($range['end_time'])->format('h:i A') }}
                                            <button wire:click="removeRange({{ $range['id'] }})" class="ml-2 hover:text-red-600 transition-colors">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-sm text-gray-400 italic">No labora este día</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Agenda Veterinaria -->
<div class="mt-8 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">

    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-700">

        <h3 class="text-lg font-bold text-gray-900 dark:text-white">

            <i class="fas fa-calendar-alt mr-2 text-cyan-600"></i>

            Agenda veterinaria

        </h3>

        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Citas registradas para este veterinario.
        </p>

    </div>

    <div class="divide-y divide-gray-200 dark:divide-gray-700">

        @forelse($appointments as $appointment)

            <div class="p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">

                <div>

                    <p class="font-bold text-gray-900 dark:text-white">

                        {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}

                    </p>

                    <p class="text-cyan-700 dark:text-cyan-400 font-medium">

                        {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}

                    </p>

                </div>

                <div class="flex-1">

                    <p class="font-semibold text-gray-800 dark:text-white">

                        {{ $appointment->patient->pet_name ?? 'Mascota sin nombre' }}

                    </p>

                    <p class="text-sm text-gray-500 dark:text-gray-400">

                        Propietario:
                        {{ $appointment->patient->user->name ?? 'No registrado' }}

                    </p>

                </div>

                <div>

    @if($appointment->status == 0)

        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300">

            Pendiente

        </span>

    @elseif($appointment->status == 1)

        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300">

            Confirmada

        </span>

    @elseif($appointment->status == 2)

        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">

            Completada

        </span>

    @elseif($appointment->status == 3)

        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300">

            Cancelada

        </span>

    @else

        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300">

            Desconocido

        </span>

    @endif

</div>

            </div>

        @empty

            <div class="p-8 text-center text-gray-500 dark:text-gray-400">

                <i class="fas fa-calendar-times text-3xl mb-3 opacity-50"></i>

                <p>
                    No hay citas registradas para este veterinario.
                </p>

            </div>

        @endforelse

    </div>

</div>
</div>
