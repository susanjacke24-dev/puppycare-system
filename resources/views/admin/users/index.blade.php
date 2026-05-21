<x-admin-layout title="Usuarios" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
    ],
]">

    <x-slot name="action">

        <x-wire-button
            blue
            href="{{ route('admin.users.create') }}">

            <i class="fa-solid fa-plus"></i>

            Nuevo

        </x-wire-button>

    </x-slot>

    <div class="relative">

        {{-- TABLA --}}
        @livewire('admin.datatables.user-table')

        {{-- MENSAJE CUANDO NO EXISTEN RESULTADOS --}}
        @if(request()->has('table-search') && request('table-search') !== '')

            @if(
                \App\Models\User::where('name', 'like', '%' . request('table-search') . '%')
                    ->orWhere('email', 'like', '%' . request('table-search') . '%')
                    ->orWhere('id_number', 'like', '%' . request('table-search') . '%')
                    ->count() === 0
            )

                <div class="flex flex-col items-center justify-center py-16">

                    <div class="w-24 h-24 rounded-3xl bg-emerald-100/80 flex items-center justify-center shadow-inner">

                        <i class="fa-solid fa-magnifying-glass text-4xl text-emerald-500"></i>

                    </div>

                    <h2 class="mt-6 text-2xl font-bold text-slate-700 dark:text-white">
                        Usuario no encontrado
                    </h2>

                    <p class="mt-2 text-slate-400 dark:text-slate-500">
                        No existen coincidencias para esa búsqueda.
                    </p>

                </div>

            @endif

        @endif

    </div>

</x-admin-layout>