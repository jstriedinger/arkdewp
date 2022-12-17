<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ARKDE
 */

get_header();
?>
	<main id="primary" class="site-main">
		<section class="section">
			<div class="container mb-6">

			</div>
			<div class="columns">
				<div class="column is-full">
					<?php

					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();

						endif;

					endwhile; // End of the loop.
					?>
				</div>
			</div>
		</section>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
