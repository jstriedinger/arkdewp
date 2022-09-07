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
<div class="modal ui-modal course-preview" id="course-preview-modal">
  <div class="modal-background"></div>
  <div class="modal-content">
		<div class="card course-preview">
			<div class="card-header">
				<h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus expedita ducimus dolore placeat ipsam quos! Cupiditate, saepe. Blanditiis tempora odit tempore, expedita, dolores nobis ut totam quis alias laboriosam vero!</h3>
	
			</div>
			<div class="card-content">
				<h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus expedita ducimus dolore placeat ipsam quos! Cupiditate, saepe. Blanditiis tempora odit tempore, expedita, dolores nobis ut totam quis alias laboriosam vero!</h3>
	
			</div>
		</div>
		<button class="modal-close is-large close-button" data-modal="course-preview-modal" aria-label="close"></button>
	</div>
</div>

	<main id="primary" class="site-main">
		<h3>lndklnasdnj
			<a href="" id="temporal">open modal!</a>
		</h3>
		<div class="container">
			<div class="columns is-centered">
				<div class="column is-half" style="background:red">
						<h3>adjsdkjbfsj</h3>
						<div class="course-card">
							<div class="card-header"></div>
							<div class="card-info"></div>
						</div>	
				</div>
			</div>
		</div>
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

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
