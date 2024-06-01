<x-guest-layout>


    <div class="lg:grid lg:min-h-screen lg:grid-cols-12">
        <div class="relative flex h-32 items-end bg-gray-900 lg:col-span-5 lg:h-full xl:col-span-6">
            
            <img src="{{asset('images\ge.jpg')}}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-80">
            
            <div class="hidden lg:relative lg:block lg:p-12">
                <a href="#" class="block text-white">
                    <span class="sr-only">Manager</span>
                    
                    
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
                <h1 class="text-center text-2xl font-bold mb-4">Congratulation!! <br>You are now one of the Managers<br>Set your new Password</h1>
                <form method="POST" action="{{ route('gestionnaire.password.set', ['id'=> $gestionnaire->id]) }}">
                    @csrf

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Set Password') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-guest-layout>