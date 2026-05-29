<?php
/**
 * Hero Settings Admin Page — Repeater for stats
 *
 * @package TailPress
 */

// Register the admin menu page
add_action('admin_menu', function () {
    add_theme_page(
        'Réglages Hero',
        '🏠 Hero (Accueil)',
        'manage_options',
        'tailpress-hero-settings',
        'tailpress_hero_settings_page'
    );
});

// Save the data
add_action('admin_post_tailpress_save_hero', function () {
    if (!current_user_can('manage_options'))
        return;
    check_admin_referer('tailpress_hero_nonce');

    $stats = [];
    if (!empty($_POST['hero_stats'])) {
        foreach ($_POST['hero_stats'] as $row) {
            $value = sanitize_text_field($row['value'] ?? '');
            $label = sanitize_text_field($row['label'] ?? '');
            if ($value !== '' || $label !== '') {
                $stats[] = ['value' => $value, 'label' => $label];
            }
        }
    }
    update_option('tailpress_hero_stats', $stats);

    wp_redirect(add_query_arg([
        'page' => 'tailpress-hero-settings',
        'saved' => '1',
    ], admin_url('themes.php')));
    exit;
});

// Render the page
function tailpress_hero_settings_page()
{
    $stats = get_option('tailpress_hero_stats', [
        ['value' => '30+', 'label' => 'Projets livrés'],
        ['value' => '5+', 'label' => "Ans d'expérience"],
        ['value' => '20+', 'label' => 'Clients satisfaits'],
    ]);
    ?>
    <div class="wrap">
        <h1 style="display:flex;align-items:center;gap:10px;">
            🏠 Réglages Hero — Statistiques
        </h1>

        <?php if (!empty($_GET['saved'])): ?>
            <div class="notice notice-success is-dismissible">
                <p>✅ Statistiques enregistrées avec succès !</p>
            </div>
        <?php endif; ?>

        <p style="color:#555;margin-bottom:24px;">
            Gérez les statistiques affichées dans la section Hero de la page d'accueil.<br>
            Vous pouvez ajouter autant de lignes que vous le souhaitez, ou en supprimer.
        </p>

        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
            <input type="hidden" name="action" value="tailpress_save_hero">
            <?php wp_nonce_field('tailpress_hero_nonce'); ?>

            <table class="wp-list-table widefat fixed striped" id="hero-stats-table" style="max-width:600px;">
                <thead>
                    <tr>
                        <th style="width:30px;">#</th>
                        <th>Chiffre (ex: 30+)</th>
                        <th>Libellé (ex: Projets livrés)</th>
                        <th style="width:80px;">Action</th>
                    </tr>
                </thead>
                <tbody id="stats-rows">
                    <?php foreach ($stats as $i => $stat): ?>
                        <tr class="stat-row">
                            <td style="color:#999;font-weight:bold;" class="row-num"><?php echo $i + 1; ?></td>
                            <td><input type="text" name="hero_stats[<?php echo $i; ?>][value]"
                                    value="<?php echo esc_attr($stat['value']); ?>" class="regular-text"
                                    style="width:100%;font-size:1.1rem;font-weight:700;" placeholder="ex: 30+"></td>
                            <td><input type="text" name="hero_stats[<?php echo $i; ?>][label]"
                                    value="<?php echo esc_attr($stat['label']); ?>" class="regular-text" style="width:100%;"
                                    placeholder="ex: Projets livrés"></td>
                            <td>
                                <button type="button" class="button remove-row" style="color:#c00;border-color:#c00;">
                                    ✕ Supprimer
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <br>
            <button type="button" id="add-stat-row" class="button button-secondary" style="margin-bottom:20px;">
                ＋ Ajouter une statistique
            </button>

            <br>
            <?php submit_button('💾 Enregistrer les statistiques', 'primary large'); ?>
        </form>
    </div>

    <script>
        (function () {
            const tbody = document.getElementById('stats-rows');
            let rowCount = tbody.querySelectorAll('.stat-row').length;

            // Update row numbers
            function updateNumbers() {
                tbody.querySelectorAll('.stat-row').forEach((row, i) => {
                    row.querySelector('.row-num').textContent = i + 1;
                    row.querySelectorAll('input').forEach(input => {
                        const name = input.getAttribute('name');
                        input.setAttribute('name', name.replace(/\[\d+\]/, '[' + i + ']'));
                    });
                });
            }

            // Remove row
            tbody.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('.stat-row').remove();
                    updateNumbers();
                }
            });

            // Add row
            document.getElementById('add-stat-row').addEventListener('click', function () {
                const i = tbody.querySelectorAll('.stat-row').length;
                const tr = document.createElement('tr');
                tr.className = 'stat-row';
                tr.innerHTML = `
                <td style="color:#999;font-weight:bold;" class="row-num">${i + 1}</td>
                <td><input type="text" name="hero_stats[${i}][value]" class="regular-text"
                    style="width:100%;font-size:1.1rem;font-weight:700;" placeholder="ex: 10+"></td>
                <td><input type="text" name="hero_stats[${i}][label]" class="regular-text"
                    style="width:100%;" placeholder="ex: Technologies maîtrisées"></td>
                <td>
                    <button type="button" class="button remove-row" style="color:#c00;border-color:#c00;">
                        ✕ Supprimer
                    </button>
                </td>
            `;
                tbody.appendChild(tr);
            });
        })();
    </script>
    <?php
}
