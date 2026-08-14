<?php
// Zabezpieczenie przed bezpośrednim dostępem do pliku
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Rejestracja obszarów nawigacji (menu locations) motywu.
 */
function demo_theme_register_menus()
{
    register_nav_menus(array(
        'primary' => 'Główne Menu Nawigacji',
    ));
}
add_action('after_setup_theme', 'demo_theme_register_menus');
