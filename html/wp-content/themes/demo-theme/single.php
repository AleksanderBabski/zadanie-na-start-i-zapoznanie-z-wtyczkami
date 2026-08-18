<?php
/**
 * Szablon pojedynczego wpisu blogowego (Single Post)
 *
 * @package Demo_Theme
 */

get_header(); ?>

<div class="content-container single-post-container">
    <?php
    if (have_posts()):
        while (have_posts()):
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-article'); ?>>
                <header class="single-post-header">
                    <div class="single-post-meta">
                        <span class="post-date"><?php echo get_the_date(); ?></span>
                        <?php if (has_category()): ?>
                            <span class="post-categories">
                                &bull; <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <h1 class="single-post-title"><?php the_title(); ?></h1>

                    <div class="single-post-author">
                        Autor: <strong><?php the_author(); ?></strong>
                    </div>
                </header>

                <?php if (has_post_thumbnail()): ?>
                    <div class="single-post-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="single-post-content entry-content">
                    <?php the_content(); ?>
                </div>

                <?php
                // Obsługa stron dzielonych znacznikiem <!--nextpage-->
                wp_link_pages(array(
                    'before' => '<div class="page-links">Strony: ',
                    'after'  => '</div>',
                ));
                ?>

                <footer class="single-post-footer">
                    <?php if (has_tag()): ?>
                        <div class="single-post-tags">
                            <strong>Tagi:</strong> <?php the_tags('', ', ', ''); ?>
                        </div>
                    <?php endif; ?>

                    <nav class="single-post-navigation">
                        <div class="nav-links">
                            <div class="nav-previous"><?php previous_post_link('&larr; %link'); ?></div>
                            <div class="nav-next"><?php next_post_link('%link &rarr;'); ?></div>
                        </div>
                    </nav>
                </footer>
            </article>
            <?php
        endwhile;
    endif;
    ?>
</div>

<?php get_footer(); ?>
