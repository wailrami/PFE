<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Crino Stadium Reservations</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <a href="{{route("root")}}" class="flex items-center space-x-2">
                <x-app-logo class="w-16 h-16 fill-current text-white" />
                <span class="font-bold text-lg">CrinoSport</span>
            </a>
            
            <a href="{{route("root")}}" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded transition-colors duration-300">Reserve a Stadium</a>
        </div>
    </header>

    <main>
        <section class="bg-cover bg-center h-96" style="background-image: url('images/about.jpg')">

            <div class="bg-black bg-opacity-50 h-full flex items-center justify-center">
                <div class="text-center text-white">
                    <h1 class="text-4xl font-bold mb-4">About CrinoSport</h1>
                    <p class="text-lg mb-8">Our CrinoSport is about how you can make a simple reservation without moving out of your place,you can just hold your phone and visit our WebSite , then you need just to creat account if you don t have one , and login , then you take a look for the stadium or the sale that you want to make a reservation in ,or you can simply go to search and write the correct name of the sale or the stadium and you'll find it </p>
                </div>
            </div>
        </section>

        <section class="py-12">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h2 class="text-3xl font-bold mb-8">who is us ?</h2>
                        <p class="mb-4">We are a group of students in our 3rd year ,science computer ,Guelma's university</p>
                        <p class="mb-4">In this program ,we helped to make the crino and reservation more simple and easy </p>
                        <p class="mb-4">We did our best to make you feel more comfortable and helpful ,so we wish you will enjoy it , but if you have a complaint or addition you can go to "Contact" and tell us</p>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold mb-8">Our Team</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h3 class="text-xl font-bold mb-2">Chohra.Chems.Eddine</h3>
                                <p class="text-gray-600">supervisor</p>
                            </div>
                            <div>
                                
                                                                <h3 class="text-xl font-bold mb-2">Wail.Haou.Rami</h3>
                                <p class="text-gray-600">Student</p>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold mb-2">Chouaib.Meliani</h3>
                                <p class="text-gray-600">student</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('components.footer')

</body>
</html>