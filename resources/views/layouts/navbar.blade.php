 <nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="visible md:block">
                    <div class="pt-2 pb-3 space-y-1">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('reservations')" :active="request()->routeIs('reservations')">
                            {{ __('Mes Reservations') }}
                        </x-nav-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
