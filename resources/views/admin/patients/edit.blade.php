@php
    $errorGroups = [
        'mascota' => ['pet_name', 'species', 'breed', 'sex', 'birth_date'],
        'historial-veterinario' => [
            'allergies',
            'chronic_conditions',
            'surgical_history',
            'family_history'
        ],
        'control-veterinario' => [
            'observations'
        ],
        'contacto-emergencia' => [
            'emergency_contact_name',
            'emergency_contact_phone',
            'emergency_contact_relationship',
        ],
    ];

    $hasErrorMascota = $errors->hasAny($errorGroups['mascota']);
    $hasErrorHistorial = $errors->hasAny($errorGroups['historial-veterinario']);
    $hasErrorControl = $errors->hasAny($errorGroups['control-veterinario']);
    $hasErrorContacto = $errors->hasAny($errorGroups['contacto-emergencia']);
    $hasErrorDatos = false;

    $initialTab = 'datos-dueno';

    if ($hasErrorMascota) {
        $initialTab = 'mascota';
    } elseif ($hasErrorHistorial) {
        $initialTab = 'historial-veterinario';
    } elseif ($hasErrorControl) {
        $initialTab = 'control-veterinario';
    } elseif ($hasErrorContacto) {
        $initialTab = 'contacto-emergencia';
    }
@endphp

<x-admin-layout title="Mascotas" :breadcrumbs="[
    ['name' => 'Panel principal', 'href' => route('admin.dashboard')],
    ['name' => 'Mascotas', 'href' => route('admin.patients.index')],
    ['name' => 'Editar expediente'],
]">

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <x-wire-card>
            <div class="lg:flex lg:justify-between lg:items-center">

                <div class="flex items-center">

                    {{-- FOTO DE LA MASCOTA --}}
                    <div class="relative">

                     <img
                        src="{{ $patient->photo_url }}"
                        alt="{{ $patient->pet_display_name }}"
                        class="w-24 h-24 rounded-2xl object-cover object-center shadow-md border border-gray-200">

                        <label
                         for="photo"
                         class="absolute bottom-0 right-0 bg-cyan-500 hover:bg-cyan-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-md transition cursor-pointer">

                         <i class="fa-solid fa-camera text-sm"></i>
                        </label>

                         <input
                         type="file"
                         name="photo"
                         id="photo"
                         accept="image/*"
                         class="mt-3 block w-full text-sm text-gray-600
                         file:mr-4 file:py-2 file:px-4
                         file:rounded-xl file:border-0
                         file:text-sm file:font-semibold
                         file:bg-cyan-50 file:text-cyan-700
                         hover:file:bg-cyan-100">

                    </div>
                    

                    <div class="px-5 py-2">
                        <p class="text-3xl font-bold text-gray-900">
                            {{ $patient->pet_display_name }}
                        </p>

                        <div class="mt-2 flex items-center gap-2">
                            <span class="bg-cyan-100 text-cyan-700 text-xs px-3 py-1 rounded-full font-semibold">
                                {{ $patient->species ?: 'Especie no registrada' }}
                            </span>

                            <span class="bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full">
                                {{ $patient->breed ?: 'Raza no registrada' }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-500 italic mt-2">
                            Propietario: {{ $patient->owner_name }}
                        </p>
                    </div>
                </div>

                <div class="flex space-x-3 mt-6 lg:mt-0">

                    <x-wire-button
                        outline
                        gray
                        href="{{ route('admin.patients.index') }}">

                        Regresar
                    </x-wire-button>

                    <x-wire-button
                        type="submit"
                        primary>

                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        Guardar expediente
                    </x-wire-button>

                </div>
            </div>
        </x-wire-card>

        <br>

        <x-wire-card>

            <x-tabs :active="$initialTab">

                <x-slot name="header">

                    <x-tabs-link tab="datos-dueno" :error="$hasErrorDatos">
                        <i class="fa-solid fa-user me-2"></i>
                        Propietario
                    </x-tabs-link>

                    <x-tabs-link tab="mascota" :error="$hasErrorMascota">
                        <i class="fa-solid fa-paw me-2"></i>
                        Perfil mascota
                    </x-tabs-link>

                    <x-tabs-link tab="historial-veterinario" :error="$hasErrorHistorial">
                        <i class="fa-solid fa-notes-medical me-2"></i>
                        Historial veterinario
                    </x-tabs-link>

                    <x-tabs-link tab="control-veterinario" :error="$hasErrorControl">
                        <i class="fa-solid fa-heart-pulse me-2"></i>
                        Control veterinario
                    </x-tabs-link>

                    <x-tabs-link tab="contacto-emergencia" :error="$hasErrorContacto">
                        <i class="fa-solid fa-phone-volume me-2"></i>
                        Emergencia
                    </x-tabs-link>

                </x-slot>

                {{-- PROPIETARIO --}}
                <x-tabs-content tab="datos-dueno">

                    <div class="bg-cyan-50 border-l-4 border-cyan-500 p-4 mb-6 rounded-r-lg shadow-sm">

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">

                            <div class="flex items-start">

                                <div class="flex-shrink-0">
                                    <i class="fa-solid fa-user-gear text-cyan-600 text-xl mt-1"></i>
                                </div>

                                <div class="ml-3">

                                    <h3 class="text-sm font-bold text-cyan-800">
                                        Cuenta del propietario
                                    </h3>

                                    <div class="mt-1 text-sm text-cyan-700">

                                        <p>
                                            La información de acceso y contacto
                                            del propietario se administra desde
                                            el módulo de usuarios.
                                        </p>

                                    </div>
                                </div>
                            </div>

                            <div class="flex-shrink-0">

                                <x-wire-button
                                    primary
                                    sm
                                    href="{{ route('admin.users.edit', $patient->user) }}"
                                    target="_blank">

                                    Editar propietario
                                    <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>

                                </x-wire-button>

                            </div>
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-2 gap-4">

                        <div>
                            <span class="font-semibold text-gray-600">Propietario:</span>
                            <span class="text-sm">{{ $patient->owner_name }}</span>
                        </div>

                        <div>
                            <span class="font-semibold text-gray-600">Teléfono:</span>
                            <span class="text-sm">{{ $patient->user->phone }}</span>
                        </div>

                        <div>
                            <span class="font-semibold text-gray-600">Correo:</span>
                            <span class="text-sm">{{ $patient->user->email }}</span>
                        </div>

                        <div>
                            <span class="font-semibold text-gray-600">Dirección:</span>
                            <span class="text-sm">{{ $patient->user->address }}</span>
                        </div>

                    </div>

                </x-tabs-content>

                {{-- PERFIL MASCOTA --}}
                <x-tabs-content tab="mascota">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <x-wire-input
                            label="Nombre de la mascota"
                            name="pet_name"
                            value="{{ old('pet_name', $patient->pet_name) }}" />

                        <x-wire-input
                            label="Especie"
                            name="species"
                            placeholder="Ej. Perro, gato, conejo"
                            value="{{ old('species', $patient->species) }}" />

                        <x-wire-input
                            label="Raza"
                            name="breed"
                            placeholder="Ej. Labrador, siamés, mestizo"
                            value="{{ old('breed', $patient->breed) }}" />

                        <x-wire-native-select
                            label="Sexo"
                            name="sex">

                            <option value="">Selecciona...</option>

                            <option value="Macho"
                                @selected(old('sex', $patient->sex) === 'Macho')>
                                Macho
                            </option>

                            <option value="Hembra"
                                @selected(old('sex', $patient->sex) === 'Hembra')>
                                Hembra
                            </option>

                        </x-wire-native-select>

                        <x-wire-input
                            label="Fecha aproximada de nacimiento"
                            name="birth_date"
                            type="date"
                            value="{{ old('birth_date', optional($patient->birth_date)->format('Y-m-d')) }}" />

                    </div>

                </x-tabs-content>

                {{-- HISTORIAL VETERINARIO --}}
                <x-tabs-content tab="historial-veterinario">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <x-wire-textarea
                            label="Alergias conocidas"
                            name="allergies">

                            {{ old('allergies', $patient->allergies) }}

                        </x-wire-textarea>

                        <x-wire-textarea
                            label="Enfermedades o padecimientos recurrentes"
                            name="chronic_conditions">

                            {{ old('chronic_conditions', $patient->chronic_conditions) }}

                        </x-wire-textarea>

                        <x-wire-textarea
                            label="Cirugías, esterilizaciones o tratamientos"
                            name="surgical_history">

                            {{ old('surgical_history', $patient->surgical_history) }}

                        </x-wire-textarea>

                        <x-wire-textarea
                            label="Observaciones veterinarias importantes"
                            name="family_history">

                            {{ old('family_history', $patient->family_history) }}

                        </x-wire-textarea>

                    </div>

                </x-tabs-content>

                {{-- CONTROL VETERINARIO --}}
                <x-tabs-content tab="control-veterinario">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <x-wire-input
                            label="Peso actual (kg)"
                            name="weight"
                            placeholder="Ej. 12.5 kg" />

                        <x-wire-native-select
                            label="Esterilizado/a"
                            name="sterilized">

                            <option value="">Selecciona...</option>
                            <option value="Si">Sí</option>
                            <option value="No">No</option>

                        </x-wire-native-select>

                        <div class="md:col-span-2">

                            <x-wire-textarea
                                label="Vacunas aplicadas"
                                name="vaccines"
                                rows="4">

                            </x-wire-textarea>

                        </div>

                        <div class="md:col-span-2">

                            <x-wire-textarea
                                label="Observaciones del expediente"
                                name="observations"
                                rows="4">

                                {{ old('observations', $patient->observations) }}

                            </x-wire-textarea>

                        </div>

                    </div>

                </x-tabs-content>

                {{-- CONTACTO --}}
                <x-tabs-content tab="contacto-emergencia">

                    <div class="grid md:grid-cols-2 gap-4">

                        <x-wire-input
                            label="Nombre del contacto alternativo"
                            name="emergency_contact_name"
                            value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" />

                        <x-wire-phone
                            label="Teléfono"
                            name="emergency_contact_phone"
                            mask="(###) ###-####"
                            value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" />

                        <div class="md:col-span-2">

                            <x-wire-input
                                label="Relación con el propietario"
                                name="emergency_contact_relationship"
                                value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}" />

                        </div>

                    </div>

                </x-tabs-content>

            </x-tabs>

        </x-wire-card>

    </form>

</x-admin-layout>