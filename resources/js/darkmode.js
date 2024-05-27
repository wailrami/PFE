// On page load or when changing themes, best to add inline in `head` to avoid FOUC
window.addEventListener('DOMContentLoaded', () => {
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      document.documentElement.classList.add('dark');
      document.getElementById('dark-mode-toggle').checked = true;
    } else {
      document.documentElement.classList.remove('dark');
      document.getElementById('dark-mode-toggle').checked = false;
    }
  });
  
  // Function to set theme preference
  function setThemePreference(theme) {
    localStorage.theme = theme;
  }
  
  // Event listener for dark mode toggle switch
  document.getElementById('dark-mode-toggle').addEventListener('change', (event) => {
    if (event.target.checked) {
      setThemePreference('dark');
      document.documentElement.classList.add('dark');
    } else {
      setThemePreference('light');
      document.documentElement.classList.remove('dark');
    }
  });
  