<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('root') }}">
                        <x-app-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
                

                <!-- Navigation Links -->
                @auth

                    @if (auth()->user()->isAdmin())

                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('admin.gestionnaires.index')" :active="request()->routeIs('admin.gestionnaires.index')">
                                {{ __('List of Managers') }}
                            </x-nav-link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('admin.gestionnaires.create')" :active="request()->routeIs('admin.gestionnaires.create')">
                                {{ __('Add a Manager') }}
                            </x-nav-link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('admin.gestionnaires.requests')" 
                            :active="request()->routeIs('admin.gestionnaires.requests')">
                                {{ __('Manager Requests') }}
                            </x-nav-link>
                        </div>
                    @else
                    @if (auth()->user()->isGestionnaire())
                    {{--  <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('gestionnaire.dashboard')" :active="request()->routeIs('gestionnaire.dashboard')">
                                {{ __('Home') }}
                            </x-nav-link>
                        </div> --}}
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('gestionnaire.infrastructure.index')" :active="request()->routeIs('gestionnaire.infrastructure.index')">
                                {{ __('My Infrastructures') }}
                            </x-nav-link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('gestionnaire.infrastructure.create')" :active="request()->routeIs('gestionnaire.infrastructure.create')">
                                {{ __('Add an infrastructure') }}
                            </x-nav-link>
                        </div>

                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('gestionnaire.reservations.requests')" :active="request()->routeIs('gestionnaire.reservations.requests')">
                                {{ __('Reservation Requests') }}
                            </x-nav-link>
                        </div>    
                    @else
                    @if (auth()->user()->isClient())
                        {{-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                        </div> --}}
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('infrastructure.index')" :active="request()->routeIs('infrastructure.index')">
                                {{ __('List of Infrastructures') }}
                            </x-nav-link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.index')">
                                {{ __('My Reservations') }}
                            </x-nav-link>
                        </div>
                    @endif
                    @endif
                    @endif
                @endauth
            </div>

            

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                @if (App\Models\Notification::unreadCount() > 0)
                                    <span class="me-1 rounded-full size-2 inline-block text-center  font-semibold bg-red-500 text-white">  </span>
                                @endif
                                <div class="capitalize">{{ Auth::user()->nom.' '.Auth::user()->prenom }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">

                            <x-dropdown-link :href="route('notifications')">
                                {{ __('Notifications') }}
                                @if (app\Models\Notification::unreadCount() > 0)
                                    <span class="float-end">
                                        <span class="ms-1 rounded-full size-5 inline-block text-center font-semibold bg-red-500 text-white"> {{app\Models\Notification::unreadCount()}} </span>
                                    </span>
                                @endif
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="mx-4">

                        <a href="{{ route('login') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">Log in</a>
                        <a href="{{ route('register') }}" class="ms-4 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:bg-blue-500 focus:border-blue-700 active:bg-blue-700 transition ease-in-out duration-150">Sign up</a>
                    </div>
                @endauth
                <!-- Dark Mode -->
                <div class="flex items-center">
                    <div class="dark-mode-switch">
                        <input type="checkbox" id="dark-mode-toggle" class="hidden">
                        <label for="dark-mode-toggle" class="toggle-label"></label>
                    </div>
                                                        
                </div>
                
            </div>

            
              
              

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if (auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.gestionnaires.index')" :active="request()->routeIs('admin.gestionnaires.index')">
                        {{ __('List of Managers') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.gestionnaires.create')" :active="request()->routeIs('admin.gestionnaires.create')">
                        {{ __('Add a Manager') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.gestionnaires.requests')" :active="request()->routeIs('admin.gestionnaires.requests')">
                        {{ __('Requests') }}
                    </x-responsive-nav-link>
                @else
                @if (auth()->user()->isGestionnaire())
                    
                    <x-responsive-nav-link :href="route('gestionnaire.infrastructure.index')" :active="request()->routeIs('gestionnaire.infrastructure.index')">
                        {{ __('My Infrastructures') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('gestionnaire.infrastructure.create')" :active="request()->routeIs('gestionnaire.infrastructure.create')">
                        {{ __('Add an infrastructure') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('gestionnaire.reservations.requests')" :active="request()->routeIs('gestionnaire.reservations.requests')">
                        {{ __('Reservation Requests') }}
                    </x-responsive-nav-link>
                    
                @else
                @if (auth()->user()->isClient())
                    <x-responsive-nav-link :href="route('infrastructure.index')" :active="request()->routeIs('infrastructure.index')">
                        {{ __('List of Infrastructures') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('reservations.index')" :active="request()->routeIs('infrastructure.index')">
                        {{ __('My Reservations') }}
                    </x-responsive-nav-link>

                @endif
                @endif
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200 capitalize">{{ Auth::user()->nom.' '.Auth::user()->prenom }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('notifications')">
                        {{ __('Notifications') }}
                        @if (app\Models\Notification::unreadCount() > 0)
                            <span class="float-end">
                                <span class="ms-1 rounded-full size-5 inline-block text-center font-semibold bg-red-500 text-white"> {{app\Models\Notification::unreadCount()}} </span>
                            </span>
                        @endif
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Sign up') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
            <div class="flex items-center">
                <div class="dark-mode-switch">
                    <input type="checkbox" id="dark-mode-toggle" class="hidden">
                    <label for="dark-mode-toggle" class="toggle-label"></label>
                </div>
            </div>

        </div>
    </div>
    <style>
        .toggle-label {
        cursor: pointer;
        width: 3rem;
        height: 1.5rem;
        background-color: #ddd;
        display: block;
        border-radius: 1.5rem;
        position: relative;
        }
    
        .toggle-label::after {
        content: '';
        position: absolute;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background-color: #fff;
        top: 0.25rem;
        left: 0.25rem;
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 0 0.125rem rgba(0, 0, 0, 0.3);
        }
    
        #dark-mode-toggle:checked + .toggle-label {
        background-color: #333;
        }
    
        #dark-mode-toggle:checked + .toggle-label::after {
        transform: translateX(1.5rem);
        }
    </style>
</nav>
