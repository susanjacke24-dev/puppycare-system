<nav class="fixed top-0 z-50 w-full bg-white/70 dark:bg-emerald-950/40 backdrop-blur-2xl border-b border-white/20 dark:border-emerald-800/20 shadow-sm shadow-emerald-100/10">

    <div class="px-4 py-3 lg:px-6">

        <div class="flex items-center justify-between">

            <!-- LEFT -->
            <div class="flex items-center">

                <!-- MOBILE BUTTON -->
                <button
                    data-drawer-target="top-bar-sidebar"
                    data-drawer-toggle="top-bar-sidebar"
                    aria-controls="top-bar-sidebar"
                    type="button"
                    class="sm:hidden inline-flex items-center justify-center p-2 rounded-xl text-slate-600 hover:bg-emerald-100/70 hover:text-emerald-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-300">

                    <span class="sr-only">Open sidebar</span>

                    <svg class="w-6 h-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24">

                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-width="2"
                            d="M5 7h14M5 12h14M5 17h10" />
                    </svg>

                </button>

            </div>

            <!-- RIGHT -->
            <div class="flex items-center">

                <div class="relative">

                    <x-dropdown align="right" width="48">

                        <!-- TRIGGER -->
                        <x-slot name="trigger">

                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())

                                <button class="flex rounded-full focus:outline-none transition duration-300 hover:scale-105">

                                    <img
                                        class="h-10 w-10 rounded-full object-cover ring-2 ring-emerald-200/50 shadow-md"
                                        src="{{ Auth::user()->profile_photo_url }}"
                                        alt="{{ Auth::user()->name }}" />

                                </button>

                            @else

                                <span class="inline-flex rounded-xl">

                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/60 dark:bg-emerald-900/40 backdrop-blur-lg border border-white/20 dark:border-emerald-800/30 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-emerald-50/70 transition-all duration-300 shadow-sm">

                                        {{ Auth::user()->name }}

                                        <svg class="w-4 h-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor">

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />

                                        </svg>

                                    </button>

                                </span>

                            @endif

                        </x-slot>

                        <!-- DROPDOWN -->
                        <x-slot name="content">

                            <div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase">
                                Manage Account
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                Profile
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())

                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    API Tokens
                                </x-dropdown-link>

                            @endif

                            <div class="border-t border-slate-200 dark:border-emerald-800/30"></div>

                            <!-- LOGOUT -->
                            <form method="POST"
                                action="{{ route('logout') }}"
                                x-data>

                                @csrf

                                <x-dropdown-link
                                    href="{{ route('logout') }}"
                                    @click.prevent="$root.submit();">

                                    Log Out

                                </x-dropdown-link>

                            </form>

                        </x-slot>

                    </x-dropdown>

                </div>

            </div>

        </div>

    </div>

</nav>