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
    $theme_version = '1.0.0';
    $theme_uri = get_template_directory_uri();

    // 1. Podpięcie głównego pliku style.css (zawiera metadane motywu)
    wp_enqueue_style(
        'demo-theme-style',
        get_stylesheet_uri(),
        array(),
        $theme_version
    );

    // 2. Podpięcie modułów CSS z obsługą zależności (dependencies)
    wp_enqueue_style(
        'demo-theme-base',
        $theme_uri . '/css/base.css',
        array(),
        $theme_version
    );

    wp_enqueue_style(
        'demo-theme-components',
        $theme_uri . '/css/components.css',
        array('demo-theme-base'),
        $theme_version
    );

    wp_enqueue_style(
        'demo-theme-navigation',
        $theme_uri . '/css/navigation.css',
        array('demo-theme-base'),
        $theme_version
    );

    wp_enqueue_style(
        'demo-theme-projects',
        $theme_uri . '/css/projects.css',
        array('demo-theme-base', 'demo-theme-components'),
        $theme_version
    );

    wp_enqueue_style(
        'demo-theme-contact',
        $theme_uri . '/css/contact.css',
        array('demo-theme-base', 'demo-theme-components'),
        $theme_version
    );

    wp_enqueue_style(
        'demo-theme-error-404',
        $theme_uri . '/css/error-404.css',
        array('demo-theme-base', 'demo-theme-components'),
        $theme_version
    );

    wp_enqueue_style(
        'demo-theme-acf-demo',
        $theme_uri . '/css/acf-demo.css',
        array('demo-theme-base', 'demo-theme-components'),
        $theme_version
    );

    wp_enqueue_style(
        'demo-theme-acf-taksonomie',
        $theme_uri . '/css/acf-taksonomie.css',
        array('demo-theme-base', 'demo-theme-components'),
        $theme_version
    );

    wp_enqueue_style(
        'demo-theme-blog',
        $theme_uri . '/css/blog.css',
        array('demo-theme-base', 'demo-theme-components'),
        $theme_version
    );

    // Podpięcie skryptu do nawigacji mobilnej (załadowany w stopce dla lepszej wydajności)
    wp_enqueue_script(
        'demo-theme-navigation',
        $theme_uri . '/js/navigation.js',
        array(),
        $theme_version,
        true
    );
}

add_action('wp_enqueue_scripts', 'demo_theme_enqueue_styles');
