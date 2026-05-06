(function () {
    'use strict';

    var hamburger = document.querySelector('.sc-nav__hamburger');
    var mobileNav = document.getElementById('sc-nav-mobile');

    if (!hamburger || !mobileNav) return;

    hamburger.addEventListener('click', function () {
        var isOpen = mobileNav.classList.toggle('is-open');
        hamburger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
}());
