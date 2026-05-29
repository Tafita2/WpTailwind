<?php
/**
 * Theme footer — Professional Blue & White Portfolio
 *
 * @package TailPress
 */
?>
</main>
<?php do_action('tailpress_content_end'); ?>
</div>
</section>

<?php do_action('tailpress_content_after'); ?>

<!-- ═══════════ CONTACT FORM (blue navy bg) ═══════════ -->
<section id="contact" class="py-24 px-4" style="background:#0A1628;">
    <div style="max-width:1100px;margin:auto;">

        <!-- Title -->
        <div style="text-align:center;margin-bottom:3.5rem;">
            <span class="section-label" style="color:#60A5FA;">— Travaillons ensemble</span>
            <h2 style="font-size:clamp(2rem,4vw,2.75rem);font-weight:800;line-height:1.15;color:#FFFFFF;margin:1rem 0;">
                Vous avez un projet <span class="gradient-text">en tête ?</span>
            </h2>
            <p style="color:rgba(255,255,255,0.5);font-size:1rem;max-width:480px;margin-inline:auto;line-height:1.8;">
                Partagez votre vision et construisons ensemble une présence digitale qui vous démarque vraiment.
            </p>
        </div>

        <!-- Two-column layout -->
        <div class="contact-grid">

            <!-- LEFT — Info -->
            <div class="contact-info-col">
                <h3 class="contact-info-title">Prenons contact</h3>
                <p class="contact-info-sub">Je suis disponible pour vos projets de développement web, design et conseil
                    digital.</p>

                <div class="contact-info-items">
                    <div class="contact-info-item">
                        <div class="contact-icon-box">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#60A5FA"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </div>
                        <div>
                            <p class="contact-info-label">Email</p>
                            <p class="contact-info-value">
                                <?php echo esc_html(get_option('portfolio_contact_email', 'contact@exemple.com')); ?>
                            </p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-icon-box">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#60A5FA"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2.69h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 10.1a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 18z" />
                            </svg>
                        </div>
                        <div>
                            <p class="contact-info-label">Téléphone</p>
                            <p class="contact-info-value">
                                <?php echo esc_html(get_option('portfolio_contact_phone', '+33 6 00 00 00 00')); ?>
                            </p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-icon-box">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#60A5FA"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </div>
                        <div>
                            <p class="contact-info-label">Disponibilité</p>
                            <p class="contact-info-value">
                                <?php echo esc_html(get_option('portfolio_contact_availability', 'Réponse sous 24h')); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT — Form -->
            <div class="contact-form-col">
                <form class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('contact_form_nonce_action', 'contact_form_nonce'); ?>
                    <input type="hidden" name="action" value="portfolio_contact_form" />

                    <div class="contact-form-row">
                        <div class="contact-form-group">
                            <label class="contact-label" for="cf_name">Nom complet</label>
                            <input type="text" id="cf_name" name="cf_name" class="contact-input"
                                placeholder="Nom et Prenom" required />
                        </div>
                        <div class="contact-form-group">
                            <label class="contact-label" for="cf_email">Adresse e-mail</label>
                            <input type="email" id="cf_email" name="cf_email" class="contact-input"
                                placeholder="Votre Adresse Email" required />
                        </div>
                    </div>

                    <div class="contact-form-group">
                        <label class="contact-label" for="cf_subject">Objet</label>
                        <input type="text" id="cf_subject" name="cf_subject" class="contact-input"
                            placeholder="Création d'un site e-commerce..." />
                    </div>

                    <div class="contact-form-group">
                        <label class="contact-label" for="cf_message">Message</label>
                        <textarea id="cf_message" name="cf_message" class="contact-input contact-textarea" rows="5"
                            placeholder="Décrivez votre projet en quelques lignes..." required></textarea>
                    </div>

                    <button type="submit" class="contact-submit">
                        Envoyer le message
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13" />
                            <polygon points="22 2 15 22 11 13 2 9 22 2" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>


<!-- ═══════════ FOOTER ═══════════ -->
<footer id="colophon" style="background:#060E1C;padding:3rem 1rem;" role="contentinfo">
    <div style="max-width:1200px;margin:auto;">
        <div class="md:flex md:items-center md:justify-between gap-6 mb-6">

            <!-- Brand -->
            <div>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2.5 mb-2"
                    style="text-decoration:none!important;">
                    <div
                        style="width:32px;height:32px;border-radius:9px;background:#2563EB;display:flex;align-items:center;justify-content:center;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 2 7 12 22 22 7 12 2" />
                        </svg>
                    </div>
                    <span style="font-weight:700;font-size:0.95rem;color:#FFFFFF;"><?php bloginfo('name'); ?></span>
                </a>
                <p style="color:rgba(255,255,255,0.4);font-size:0.78rem;">Créer. Innover. Inspirer.</p>
            </div>

            <!-- Social -->
            <div class="flex items-center gap-3 mt-4 md:mt-0">
                <a href="#" class="footer-link"
                    style="width:36px;height:36px;border-radius:50%;border:1px solid rgba(59,130,246,0.25);display:flex;align-items:center;justify-content:center;"
                    aria-label="GitHub">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z" />
                    </svg>
                </a>
                <a href="#" class="footer-link"
                    style="width:36px;height:36px;border-radius:50%;border:1px solid rgba(59,130,246,0.25);display:flex;align-items:center;justify-content:center;"
                    aria-label="LinkedIn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                    </svg>
                </a>
                <a href="#" class="footer-link"
                    style="width:36px;height:36px;border-radius:50%;border:1px solid rgba(59,130,246,0.25);display:flex;align-items:center;justify-content:center;"
                    aria-label="Twitter/X">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="gradient-divider"></div>

        <div class="md:flex md:items-center md:justify-between gap-4 mt-5">
            <p style="color:rgba(255,255,255,0.35);font-size:0.76rem;">
                &copy; <?php echo esc_html(date_i18n('Y')); ?> <?php bloginfo('name'); ?>. Tous droits réservés.
            </p>
            <!-- <p style="color:rgba(255,255,255,0.35);font-size:0.76rem;margin-top:0.4rem;">
                Propulsé par <a href="https://wordpress.org" style="color:#60A5FA;text-decoration:none;">WordPress</a>
                &amp; <a href="https://tailwindcss.com" style="color:#60A5FA;text-decoration:none;">Tailwind CSS</a>
            </p> -->
        </div>
    </div>
</footer>
<!-- ═══════════ BACK TO TOP ═══════════ -->
<a href="#" id="back-to-top" class="back-to-top" aria-label="Retour en haut">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 15l-6-6-6 6" />
    </svg>
</a>

<?php wp_footer(); ?>
</body>

</html>