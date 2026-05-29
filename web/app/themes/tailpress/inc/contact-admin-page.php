<?php
/**
 * Contact Info Admin Page — Portfolio Theme
 * Accessible via: Administration > Contact
 */

// ─── Register menu page ────────────────────────────────────────
add_action('admin_menu', function () {
    add_menu_page(
        'Informations de Contact',
        'Contact',
        'manage_options',
        'portfolio-contact-settings',
        'portfolio_contact_settings_page',
        'dashicons-email-alt',
        26
    );
});

// ─── Register settings ─────────────────────────────────────────
add_action('admin_init', function () {
    register_setting('portfolio_contact_group', 'portfolio_contact_email', ['sanitize_callback' => 'sanitize_email']);
    register_setting('portfolio_contact_group', 'portfolio_contact_phone', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('portfolio_contact_group', 'portfolio_contact_availability', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('portfolio_contact_group', 'portfolio_contact_address', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('portfolio_contact_group', 'portfolio_contact_recipient', ['sanitize_callback' => 'sanitize_email']);
});

// ─── Render page ───────────────────────────────────────────────
function portfolio_contact_settings_page()
{
    // Save feedback
    $updated = isset($_GET['settings-updated']) && $_GET['settings-updated'];
    ?>
    <div class="wrap">
        <h1 style="display:flex;align-items:center;gap:10px;margin-bottom:24px;">
            <span class="dashicons dashicons-email-alt" style="font-size:28px;color:#2563EB;"></span>
            Informations de Contact
        </h1>

        <?php if ($updated): ?>
            <div class="notice notice-success is-dismissible">
                <p><strong>Informations mises à jour avec succès !</strong></p>
            </div>
        <?php endif; ?>

        <form method="post" action="options.php">
            <?php settings_fields('portfolio_contact_group'); ?>

            <div style="max-width:720px;">

                <div
                    style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);margin-bottom:24px;">
                    <div
                        style="background:#2563EB;color:#fff;padding:14px 24px;font-weight:700;font-size:14px;letter-spacing:.03em;">
                        📬 &nbsp;Coordonnées affichées sur le site
                    </div>
                    <div style="padding:24px;display:grid;gap:20px;">

                        <!-- Email public -->
                        <div>
                            <label style="display:block;font-weight:600;margin-bottom:6px;" for="pc_email">Adresse e-mail de
                                contact :</label>
                            <input type="email" id="pc_email" name="portfolio_contact_email"
                                value="<?php echo esc_attr(get_option('portfolio_contact_email', 'contact@exemple.com')); ?>"
                                style="width:100%;max-width:420px;" placeholder="contact@exemple.com" />
                            <p class="description">Affichée dans la section contact du site.</p>
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <label style="display:block;font-weight:600;margin-bottom:6px;" for="pc_phone">Téléphone
                                :</label>
                            <input type="text" id="pc_phone" name="portfolio_contact_phone"
                                value="<?php echo esc_attr(get_option('portfolio_contact_phone', '+33 6 00 00 00 00')); ?>"
                                style="width:100%;max-width:280px;" placeholder="+33 6 00 00 00 00" />
                        </div>

                        <!-- Disponibilité -->
                        <div>
                            <label style="display:block;font-weight:600;margin-bottom:6px;" for="pc_avail">Disponibilité /
                                Délai de réponse :</label>
                            <input type="text" id="pc_avail" name="portfolio_contact_availability"
                                value="<?php echo esc_attr(get_option('portfolio_contact_availability', 'Réponse sous 24h')); ?>"
                                style="width:100%;max-width:320px;" placeholder="Réponse sous 24h" />
                        </div>

                    </div>
                </div>

                <div
                    style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.06);margin-bottom:24px;">
                    <div
                        style="background:#0A1628;color:#60A5FA;padding:14px 24px;font-weight:700;font-size:14px;letter-spacing:.03em;">
                        ⚙️ &nbsp;Paramètres du formulaire
                    </div>
                    <div style="padding:24px;">
                        <label style="display:block;font-weight:600;margin-bottom:6px;" for="pc_recipient">Email de
                            réception des messages (privé) :</label>
                        <input type="email" id="pc_recipient" name="portfolio_contact_recipient"
                            value="<?php echo esc_attr(get_option('portfolio_contact_recipient', get_option('admin_email'))); ?>"
                            style="width:100%;max-width:420px;" />
                        <p class="description">Les messages du formulaire seront envoyés à cette adresse (non visible sur le
                            site).</p>
                    </div>
                </div>

                <?php submit_button('💾  Enregistrer les modifications', 'primary large'); ?>
            </div>
        </form>
    </div>
    <?php
}
