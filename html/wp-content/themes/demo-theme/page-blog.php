<?php
/*
Template Name: Lista Wpisów (Blog)
*/

get_header(); ?>

<main id="primary" class="site-main blog-container">
    <h1 class="blog-page-title"><?php the_title(); ?></h1>

    <div class="blog-grid">
        <?php
        // Pobieranie aktualnego numeru strony (dla paginacji)
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 6,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $blog_query = new WP_Query($args);

        if ($blog_query->have_posts()):
            while ($blog_query->have_posts()):
                $blog_query->the_post();
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

            // Paginacja
            echo '<div class="blog-pagination">';
            echo paginate_links(array(
                'total' => $blog_query->max_num_pages,
                'current' => $paged,
                'format' => '?paged=%#%',
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
        wp_reset_postdata();
        ?>
    </div>
</main>

<?php
get_footer();
