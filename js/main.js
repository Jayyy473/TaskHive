(function(){
  'use strict';

  // Helpers
  const q = (s, root=document) => root.querySelector(s);
  const qall = (s, root=document) => Array.from(root.querySelectorAll(s));
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ----------------------------
     Dark mode (persisted)
     ---------------------------- */
  const DARK_KEY = 'taskhive_dark';
  const body = document.body;
  const toggle = q('#darkToggle');

  function enableDark() {
    body.classList.add('dark');
    localStorage.setItem(DARK_KEY, 'enabled');
    if (toggle) toggle.setAttribute('aria-pressed','true');
  }
  function disableDark() {
    body.classList.remove('dark');
    localStorage.setItem(DARK_KEY, 'disabled');
    if (toggle) toggle.setAttribute('aria-pressed','false');
  }
  function initDark() {
    // prefer-system if not set
    const stored = localStorage.getItem(DARK_KEY);
    if (stored === 'enabled') enableDark();
    else if (stored === 'disabled') disableDark();
    else {
      // fallback to system preference
      if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        enableDark();
      } else {
        disableDark();
      }
    }

    if (toggle) {
      toggle.addEventListener('click', () => {
        const cur = localStorage.getItem(DARK_KEY);
        if (cur === 'enabled') disableDark(); else enableDark();
      });
    }
  }

  /* ----------------------------
     Entrance animation for main elements
     ---------------------------- */
  function entranceAnimate() {
    if (prefersReducedMotion) return;
    // add fadeIn class to major sections
    const targets = qall('.hero-card, .hero-left, .task-card, .hero-right, .center-card');
    targets.forEach((el, i) => {
      el.style.animationDelay = `${i * 60}ms`; // stagger
      el.classList.add('fadeIn');
    });
  }

  /* ----------------------------
     Micro-interactions
     ---------------------------- */
  function microInteractions() {
    // Buttons: raise on press
    qall('button, .btn-primary, .btn-outline').forEach(btn => {
      btn.addEventListener('mousedown', () => btn.style.transform = 'translateY(1px) scale(0.997)');
      btn.addEventListener('mouseup', () => btn.style.transform = '');
      btn.addEventListener('mouseleave', () => btn.style.transform = '');
      // keyboard focus style already handled in CSS
    });

    // Task card click pop
    qall('.task-card').forEach(card => {
      card.addEventListener('click', (e) => {
        // avoid pop when clicking buttons inside card
        if (e.target.tagName.toLowerCase() === 'a' || e.target.closest('button')) return;
        card.classList.add('pop');
        setTimeout(() => card.classList.remove('pop'), 220);
      });
      // small hover micro-shadow
      card.addEventListener('mouseenter', () => {
        card.style.boxShadow = '0 18px 46px rgba(10,20,30,0.12)';
      });
      card.addEventListener('mouseleave', () => {
        card.style.boxShadow = '';
      });
    });

    // Input focus highlight
    qall('input, textarea, select').forEach(inp => {
      inp.addEventListener('focus', () => {
        inp.closest('.hero-left')?.classList?.add('focus-mode');
      });
      inp.addEventListener('blur', () => {
        inp.closest('.hero-left')?.classList?.remove('focus-mode');
      });
    });

    // Simple confirmation for destructive links (add data-confirm attr to links)
    qall('a[data-confirm]').forEach(a => {
      a.addEventListener('click', (ev) => {
        const msg = a.getAttribute('data-confirm') || 'Are you sure?';
        if (!confirm(msg)) ev.preventDefault();
      });
    });
  }

  /* ----------------------------
     Smooth page transitions (progressive)
     ---------------------------- */
  function smoothNavigation() {
    if (prefersReducedMotion) return;
    // We'll fade out the page on internal navigation
    qall('a').forEach(a => {
      // only attach for same-origin internal links (not anchors with hash-only)
      const href = a.getAttribute('href') || '';
      if (!href || href.startsWith('http') || href.startsWith('#') || href.startsWith('mailto:')) return;
      a.addEventListener('click', (e) => {
        // allow ctrl/meta clicks
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        e.preventDefault();
        document.documentElement.style.transition = 'opacity 300ms ease';
        document.documentElement.style.opacity = '0';
        setTimeout(() => { window.location = href; }, 280);
      });
    });
  }

  /* ----------------------------
     Init
     ---------------------------- */
  function init() {
    initDark();
    entranceAnimate();
    microInteractions();
    smoothNavigation();
  }

  // Run when DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else init();

})();
