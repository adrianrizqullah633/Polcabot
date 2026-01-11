/**
 * Navigation Functions
 */

// Toggle Sidebar
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    
    if (!sidebar || !mainContent) return;
    
    sidebar.classList.toggle('hidden');
    if (sidebar.classList.contains('hidden')) {
        mainContent.classList.add('expanded');
    } else {
        mainContent.classList.remove('expanded');
    }
}

// Smooth scroll to section
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});