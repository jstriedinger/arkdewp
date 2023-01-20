<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ARKDE
 */

get_header();
$meta        = get_fields();
$bg_video_id = $meta['bg_video_id'];
$career_icon = $meta['icon'];
$title_tech  = $meta['header']['tech'];
$title_name  = $meta['header']['name'];
$desc        = $meta['desc'];
$preview_url = $meta['career_video_preview'];

get_template_part( 'template-parts/modals/course', 'preview', array( 'modal_id' => 'career-preview-modal' ) );
?>

<main id="primary" class="site-main">
	

<?php
while ( have_posts() ) :
	the_post();
	?>
	<section class="section pr-0 pl-0 background-gradient-purple background-career has-image has-video" id="main-section" style="background-image: url(<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>)">
		<?php if ( $bg_video_id != '' ) : ?>
			<div class="video-bg-wrapper">
				<iframe id="video-background" class="fitvidsignore" data-src="https://player.vimeo.com/video/<?php echo esc_attr( $bg_video_id ); ?>?background=1&autoplay=1&loop=1&byline=0&title=0"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen ></iframe>
			</div>
		<?php endif; ?>
		<div class="container columns is-centered has-text-centered pt-6 pb-5 mt-6 mb-6">
			<div class="column is-full is-three-quarters-desktop is-half-fullhd" id="anim-top-section">
				<div class="hr-badge is-gold">
					<span>
						<hr>
					</span>
					<img src="<?php echo esc_url( $career_icon ); ?>" alt="carrera arkde curso online" width="70px" height="70px">
					<span>
						<hr>
					</span>
				</div>
				<h1 class="title is-uppercase is-size-2 is-size-1-desktop is-size-0 has-text-light-gold mt-4 has-text-weight-light">
					<span><?php echo esc_html( $title_tech ); ?></span><br>
					<span class="has-text-weight-bold"><?php echo esc_html( $title_name ); ?></span>
				</h1>
				<p class="subtitle is-size-6 has-text-white pt-4 mb-6"><?php echo esc_html( $desc ); ?></p> 
				<div>
					<a href="" id="career-preview-launcher" data-preview="<?php echo esc_attr( $preview_url ); ?>">
						<i class="fa-solid fa-circle-play has-text-light-gold"></i>
					</a>
					<p class="has-text-white is-size-6 mt-1"><?php esc_html_e( 'Clic para mirar el trailer', 'arkdewp' ); ?></p>
				</div>
			</div>

		</div>
	</section>
	

	<?php
endwhile; // End of the loop.
?>

</main><!-- #main -->

<?php
get_footer();
