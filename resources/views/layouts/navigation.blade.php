<nav x-data="{ open: false }" class="bg-brand-navy border-b border-white/10 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> {{-- Increased height for prestige --}}
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center py-2">
                        <x-application-logo class="block h-16 w-auto max-w-[200px] transition-transform hover:scale-105 brightness-0 invert" />
                    </a>
                    <div class="hidden md:block h-10 w-px bg-white/20 ms-6"></div>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    {{-- Dashboard: Matches the generic landing OR the role-specific dashboards --}}
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('*.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(auth()->user()->role === 'admin')
                    {{-- Admin Scholarships --}}
                    <x-nav-link :href="route('admin.scholarships.index')" :active="request()->routeIs('admin.scholarships.*')">
                        {{ __('Scholarships') }}
                    </x-nav-link>

                    {{-- Admin Applications --}}
                    <x-nav-link :href="route('admin.applications.index')" :active="request()->routeIs('admin.applications.*')">
                        {{ __('Applications') }}
                    </x-nav-link>

                    {{-- Admin Announcements --}}
                    <x-nav-link :href="route('admin.announcements.index')" :active="request()->routeIs('admin.announcements.*')">
                        {{ __('Announcements') }}
                    </x-nav-link>

                    @elseif(auth()->user()->role === 'student')
                    {{-- Student Portfolio --}}
                    <x-nav-link :href="route('student.applications.index')" :active="request()->routeIs('student.applications.*')">
                        {{ __('Applications') }}
                    </x-nav-link>

                    {{-- Student Available Scholarships --}}
                    <x-nav-link :href="route('student.scholarships.index')" :active="request()->routeIs('student.scholarships.*')">
                        {{ __('Scholarships') }}
                    </x-nav-link>

                    {{-- Student Announcements --}}
                    <x-nav-link :href="route('student.announcements.index')" :active="request()->routeIs('student.announcements.*')">
                        {{ __('Announcements') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-white/20 text-xs leading-4 font-bold rounded-none text-white bg-transparent hover:bg-white/10 focus:outline-none transition ease-in-out duration-150 uppercase tracking-widest">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="rounded-none border-neutral-divider">
                            <x-dropdown-link :href="route('profile.edit')" class="text-xs uppercase font-bold tracking-widest">
                                {{ __('My Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                    class="text-xs uppercase font-bold tracking-widest text-brand-crimson">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-none text-white hover:bg-white/10 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-brand-navy border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-white/10">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            {{-- ... Other responsive links follow the same pattern ... --}}
        </div>
    </div>
</nav>