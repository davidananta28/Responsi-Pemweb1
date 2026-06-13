document.addEventListener('DOMContentLoaded', () => {
    
    // --- 1. FITUR MENU MOBILE (HAMBURGER MENU) ---
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileNav = document.querySelector('.mobile-nav');

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileNav.classList.toggle('active');
        });
    }

    // --- 2. FITUR KLIK DROPDOWN PROFIL ---
    const profileBtn = document.querySelector('.profile-btn');
    const dropdownContent = document.querySelector('.dropdown-content');

    if (profileBtn) {
        // Ketika foto profil diklik, munculkan atau sembunyikan dropdown
        profileBtn.addEventListener('click', (event) => {
            event.stopPropagation(); // Mencegah klik bocor ke background
            dropdownContent.classList.toggle('show');
        });
    }

    // Menutup dropdown jika user mengklik sembarang tempat di luar menu
    window.addEventListener('click', (event) => {
        if (!event.target.closest('.profile-dropdown')) {
            if (dropdownContent && dropdownContent.classList.contains('show')) {
                dropdownContent.classList.remove('show');
            }
        }
    });

});