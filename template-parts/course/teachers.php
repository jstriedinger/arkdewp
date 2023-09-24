<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$teachers = $args[0];
$career   = isset( $args[1] ) ? true : false;
?>

<h3 class="subtitle is-size-4 has-text-weight-bold pt-4 <?php echo $career ? 'has-text-white' : ''; ?>"><?php count( $teachers ) > 1 ? esc_html_e( 'Tus instructores', 'arkdewp' ) : esc_html_e( 'Tu instructor', 'arkdewp' ); ?></h3>
<div class="is-flex has-gap-16 is-flex-direction-column mb-6">
	<?php
	foreach ( $teachers as $teacher ) :
		$img     = get_the_post_thumbnail_url( $teacher->ID );
		$meta    = get_fields( $teacher->ID );
		$company = isset( $meta['company'] ) ? $meta['company'] : false;
		$bio     = isset( $meta['bio'] ) ? $meta['bio'] : false;
		?>
		<div class="column is-full">
			<div class="teacher-horizontal-card">
				<div class="is-flex is-align-items-center">
					<figure class="image is-128x128 mr-5 ">
						<img src="<?php echo esc_url( $img ); ?>" alt="" width="120px" height="120px" class="is-rounded">
					</figure>
					<div class="is-flex is-flex-direction-column">
						<span class="subtitle is-size-4 mb-2 has-text-weight-bold <?php echo $career ? 'has-text-white' : ''; ?>"><?php echo esc_html( $teacher->post_title ); ?></span>
						<?php if ( ! isset( $company['name'] ) ) : ?>
							<span class="subtitle is-size-6 mb-2 <?php echo $career ? 'has-text-white' : ''; ?>"><?php echo esc_attr( $company['position'] ); ?></span>
						<?php else : ?>
								<span class="subtitle is-size-6 mb-2 <?php echo $career ? 'has-text-white' : ''; ?>"><?php echo sprintf( __( '%s en', 'arkdewp' ), esc_attr( $company['position'] ) ); ?></span>
								<?php if ( ! $company['img_bw'] && ! $company['img_color'] ) : ?>
									<span class="subtitle is-size-6 mb-2 has-text-weight-bold"><?php echo esc_attr( $company['name'] ); ?></span>
								<?php else : ?>
									<img src="<?php echo esc_url( $career ? $company['img_bw'] : $company['img_color'] ); ?>" alt="<?php echo esc_attr( $company['name'] ); ?>" width="125px">
								<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
				<?php if ( $bio ) : ?>
					<div class="content mt-4 <?php echo $career ? 'has-text-white' : ''; ?>">
						<?php echo $bio; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		
	<?php endforeach; ?>
</div>

