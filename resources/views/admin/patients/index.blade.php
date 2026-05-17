<x-admin-layout title="Mascotas" :breadcrumbs="[
    [
      'name' => 'Dashboard', 
    'href' => route('admin.dashboard')
    ],
    
    ['name' => 'Mascotas'],
]">

  @livewire('admin.datatables.patient-table')
    
</x-admin-layout>
