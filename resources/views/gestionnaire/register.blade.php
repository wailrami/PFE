<x-guest-layout>
    <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
        <div class="relative flex h-32 items-end bg-gray-900 lg:col-span-5 lg:h-full xl:col-span-6">
            
            <img src="{{asset('images\ge.jpg')}}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-80">
            
            <div class="hidden lg:relative lg:block lg:p-12">
                <a href="#" class="block text-white">
                    <span class="sr-only">Home</span>
                    
                    
                </a>
                
                <p class="mt-4 leading-relaxed text-white/90">
                   
                </p>
            </div>
        </div>

        <main class="flex items-center justify-center px-8 py-8 sm:px-12 lg:col-span-7 lg:px-16 lg:py-12 xl:col-span-6 bg-gray-300" >
            <div class="max-w-xl lg:max-w-3xl">
                <div class="relative -mt-16 block lg:hidden">
                    <a href="#" class="inline-flex items-center justify-center rounded-full bg-white text-blue-600 p-4 sm:p-5">
                        <span class="sr-only">Home</span>
                        <x-app-logo class="w-32 h-32 fill-current text-gray-700" />
                    </a>
                </div>
                <h1 class="text-center text-2xl font-bold mb-4">WELCOME TO THE MANAGER SPACE <br> Request to be a Manager</h1>
                <form method="POST" action="{{ route('register.gestionnaire.store') }}">
                    @csrf

                    <!-- Nom -->
                    <div>
                        <x-input-label for="nom" :value="__('Family Name')" />
                        <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus autocomplete="nom" />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>

                    <!-- Prenom -->
                    <div class="mt-4">
                        <x-input-label for="prenom" :value="__('First Name')" />
                        <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required autofocus autocomplete="prenom" />
                        <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- N Tel -->
                    <div class="mt-4">
                        <x-input-label for="tel" :value="__('Phone Number')" />
                        <x-text-input id="tel" class="block mt-1 w-full" type="text" name="tel" :value="old('tel')" required autocomplete="tel" />
                        <x-input-error :messages="$errors->get('tel')" class="mt-2" />
                    </div>

                    

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-primary-button class="ml-4">
                            {{ __('Send Request') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-guest-layout>