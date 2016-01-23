<?php
/**
 * The template for displaying all single posts and attachments
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

            // Include the single post content template. ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header><!-- .entry-header -->

                <?php twentysixteen_excerpt(); ?>

                <?php twentysixteen_post_thumbnail(); ?>

                <div class="entry-content">
                    <?php
                    global $wpdb;
                        $module_ID = get_post_meta(get_the_ID(), 'wpcw_associated_module', true);
                        $course_ID = $wpdb->get_var( 'SELECT parent_course_id FROM ' . $wpdb->prefix . 'wpcw_modules WHERE module_id = ' . $module_ID );
                        $course_name = $wpdb->get_var( 'SELECT course_title FROM ' . $wpdb->prefix . 'wpcw_courses WHERE course_id = ' . $course_ID );
                        $parent_page = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'posts WHERE post_name LIKE \'' . sanitize_title( $course_name ) . '\' AND post_status LIKE \'publish\'' );

                        echo '<p class="breadcrumb"><a href="' . home_url( '/missionary-orientation-school/' ) . '">Missionary Orientation School</a> / ' . '<a href="' . home_url( '/missionary-orientation-school/' ) . $parent_page->post_name . '/">' . $parent_page->post_title . '</a> / ' . get_the_title() . '</p>';

                        the_content();

                        wp_link_pages( array(
                            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
                            'after'       => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                            'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
                            'separator'   => '<span class="screen-reader-text">, </span>',
                        ) );

                        if ( '' != get_the_author_meta( 'description' ) ) {
                            get_template_part( 'template-parts/biography' );
                        }
                    ?>
                </div><!-- .entry-content -->

                <footer class="entry-footer">
                    <?php twentysixteen_entry_meta(); ?>
                    <?php
                        edit_post_link(
                            sprintf(
                                /* translators: %s: Name of current post */
                                __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
                                the_title( '', '', false )
                            ),
                            '<span class="edit-link">',
                            '</span>'
                        );
                    ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-## -->

            <?php // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }

            if ( is_singular( 'attachment' ) ) {
                // Parent post navigation.
                the_post_navigation( array(
                    'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'twentysixteen' ),
                ) );
            } elseif ( is_singular( 'post' ) ) {
                // Previous/next post navigation.
                the_post_navigation( array(
                    'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'twentysixteen' ) . '</span> ' .
                        '<span class="screen-reader-text">' . __( 'Next post:', 'twentysixteen' ) . '</span> ' .
                        '<span class="post-title">%title</span>',
                    'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'twentysixteen' ) . '</span> ' .
                        '<span class="screen-reader-text">' . __( 'Previous post:', 'twentysixteen' ) . '</span> ' .
                        '<span class="post-title">%title</span>',
                ) );
            }

            // End of the loop.
        endwhile;
        ?>

    </main><!-- .site-main -->

    <?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
