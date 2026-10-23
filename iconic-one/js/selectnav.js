(function () {
    'use strict';

    var siteNavigation = document.getElementById('site-navigation');
    if (!siteNavigation) { return; }

    var button = siteNavigation.getElementsByTagName('button')[0];
    if (typeof button === 'undefined') { return; }

    var menu = siteNavigation.getElementsByTagName('ul')[0];
    if (typeof menu === 'undefined') { button.style.display = 'none'; return; }

    if (!menu.classList.contains('nav-menu')) menu.classList.add('nav-menu');

    /* Clear any .focus left over from a previous page state. */
    Array.prototype.forEach.call(siteNavigation.querySelectorAll('li.focus'), function (li) {
        li.classList.remove('focus');
    });

    /* ---------- Mobile hamburger ---------- */
    button.addEventListener('click', function () {
        siteNavigation.classList.toggle('toggled');
        button.setAttribute('aria-expanded',
            button.getAttribute('aria-expanded') === 'true' ? 'false' : 'true');
    });

    /* ---------- Keyboard focus  ---------- */
    var links = menu.getElementsByTagName('a');
    for (var i = 0; i < links.length; i++) {
        links[i].addEventListener('focus', toggleFocus, true);
        links[i].addEventListener('blur', toggleFocus, true);
    }
    function toggleFocus(event) {
        if (event.type !== 'focus' && event.type !== 'blur') return;
        var self = this;
        while (self && !self.classList.contains('nav-menu')) {
            if (self.tagName && self.tagName.toLowerCase() === 'li') {
                self.classList.toggle('focus');
            }
            self = self.parentNode;
        }
    }

    /* ---------- Shared cleanup ---------- */
    function clearFocusExcept(except) {
        var open = siteNavigation.querySelectorAll('li.focus');
        for (var j = 0; j < open.length; j++) {
            var li = open[j];
            if (li === except) continue;
            if (except && (li.contains(except) || except.contains(li))) continue;
            li.classList.remove('focus');
        }
    }
    function clearAllFocus() { clearFocusExcept(null); }

    /* ---------- Touch: open submenu on parent-link tap ---------- */
    siteNavigation.addEventListener('touchstart', function (event) {
        var target = event.target;
        if (!target || !target.closest) return;

        var parentLink = target.closest('.menu-item-has-children > a, .page_item_has_children > a');
        if (parentLink && siteNavigation.contains(parentLink)) {
            var li = parentLink.parentNode;
            if (li && !li.classList.contains('focus')) {
                event.preventDefault();
                clearFocusExcept(li);
                li.classList.add('focus');
            }
            return;
        }

        /* Tapped a submenu link or empty nav space.
           Only close if the tap did not land inside an already-open chain. */
        if (!target.closest('li.focus')) {
            clearAllFocus();
        }
    }, { passive: false });

    /* ---------- Touch outside nav ---------- */
    document.addEventListener('touchstart', function (event) {
        if (siteNavigation.contains(event.target)) return;
        clearAllFocus();
        siteNavigation.classList.remove('toggled');
        button.setAttribute('aria-expanded', 'false');
    }, true);

    /* ---------- Mouse movement: closes stale touch-opened submenus ---------- */
    var lastHoverLi = null;
    document.addEventListener('mousemove', function (event) {
        var target = event.target;
        if (!target || !target.closest) {
            if (lastHoverLi !== null) { lastHoverLi = null; clearAllFocus(); }
            return;
        }
        var li = target.closest('li');

        if (li === lastHoverLi) return;       // nothing changed
        lastHoverLi = li;

        if (li && siteNavigation.contains(li)) {
            clearFocusExcept(li);             // keep the one we're over (and its ancestors), drop the rest
        } else {
            clearAllFocus();                  // moved outside the nav entirely
        }
    }, true);

    /* ---------- Mouse leaves nav ---------- */
    siteNavigation.addEventListener('mouseleave', function () {
        lastHoverLi = null;
        clearAllFocus();
    });

    /* ---------- Click outside nav ---------- */
    document.addEventListener('click', function (event) {
        if (siteNavigation.contains(event.target)) return;
        clearAllFocus();
        siteNavigation.classList.remove('toggled');
        button.setAttribute('aria-expanded', 'false');
    });

})();