<?php
/**
 * Theme header — Professional Blue & White Portfolio
 *
 * @package TailPress
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-white text-slate-800 antialiased'); ?>>

    <?php do_action('tailpress_site_before'); ?>

    <!-- ═══════════ NAVIGATION ═══════════ -->
    <header id="site-header" class="site-header py-4 px-4">
        <div style="max-width:1200px;margin:auto;" class="flex items-center justify-between">

            <!-- Logo / Brand -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2.5"
                style="text-decoration:none!important;">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <div
                        style="width:38px;height:38px;border-radius:10px;background:#2563EB;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 14px rgba(37,99,235,0.35);">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 2 7 12 22 22 7 12 2" />
                        </svg>
                    </div>
                    <span class="brand-text"><?php bloginfo('name'); ?></span>
                <?php endif; ?>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center gap-8">
                <?php if (has_nav_menu('primary')): ?>
                    <?php
                    wp_nav_menu([
                        'container' => false,
                        'menu_class' => 'flex items-center gap-8',
                        'theme_location' => 'primary',
                        'fallback_cb' => false,
                    ]);
                    ?>
                <?php else: ?>
                    <a href="#hero" class="nav-link">Accueil</a>
                    <a href="#a_propos" class="nav-link">A Propos</a>
                    <a href="#portfolio" class="nav-link">Portfolio</a>
                    <a href="#contact" class="nav-link">Contact</a>
                <?php endif; ?>
            </nav>

            <!-- CTA -->
            <div class="hidden md:flex items-center gap-3">
                <a href="#contact" class="btn-primary" style="padding:0.6rem 1.5rem;font-size:0.85rem;">
                    Me Contacter
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12" />
                        <polyline points="12 5 19 12 12 19" />
                    </svg>
                </a>
            </div>

            <!-- Mobile hamburger -->
            <button id="mobile-menu-btn" aria-label="Ouvrir le menu" aria-expanded="false"
                class="md:hidden flex flex-col gap-1.5 p-2 z-50 relative">
                <span class="hamburger-bar ham-top" style="width:22px;"></span>
                <span class="hamburger-bar primary ham-mid" style="width:14px;"></span>
                <span class="hamburger-bar ham-bot" style="width:22px;"></span>
            </button>
        </div>
    </header>

    <!-- ═══════════ MOBILE DRAWER ═══════════ -->
    <!-- Backdrop -->
    <div id="drawer-backdrop"
        style="position:fixed;inset:0;background:rgba(5,12,25,0.65);z-index:200;opacity:0;pointer-events:none;transition:opacity 0.35s ease;backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);">
    </div>

    <!-- Drawer Panel (slides from left) -->
    <aside id="mobile-drawer" style="position:fixed;top:0;left:0;height:100%;width:min(300px,85vw);z-index:201;
               background:linear-gradient(160deg,#0A1628 0%,#0F2545 100%);
               border-right:1px solid rgba(59,130,246,0.18);
               transform:translateX(-100%);transition:transform 0.38s cubic-bezier(0.22,1,0.36,1);
               display:flex;flex-direction:column;overflow-y:auto;padding:0;">

        <!-- Drawer header -->
        <div
            style="display:flex;align-items:center;justify-content:space-between;padding:1.5rem 1.5rem 1rem;border-bottom:1px solid rgba(255,255,255,0.07);">
            <!-- Brand -->
            <a href="<?php echo esc_url(home_url('/')); ?>"
                style="display:flex;align-items:center;gap:10px;text-decoration:none;">
                <div
                    style="width:36px;height:36px;border-radius:9px;background:#2563EB;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 14px rgba(37,99,235,0.4);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 2 7 12 22 22 7 12 2" />
                    </svg>
                </div>
                <span style="font-weight:800;font-size:1rem;letter-spacing:-0.02em;color:#fff;">
                    <?php bloginfo('name'); ?>
                </span>
            </a>
            <!-- Close button -->
            <button id="drawer-close" class="drawer-close-btn" aria-label="Fermer le menu">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        <!-- Navigation links -->
        <nav style="padding:1.75rem 1.5rem;flex:1;display:flex;flex-direction:column;gap:0.25rem;">
            <a href="#hero" class="drawer-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                </svg>
                Accueil
            </a>
            <a href="#a_propos" class="drawer-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <rect x="2" y="3" width="20" height="14" rx="2" />
                    <line x1="8" y1="21" x2="16" y2="21" />
                    <line x1="12" y1="17" x2="12" y2="21" />
                </svg>
                A Propos
            </a>
            <a href="#portfolio" class="drawer-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" />
                    <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                </svg>
                Portfolio
            </a>
            <a href="#contact" class="drawer-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <polyline points="22,6 12,13 2,6" />
                </svg>
                Contact
            </a>
        </nav>

        <!-- CTA in drawer -->
        <div style="padding:1.25rem 1.5rem;border-top:1px solid rgba(255,255,255,0.07);">
            <a href="#contact" class="btn-primary"
                style="width:100%;justify-content:center;display:flex;font-size:0.9rem;">
                Me Contacter
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round">
                    <line x1="5" y1="12" x2="19" y2="12" />
                    <polyline points="12 5 19 12 12 19" />
                </svg>
            </a>
        </div>
    </aside>


    <!-- ═══════════ HERO ═══════════ -->
    <?php $hero_bg = get_theme_mod('hero_background_image', get_template_directory_uri() . '/resources/images/hero-bg.png'); ?>
    <section id="hero" class="hero-bg min-h-screen flex items-center pt-24 pb-20 px-4"
        style="background-image: url('<?php echo esc_url($hero_bg); ?>');">
        <div style="max-width:1200px;margin:auto;width:100%;position:relative;z-index:1;">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-16 justify-between">

                <!-- Text Column -->
                <div style="flex:1; max-width:760px;">

                    <!-- Badge -->
                    <div class="glow-badge mb-8 reveal" data-delay="0">
                        <span class="glow-dot"></span>
                        Disponible pour de nouveaux projets
                    </div>

                    <!-- Headline -->
                    <h1 class="reveal" data-delay="80"
                        style="font-size:clamp(2.6rem, 5.5vw, 4.8rem);font-weight:900;line-height:1.1;letter-spacing:-0.03em;color:#FFFFFF;margin-bottom:1.5rem;min-height:2.2em;">
                        <span id="typewriter"></span><span class="typewriter-cursor">|</span>
                    </h1>

                    <!-- Subtitle -->
                    <p class="reveal" data-delay="180"
                        style="font-size:1.15rem;color:rgba(255,255,255,0.6);line-height:1.8;max-width:560px;margin-bottom:2.5rem;">
                        Développeur & Designer, je conçois des sites web professionnels qui attirent, engagent et
                        convertissent. De la maquette au déploiement.
                    </p>

                    <!-- Mobile Profile Picture (shown on small screens) -->
                    <?php $profile_pic = get_theme_mod('hero_profile_picture'); ?>
                    <?php if ($profile_pic): ?>
                        <div class="lg:hidden reveal w-full max-w-xs mx-auto mb-10" data-delay="220">
                            <div
                                style="padding:0.6rem; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.12); border-radius:2rem; backdrop-filter:blur(12px);">
                                <img src="<?php echo esc_url($profile_pic); ?>" alt="Profile"
                                    style="width:100%; height:auto; border-radius:1.5rem; object-fit:cover; display:block;" />
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 reveal" data-delay="260">
                        <a href="#portfolio" class="btn-white"
                            style="padding:0.85rem 2.2rem;font-size:0.95rem;justify-content:center;">
                            Voir mes projets
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12" />
                                <polyline points="12 5 19 12 12 19" />
                            </svg>
                        </a>
                        <a href="#contact" class="btn-outline-blue"
                            style="padding:0.85rem 2.2rem;font-size:0.95rem;border:2px solid rgba(255,255,255,0.3);color:#FFFFFF;border-radius:9999px;display:inline-flex;justify-content:center;align-items:center;gap:0.5rem;font-weight:600;transition:border-color 0.2s ease,background 0.2s ease;text-decoration:none!important;">
                            Me contacter
                        </a>
                    </div>

                    <!-- Stats Row (dynamiques depuis Apparence > 🏠 Hero Accueil) -->
                    <?php
                    $hero_stats = get_option('tailpress_hero_stats', [
                        ['value' => '30+', 'label' => 'Projets livrés'],
                        ['value' => '5+', 'label' => "Ans d'expérience"],
                        ['value' => '20+', 'label' => 'Clients satisfaits'],
                    ]);
                    ?>
                    <?php if (!empty($hero_stats)): ?>
                        <div class="flex flex-wrap gap-8 mt-14 pt-8 reveal" data-delay="300"
                            style="border-top:1px solid rgba(255,255,255,0.1);">
                            <?php foreach ($hero_stats as $i => $stat): ?>
                                <?php if ($i > 0): ?>
                                    <div class="hidden sm:block"
                                        style="width:1px;background:rgba(255,255,255,0.12);align-self:stretch;"></div>
                                <?php endif; ?>
                                <div>
                                    <div class="stat-number"><?php echo esc_html($stat['value']); ?></div>
                                    <div style="color:rgba(255,255,255,0.5);font-size:0.82rem;margin-top:4px;font-weight:500;">
                                        <?php echo esc_html($stat['label']); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>


                </div>

                <!-- Desktop Profile Picture Column -->
                <?php if ($profile_pic): ?>
                    <div class="hidden lg:block reveal" data-delay="400" style="flex:0 0 420px; position:relative;">
                        <div
                            style="position:absolute; inset:0; background:radial-gradient(circle at center, rgba(37,99,235,0.4) 0%, transparent 70%); filter:blur(40px); z-index:-1; transform:scale(1.2);">
                        </div>
                        <div
                            style="padding:1.25rem; background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.12); border-radius:2.5rem; backdrop-filter:blur(12px); box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);">
                            <img src="<?php echo esc_url($profile_pic); ?>" alt="Profile"
                                style="width:100%; height:auto; border-radius:1.75rem; object-fit:cover; display:block;" />
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <!-- ═══════════ SERVICES (white bg) ═══════════ -->
    <section id="a_propos" class="py-28 px-4 dot-pattern" style="background:#F8FAFF;">
        <div style="max-width:1200px;margin:auto;">

            <div class="text-center mb-16 reveal">
                <span class="section-label">— Ce que je fais</span>
                <h2 class="section-title">Mes <span class="gradient-text">Services</span></h2>
                <p class="section-sub" style="margin-inline:auto;text-align:center;">De la conception à la réalisation,
                    je vous accompagne à chaque étape de votre projet digital.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="white-card p-8 reveal" data-delay="0">
                    <div class="service-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M3 9h18" />
                            <path d="M9 21V9" />
                        </svg>
                    </div>
                    <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:0.6rem;color:#0F172A;">Design UI/UX</h3>
                    <p style="color:#64748B;font-size:0.875rem;line-height:1.75;">Interfaces intuitives, modernes et
                        esthétiques qui captivent vos visiteurs et améliorent la conversion.</p>
                </div>

                <div class="white-card p-8 reveal" data-delay="100">
                    <div class="service-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="16 18 22 12 16 6" />
                            <polyline points="8 6 2 12 8 18" />
                        </svg>
                    </div>
                    <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:0.6rem;color:#0F172A;">Développement Web
                    </h3>
                    <p style="color:#64748B;font-size:0.875rem;line-height:1.75;">Sites WordPress modernes avec Bedrock
                        et Tailwind CSS, rapides, sécurisés et évolutifs.</p>
                </div>

                <div class="white-card p-8 reveal" data-delay="200">
                    <div class="service-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2L2 7l10 5 10-5-10-5z" />
                            <path d="M2 17l10 5 10-5" />
                            <path d="M2 12l10 5 10-5" />
                        </svg>
                    </div>
                    <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:0.6rem;color:#0F172A;">Architecture &
                        DevOps</h3>
                    <p style="color:#64748B;font-size:0.875rem;line-height:1.75;">Infrastructure Docker, CI/CD,
                        hébergement cloud et déploiements automatisés pour vos projets.</p>
                </div>

                <div class="white-card p-8 reveal" data-delay="0">
                    <div class="service-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M2 12h20" />
                            <path
                                d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                        </svg>
                    </div>
                    <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:0.6rem;color:#0F172A;">SEO & Performance
                    </h3>
                    <p style="color:#64748B;font-size:0.875rem;line-height:1.75;">Optimisation moteurs de recherche et
                        temps de chargement ultra-rapides pour plus de visibilité.</p>
                </div>

                <div class="white-card p-8 reveal" data-delay="100">
                    <div class="service-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="5" y="2" width="14" height="20" rx="2" />
                            <line x1="12" y1="18" x2="12.01" y2="18" />
                        </svg>
                    </div>
                    <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:0.6rem;color:#0F172A;">Responsive Design
                    </h3>
                    <p style="color:#64748B;font-size:0.875rem;line-height:1.75;">Expériences parfaites et cohérentes
                        sur tous les appareils — mobile, tablette, desktop.</p>
                </div>

                <div class="white-card p-8 reveal" data-delay="200">
                    <div class="service-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.18 12.18 0 0 0 .66 2.68 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.18 12.18 0 0 0 2.68.66A2 2 0 0 1 22 16.92z" />
                        </svg>
                    </div>
                    <h3 style="font-size:1.1rem;font-weight:700;margin-bottom:0.6rem;color:#0F172A;">Support &
                        Maintenance</h3>
                    <p style="color:#64748B;font-size:0.875rem;line-height:1.75;">Accompagnement continu, mises à jour
                        régulières et évolution long-terme de vos projets.</p>
                </div>

            </div>
        </div>
    </section>

    <div class="gradient-divider"></div>

    <!-- ═══════════ PORTFOLIO (white) ═══════════ -->
    <section id="portfolio" class="py-28 px-4" style="background:#FFFFFF;">
        <div style="max-width:1200px;margin:auto;">
            <div class="text-center mb-16 reveal">
                <span class="section-label">— Mes réalisations</span>
                <h2 class="section-title">Mon <span class="gradient-text">Portfolio</span></h2>
                <p class="section-sub" style="margin-inline:auto;text-align:center;">Projets récents qui illustrent mon
                    approche créative et mon excellence technique.</p>
            </div>

            <?php do_action('tailpress_content_start'); ?>
            <main>