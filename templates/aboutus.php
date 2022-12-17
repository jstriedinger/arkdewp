<?php
/**
 * Template Name: About Us
 * @package ARKDE
 */

get_header();
$meta = get_fields();
$teachers = $meta['teachers'];
$testimonials = $meta['testimonials'];
?>
<main id="primary">
	<section class="hero background-gradient-purple has-image" id="main-section" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>)">
		<div class="hero-body " >
			<div class="container columns is-centered">
				<div class="column is-full is-three-quarters-widescreen has-text-centered " id="anim-top-section">
					<h1 class="title is-uppercase is-size-2 is-size-1-desktop is-size-0 has-text-weight-bold has-text-white mt-4">
						<?php the_title();?>
					</h1>
					<?php if( $meta['founder'] != null) :  ?>
						<p class="has-text-white">"<?php echo $meta['founder']['txt']; ?>"</p> 
						<figure class="image is-128x128 mt-6">
							<img src="<?php echo esc_url($meta['founder']['img']['url']); ?>" alt="<?php echo esc_attr($meta['founder']['img']['alt']); ?>" class="is-rounded">
						</figure>
						<p class="title is-size-4 mt-2 has-text-white">José Striedinger</p>
						<p class="subtitle is-size-6 is-italic has-text-white">Founder</p>

					<?php endif; ?>
				</div>
			</div>
		</div>
		<img src="<?php echo ARKDE_THEME_URI . 'assets/img/main-section-bottom.svg' ?>" alt="" class="woosh-svg">
	</section>
	<section class="section">
		<div class="container">
			<div class="columns is-centered">
				<div class="column is-11">
					<div class="columns is-variable is-8 is-centered is-vcentered pb-6">
						<div class="column is-half">
							<h2 class="title is-size-3"><?php echo __('Un emprendimiento latino creado con las uñas','arkdewp');?></h2>
							<?php the_content();?>
						</div>
						<?php if($meta["feature_img"] != null) : ?>
							<div class="column is-5">
								<img src="<?php echo esc_url($meta["feature_img"]['url']) ?>" alt="<?php echo esc_attr($meta["feature_img"]['alt']) ?>" class="anim-right-left">
							</div>
						<?php endif; ?>
					</div>
					<div class="columns is-variable is-8 is-centered is-vcentered pt-6 pb-6 is-multiline">
						<div class="column is-two-thirds has-text-centered">
							<h3 class="title is-size-3 has-text-weight-bold"><?php echo esc_html($meta["mission"]['header']);?></h3>
							<p class="subtitle"><?php echo esc_html($meta["mission"]['txt']);?></p>
						</div>
						<div class="column is-full">
							<div class="columns is-centered has-text-centered is-variable is-8 anim-numbers-up">
								<?php foreach ($meta['mission']['facts'] as $fact) { ?>
											<div class="column is-one-third is-3-fullhd" >
													<p class="title is-size-2 has-text-weight-bold"><span class="anim-number"><?php echo esc_html($fact['num']);?></span>+</p>
													<p class="subtitle is-size-14px"><?php echo esc_html($fact['txt']);?></p>
											</div>
						<?php		} ?>
							</div>
						</div>
					</div>
					<div class="columns is-variable is-8 is-vcentered is-centered pt-6 pb-6">
						<div class="column is-half">
							<h3 class="title is-size-3 has-text-weight-bold"><?php esc_html_e('Una iniciativa reconocida internacionalmente','arkdewp');?></h3>
							<p><?php esc_html_e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque quis tempus ligula, ut iaculis sapien. 
							Pellentesque hendrerit molestie dolor, vel molestie velit dapibus sed. 
							Donec euismod fermentum fermentum. Aenean a sem dapibus libero dapibus accumsan. 
							Suspendisse fermentum justo sit amet placerat sagittis','arkdewp');?></p>
						</div>
						<div class="column is-narrow">
							<img src="<?php echo ARKDE_THEME_URI . 'assets/img/megagrants_black.png' ?>" alt="arkde epic games mega grant 2022" width="300px" class="anim-right-left">
						</div>
					</div>
					<div class="columns is-centered  has-text-centered pt-6" id="instructores">
						<div class="column is-half">
								<h3 class="title is-size-3 has-text-weight-bold mb-5"><?php esc_html_e('Una plataforma con excelentes instructores de la industria','arkdewp');?></h3>
						</div>
					</div>
					<div class="columns is-centered is-multiline  is-variable is-6 pb-6 anim-bottom-top-children">
						<?php 
									if ($teachers) {
										foreach ($teachers as $teacher) { ?>
											<div class="column is-half is-one-third-widescreen" >
								<?php	get_template_part( 'template-parts/cards/teacher','',array('teacher' => $teacher ) ); ?>
											</div>
						<?php		}
									}
									?>
					</div>
					
				</div>
			</div>
		</div>
	</section>
	<section class="section">
		<div class="container pb-6">
			<div class="columns is-centered  has-text-centered pt-6">
				<div class="column is-half">
						<h3 class="title is-size-3 has-text-weight-bold mb-5"><?php esc_html_e('Unos cursos con excelentes resultados','arkdewp');?></h3>
				</div>
			</div>
			<div class="masonry-grid columns-3 pb-6">
				<?php 
							if ($testimonials) {
								foreach ($testimonials as $testimonial) { ?>
						<?php	get_template_part( 'template-parts/cards/testimonial','',array('testimonial' => $testimonial ) ); ?>
				<?php		}
							}
							?>
			</div>
		</div>
	</section>
	<section class="hero backround-gradient-purple">
		<img src="<?php echo ARKDE_THEME_URI . 'assets/img/section-top.svg' ?>" alt="" class="woosh-svg">
		<div class="hero-body">
			<div class="container">
				<div class="columns is-centered pb-6">
					<div class="column is-8 has-text-centered">
						<h3 class="title is-size-3 is-size-2-desktop"><?php echo esc_html__( '¿Qué estás esperando?','arkdewp');?></h3>
						<p class="subtitle is-size-6 is-size-4-desktop"><?php echo esc_html__( 'Empieza con uno de nuestros cursos gratis','arkdewp');?></p>
						<a href="" class="button is-medium is-gold">Registrate aquí</a>
					</div>
				</div>

			</div>
		</div>
	</section>
</main><!-- #main -->
<?php
get_template_part( 'template-parts/modals/course','preview' );
get_footer();
