<?php get_header(); ?>

<main id="primary" class="site-main">
    <div class="content-container filmy-container">
        <h1 class="filmy-page-title">Lista Filmów</h1>

        <div class="filmy-grid">
            <?php
            $args = array(
                'post_type' => 'filmy',
                'posts_per_page' => 6,
                'orderby' => 'date',
                'order' => 'DESC'
            );

            $filmy_query = new WP_Query($args);

            if ($filmy_query->have_posts()) :
                while ($filmy_query->have_posts()) :
                    $filmy_query->the_post();
                    
                    // Pobieranie taksonomii
                    $aktorzy = get_the_term_list(get_the_ID(), 'aktorzy', '', ', ', '');
                    $jezyki = get_the_term_list(get_the_ID(), 'jezyki', '', ', ', '');
                    ?>
                    <article class="film-card">
                        <div>
                            <h2 class="film-title"><?php the_title(); ?></h2>
                            <div class="film-content">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <div class="film-taxonomies">
                            <?php if ($aktorzy && !is_wp_error($aktorzy)) : ?>
                                <div class="film-taxonomy-item">
                                    <span class="film-taxonomy-label">Aktorzy: </span>
                                    <span class="film-taxonomy-values"><?php echo $aktorzy; ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($jezyki && !is_wp_error($jezyki)) : ?>
                                <div class="film-taxonomy-item">
                                    <span class="film-taxonomy-label">Języki: </span>
                                    <span class="film-taxonomy-values"><?php echo $jezyki; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php
                endwhile;
            else :
                ?>
                <div class="no-filmy">
                    <p>Nie znaleziono żadnych filmów.</p>
                </div>
            <?php
            endif;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</main>

<?php
get_footer();