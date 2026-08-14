<?php
// Zabezpieczenie przed bezpośrednim dostępem do pliku
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Rejestracja Meta Boxa w panelu edycji Projektu.
 */
function demo_theme_add_project_metabox()
{
    add_meta_box(
        'project_details_mb',
        'Szczegóły Projektu (Custom Fields)',
        'demo_theme_project_metabox_html',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'demo_theme_add_project_metabox');

/**
 * Renderowanie HTML formularza Meta Boxa.
 *
 * @param WP_Post $post Aktualnie edytowany post.
 */
function demo_theme_project_metabox_html($post)
{
    $github_url = get_post_meta($post->ID, '_project_github_url', true);
    $deadline   = get_post_meta($post->ID, '_project_deadline', true);

    wp_nonce_field('demo_theme_save_project_meta', 'demo_theme_project_nonce');
    ?>
    <p>
        <label for="project_github_url"><strong>URL Repozytorium GitHub:</strong></label><br>
        <input type="url" id="project_github_url" name="project_github_url"
               value="<?php echo esc_attr($github_url); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="project_deadline"><strong>Termin wykonania:</strong></label><br>
        <input type="text" id="project_deadline" name="project_deadline"
               value="<?php echo esc_attr($deadline); ?>"
               placeholder="np. Q3 2026 / 2 tygodnie" style="width: 100%;">
    </p>
    <?php
}

/**
 * Zapisywanie danych z Meta Boxa przy zapisie posta.
 *
 * @param int $post_id ID zapisywanego posta.
 */
function demo_theme_save_project_meta($post_id)
{
    // Weryfikacja nonce (zabezpieczenie przed CSRF)
    if (!isset($_POST['demo_theme_project_nonce']) || !wp_verify_nonce($_POST['demo_theme_project_nonce'], 'demo_theme_save_project_meta')) {
        return;
    }

    // Pomiń autozapis
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Sprawdzenie uprawnień
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['project_github_url'])) {
        update_post_meta($post_id, '_project_github_url', esc_url_raw($_POST['project_github_url']));
    }

    if (isset($_POST['project_deadline'])) {
        update_post_meta($post_id, '_project_deadline', sanitize_text_field($_POST['project_deadline']));
    }
}
add_action('save_post', 'demo_theme_save_project_meta');
