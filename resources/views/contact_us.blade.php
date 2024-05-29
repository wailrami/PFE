<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - CrinoSport</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <a href="#" class="flex items-center space-x-2">
                <x-app-logo class="w-16 h-16 fill-current text-white" />
                                <span class="font-bold text-lg">CrinoSport</span>
            </a>
            
            <a href="{{route("root")}}" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded transition-colors duration-300">Reserve a Stadium</a>
        </div>
    </header>

    <main>
        <section class="bg-cover bg-center h-96" style="background-image: url('images/contact.jpg')">
            <div class="bg-black bg-opacity-50 h-full flex items-center justify-center">
                <div class="text-center text-white">
                    <h1 class="text-4xl font-bold mb-4">Get in Touch</h1>
                    <p class="text-lg mb-8">Have a question or want to book an event? Contact us today!</p>
                </div>
            </div>
        </section>

        <section class="py-12">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h2 class="text-3xl font-bold mb-8">Contact Information</h2>
                        <ul class="space-y-4">
                            <li>
                                <i class="fas fa-map-marker-alt text-cyan-500 mr-4"></i>
                                <span class="font-bold">Address:</span> Guelma-University 8 mai 1945
                            </li>
                            <li>
                                <i class="fas fa-phone-alt text-cyan-500 mr-4"></i>
                                <span class="font-bold">Phone:</span> 0798454408
                            </li>
                            <li>
                                <i class="fas fa-envelope text-cyan-500 mr-4"></i>
                                <span class="font-bold">Email:</span> adimn@support.com
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold mb-8">Contact Form</h2>
                        <form class="space-y-4" action="{{route('contact.send')}}" method="POST">
                            @csrf
                            <div>
                                <label for="name" class="block font-bold mb-2">Name</label>
                                <input type="text" id="name" name="name" class="w-full border-gray-300 rounded py-2 px-3 focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="Enter your name" required>
                            </div>
                            <div>
                                <label for="email" class="block font-bold mb-2">Email</label>
                                <input type="email" id="email" name="email" class="w-full border-gray-300 rounded py-2 px-3 focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="Enter your email" required>
                            </div>
                            <div>
                                <label for="message" class="block font-bold mb-2">Message</label>
                                <textarea id="message" name="message" rows="5" class="w-full border-gray-300 rounded py-2 px-3 focus:outline-none focus:ring-2 focus:ring-cyan-500" placeholder="Enter your message" required></textarea>
                            </div>
                            <button type="submit" class="bg-gray-800 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded transition-colors duration-300">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('components.footer')

</body>
</html>