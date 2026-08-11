<?php
get_header();

$plec = get_field('plec');
$kolor_tekstu = get_field('kolor_tekstu');

if (empty($kolor_tekstu)) {
    $kolor_tekstu = '#1e293b';
}
?>

<main id="primary" class="site-main acf-demo-page" style="--acf-custom-color: <?php echo esc_attr($kolor_tekstu); ?>;">
    <article class="acf-demo-card">

        <h1 class="acf-demo-title">ACF wybór płci i koloru</h1>
        <hr class="acf-demo-divider">
        <div class="user-info-box">
            <h2 class="user-info-title">Dane z wtyczki ACF:</h2>

            <p class="user-info-field">
                <strong>Wybrana płeć:</strong> <?php echo esc_html($plec ? $plec : 'Brak danych'); ?>
            </p>

            <p class="description-text">
                Ten akapit dynamicznie zmienia swój kolor w zależności od wartości wybranej w polu
                <code class="acf-code-badge">kolor_tekstu</code>
                w edytorze strony!
            </p>
        </div>

        <div class="gender-notice">
            <h3 class="gender-notice-title">Dedykowany komunikat:</h3>

            <?php if ($plec === 'Kobieta' || $plec === 'kobieta'): ?>
                <p class="gender-message">
                    Witaj! Przygotowaliśmy dla Ciebie dedykowaną ofertę dla Kobiet.
                </p>
            <?php elseif ($plec === 'Mężczyzna' || $plec === 'mezczyzna'): ?>
                <p class="gender-message">
                    Witaj! Sprawdź nasz dedykowany panel dla Mężczyzn.
                </p>
            <?php else: ?>
                <p class="gender-message">
                    Witaj na naszej stronie! Wypełnij profil w edytorze strony, aby zobaczyć spersonalizowane treści.
                </p>
            <?php endif; ?>
        </div>

    </article>
</main>

<?php
get_footer();