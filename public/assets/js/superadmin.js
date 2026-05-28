/**
 * SUPERADMIN DASHBOARD JAVASCRIPT
 * Mobile First & Responsive
 */

document.addEventListener('DOMContentLoaded', function() {

    // ==========================================
    // Mobile Sidebar Toggle
    // ==========================================
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const mainContent = document.getElementById('mainContent');

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            toggleSidebar();
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            closeSidebar();
        });
    }

    // Close sidebar when clicking nav links on mobile
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        });
    });

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        sidebarOverlay.classList.toggle('active');
        mobileMenuToggle.classList.toggle('hidden');
        document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
    }

    function closeSidebar() {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        mobileMenuToggle.classList.remove('hidden');
        document.body.style.overflow = '';
    }

    // Close sidebar on window resize if desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            closeSidebar();
        }
    });

    // ==========================================
    // Auto-dismiss Alerts
    // ==========================================
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000); // Auto close after 5 seconds
    });

    // ==========================================
    // Notification Button
    // ==========================================
    const notificationBtn = document.getElementById('notificationBtn');
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function() {
            // Placeholder for notification functionality
            console.log('Notification button clicked');
            // You can implement a dropdown or modal here
        });
    }

    // ==========================================
    // Active Navigation Link
    // ==========================================
    function setActiveNavLink() {
        const currentPath = window.location.pathname;
        navLinks.forEach(link => {
            const linkPath = new URL(link.href).pathname;
            if (currentPath === linkPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }
    setActiveNavLink();

    // ==========================================
    // Smooth Scroll for Anchor Links
    // ==========================================
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '#!') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // ==========================================
    // Counter Animation for Statistics
    // ==========================================
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16);
        const timer = setInterval(() => {
            start += increment;
            if (start >= target) {
                element.textContent = formatNumber(target);
                clearInterval(timer);
            } else {
                element.textContent = formatNumber(Math.floor(start));
            }
        }, 16);
    }

    function formatNumber(num) {
        if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toString();
    }

    // Animate counters when they come into view
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.animated) {
                const target = entry.target;
                const value = target.textContent.replace(/[^0-9.]/g, '');
                const numValue = parseFloat(value);

                if (!isNaN(numValue)) {
                    target.dataset.animated = 'true';
                    animateCounter(target, numValue, 1500);
                }
            }
        });
    }, observerOptions);

    // Observe stat card numbers
    const statNumbers = document.querySelectorAll('.stat-content h3');
    statNumbers.forEach(stat => observer.observe(stat));

    // ==========================================
    // Chart Initialization Placeholder
    // ==========================================
    // You can add Chart.js or other chart library initialization here
    const chartPlaceholders = document.querySelectorAll('.chart-placeholder');
    chartPlaceholders.forEach(placeholder => {
        // Example: Initialize charts here when you add a chart library
        console.log('Chart placeholder found:', placeholder);
    });

    // ==========================================
    // Loading State for Action Buttons
    // ==========================================
    const actionBtns = document.querySelectorAll('.action-btn');
    actionBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Add loading state if needed
            const originalText = this.innerHTML;
            // this.innerHTML = '<i class="bi bi-hourglass-split"></i> Loading...';
            // Restore after action completes
        });
    });

    // ==========================================
    // Real-time Clock (Optional)
    // ==========================================
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });
        const clockElement = document.getElementById('currentTime');
        if (clockElement) {
            clockElement.textContent = timeString;
        }
    }

    // Update clock every minute
    setInterval(updateClock, 60000);
    updateClock();

    // ==========================================
    // Progress Bar Animation
    // ==========================================
    const progressBars = document.querySelectorAll('.distribution-progress');
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            }
        });
    }, { threshold: 0.5 });

    progressBars.forEach(bar => progressObserver.observe(bar));

    // ==========================================
    // Activity Feed Auto-refresh (Optional)
    // ==========================================
    function refreshActivityFeed() {
        // Placeholder for AJAX call to refresh activity feed
        console.log('Activity feed refresh');
        // You can implement AJAX call here to fetch new activities
    }

    // Uncomment to enable auto-refresh every 30 seconds
    // setInterval(refreshActivityFeed, 30000);

    // ==========================================
    // Form Validation Enhancement
    // ==========================================
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // ==========================================
    // Keyboard Shortcuts
    // ==========================================
    document.addEventListener('keydown', function(e) {
        // Toggle sidebar with Ctrl/Cmd + B
        if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
            e.preventDefault();
            toggleSidebar();
        }

        // Close sidebar with Escape
        if (e.key === 'Escape') {
            closeSidebar();
        }
    });

    // ==========================================
    // Tooltip Initialization
    // ==========================================
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // ==========================================
    // Status Indicator Animation
    // ==========================================
    function animateStatusIndicators() {
        const statusOnline = document.querySelectorAll('.status-online');
        statusOnline.forEach((status, index) => {
            setTimeout(() => {
                status.style.animation = 'pulse 2s infinite';
            }, index * 200);
        });
    }
    animateStatusIndicators();

    // Add pulse animation to CSS if not exists
    if (!document.querySelector('#pulseAnimation')) {
        const style = document.createElement('style');
        style.id = 'pulseAnimation';
        style.textContent = `
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.6; }
            }
        `;
        document.head.appendChild(style);
    }

    // ==========================================
    // Console Welcome Message
    // ==========================================
    console.log('%c🚀 Superadmin Dashboard Loaded!', 'color: #6366f1; font-size: 20px; font-weight: bold;');
    console.log('%cVersion: 1.0.0', 'color: #10b981; font-size: 12px;');
    console.log('%cDeveloped with ❤️', 'color: #ef4444; font-size: 12px;');

    // ==========================================
    // Performance Monitoring (Optional)
    // ==========================================
    if (window.performance && window.performance.timing) {
        window.addEventListener('load', function() {
            const perfData = window.performance.timing;
            const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
            console.log(`⚡ Page Load Time: ${pageLoadTime}ms`);
        });
    }

    // ==========================================
    // Service Worker Registration (Optional)
    // ==========================================
    // Uncomment to enable PWA features
    /*
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => {
                    console.log('ServiceWorker registered:', registration);
                })
                .catch(error => {
                    console.log('ServiceWorker registration failed:', error);
                });
        });
    }
    */

});

// ==========================================
// Export functions for external use
// ==========================================
window.SuperadminDashboard = {
    version: '1.0.0',
    init: function() {
        console.log('Superadmin Dashboard Initialized');
    },
    refreshStats: function() {
        console.log('Refreshing statistics...');
        // Implement stats refresh logic
    },
    refreshActivity: function() {
        console.log('Refreshing activity feed...');
        // Implement activity refresh logic
    }
};
