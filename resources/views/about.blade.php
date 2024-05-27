<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Crino Stadium Reservations</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <a href="#" class="flex items-center space-x-2">
                <img src="logo.svg" alt="Crino Logo" class="h-8">
                <span class="font-bold text-lg">Crino</span>
            </a>
            <nav class="space-x-4">
                <a href="#" class="hover:text-cyan-500 transition-colors duration-300">Home</a>
                <a href="#" class="hover:text-cyan-500 transition-colors duration-300 active">About</a>
                <a href="#" class="hover:text-cyan-500 transition-colors duration-300">Stadiums</a>
                <a href="#" class="hover:text-cyan-500 transition-colors duration-300">Pricing</a>
                <a href="#" class="hover:text-cyan-500 transition-colors duration-300">Contact</a>
            </nav>
            <button class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded transition-colors duration-300">Reserve a Stadium</button>
        </div>
    </header>

    <main>
        <section class="bg-cover bg-center h-96" style="background-image: url('about-bg.jpg')">
            <div class="bg-black bg-opacity-50 h-full flex items-center justify-center">
                <div class="text-center text-white">
                    <h1 class="text-4xl font-bold mb-4">About Crino</h1>
                    <p class="text-lg mb-8">Learn more about our company and our mission to provide the best stadium reservation experience.</p>
                </div>
            </div>
        </section>

        <section class="py-12">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h2 class="text-3xl font-bold mb-8">Our Company</h2>
                        <p class="mb-4">Crino Stadium Reservations is a leading provider of stadium rental services. We have been in business for over 20 years and have built a reputation for delivering exceptional customer service and top-notch facilities.</p>
                        <p class="mb-4">Our mission is to make it easy for individuals, teams, and organizations to reserve the perfect stadium for their events. Whether you're hosting a sporting event, a concert, or a corporate function, we have the right venue to meet your needs.</p>
                        <p class="mb-4">We take pride in our commitment to sustainability and environmental responsibility. All of our stadiums are designed and operated with a focus on reducing our carbon footprint and promoting eco-friendly practices.</p>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold mb-8">Our Team</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <img src="team-member-1.jpg" alt="Team Member 1" class="rounded-lg mb-4">
                                <h3 class="text-xl font-bold mb-2">John Doe</h3>
                                <p class="text-gray-600">CEO</p>
                            </div>
                            <div>
                                <img src="team-member-2.jpg" alt="Team Member 2" class="rounded-lg mb-4">
                                <h3 class="text-xl font-bold mb-2">Jane Smith</h3>
                                <p class="text-gray-600">Operations Manager</p>
                            </div>
                            <div>
                                <img src="team-member-3.jpg" alt="Team Member 3" class="rounded-lg mb-4">
                                <h3 class="text-xl font-bold mb-2">Michael Johnson</h3>
                                <p class="text-gray-600">Sales Manager</p>
                            </div>
                            <div>
                                <img src="team-member-4.jpg" alt="Team Member 4" class="rounded-lg mb-4">
                                <h3 class="text-xl font-bold mb-2">Emily Brown</h3>
                                <p class="text-gray-600">Customer Service Representative</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto flex justify-between items-center px-6">
            <p>&copy; 2022 Crino Stadium Reservations</p>
            <div class="space-x-4">
                <a href="#" class="hover:text-cyan-500 transition-colors duration-300 active">About</a>
                <a href="#" class="hover:text-cyan-500 transition-colors duration-300">Contact</a>
                <a href="#" class="hover:text-cyan-500 transition-colors duration-300">Privacy Policy</a>
                <a href="#" class="hover:text-cyan-500 transition-colors duration-300">Terms of Service</a>
            </div>
        </div>
    </footer>

    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>