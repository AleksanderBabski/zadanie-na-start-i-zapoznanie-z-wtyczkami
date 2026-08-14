<?php
// Zabezpieczenie przed bezpośrednim dostępem do pliku
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Obsługa formularza kontaktowego (wzorzec Post/Redirect/Get).
 *
 * Hooki admin_post_* przechwytują żądania POST wysłane do admin-post.php
 * z action="submit_contact_form".
 */
function demo_theme_handle_contact_form()
{
    // 1. Sprawdzenie metody żądania (tylko POST)
    if ('POST' !== $_SERVER['REQUEST_METHOD']) {
        wp_die('Niedozwolona metoda żądania.', 'Błąd', array('response' => 405));
    }

    // 2. Weryfikacja nonce (zabezpieczenie przed CSRF)
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'contact_form_submit')) {
        wp_die('Błąd bezpieczeństwa! Nieprawidłowy żeton nonce.', 'Błąd', array('response' => 403));
    }

    // 3. Pobranie i sanityzacja danych z $_POST (ochrona przed XSS i SQL Injection)
    $name    = isset($_POST['contact_name'])    ? sanitize_text_field($_POST['contact_name'])       : '';
    $email   = isset($_POST['contact_email'])   ? sanitize_email($_POST['contact_email'])            : '';
    $message = isset($_POST['contact_message']) ? sanitize_textarea_field($_POST['contact_message']) : '';

    // Bezpieczny URL powrotny
    $referer      = wp_get_referer();
    $redirect_url = $referer ? $referer : home_url('/');

    // 4. Walidacja danych
    if (empty($name) || empty($email) || !is_email($email) || empty($message)) {
        wp_safe_redirect(add_query_arg('contact_status', 'error', $redirect_url));
        exit;
    }

    // 5. Wysyłka maila
    $to      = get_option('admin_email');
    $subject = 'Nowa wiadomość ze strony kontaktowej od ' . $name;

    $body  = "Masz nową wiadomość z formularza kontaktowego:\n\n";
    $body .= "Imię i nazwisko: " . $name . "\n";
    $body .= "Email: " . $email . "\n\n";
    $body .= "Treść:\n" . $message . "\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );

    wp_mail($to, $subject, $body, $headers);

    // 6. Przekierowanie HTTP 302 po sukcesie (zapobiega ponownemu wysłaniu po odświeżeniu)
    wp_safe_redirect(add_query_arg('contact_status', 'success', $redirect_url));
    exit;
}

// Dla użytkowników niezalogowanych i zalogowanych
add_action('admin_post_nopriv_submit_contact_form', 'demo_theme_handle_contact_form');
add_action('admin_post_submit_contact_form',        'demo_theme_handle_contact_form');
