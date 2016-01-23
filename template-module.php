<?php
/**
 * Template name: Module Page
 * The template for each individual module
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

        echo '<header class="module-header" style="background-image: url(' . wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'header-image' )[0] . ');">';
        echo '<h1 class="module-title">' . get_the_title() . '</h1>';
        echo '</header>';

        echo '<p class="breadcrumb"><a href="' . home_url( '/missionary-orientation-school/' ) . '">Missionary Orientation School</a> / ' . get_the_title() . '</p>';

            // Include the page content template. ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content">
                    <?php
                    if ( ! is_user_logged_in() ) {
                        echo '<div class="wpcw_fe_progress_box_wrap"><div class="wpcw_fe_progress_box wpcw_fe_progress_box_error">Please log in to access these videos. <a class="button orange" href="/wp-admin/">Log in here</a></div></div>';
                    }
                    the_content();
                    ?>
                </div><!-- .entry-content -->

                <?php
                    edit_post_link(
                        sprintf(
                            /* translators: %s: Name of current post */
                            __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
                            the_title( '', '', false )
                        ),
                        '<footer class="entry-footer"><span class="edit-link">',
                        '</span></footer><!-- .entry-footer -->'
                    );
                ?>

            </article><!-- #post-## -->

            <?php
            // End of the loop.
        endwhile;
        ?>

    </main><!-- .site-main -->

    <?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
