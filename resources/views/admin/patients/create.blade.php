<x-admin-layout title="Mascotas" :breadcrumbs="[
    ['name' => 'Dashboard', 'href' => route('admin.dashboard')],
    ['name' => 'Mascotas', 'href' => route('admin.patients.index')],
    ['name' => 'Crear'],
]">
    <form action="{{ route('admin.patients.store') }}" method="POST" novalidate>
        @csrf

        <x-wire-card>
            <div class="lg:flex lg:justify-between lg:items-center">
                <div>
                    <p class="text-2xl font-bold text-gray-900">Registrar mascota</p>
                    <p class="text-sm text-gray-500 mt-1">Selecciona un dueño existente del módulo Usuarios y completa los datos de la mascota.</p>
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

        @if($owners->isEmpty())
            <x-wire-card>
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-lg">
                    <h3 class="text-sm font-bold text-yellow-800">No hay dueños registrados</h3>
                    <p class="mt-1 text-sm text-yellow-700">Primero registra un usuario con rol Dueño/Paciente para poder asociarle una mascota.</p>
                    <div class="mt-4">
                        <x-wire-button yellow href="{{ route('admin.users.create') }}">
                            <i class="fa-solid fa-user-plus me-2"></i>Registrar dueño
                        </x-wire-button>
                    </div>
                </div>
            </x-wire-card>
        @else
            <x-wire-card>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <x-wire-native-select label="Dueño registrado" name="user_id" :required="true">
                            <option value="">Selecciona un dueño...</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" @selected(old('user_id') == $owner->id)>
                                    {{ $owner->name }} - {{ $owner->email }} - {{ $owner->phone }}
                                </option>
                            @endforeach
                        </x-wire-native-select>
                    </div>

                    <x-wire-input label="Nombre de la mascota" name="pet_name" :required="true" value="{{ old('pet_name') }}" />
                    <x-wire-input label="Especie" name="species" :required="true" placeholder="Ej. Perro, gato, conejo" value="{{ old('species') }}" />
                    <x-wire-input label="Raza" name="breed" placeholder="Ej. Labrador, mestizo" value="{{ old('breed') }}" />
                    <x-wire-native-select label="Sexo" name="sex">
                        <option value="">Selecciona...</option>
                        <option value="Macho" @selected(old('sex') === 'Macho')>Macho</option>
                        <option value="Hembra" @selected(old('sex') === 'Hembra')>Hembra</option>
                        <option value="No especificado" @selected(old('sex') === 'No especificado')>No especificado</option>
                    </x-wire-native-select>
                    <x-wire-input label="Fecha de nacimiento aproximada" name="birth_date" type="date" value="{{ old('birth_date') }}" />

                    

                    <x-wire-textarea label="Alergias conocidas" name="allergies">{{ old('allergies') }}</x-wire-textarea>
                    <x-wire-textarea label="Condiciones cronicas o recurrentes" name="chronic_conditions">{{ old('chronic_conditions') }}</x-wire-textarea>
                    <x-wire-textarea label="Cirugias o procedimientos previos" name="surgical_history">{{ old('surgical_history') }}</x-wire-textarea>
                    <x-wire-textarea label="Antecedentes relevantes" name="family_history">{{ old('family_history') }}</x-wire-textarea>

                    <div class="md:col-span-2">
                        <x-wire-textarea label="Observaciones del expediente" name="observations" rows="4">{{ old('observations') }}</x-wire-textarea>
                    </div>

                    <x-wire-input label="Nombre del contacto alternativo" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" />
                    <x-wire-phone label="Telefono alternativo" name="emergency_contact_phone" mask="(###) ###-####" value="{{ old('emergency_contact_phone') }}" />
                    <div class="md:col-span-2">
                        <x-wire-input label="Relacion con el dueño" name="emergency_contact_relationship" value="{{ old('emergency_contact_relationship') }}" />
                    </div>
                </div>
            </x-wire-card>
        @endif
    </form>
</x-admin-layout>
