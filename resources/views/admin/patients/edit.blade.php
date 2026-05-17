@php
    $errorGroups = [
        'mascota' => ['pet_name', 'species', 'breed', 'sex', 'birth_date'],
        'salud' => ['allergies', 'chronic_conditions', 'surgical_history', 'family_history'],
        'informacion-general' => ['blood_type_id', 'observations'],
        'contacto-emergencia' => [
            'emergency_contact_name',
            'emergency_contact_phone',
            'emergency_contact_relationship',
        ],
    ];

    $hasErrorMascota = $errors->hasAny($errorGroups['mascota']);
    $hasErrorSalud = $errors->hasAny($errorGroups['salud']);
    $hasErrorInfoGeneral = $errors->hasAny($errorGroups['informacion-general']);
    $hasErrorContacto = $errors->hasAny($errorGroups['contacto-emergencia']);
    $hasErrorDatos = false;

    $initialTab = 'datos-dueno';

    if ($hasErrorMascota) {
        $initialTab = 'mascota';
    } elseif ($hasErrorSalud) {
        $initialTab = 'salud';
    } elseif ($hasErrorInfoGeneral) {
        $initialTab = 'informacion-general';
    } elseif ($hasErrorContacto) {
        $initialTab = 'contacto-emergencia';
    }
@endphp

<x-admin-layout title="Mascotas" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Mascotas', 'href' => route('admin.patients.index')],
    ['name' => 'Editar'],
]">

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <x-wire-card>
            <div class="lg:flex lg:justify-between lg:items-center">
                <div class="flex items-center">
                    <img src="{{ $patient->user->profile_photo_url }}" alt="{{ $patient->owner_name }}"
                        class="w-20 h-20 rounded-full mr-4 object-cover object-center shadow-sm">
                    <div class="px-4 py-2">
                        <p class="text-2xl font-bold text-gray-900">{{ $patient->pet_display_name }}</p>
                        <span class="text-sm text-gray-500 italic">Dueño: {{ $patient->owner_name }}</span>
                    </div>
                </div>
                <div class="flex space-x-3 mt-6 lg:mt-0">
                    <x-wire-button outline gray href="{{ route('admin.patients.index') }}">Regresar</x-wire-button>
                    <x-wire-button type="submit" primary>
                        <i class="fa-solid fa-check me-2"></i>Guardar
                    </x-wire-button>
                </div>
            </div>
        </x-wire-card>

        <br>

        <x-wire-card>
            <x-tabs :active="$initialTab">
                <x-slot name="header">
                    <x-tabs-link tab="datos-dueno" :error="$hasErrorDatos">
                        <i class="fa-solid fa-user me-2"></i> Datos del dueño
                    </x-tabs-link>

                    <x-tabs-link tab="mascota" :error="$hasErrorMascota">
                        <i class="fa-solid fa-paw me-2"></i> Datos de la mascota
                    </x-tabs-link>

                    <x-tabs-link tab="salud" :error="$hasErrorSalud">
                        <i class="fa-solid fa-file-medical me-2"></i> Salud
                    </x-tabs-link>

                    <x-tabs-link tab="informacion-general" :error="$hasErrorInfoGeneral">
                        <i class="fa-solid fa-info me-2"></i> Informacion general
                    </x-tabs-link>

                    <x-tabs-link tab="contacto-emergencia" :error="$hasErrorContacto">
                        <i class="fa-solid fa-phone-alt me-2"></i> Contacto alternativo
                    </x-tabs-link>
                </x-slot>

                <x-tabs-content tab="datos-dueno">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fa-solid fa-user-gear text-blue-500 text-xl mt-1"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-blue-800">Cuenta del dueño</h3>
                                    <div class="mt-1 text-sm text-blue-600">
                                        <p><strong>Nombre, acceso y contacto del dueño</strong> se gestionan desde la cuenta de usuario.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <x-wire-button primary sm href="{{ route('admin.users.edit', $patient->user) }}" target="_blank">
                                    Editar dueño <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                                </x-wire-button>
                            </div>
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div><span class="font-semibold text-gray-600">Dueño:</span> <span class="text-sm">{{ $patient->owner_name }}</span></div>
                        <div><span class="font-semibold text-gray-600">Telefono:</span> <span class="text-sm">{{ $patient->user->phone }}</span></div>
                        <div><span class="font-semibold text-gray-600">Correo:</span> <span class="text-sm">{{ $patient->user->email }}</span></div>
                        <div><span class="font-semibold text-gray-600">Direccion:</span> <span class="text-sm">{{ $patient->user->address }}</span></div>
                    </div>
                </x-tabs-content>

                <x-tabs-content tab="mascota">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-wire-input label="Nombre de la mascota" name="pet_name" value="{{ old('pet_name', $patient->pet_name) }}" />
                        <x-wire-input label="Especie" name="species" placeholder="Ej. Perro, gato, conejo" value="{{ old('species', $patient->species) }}" />
                        <x-wire-input label="Raza" name="breed" placeholder="Ej. Labrador, mestizo" value="{{ old('breed', $patient->breed) }}" />
                        <x-wire-native-select label="Sexo" name="sex">
                            <option value="">Selecciona...</option>
                            <option value="Macho" @selected(old('sex', $patient->sex) === 'Macho')>Macho</option>
                            <option value="Hembra" @selected(old('sex', $patient->sex) === 'Hembra')>Hembra</option>
                            <option value="No especificado" @selected(old('sex', $patient->sex) === 'No especificado')>No especificado</option>
                        </x-wire-native-select>
                        <x-wire-input label="Fecha de nacimiento aproximada" name="birth_date" type="date" value="{{ old('birth_date', optional($patient->birth_date)->format('Y-m-d')) }}" />
                    </div>
                </x-tabs-content>

                <x-tabs-content tab="salud">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-wire-textarea label="Alergias conocidas" name="allergies">{{ old('allergies', $patient->allergies) }}</x-wire-textarea>
                        <x-wire-textarea label="Condiciones cronicas o recurrentes" name="chronic_conditions">{{ old('chronic_conditions', $patient->chronic_conditions) }}</x-wire-textarea>
                        <x-wire-textarea label="Cirugias o procedimientos previos" name="surgical_history">{{ old('surgical_history', $patient->surgical_history) }}</x-wire-textarea>
                        <x-wire-textarea label="Antecedentes relevantes" name="family_history">{{ old('family_history', $patient->family_history) }}</x-wire-textarea>
                    </div>
                </x-tabs-content>

                <x-tabs-content tab="informacion-general">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-wire-native-select label="Tipo de sangre de la mascota" name="blood_type_id">
                            <option value="">Selecciona...</option>
                            @foreach ($bloodTypes as $bloodType)
                                <option value="{{ $bloodType->id }}" @selected(old('blood_type_id', $patient->blood_type_id) == $bloodType->id)>
                                    {{ $bloodType->name }}
                                </option>
                            @endforeach
                        </x-wire-native-select>
                        <div class="md:col-span-2">
                            <x-wire-textarea label="Observaciones del expediente" name="observations" rows="4">{{ old('observations', $patient->observations) }}</x-wire-textarea>
                        </div>
                    </div>
                </x-tabs-content>

                <x-tabs-content tab="contacto-emergencia">
                    <div class="grid md:grid-cols-2 gap-4">
                        <x-wire-input label="Nombre del contacto alternativo" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" />
                        <x-wire-phone label="Telefono" name="emergency_contact_phone" mask="(###) ###-####" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}" />
                        <div class="md:col-span-2">
                            <x-wire-input label="Relacion con el dueño" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}" />
                        </div>
                    </div>
                </x-tabs-content>
            </x-tabs>
        </x-wire-card>
    </form>
</x-admin-layout>
