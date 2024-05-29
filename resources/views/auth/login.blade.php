<!-- resources/views/login.blade.php -->

<x-guest-layout>
    <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
        <div class="relative flex h-32 items-end bg-gray-900 lg:col-span-5 lg:h-full xl:col-span-6">
            
            <img src="{{asset('images\OIP.jpeg')}}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-80">
            
            <div class="hidden lg:relative lg:block lg:p-12">
                <a href="#" class="block text-white">
                    <span class="sr-only">Home</span>
                    
                    <div class="absolute bottom-96 left-3">
                        <a href="{{route("root")}}" class="flex items-center space-x-2">
                        <x-app-logo class="w-32 h-32 fill-current text-gray-700" />
                        
                    </div>
                </a>
                <div class="absolute bottom-80 left-4">
                    <h2 class="mt-6 text-2xl font-bold text-gray-400 sm:text-3xl md:text-4xl">CrinoSport</h2>
                </div>
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
                <h1 class="text-center text-2xl font-bold mb-4">WELCOME BACK</h1>
                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="mt-8">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            
                            
                            
                        </label>
                        
                        <p href="#"></p>
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                            {{ __('you dont have an account ?') }}
                        </a>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                        

                        <x-primary-button class="ml-3">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-guest-layout>