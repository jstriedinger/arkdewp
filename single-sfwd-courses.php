<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ARKDE
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			if ( 'draft' == get_post_status() ) {
				do_action( THEME_HOOK_PREFIX . '_single_template_part_content', get_post_type() );
			} else {
				get_template_part( 'template-parts/content', 'sfwd' );
				// the_content();
			}

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
