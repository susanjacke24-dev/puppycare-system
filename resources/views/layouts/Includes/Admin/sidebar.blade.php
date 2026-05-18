@php
use Illuminate\Support\Str;

$links = [

    [
        'name' => 'Sobre Nosotros',
        'icon' => 'fa-solid fa-gauge',
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
      'active' => request()->routeIs('admin.appointments.*') || request()->routeIs('admin.consultations.*'),
    ],


];
@endphp


<aside id="top-bar-sidebar"
   class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0"
   aria-label="Sidebar">

   <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default">

      <!-- LOGO (TU VERSIÓN ORIGINAL, SIN CAMBIOS) -->
      <a href="/" class="flex items-center ps-2.5 mb-5">
         <img src="{{ asset('images/logoveterinaria.jpg') }}" class="h-6 me-3" alt="Flowbite Logo" />
         <span class="self-center text-lg text-heading font-semibold whitespace-nowrap">
            PuppyCare
         </span>
      </a>

      <ul class="space-y-2 font-medium">

         @foreach ($links as $link)
         <li>

            {{-- HEADER --}}
            @isset($link['header'])
               <div class="px-2 py-2 text-xs font-semibold text-gray-500 uppercase">
                  {{ $link['header'] }}
               </div>

            {{-- SUBMENU --}}
            @elseif(isset($link['submenu']))

               @php
                  $dropdownId = 'dropdown-' . Str::slug($link['name']);
                  $isOpen = collect($link['submenu'])->contains('active', true);
               @endphp

               <button type="button"
                  class="flex items-center w-full justify-between px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group"
                  data-collapse-toggle="{{ $dropdownId }}"
                  aria-controls="{{ $dropdownId }}">

                  <div class="flex items-center">
                     <span class="w-6 h-6 inline-flex items-center justify-center text-gray-500">
                        <i class="{{ $link['icon'] }}"></i>
                     </span>
                     <span class="ms-3 whitespace-nowrap">
                        {{ $link['name'] }}
                     </span>
                  </div>

                  <svg class="w-5 h-5 transition-transform {{ $isOpen ? 'rotate-180' : '' }}"
                     fill="none" viewBox="0 0 24 24">
                     <path stroke="currentColor"
                           stroke-linecap="round"
                           stroke-linejoin="round"
                           stroke-width="2"
                           d="m19 9-7 7-7-7"/>
                  </svg>
               </button>

               <ul id="{{ $dropdownId }}"
                  class="{{ $isOpen ? '' : 'hidden' }} py-2 space-y-2">

                  @foreach ($link['submenu'] as $sublink)
                     <li>
                        <a href="{{ $sublink['href'] }}"
                           class="flex items-center w-full p-2 pl-11 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand
                           {{ $sublink['active'] ? 'bg-gray-100 font-semibold' : '' }}">
                           {{ $sublink['name'] }}
                        </a>
                     </li>
                  @endforeach

               </ul>

            {{-- LINK NORMAL --}}
          {{-- LINK NORMAL --}}
@else

<a href="{{ $link['href'] }}"
   class="flex items-center w-full px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group
   {{ $link['active'] ? 'bg-gray-100 font-semibold' : '' }}">

    <span class="w-6 h-6 inline-flex items-center justify-center text-gray-500">
        <i class="{{ $link['icon'] }}"></i>
    </span>

    <span class="ms-3 whitespace-nowrap">
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
