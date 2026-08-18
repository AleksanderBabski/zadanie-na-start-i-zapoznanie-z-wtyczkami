<?php
/**
 * Template Name: Odmiana końcówek słów Regex
 *
 * @package Demo_Theme
 */

get_header();

// Pobranie tekstu ze znacznikami z ACF, standardowej treści lub tekstu domyślnego
$custom_text = function_exists('get_field') ? get_field('tekst_odmiana') : get_post_meta(get_the_ID(), 'tekst_odmiana', true);

if (empty($custom_text)) {
    // Jeśli pole ACF jest puste, sprawdź treść wpisaną w edytorze Gutenberg
    $custom_text = get_the_content();
}

if (empty($custom_text)) {
    // Przykładowy tekst demonstracyjny z tagami {forma_męska|forma_żeńska}
    $custom_text = "Witaj {drogi|droga} Użytkowniku!\n\nCieszymy się, że {odwiedziłeś|odwiedziłaś} nasz portal. {Byłeś|Byłaś} dziś bardzo {aktywny|aktywna} i {zrobiłeś|zrobiłaś} ogromne postępy w pracy z WordPressem.\n\nCzy {chciałbyś|chciałabyś} dowiedzieć się więcej? Jesteśmy {przekonani|przekonana}, że {zostałeś|zostałaś} już świetnie przygotowany do pracy!";
}
?>

<div class="content-container gender-demo-container">
    <header class="gender-demo-header">
        <h1 class="gender-demo-title"><?php the_title(); ?></h1>
        <p class="gender-demo-subtitle">
            Wybierz płeć poniżej, aby zobaczyć dynamiczną odmianę form gramatycznych w tekście w czasie rzeczywistym.
        </p>
    </header>

    <section class="gender-selector-card">
        <h2 class="gender-selector-heading">Wybierz formę gramatyczną:</h2>
        <div class="gender-btn-group" role="group" aria-label="Wybór płci dla odmiany tekstu">
            <button type="button" class="gender-btn active" data-gender="m">
                <span class="gender-label">Mężczyzna</span>
                <span class="gender-tag">Forma męska</span>
            </button>

            <button type="button" class="gender-btn" data-gender="f">
                <span class="gender-label">Kobieta</span>
                <span class="gender-tag">Forma żeńska</span>
            </button>
        </div>
    </section>

    <article class="gender-content-card">
        <div class="gender-content-header">
            <h2 class="gender-content-title">Przekształcony tekst:</h2>
            <span class="active-gender-badge" id="current-gender-badge">Tryb: Mężczyzna</span>
        </div>

        <!-- Ukryty szablon źródłowy dla JavaScript -->
        <div id="gender-raw-template" style="display: none;" aria-hidden="true"><?php echo esc_textarea($custom_text); ?></div>

        <!-- Kontener renderowanego tekstu -->
        <div id="gender-rendered-output" class="gender-rendered-text">
        </div>
    </article>
</div>

<?php get_footer(); ?>
