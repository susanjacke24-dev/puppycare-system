<x-admin-layout title="Mascotas" :breadcrumbs="[
    [
      'name' => 'Dashboard', 
    'href' => route('admin.dashboard')
    ],
    
    ['name' => 'Mascotas'],
]">
  <x-slot name="action">
      <x-wire-button blue href="{{ route('admin.patients.create') }}">
          <i class="fa-solid fa-plus"></i>
          Nuevo
      </x-wire-button>
  </x-slot>

  @livewire('admin.datatables.patient-table')
    
</x-admin-layout>
