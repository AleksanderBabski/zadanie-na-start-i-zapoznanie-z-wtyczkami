<?php
/**
 * Plik bootstrapujący motywu demo-theme.
 *
 * Nie zawiera logiki biznesowej — ładuje wyłącznie moduły z katalogu inc/.
 * Każdy moduł odpowiada za jedną, dobrze zdefiniowaną odpowiedzialność.
 */
if (!defined('ABSPATH')) {
    exit;
}

$inc_path = get_template_directory() . '/inc/';

require_once $inc_path . 'enqueue.php';       // Ładowanie CSS i JS
require_once $inc_path . 'menus.php';         // Rejestracja obszarów nawigacji
require_once $inc_path . 'cpt-projects.php';  // Custom Post Type: Projekty + taksonomia: Technologie
require_once $inc_path . 'metaboxes.php';     // Meta Box z custom fields dla CPT Projekty
require_once $inc_path . 'contact-form.php';  // Obsługa formularza kontaktowego (PRG)