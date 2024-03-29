import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


                // Check if the user's preference for dark mode is enabled
                const prefersDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                // Get the modeToggle checkbox, modeLabel, modeIcon, and addUserModal
                const modeToggle = document.getElementById('modeToggle');
                const modeLabel = document.getElementById('modeLabel');
                const modeIcon = document.getElementById('modeIcon');
                const body = document.body;

                // Function to toggle between light and dark modes
                function toggleMode() {
                body.classList.toggle('dark');
                if (body.classList.contains('dark')) {
                    // Dark mode
                    body.classList.remove('light-mode');
                    body.style.setProperty('--bg-color', 'black');
                    body.style.setProperty('--text-color', 'white');
                    modeLabel.textContent = 'Light Mode';
                    modeIcon.classList.add('translate-x-6', 'bg-yellow-400');
                } else {
                    // Light mode
                    body.classList.add('light-mode');
                    body.style.setProperty('--bg-color', 'white');
                    body.style.setProperty('--text-color', 'black');
                    modeLabel.textContent = 'Dark Mode';
                    modeIcon.classList.remove('translate-x-6', 'bg-yellow-400');
                }
                }

              
                // Add event listeners
                modeToggle.addEventListener('change', toggleMode);

                // Check user's preference and set the initial mode accordingly
                if (prefersDarkMode) {
                toggleMode();
                }
         
