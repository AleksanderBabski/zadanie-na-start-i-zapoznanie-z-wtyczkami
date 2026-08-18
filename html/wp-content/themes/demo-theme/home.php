<?php
/**
 * Szablon strony z wpisami (Blog)
 */
get_header(); ?>

<main id="primary" class="site-main blog-container">
    <h1 class="blog-page-title"><?php single_post_title(); ?></h1>

    <div class="blog-grid">
        <?php
        // Korzystamy z natywnej pętli WordPressa (Main Query)
        if (have_posts()):
            while (have_posts()):
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post-card'); ?>>
                    <?php if (has_post_thumbnail()): ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="post-content-wrapper">
                        <header class="post-header">
                            <span class="post-date"><?php echo get_the_date(); ?></span>
                            <h2 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                        </header>

                        <div class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </div>

                        <footer class="post-footer">
                            <a href="<?php the_permalink(); ?>" class="read-more-btn">Czytaj więcej &rarr;</a>
                        </footer>
                    </div>
                </article>
                <?php
            endwhile;

            // Natywna paginacja
            echo '<div class="blog-pagination">';
            the_posts_pagination(array(
                'prev_text' => '&larr; Poprzednia',
                'next_text' => 'Następna &rarr;',
            ));
            echo '</div>';

        else:
            ?>
            <div class="no-posts">
                <p>Brak wpisów do wyświetlenia.</p>
            </div>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
