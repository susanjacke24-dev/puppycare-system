@props([
    'title' => config('app.name', 'Vitalia'), 
    'breadcrumbs' =>[] 
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire -->
    @livewireStyles

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/6244811c40.js" crossorigin="anonymous"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- WireUI -->
    <wireui:scripts />
</head>

<body class="font-sans antialiased bg-gradient-to-br from-slate-100 via-green-50 to-white dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 text-slate-800 dark:text-slate-100">

@include('layouts.includes.Admin.navigation')
@include('layouts.includes.Admin.sidebar')

<div class="p-6 sm:ml-64 mt-14 min-h-screen transition-all duration-300">
    <div class="mt-10 mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        @include('layouts.includes.Admin.breadcrumb')

        @isset($action)
            <div>
                {{ $action }}
            </div>
        @endisset
    </div>

    {{ $slot }}
</div>

@stack('modals')


@if(session('swal'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: "{{ session('swal.icon') }}",
        title: "{{ session('swal.title') }}",
        text: "{{ session('swal.text') }}",
    });
});
</script>
@endif

@livewireScripts


<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.delete-form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

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
                    form.submit();
                }
            });
        });
    });
});
</script>

{{-- Flowbite --}}
<script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

</body>
</html>

