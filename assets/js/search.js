(function () {
    'use strict';

    var overlay     = document.getElementById('sc-search-overlay');
    var input       = overlay ? overlay.querySelector('.sc-search-overlay__input') : null;
    var closeBtn    = overlay ? overlay.querySelector('.sc-search-overlay__close') : null;
    var openBtns    = document.querySelectorAll('.sc-nav__search-btn');

    if (!overlay || !input) return;

    function openSearch() {
        overlay.classList.add('is-open');
        var mNav = document.getElementById('sc-nav-mobile');
        if (mNav) mNav.classList.remove('is-open');
        var ham = document.querySelector('.sc-nav__hamburger');
        if (ham) ham.setAttribute('aria-expanded', 'false');
        input.focus();
        openBtns.forEach(function (btn) { btn.setAttribute('aria-expanded', 'true'); });
    }

    function closeSearch() {
        overlay.classList.remove('is-open');
        input.value = '';
        openBtns.forEach(function (btn) { btn.setAttribute('aria-expanded', 'false'); });
    }

    openBtns.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            overlay.classList.contains('is-open') ? closeSearch() : openSearch();
        });
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', closeSearch);
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('is-open')) {
            closeSearch();
        }
    });
}());
