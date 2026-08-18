<?php
// Zabezpieczenie przed bezpośrednim dostępem do pliku
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Ładowanie stylów CSS i skryptów JS motywu.
 *
 * Hook 'wp_enqueue_scripts' to standardowe miejsce do ładowania CSS i JS.
 */
function demo_theme_enqueue_styles()
{
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // 1. Podpięcie głównego pliku style.css
    wp_enqueue_style(
        'demo-theme-style',
        get_stylesheet_uri(),
        array(),
        filemtime($theme_dir . '/style.css')
    );

    // 2. Podstawowe moduły CSS ładowane globalnie
    wp_enqueue_style(
        'demo-theme-base',
        $theme_uri . '/css/base.css',
        array(),
        filemtime($theme_dir . '/css/base.css')
    );

    wp_enqueue_style(
        'demo-theme-components',
        $theme_uri . '/css/components.css',
        array('demo-theme-base'),
        filemtime($theme_dir . '/css/components.css')
    );

    wp_enqueue_style(
        'demo-theme-navigation',
        $theme_uri . '/css/navigation.css',
        array('demo-theme-base'),
        filemtime($theme_dir . '/css/navigation.css')
    );

    // 3. Warunkowe ładowanie stylów tylko na dedykowanych widokach

    // Styl dla strony głównej oraz pojedynczego projektu CPT
    if (is_front_page() || is_singular('project') || is_post_type_archive('project')) {
        wp_enqueue_style(
            'demo-theme-projects',
            $theme_uri . '/css/projects.css',
            array('demo-theme-base', 'demo-theme-components'),
            filemtime($theme_dir . '/css/projects.css')
        );
    }

    // Styl dla bloga (lista wpisów, pojedynczy wpis, archiwa)
    if (is_home() || is_singular('post') || is_archive() || is_search()) {
        wp_enqueue_style(
            'demo-theme-blog',
            $theme_uri . '/css/blog.css',
            array('demo-theme-base', 'demo-theme-components'),
            filemtime($theme_dir . '/css/blog.css')
        );
    }

    // Styl dla formularza kontaktowego
    if (is_page('kontakt') || is_page_template('page-kontakt.php')) {
        wp_enqueue_style(
            'demo-theme-contact',
            $theme_uri . '/css/contact.css',
            array('demo-theme-base', 'demo-theme-components'),
            filemtime($theme_dir . '/css/contact.css')
        );
    }

    // Styl dla strony błędu 404
    if (is_404()) {
        wp_enqueue_style(
            'demo-theme-error-404',
            $theme_uri . '/css/error-404.css',
            array('demo-theme-base', 'demo-theme-components'),
            filemtime($theme_dir . '/css/error-404.css')
        );
    }

    // Styl dla strony demonstracyjnej ACF (kolory i płeć)
    if (is_page('acf-plec-i-kolory') || is_page_template('page-acf-demo.php')) {
        wp_enqueue_style(
            'demo-theme-acf-demo',
            $theme_uri . '/css/acf-demo.css',
            array('demo-theme-base', 'demo-theme-components'),
            filemtime($theme_dir . '/css/acf-demo.css')
        );
    }

    // Styl dla strony taksonomii ACF / CPT filmy
    if (is_page('acf-typy-tresci-taksonomie') || is_page_template('page-acf-taksonomie.php') || is_post_type_archive('filmy')) {
        wp_enqueue_style(
            'demo-theme-acf-taksonomie',
            $theme_uri . '/css/acf-taksonomie.css',
            array('demo-theme-base', 'demo-theme-components'),
            filemtime($theme_dir . '/css/acf-taksonomie.css')
        );
    }

    // Styl dla strony dynamicznej odmiany tekstu wg płci (Placeholders)
    if (is_page('odmiana-tekstu') || is_page_template('page-gender-text.php')) {
        wp_enqueue_style(
            'demo-theme-gender-text',
            $theme_uri . '/css/gender-text.css',
            array('demo-theme-base', 'demo-theme-components'),
            filemtime($theme_dir . '/css/gender-text.css')
        );

        wp_enqueue_script(
            'demo-theme-gender-text',
            $theme_uri . '/js/gender-text.js',
            array(),
            filemtime($theme_dir . '/js/gender-text.js'),
            true
        );
    }

    // 4. Skrypt do nawigacji mobilnej (w stopce)
    wp_enqueue_script(
        'demo-theme-navigation',
        $theme_uri . '/js/navigation.js',
        array(),
        filemtime($theme_dir . '/js/navigation.js'),
        true
    );
}

add_action('wp_enqueue_scripts', 'demo_theme_enqueue_styles');
