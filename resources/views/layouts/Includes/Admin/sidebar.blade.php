@php
use Illuminate\Support\Str;

$links = [

    [
        'name' => 'Sobre Nosotros',
        'icon' => 'fa-solid fa-circle-info',
        'href' => route('admin.dashboard'),
        'active' => request()->routeIs('admin.dashboard'),
    ],

    [
        'header' => 'Gestión',
    ],

    [
        'name' => 'Roles y permisos',
        'icon' => 'fa-solid fa-shield-halved',
        'href' => route('admin.roles.index'),
        'active' => request()->routeIs('admin.roles.*')
    ],

    [
        'name' => 'Usuarios',
        'icon' => 'fa-solid fa-users',
        'href' => route('admin.users.index'),
        'active' => request()->routeIs('admin.user.*'),
    ],

    [
        'name' => 'Mascotas',
        'icon' => 'fa-solid fa-paw',
        'href' => route('admin.patients.index'),
        'active' => request()->routeIs('admin.patients.*'),
    ],

    [
        'name' => 'Veterinarios',
        'icon' => 'fa-solid fa-user-md',
        'href' => route('admin.doctors.index'),
        'active' => request()->routeIs('admin.doctors.*'),
    ],

    [
        'name' => 'Citas veterinarias',
        'icon' => 'fa-solid fa-calendar-check',
        'href' => route('admin.appointments.index'),
        'active' => request()->routeIs('admin.appointments.*')
            || request()->routeIs('admin.consultations.*'),
    ],

];
@endphp

<aside
    id="top-bar-sidebar"
    class="fixed top-0 left-0 z-50 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">

    <div class="h-full overflow-y-auto px-4 pt-6 pb-5
        bg-white/70 dark:bg-emerald-950/40
        backdrop-blur-2xl
        border-r border-white/20 dark:border-emerald-800/30
        shadow-2xl shadow-emerald-100/10">

        <!-- LOGO -->
        <a href="/"
           class="flex items-center gap-3 mb-10 group">

            <img
                src="{{ asset('images/logoveterinaria.jpg') }}"
                class="h-14 w-14 object-cover rounded-2xl shadow-lg transition-all duration-300 group-hover:scale-105"
                alt="PuppyCare Logo" />

            <span class="text-3xl font-bold tracking-tight text-slate-800 dark:text-white">
                PuppyCare
            </span>

        </a>

        <!-- MENÚ -->
        <ul class="space-y-3 font-medium">

            @foreach ($links as $link)

                <li>

                    {{-- HEADER --}}
                    @isset($link['header'])

                        <div class="px-2 pt-5 pb-2 text-xs font-bold tracking-[0.2em] uppercase text-emerald-700/70 dark:text-emerald-300/70">
                            {{ $link['header'] }}
                        </div>

                    {{-- SUBMENU --}}
                    @elseif(isset($link['submenu']))

                        @php
                            $dropdownId = 'dropdown-' . Str::slug($link['name']);
                            $isOpen = collect($link['submenu'])->contains('active', true);
                        @endphp

                        <button
                            type="button"
                            class="flex items-center justify-between w-full px-4 py-3 rounded-2xl transition-all duration-300
                            hover:bg-white/60 hover:shadow-lg hover:shadow-emerald-100/20
                            text-slate-700 dark:text-slate-200"
                            data-collapse-toggle="{{ $dropdownId }}"
                            aria-controls="{{ $dropdownId }}">

                            <div class="flex items-center gap-4">

                                <span class="w-11 h-11 flex items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 shadow-sm">

                                    <i class="{{ $link['icon'] }} text-sm"></i>

                                </span>

                                <span class="font-medium">
                                    {{ $link['name'] }}
                                </span>

                            </div>

                            <svg
                                class="w-5 h-5 transition-transform {{ $isOpen ? 'rotate-180' : '' }}"
                                fill="none"
                                viewBox="0 0 24 24">

                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m19 9-7 7-7-7"/>

                            </svg>

                        </button>

                        <ul
                            id="{{ $dropdownId }}"
                            class="{{ $isOpen ? '' : 'hidden' }} py-2 space-y-2">

                            @foreach ($link['submenu'] as $sublink)

                                <li>

                                    <a
                                        href="{{ $sublink['href'] }}"
                                        class="flex items-center w-full pl-16 pr-4 py-2 rounded-xl text-sm transition-all duration-300
                                        {{ $sublink['active']
                                            ? 'bg-emerald-100/70 text-emerald-700 font-semibold'
                                            : 'hover:bg-white/60 text-slate-600 dark:text-slate-300'
                                        }}">

                                        {{ $sublink['name'] }}

                                    </a>

                                </li>

                            @endforeach

                        </ul>

                    {{-- LINK NORMAL --}}
                    @else

                        <a
                            href="{{ $link['href'] }}"
                            class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-300 group
                            {{ $link['active']
                                ? 'bg-emerald-100/70 text-emerald-700 shadow-md shadow-emerald-200/30'
                                : 'hover:bg-white/60 hover:shadow-lg hover:shadow-emerald-100/20 text-slate-700 dark:text-slate-200'
                            }}">

                            <span class="w-11 h-11 flex items-center justify-center rounded-2xl
                                bg-emerald-50 text-emerald-600 shadow-sm
                                transition-all duration-300
                                group-hover:scale-110 group-hover:-translate-y-0.5">

                                <i class="{{ $link['icon'] }} text-sm"></i>

                            </span>

                            <span class="font-medium whitespace-nowrap">
                                {{ $link['name'] }}
                            </span>

                        </a>

                    @endisset

                </li>

            @endforeach

        </ul>

    </div>

</aside>

<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/7c9a7ad4c0.js" crossorigin="anonymous"></script>

<!-- Flowbite -->
<script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>