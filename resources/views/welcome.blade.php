<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans">
        {{-- @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('register.gestionnaire') }}" class="me-5 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Be a Manager</a>
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif --}}
            <header class="bg-gray-100 py-4 px-6 flex justify-between items-center">
              <div>
                <a href="{{ route('dashboard') }}">
                    <x-app-logo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
            </div>
            
                <div class="space-x-4">
                    <a href="{{route('register')}}" class="bg-cyan-500 text-black font-bold py-2 px-6 rounded-md hover:bg-cyan-600 transition-colors duration-300">Sign Up</a>
                    <a href="{{route('login')}}" class="bg-gray-800 text-white font-bold py-2 px-6 rounded-md hover:bg-gray-700 transition-colors duration-300">Login</a>
                </div>
            </header>
            
            <main>
     

                <section class="bg-cover bg-center h-screen flex flex-col justify-center items-center text-white" style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1579952363873-27f3bade9f55?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80')">
                    <h1 class="text-5xl font-bold uppercase">Crino Stadium Reservations</h1>
                    <p class="text-lg uppercase text-gray-300 my-4">Secure your events at top-tier sports venues using Crino, the digital asset revolution.</p>
                    <button class="bg-cyan-500 text-black font-bold py-2 px-6 rounded-md hover:bg-cyan-600 transition-colors duration-300">Reserve a Stadium</button>
                </section>
                <section class="bg-white py-16">
                    <div class="container mx-auto px-6">
                        <h2 class="text-2xl uppercase text-gray-600 mb-8 text-center">How to Get a Crino Stadium Reservation</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                                <h3 class="text-xl uppercase text-gray-600 mb-2">1. Visit our website</h3>
                                <p class="text-gray-500">Start your journey by visiting our Crino Stadium Reservations website, where you can explore our available venues and upcoming event dates.</p>
                            </div>
                            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                                <h3 class="text-xl uppercase text-gray-600 mb-2">2. Create an account</h3>
                                <p class="text-gray-500">Sign up for a Crino account, which will give you access to our platform and allow you to securely book your stadium reservations.</p>
                            </div>
                            <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                                <h3 class="text-xl uppercase text-gray-600 mb-2">3. Choose your stadium and date</h3>
                                <p class="text-gray-500">Browse our selection of top-tier stadiums and pick the one that suits your event best. Then, choose the date that works for you and complete the reservation process.</p>
                            </div>
                            
                        </div>
                        <div class="text-center mt-8">
                            <p class="text-gray-500">Once you've completed these steps, you can sit back and relax, knowing that your event is secure with Crino Stadium Reservations.</p>
                        </div>
                    </div>
                </section>
                <section class="py-16">
                  <div class="container mx-auto px-6">
                      <h2 class="text-2xl uppercase text-gray-600 mb-8 text-center">Crino Stadium Reservations</h2>
                      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                          <div class="bg-white p-6 rounded-lg shadow-md">
                              <img src="https://via.placeholder.com/300x200" alt="Stadium Reservation" class="mb-4 rounded-lg">
                              <h3 class="text-xl uppercase text-gray-600 mb-2">Stadium Reservation</h3>
                              <p class="text-gray-500">Reserve your preferred stadium for your upcoming sports events, concerts, or other large-scale gatherings. Our platform provides a seamless booking experience and secure payment options powered by Crino.</p>
                          </div>
                          <div class="bg-white p-6 rounded-lg shadow-md">
                              <img src="https://via.placeholder.com/300x200" alt="Crino Integration" class="mb-4 rounded-lg">
                              <h3 class="text-xl uppercase text-gray-600 mb-2">Crino Integration</h3>
                              <p class="text-gray-500">Leverage the power of Crino, the digital asset revolution, to transform the way you manage ticketing, sponsorships, and more for your sports and entertainment events.</p>
                          </div>
                          <div class="bg-white p-6 rounded-lg shadow-md">
                              <img src="https://via.placeholder.com/300x200" alt="Event Management" class="mb-4 rounded-lg">
                              <h3 class="text-xl uppercase text-gray-600 mb-2">Event Management</h3>
                              <p class="text-gray-500">Our platform offers comprehensive event management tools to help you streamline your sports, entertainment, or corporate events. From ticketing to vendor coordination, we've got you covered using Crino-powered solutions.</p>
                          </div>
                      </div>
                  </div>
              </section>
            
                <section class="bg-gray-100 py-16">
                    <div class="container mx-auto flex items-center px-6">
                        <img src="https://via.placeholder.com/500x300" alt="About Crino Stadium Reservations" class="rounded-lg w-full md:w-1/2 mr-6">
                        <div>
                            <h2 class="text-2xl uppercase text-gray-600 mb-4">About Crino Stadium Reservations</h2>
                            <p class="text-gray-500">Discover the power of Crino, the digital asset revolution, combined with the convenience of stadium reservations. Our platform provides a seamless experience for event organizers, athletes, and fans alike, unlocking new opportunities in the world of sports and entertainment.</p>
                        </div>
                    </div>
                </section>
                <section class="bg-gray-100 py-16">
                    <div class="container mx-auto flex items-center px-6">
                        <img src="https://via.placeholder.com/500x300" alt="About Crino Stadium Reservations" class="rounded-lg w-full md:w-1/2 mr-6">
                        <div>
                            <h2 class="text-2xl uppercase text-gray-600 mb-4">How to be a gestionnaire</h2>
                            <p class="text-gray-500">If you have permissions for one of the infrastructures or you own ones  in the city and you want to put it in the online reservation, submit a request to become the manager of your infrastructure. or just go from here : </p>
                            <button class="bg-cyan-500 text-black font-bold py-2 px-6 rounded-md hover:bg-cyan-600 transition-colors duration-300">Request Here</button>
            
                        </div>
                    </div>
                </section>
          
            @include('components.footer')
        </main>
      
    </body>
</html>
