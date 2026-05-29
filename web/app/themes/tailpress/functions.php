<?php

if (is_file(__DIR__ . '/vendor/autoload_packages.php')) {
    require_once __DIR__ . '/vendor/autoload_packages.php';
}

// Admin pages
require_once __DIR__ . '/inc/hero-admin-page.php';
require_once __DIR__ . '/inc/contact-admin-page.php';


// Bypassing Docker network restriction for Vite dev server
class CustomViteCompiler extends TailPress\Framework\Assets\ViteCompiler
{
    public function isDevServerRunning(): bool
    {
        // En développement, on force le serveur Vite à vrai car wp_remote_get échoue (PHP = dans Docker, Vite = sur l'hôte)
        if (wp_get_environment_type() === 'local' || wp_get_environment_type() === 'development') {
            return true;
        }
        return parent::isDevServerRunning();
    }
}

function tailpress(): TailPress\Framework\Theme
{
    return TailPress\Framework\Theme::instance()
        ->assets(
            fn($manager) => $manager
                ->withCompiler(
                    new CustomViteCompiler('http://localhost:3000'),
                    fn($compiler) => $compiler
                        ->registerAsset('resources/css/app.css')
                        ->registerAsset('resources/js/app.js')
                        ->editorStyleFile('resources/css/editor-style.css')
                )
                ->enqueueAssets()
        )
        ->features(fn($manager) => $manager->add(TailPress\Framework\Features\MenuOptions::class))
        ->menus(fn($manager) => $manager->add('primary', __('Primary Menu', 'tailpress')))
        ->themeSupport(fn($manager) => $manager->add([
            'title-tag',
            'custom-logo',
            'post-thumbnails',
            'align-wide',
            'wp-block-styles',
            'responsive-embeds',
            'html5' => [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ]
        ]));
}

add_action('after_setup_theme', 'tailpress');

// Correction du chargement en module JS (Vite Dev Server)
add_filter('script_loader_tag', function ($tag, $handle) {
    if (in_array($handle, ['tailpress-app'])) {
        if (strpos($tag, 'type="module"') === false) {
            $tag = str_replace('<script ', '<script type="module" ', $tag);
        }
    }
    return $tag;
}, 20, 2);

// ─── CUSTOMIZER: HERO ──────────────────────────────────────────────
add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('tailpress_hero_section', [
        'title' => 'Section Hero (Accueil)',
        'priority' => 30,
    ]);

    // Background Image
    $wp_customize->add_setting('hero_background_image', [
        'default' => get_template_directory_uri() . '/resources/images/hero-bg.png',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', [
        'label' => 'Image de fond (Hero)',
        'section' => 'tailpress_hero_section',
        'settings' => 'hero_background_image',
    ]));

    // Profile Picture
    $wp_customize->add_setting('hero_profile_picture', [
        'default' => '',
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_profile_picture', [
        'label' => 'Photo de profil (Hero)',
        'section' => 'tailpress_hero_section',
        'settings' => 'hero_profile_picture',
    ]));

    // Typewriter Texts
    $wp_customize->add_setting('hero_typewriter_texts', [
        'default' => "Créateur d'expériences <span class=\"gradient-text\">web modernes</span> et performantes",
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('hero_typewriter_texts', [
        'label' => 'Textes animés (Machine à écrire)',
        'description' => 'Un texte par ligne. Vous pouvez utiliser <span class="gradient-text">mot</span> pour faire un mot en bleu.',
        'section' => 'tailpress_hero_section',
        'type' => 'textarea',
    ]);

    // ── Statistiques Hero ─────────────────────────────────────
    $stats = [
        1 => ['value' => '30+', 'label' => 'Projets livrés'],
        2 => ['value' => '5+', 'label' => "Ans d'expérience"],
        3 => ['value' => '20+', 'label' => 'Clients satisfaits'],
    ];
    foreach ($stats as $i => $defaults) {
        $wp_customize->add_setting("hero_stat_{$i}_value", [
            'default' => $defaults['value'],
            'transport' => 'refresh',
        ]);
        $wp_customize->add_control("hero_stat_{$i}_value", [
            'label' => "Statistique {$i} — Chiffre",
            'section' => 'tailpress_hero_section',
            'type' => 'text',
        ]);
        $wp_customize->add_setting("hero_stat_{$i}_label", [
            'default' => $defaults['label'],
            'transport' => 'refresh',
        ]);
        $wp_customize->add_control("hero_stat_{$i}_label", [
            'label' => "Statistique {$i} — Libellé",
            'section' => 'tailpress_hero_section',
            'type' => 'text',
        ]);
    }
});


// Inject Customizer settings to JS
add_action('wp_enqueue_scripts', function () {
    $texts = get_theme_mod('hero_typewriter_texts', "Créateur d'expériences <span class=\"gradient-text\">web modernes</span> et performantes");
    // Extraire les lignes non vides
    $phrases = array_filter(array_map('trim', explode("\n", $texts)));

    // Inject custom JS object
    wp_register_script('tailpress-hero-data', false);
    wp_enqueue_script('tailpress-hero-data');
    wp_add_inline_script('tailpress-hero-data', 'const tailpressHeroData = ' . json_encode([
        'phrases' => array_values($phrases)
    ]) . ';');
});

add_action('after_setup_theme', function () {
    add_theme_support('post-thumbnails');
});

// ─── CPT: PORTFOLIO ──────────────────────────────────────────────
add_action('init', function () {
    register_post_type('portfolio', [
        'labels' => [
            'name' => 'Portfolio',
            'singular_name' => 'Projet Portfolio',
            'menu_name' => 'Portfolio',
            'add_new' => 'Ajouter un projet',
            'add_new_item' => 'Ajouter un nouveau projet',
            'edit_item' => 'Modifier le projet',
            'new_item' => 'Nouveau projet',
            'view_item' => 'Voir le projet',
            'all_items' => 'Tous les projets',
            'search_items' => 'Rechercher un projet',
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest' => true, // Gutenberg support
        'rewrite' => ['slug' => 'portfolio'],
    ]);
});

// Metabox URL & Client
add_action('add_meta_boxes', function () {
    add_meta_box('portfolio_details', 'Détails du Projet', function ($post) {
        wp_nonce_field('portfolio_details_nonce_action', 'portfolio_details_nonce');
        $url = get_post_meta($post->ID, '_portfolio_url', true);
        $client = get_post_meta($post->ID, '_portfolio_client', true);
        $techs = get_post_meta($post->ID, '_portfolio_techs', true);

        echo '<div style="margin-bottom:15px;">';
        echo '<label for="portfolio_client" style="display:block;margin-bottom:8px;font-weight:600;">Nom de l\'entreprise / Client :</label>';
        echo '<input type="text" id="portfolio_client" name="portfolio_client" value="' . esc_attr($client) . '" style="width:100%;max-width:500px;" placeholder="Ex: Apple, Nike..." />';
        echo '<p style="color:#666;font-size:13px;margin-top:6px;">Sera affiché sur le bas de la face avant de la carte.</p>';
        echo '</div>';

        echo '<div style="margin-bottom:15px;">';
        echo '<label for="portfolio_techs" style="display:block;margin-bottom:8px;font-weight:600;">Langages/Technologies (séparées par une virgule) :</label>';
        echo '<input type="text" id="portfolio_techs" name="portfolio_techs" value="' . esc_attr($techs) . '" style="width:100%;max-width:500px;" placeholder="E-COMMERCE, PRESTASHOP, REACT..." />';
        echo '<p style="color:#666;font-size:13px;margin-top:6px;">Les badges qui s\'afficheront sur la face avant.</p>';
        echo '</div>';

        echo '<div>';
        echo '<label for="portfolio_url" style="display:block;margin-bottom:8px;font-weight:600;">URL externe du projet (Optionnel) :</label>';
        echo '<input type="url" id="portfolio_url" name="portfolio_url" value="' . esc_attr($url) . '" style="width:100%;max-width:500px;" placeholder="https://..." />';
        echo '<p style="color:#666;font-size:13px;margin-top:6px;">Lien du bouton "Visiter le projet" au dos de la carte.</p>';
        echo '</div>';
    }, 'portfolio', 'normal', 'high');
});

add_action('save_post', function ($post_id) {
    if (!isset($_POST['portfolio_details_nonce']) || !wp_verify_nonce($_POST['portfolio_details_nonce'], 'portfolio_details_nonce_action')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['portfolio_client'])) {
        update_post_meta($post_id, '_portfolio_client', sanitize_text_field($_POST['portfolio_client']));
    }
    if (isset($_POST['portfolio_techs'])) {
        update_post_meta($post_id, '_portfolio_techs', sanitize_text_field($_POST['portfolio_techs']));
    }
    if (isset($_POST['portfolio_url'])) {
        update_post_meta($post_id, '_portfolio_url', sanitize_url($_POST['portfolio_url']));
    }
});

// ─── CONTACT FORM HANDLER ──────────────────────────────────────
add_action('admin_post_portfolio_contact_form', 'handle_portfolio_contact');
add_action('admin_post_nopriv_portfolio_contact_form', 'handle_portfolio_contact');

function handle_portfolio_contact()
{
    if (!isset($_POST['contact_form_nonce']) || !wp_verify_nonce($_POST['contact_form_nonce'], 'contact_form_nonce_action')) {
        wp_die('Requête invalide.', 'Erreur', ['response' => 403]);
    }

    $name = sanitize_text_field($_POST['cf_name'] ?? '');
    $email = sanitize_email($_POST['cf_email'] ?? '');
    $subject = sanitize_text_field($_POST['cf_subject'] ?? 'Nouveau message de contact');
    $message = sanitize_textarea_field($_POST['cf_message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        wp_redirect(add_query_arg('contact', 'error', wp_get_referer()));
        exit;
    }

    $to = get_option('portfolio_contact_recipient', get_option('admin_email'));
    $headers = ["Reply-To: {$name} <{$email}>", 'Content-Type: text/plain; charset=UTF-8'];
    $body = "Nom     : {$name}\nEmail   : {$email}\nObjet   : {$subject}\n\n{$message}";

    $sent = wp_mail($to, '[Portfolio] ' . $subject, $body, $headers);

    $status = $sent ? 'success' : 'error';
    wp_redirect(add_query_arg('contact', $status, home_url('/#contact')));
    exit;
}
