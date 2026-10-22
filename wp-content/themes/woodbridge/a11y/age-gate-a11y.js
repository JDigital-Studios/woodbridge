/*!
 * Age gate accessibility enhancer (WCAG 2.1 AA: 2.1.1, 2.4.1, 2.4.3, 2.4.7, 4.1.2).
 *
 * Works with an existing age gate without changing how it shows, hides or
 * remembers the visitor. Configure per site with window.AgeGateA11yConfig:
 *
 *   gate    (required) selector of the element that is the age gate dialog
 *   keep    selectors of other elements that must stay interactive while the gate
 *           is open (backdrop, legal popup containers, ...)
 *   modals  selectors of legal popups that open on top of the gate; they get
 *           focus when shown, a Tab trap, and focus returns to the opener
 *   label   accessible name fallback for the gate (default "Age verification")
 *   termsLabel  accessible name fallback for the terms checkbox
 *   main    selector(s) of the main content region (skip link target)
 *
 * What it does while the gate is visible:
 *   - exposes it as a modal dialog (role, aria-modal, name)
 *   - moves keyboard focus into it, traps Tab inside it, makes the rest of the
 *     page inert, and returns focus to the top of the page when it closes
 *   - removes misused ARIA roles (tab/tablist) and positive tabindex values
 *   - names the terms checkbox, and gives links a real href where one exists
 *   - shows a visible focus ring
 * It also adds a "Skip to main content" link when the page has none.
 */
(function () {
  'use strict';

  var cfg = window.AgeGateA11yConfig || {};
  if (!cfg.gate) { return; }
  // legal pages are also loaded inside the gate's own popup iframe; nothing to do there
  try { if (window.top !== window.self) { return; } } catch (e) { return; }

  var KEEP = (cfg.keep || []).concat([
    '#CybotCookiebotDialog',
    '.fancybox__container',
    '.fancybox-container'
  ]);
  var MODALS = cfg.modals || [];
  var LABEL = cfg.label || 'Age verification';
  var TERMS_LABEL = cfg.termsLabel || 'I agree to the Terms of Service and Privacy Policy';
  var MAIN = cfg.main === undefined ? 'main, [role="main"], #main, #primary' : cfg.main;
  var FOCUSABLE = 'a[href], button:not([disabled]), input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

  var active = false;
  var inerted = [];
  var previous = null;
  var activeModal = null;
  var modalOpener = null;
  var queued = false;

  function qs(sel) { try { return document.querySelector(sel); } catch (e) { return null; } }
  function qsa(root, sel) { try { return Array.prototype.slice.call(root.querySelectorAll(sel)); } catch (e) { return []; } }

  function visible(el) {
    if (!el || !el.isConnected) { return false; }
    var cs = window.getComputedStyle(el);
    if (cs.display === 'none' || cs.visibility === 'hidden') { return false; }
    return !!(el.offsetWidth || el.offsetHeight || el.getClientRects().length);
  }

  function uid(el, base) {
    if (!el.id) { el.id = base + '-' + Math.random().toString(36).slice(2, 7); }
    return el.id;
  }

  /* ---------- styles: skip link + focus ring ---------- */
  function addStyles() {
    if (document.getElementById('age-gate-a11y-styles')) { return; }
    var s = document.createElement('style');
    s.id = 'age-gate-a11y-styles';
    s.textContent =
      '.a11y-skip-link{position:absolute;top:0;left:0;z-index:2147483000;padding:.75rem 1.25rem;' +
      'background:#000;color:#fff;font:600 14px/1.2 Arial,sans-serif;text-decoration:none;transform:translateY(-120%)}' +
      '.a11y-skip-link:focus{transform:translateY(0);outline:3px solid #fff;outline-offset:-6px}' +
      '[data-a11y-gate]:focus{outline:none!important}' +
      '[data-a11y-gate] a:focus-visible,[data-a11y-gate] button:focus-visible,[data-a11y-gate] input:focus-visible,' +
      '[data-a11y-gate] select:focus-visible,[data-a11y-gate] [tabindex]:focus-visible{' +
      'outline:3px solid #fff!important;outline-offset:3px!important;box-shadow:0 0 0 6px #000!important}';
    document.head.appendChild(s);
  }

  /* ---------- skip link ---------- */
  function addSkipLink() {
    try {
      var links = qsa(document, 'a[href^="#"]').slice(0, 6);
      for (var i = 0; i < links.length; i++) {
        if (/skip/i.test(links[i].textContent) || /skip/i.test(links[i].className)) { return; }
      }
      var target = null;
      var sels = MAIN ? MAIN.split(',') : [];
      for (var j = 0; j < sels.length && !target; j++) {
        var cand = qs(sels[j].trim());
        if (cand && !cand.closest('[data-a11y-gate]')) { target = cand; }
      }
      if (!target) {
        // no main landmark: drop a focusable marker right after the site header
        var header = qs('header');
        if (header && header.parentNode) {
          target = document.createElement('div');
          target.id = 'main-content';
          target.setAttribute('tabindex', '-1');
          header.parentNode.insertBefore(target, header.nextSibling);
        }
      }
      if (!target || !document.body) { return; }
      var id = target.id || 'main-content';
      target.id = id;
      if (!target.hasAttribute('tabindex')) { target.setAttribute('tabindex', '-1'); }
      var a = document.createElement('a');
      a.className = 'a11y-skip-link';
      a.href = '#' + id;
      a.textContent = 'Skip to main content';
      a.addEventListener('click', function () {
        // make sure focus actually moves, even if the browser does not
        window.setTimeout(function () { try { target.focus(); } catch (e) {} }, 0);
      });
      document.body.insertBefore(a, document.body.firstChild);
    } catch (e) {}
  }

  /* ---------- decorate dialog content ---------- */
  function decorate(el, fallbackName) {
    if (!el.hasAttribute('role')) { el.setAttribute('role', 'dialog'); }
    el.setAttribute('aria-modal', 'true');
    el.setAttribute('data-a11y-gate', '');
    if (!el.hasAttribute('aria-label') && !el.hasAttribute('aria-labelledby')) {
      var h = el.querySelector('h1, h2, h3, [role="heading"]');
      if (h && h.textContent.replace(/\s+/g, ' ').trim()) {
        el.setAttribute('aria-labelledby', uid(h, 'a11y-title'));
      } else {
        el.setAttribute('aria-label', fallbackName);
      }
    }
    if (!el.hasAttribute('tabindex')) { el.setAttribute('tabindex', '-1'); }
  }

  function sanitize(el) {
    // misused tab roles (these are buttons / a checkbox, not tabs)
    qsa(el, '[role="tablist"], [role="tab"], [role="tabpanel"]').forEach(function (n) {
      n.removeAttribute('role');
      n.removeAttribute('aria-selected');
    });
    // positive tabindex values override natural order
    qsa(el, '[tabindex]').forEach(function (n) {
      var v = parseInt(n.getAttribute('tabindex'), 10);
      if (v > 0) { n.removeAttribute('tabindex'); }
    });
    // <a><button></button></a>: one tab stop only (the button)
    qsa(el, 'a > button').forEach(function (b) {
      var a = b.parentNode;
      a.setAttribute('tabindex', '-1');
      a.setAttribute('role', 'presentation');
    });
    // terms checkbox needs a name
    qsa(el, 'input[type="checkbox"]').forEach(function (cb) {
      if (cb.hasAttribute('aria-label') || cb.hasAttribute('aria-labelledby')) { return; }
      var named = false;
      if (cb.id) {
        var l = document.querySelector('label[for="' + cb.id.replace(/"/g, '\\"') + '"]');
        if (l && l.textContent.replace(/\s+/g, '').length) { named = true; }
      }
      if (!named) {
        var wrap = cb.closest('label');
        if (wrap && wrap.textContent.replace(/\s+/g, '').length) { named = true; }
      }
      if (!named) { cb.setAttribute('aria-label', cfg.termsLabel || TERMS_LABEL); }
    });
    // javascript:/# links that open a legal URL: use the real URL
    qsa(el, 'a[data-src]').forEach(function (a) {
      var href = (a.getAttribute('href') || '').trim();
      var src = a.getAttribute('data-src') || '';
      if ((href === '' || href === '#' || /^javascript:/i.test(href)) && src && src.charAt(0) !== '#') {
        a.setAttribute('href', src);
      }
    });
    // links disabled by aria-disabled that are in fact operable
    qsa(el, 'a[aria-disabled="true"][href]').forEach(function (a) { a.removeAttribute('aria-disabled'); });
    // decorative backdrop mislabelled as an image
    qsa(document, '#modal_screen[role="img"]').forEach(function (n) {
      n.removeAttribute('role');
      n.setAttribute('aria-hidden', 'true');
    });
  }

  /* ---------- inert background ---------- */
  function inertBackground(gate) {
    var protectedEls = [gate];
    KEEP.forEach(function (sel) { qsa(document, sel).forEach(function (n) { if (!gate.contains(n)) { protectedEls.push(n); } }); });
    var onPath = [];
    protectedEls.forEach(function (p) {
      for (var n = p; n && n !== document.documentElement; n = n.parentElement) {
        if (onPath.indexOf(n) === -1) { onPath.push(n); }
      }
    });
    onPath.forEach(function (n) {
      var parent = n.parentElement;
      if (!parent) { return; }
      Array.prototype.slice.call(parent.children).forEach(function (sib) {
        if (onPath.indexOf(sib) === -1 && !sib.hasAttribute('inert') && !/^(SCRIPT|STYLE|LINK|NOSCRIPT)$/.test(sib.tagName)) {
          sib.setAttribute('inert', '');
          inerted.push(sib);
        }
      });
    });
  }

  function restoreBackground() {
    inerted.forEach(function (n) { n.removeAttribute('inert'); });
    inerted = [];
  }

  /* ---------- focus trap ---------- */
  function topLayer(gate) {
    for (var i = MODALS.length - 1; i >= 0; i--) {
      var m = qs(MODALS[i]);
      if (m && visible(m)) { return m; }
    }
    return gate;
  }

  function onKeydown(e) {
    if (e.key !== 'Tab' && e.keyCode !== 9) { return; }
    var gate = qs(cfg.gate);
    if (!gate) { return; }
    var layer = topLayer(gate);
    var current = document.activeElement;
    if (!layer.contains(current)) { return; } // e.g. Fancybox / Cookiebot manage their own focus
    var items = qsa(layer, FOCUSABLE).filter(function (el) { return el.tabIndex >= 0 && visible(el); });
    if (!items.length) { e.preventDefault(); layer.focus(); return; }
    var first = items[0];
    var last = items[items.length - 1];
    if (e.shiftKey && (current === first || current === layer)) {
      e.preventDefault(); last.focus();
    } else if (!e.shiftKey && current === last) {
      e.preventDefault(); first.focus();
    }
  }

  /* ---------- lifecycle ---------- */
  var watchTimer = null;
  function startWatching() {
    // the gate can be hidden by a CSS transition or timer that causes no DOM
    // mutation we can observe, so keep checking while it is open
    if (!watchTimer) { watchTimer = window.setInterval(schedule, 400); }
  }
  function stopWatching() {
    if (watchTimer) { window.clearInterval(watchTimer); watchTimer = null; }
  }

  function activate(gate) {
    active = true;
    startWatching();
    previous = document.activeElement;
    decorate(gate, LABEL);
    sanitize(gate);
    inertBackground(gate);
    document.addEventListener('keydown', onKeydown, true);
    try { gate.focus({ preventScroll: true }); } catch (e) { gate.focus(); }
  }

  function deactivate() {
    active = false;
    document.removeEventListener('keydown', onKeydown, true);
    stopWatching();
    restoreBackground();
    // the gate opens on page load, so there is no opener to return to: start
    // again from the top of the page so the next Tab reaches the skip link
    if (document.body) {
      document.body.setAttribute('tabindex', '-1');
      try { document.body.focus({ preventScroll: true }); } catch (e) {}
      document.body.removeAttribute('tabindex');
    }
    previous = null;
  }

  function watchModals(gate) {
    var open = null;
    for (var i = MODALS.length - 1; i >= 0; i--) {
      var m = qs(MODALS[i]);
      if (m && visible(m)) { open = m; break; }
    }
    if (open && open !== activeModal) {
      modalOpener = document.activeElement;
      activeModal = open;
      decorate(open, 'Legal information');
      try { open.focus({ preventScroll: true }); } catch (e) { open.focus(); }
    } else if (!open && activeModal) {
      activeModal = null;
      if (modalOpener && document.contains(modalOpener) && visible(modalOpener)) {
        try { modalOpener.focus(); } catch (e) {}
      } else if (gate) {
        try { gate.focus({ preventScroll: true }); } catch (e) {}
      }
      modalOpener = null;
    }
  }

  function check() {
    queued = false;
    try {
      var gate = qs(cfg.gate);
      var isOpen = !!gate && visible(gate);
      if (isOpen && !active) { activate(gate); }
      else if (!isOpen && active) { deactivate(); }
      if (isOpen) {
        sanitize(gate); // gate markup can be re-rendered (e.g. "No" regret view)
        watchModals(gate);
      }
    } catch (e) {}
  }

  function schedule() {
    if (queued) { return; }
    queued = true;
    (window.requestAnimationFrame || window.setTimeout)(check);
  }

  function init() {
    addStyles();
    addSkipLink();
    check();
    try {
      new MutationObserver(schedule).observe(document.documentElement, {
        childList: true,
        subtree: true,
        attributes: true,
        attributeFilter: ['class', 'style', 'hidden']
      });
    } catch (e) {}
    window.addEventListener('load', schedule);
    document.addEventListener('transitionend', schedule, true);
    document.addEventListener('animationend', schedule, true);
    document.addEventListener('click', function () {
      window.setTimeout(schedule, 50);
      window.setTimeout(schedule, 450);
      window.setTimeout(schedule, 1100);
    }, true);
    // jQuery fades finish without DOM mutations we can see; re-check briefly
    var n = 0;
    var t = window.setInterval(function () { schedule(); if (++n > 40) { window.clearInterval(t); } }, 250);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
