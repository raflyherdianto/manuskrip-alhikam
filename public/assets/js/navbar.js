// ========================================
// NAVBAR MOBILE MENU FUNCTIONALITY
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    if (!navbarToggler || !navbarCollapse) return;

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInsideNav = navbarCollapse.contains(event.target);
        const isClickOnToggler = navbarToggler.contains(event.target);
        const isMenuOpen = navbarCollapse.classList.contains('show');

        // If menu is open and click is outside nav and not on toggler
        if (isMenuOpen && !isClickInsideNav && !isClickOnToggler) {
            // Use Bootstrap's collapse method to close menu
            const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
            if (bsCollapse) {
                bsCollapse.hide();
            } else {
                navbarCollapse.classList.remove('show');
            }
        }
    });

    // Close menu when clicking on nav links (for mobile)
    const navLinks = navbarCollapse.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) { // Only on mobile/tablet
                const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                if (bsCollapse) {
                    bsCollapse.hide();
                } else {
                    navbarCollapse.classList.remove('show');
                }
            }
        });
    });
});
