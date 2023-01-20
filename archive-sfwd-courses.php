<?php
/**
 * The template for displaying all learndash courses
 *
 * @package ARKDE
 */

get_header();
$terms = get_terms(
	'ld_course_category',
	array(
		'orderby'    => 'slug',
		'hide_empty' => false,
	)
);

$args = array(
	'post_type'      => 'career',
	'posts_per_page' => '-1',

);
$careers = get_posts( $args );

?>
<main id="primary">
	<section class="hero is-small background-gradient-purple ">
		<div class="hero-body">
			<div class="container columns is-centered is-max-widescreen">
				<div class="column is-full is-three-quarters-widescree">
					<nav class="breadcrumb" aria-label="breadcrumbs">
						<ul>
							<li><a href="<?php echo esc_url( get_home_url() ); ?>" class="has-text-weight-bold">
							<span class="icon-text has-text-white">
								<span class="icon">
									<i class="fa-solid fa-house"></i>
								</span>
								<span><?php esc_html_e( 'Inicio', 'arkdewp' ); ?></span>
							</span>
							</a></li>
							<li class="is-active"><a href="#" aria-current="page" class="has-text-white"><?php esc_html_e( 'Cursos', 'arkdewp' ); ?></a></li>
						</ul>
					</nav>
					<h1 class="title is-size-2 is-size-1-desktop has-text-weight-bold">
						<?php esc_html_e( 'Nuestros cursos', 'arkdewp' ); ?>
					</h1>
				</div>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="container pb-6 is-max-widescreen">
			<div class="columns is-vcentered is-multiline">
				<?php if ( ! is_wp_error( $careers ) && ! empty( $careers ) ) : ?>
					<div class="column is-half is-5-widescreen mb-4">
						<p class="title is-size-3 is-size-2-widescreen has-text-weight-bold"><?php esc_html_e( 'Packs de cursos', 'arkdewp' ); ?></p>
						<p class="subtitle is-size-6"><?php esc_html_e( 'Ahorra y llega más lejos con nuestros packs de cursos enfocado en un rol especifico en la industria', 'arkdewp' ); ?></p>
					</div>
					<div class="column is-full">
						<div class="columns is-variable is-6 anim-right-left-children">
							<?php foreach ( $careers as $career ) : ?>
										<div class="column is-narrow" >
								<?php	get_template_part( 'template-parts/cards/career', '', array( 'career' => $career ) ); ?>
										</div>
					<?php	endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
			<div class="columns is-multiline pt-6 mt-6">
				<div class="column is-half ">
					<p class="title is-size-3 is-size-2-widescreen has-text-weight-bold"><?php esc_html_e( 'Cursos online', 'arkdewp' ); ?></p>
					<p class="subtitle is-size-6"><?php esc_html_e( 'Mira todos nuestros cursos online disponibles', 'arkdewp' ); ?></p>
				</div>
				<div class="column is-half has-text-right is-flex is-flex-direction-row is-align-items-center is-justify-content-end">
					<span class="is-size-6 mr-2"><?php esc_html_e( 'Quiero aprender', 'arkdewp' ); ?> </span>
					<div class="select">
						<select id="arkde-course-category-filter">
							<option value="all" selected ><?php esc_html_e( 'de todo', 'arkdewp' ); ?></option>
							<?php foreach ( $terms as $term1 ) : ?>
								<option value="<?php echo esc_attr( $term1->slug ); ?>"><?php echo esc_html( $term1->name ); ?> </option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="column is-full arkde-course-grid anim-bottom-top-children mt-4">
				<?php
				while ( have_posts() ) :
							the_post();
					?>
						<?php
						get_template_part( 'template-parts/cards/course', '', array( 'course' => $post ) );
						endwhile;
				?>
				</div>

			</div>
		</div>
	</section>
</main>
<?php
get_template_part( 'template-parts/modals/course', 'card-preview' );
get_footer();
