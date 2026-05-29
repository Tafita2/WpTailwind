// ─── Sticky nav & Back to top ───────────────────────────────────────
const header = document.getElementById('site-header');
const backToTopBtn = document.getElementById('back-to-top');

window.addEventListener('scroll', () => {
    // Nav header
    if (header) {
        if (window.scrollY > 40) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }
    // Back to top button
    if (backToTopBtn) {
        if (window.scrollY > 400) {
            backToTopBtn.classList.add('visible');
        } else {
            backToTopBtn.classList.remove('visible');
        }
    }
}, { passive: true });

if (backToTopBtn) {
    backToTopBtn.addEventListener('click', (e) => {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
        // Reset URL if it's not already root
        if (window.location.pathname !== '/' || window.location.hash !== '') {
            history.pushState(null, '', '/');
        }
    });
}


// ─── Clean URL anchor navigation (History API) ──────────────────────
document.addEventListener('click', (e) => {
    const link = e.target.closest('a[href^="#"]');
    if (!link) return;
    const hash = link.getAttribute('href');
    if (hash === '#') return;
    const target = document.querySelector(hash);
    if (!target) return;

    e.preventDefault();
    // Smooth scroll to target
    const headerOffset = header ? header.offsetHeight + 12 : 80;
    const top = target.getBoundingClientRect().top + window.scrollY - headerOffset;
    window.scrollTo({ top, behavior: 'smooth' });

    // Clean URL: /services instead of /#services, / instead of /#hero
    const cleanPath = (hash === '#hero') ? '/' : hash.replace('#', '/');
    history.pushState(null, '', cleanPath);
});


// ─── Mobile drawer toggle ─────────────────────────────────────────────
const menuBtn = document.getElementById('mobile-menu-btn');
const drawer = document.getElementById('mobile-drawer');
const backdrop = document.getElementById('drawer-backdrop');
const closeBtn = document.getElementById('drawer-close');
const drawerLinks = document.querySelectorAll('.drawer-link');

function openDrawer() {
    if (!drawer) return;
    drawer.style.transform = 'translateX(0)';
    backdrop.style.opacity = '1';
    backdrop.style.pointerEvents = 'auto';
    menuBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden'; // Prevent scrolling
}

function closeDrawer() {
    if (!drawer) return;
    drawer.style.transform = 'translateX(-100%)';
    backdrop.style.opacity = '0';
    backdrop.style.pointerEvents = 'none';
    menuBtn.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
}

if (menuBtn) menuBtn.addEventListener('click', openDrawer);
if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
if (backdrop) backdrop.addEventListener('click', closeDrawer);
drawerLinks.forEach(link => {
    link.addEventListener('click', () => {
        closeDrawer();
        // The History API listener will handle the scroll since these are anchor links!
    });
});


// ─── Scroll reveal ──────────────────────────────────────────────────
const revealEls = document.querySelectorAll('.reveal');
if (revealEls.length) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, (entry.target.dataset.delay || 0) * 1);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    revealEls.forEach(el => observer.observe(el));
}

// ─── Typewriter Effect ──────────────────────────────────────────────
const typeWriterEl = document.getElementById('typewriter');
if (typeWriterEl) {
    // Les phrases à écrire (récupérées depuis le BO via wp_add_inline_script)
    let phrases = [
        "Créateur d'expériences <span class=\"gradient-text\">web modernes</span> et performantes"
    ];
    if (typeof tailpressHeroData !== 'undefined' && tailpressHeroData.phrases.length > 0) {
        phrases = tailpressHeroData.phrases;
    }

    let phraseIndex = 0;
    let isDeleting = false;

    // Pour ne pas "afficher" lettre par lettre le tag HTML:
    // On convertit la phrase en tableau de "segments" (texte pur ou bout de texte + balise)
    // Plus simple : on tape le texte brut, et on applique la classe `gradient-text` magiquement.
    // Mais on veut le code HTML complet.

    let currentText = '';
    let htmlIndex = 0;

    function type() {
        const fullPhraseHTML = phrases[phraseIndex];

        if (!isDeleting) {
            // Typing
            if (currentText.length < fullPhraseHTML.length) {
                // If we hit an HTML tag, skip to the end of the tag instantly
                if (fullPhraseHTML.charAt(currentText.length) === '<') {
                    let endIndex = fullPhraseHTML.indexOf('>', currentText.length);
                    // Add the entire tag to currentText
                    currentText = fullPhraseHTML.substring(0, endIndex + 1);
                } else {
                    currentText = fullPhraseHTML.substring(0, currentText.length + 1);
                }
                typeWriterEl.innerHTML = currentText;
                setTimeout(type, 40 + Math.random() * 40);
            } else {
                // Done typing, wait before deleting
                isDeleting = true;
                setTimeout(type, 3000);
            }
        } else {
            // Deleting
            if (currentText.length > 0) {
                // If we hit an HTML tag end (>) while deleting, delete the whole tag instantly
                if (currentText.charAt(currentText.length - 1) === '>') {
                    let startIndex = currentText.lastIndexOf('<');
                    currentText = currentText.substring(0, startIndex);
                } else {
                    currentText = currentText.substring(0, currentText.length - 1);
                }
                typeWriterEl.innerHTML = currentText;
                setTimeout(type, 20 + Math.random() * 20);
            } else {
                // Done deleting, move to next phrase
                isDeleting = false;
                phraseIndex = (phraseIndex + 1) % phrases.length;
                setTimeout(type, 600);
            }
        }
    }

    // Start typing after initial delay
    setTimeout(type, 1000);
}
