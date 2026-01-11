/**
 * Dark Mode Toggle
 */

function toggleDarkMode() {
    const body = document.body;
    const toggle = document.getElementById('darkModeToggle');
    
    if (body.classList.contains('light-mode')) {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        if (toggle) toggle.classList.add('active');
        localStorage.setItem('theme', 'dark');
    } else {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        if (toggle) toggle.classList.remove('active');
        localStorage.setItem('theme', 'light');
    }
}

// Load saved theme on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    const body = document.body;
    const toggle = document.getElementById('darkModeToggle');
    
    if (savedTheme === 'dark') {
        body.classList.remove('light-mode');
        body.classList.add('dark-mode');
        if (toggle) toggle.classList.add('active');
    } else {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        if (toggle) toggle.classList.remove('active');
    }
});