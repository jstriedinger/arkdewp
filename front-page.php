<?php
/**
 * The template for displaying the front page
 * @package ARKDE
 */

get_header();
?>

<main id="primary" class="container">
	<section class="section" style="background:red">
			<h3>lndklnasdnj
				<a href="" id="temporal">open modal!</a>
			</h3>
			<div class="columns is-centered">
				<div class="column is-half" style="background:red">
						<h3>adjsdkjbfsj</h3>
						<div class="course-card">
							<div class="card-header"></div>
							<div class="card-info"></div>
						</div>	
				</div>
			</div>
	</section>
	<?php

	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'page' );

	endwhile; // End of the loop.
	?>

</main><!-- #main -->

<?php
get_footer();
