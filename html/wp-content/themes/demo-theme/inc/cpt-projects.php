<?php
// Zabezpieczenie przed bezpośrednim dostępem do pliku
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Rejestracja Custom Post Type: Projekty (project)
 * oraz Custom Taxonomy: Technologie (technology).
 */
function demo_theme_register_cpt_projects()
{
    // 1. REJESTRACJA TAKSONOMII (Technologie)
    $taxonomy_labels = array(
        'name'          => 'Technologie',
        'singular_name' => 'Technologia',
        'search_items'  => 'Szukaj Technologii',
        'all_items'     => 'Wszystkie Technologie',
        'edit_item'     => 'Edytuj Technologię',
        'update_item'   => 'Aktualizuj Technologię',
        'add_new_item'  => 'Dodaj nową Technologię',
        'new_item_name' => 'Nazwa nowej Technologii',
        'menu_name'     => 'Technologie',
    );

    $taxonomy_args = array(
        'hierarchical'      => true,  // true = działa jak kategorie, false = jak tagi
        'labels'            => $taxonomy_labels,
        'show_ui'           => true,
        'show_admin_column' => true,  // Pokazuje kolumnę z technologiami na liście projektów w adminie
        'query_var'         => true,
        'rewrite'           => array('slug' => 'technologia'),
        'show_in_rest'      => true,  // Włącza obsługę w edytorze Gutenberg
    );

    register_taxonomy('technology', array('project'), $taxonomy_args);


    // 2. REJESTRACJA CPT (Projekty)
    $cpt_labels = array(
        'name'               => 'Projekty',
        'singular_name'      => 'Projekt',
        'menu_name'          => 'Projekty',
        'name_admin_bar'     => 'Projekt',
        'add_new'            => 'Dodaj nowy',
        'add_new_item'       => 'Dodaj nowy Projekt',
        'new_item'           => 'Nowy Projekt',
        'edit_item'          => 'Edytuj Projekt',
        'view_item'          => 'Zobacz Projekt',
        'all_items'          => 'Wszystkie Projekty',
        'search_items'       => 'Szukaj Projektów',
        'not_found'          => 'Nie znaleziono projektów.',
        'not_found_in_trash' => 'Brak projektów w koszu.',
    );

    $cpt_args = array(
        'labels'          => $cpt_labels,
        'public'          => true,
        'publicly_queryable' => true,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'query_var'       => true,
        'rewrite'         => array('slug' => 'projekty'),
        'capability_type' => 'post',
        'has_archive'     => true,  // Umożliwia widok archiwum pod adresem /projekty/
        'hierarchical'    => false,
        'menu_position'   => 5,     // Miejsce w menu bocznym wp-admin (5 = pod Wpisami)
        'menu_icon'       => 'dashicons-portfolio',
        'show_in_rest'    => true,  // Włącza edytor blokowy Gutenberg dla tego CPT
        'supports'        => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    );

    register_post_type('project', $cpt_args);
}

add_action('init', 'demo_theme_register_cpt_projects');
