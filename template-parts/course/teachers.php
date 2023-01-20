<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$teachers = $args[0];
?>

<h3 class="subtitle is-size-4 has-text-weight-bold pt-4"><?php esc_html_e( 'Tu instructor', 'arkdewp' ); ?></h3>
<div class="columns is-multiline mb-6">
	<?php
	foreach ( $teachers as $teacher ) :
		$img     = get_the_post_thumbnail_url( $teacher->ID );
		$meta    = get_fields( $teacher->ID );
		$company = $meta['company'];
		$rol     = $meta['position'];
		$bio    = $meta['bio'];
		?>
		<div class="column is-full">
			<div class="teacher-horizontal-card">
				<div class="is-flex is-align-items-center">
					<figure class="image is-128x128 mr-5 ">
						<img src="<?php echo esc_url( $img ); ?>" alt="" width="120px" height="120px" class="is-rounded">
					</figure>
					<div class="is-flex is-flex-direction-column">
						<span class="subtitle is-size-4 mb-2 has-text-weight-bold"><?php echo esc_html( $teacher->post_title ); ?></span>
						<?php if ( ! empty( $company ) ) : ?>
							<span class="subtitle is-size-6 mb-2"><?php echo sprintf( __( '%s en', 'arkdewp' ), esc_attr( $rol ) ); ?></span>
							<img src="<?php echo esc_url( $company['url'] ); ?>" alt="<?php echo esc_attr( $company['alt'] ); ?>" width="90px">
						<?php endif; ?>
					</div>
				</div>
				<div class="content mt-4">
					<?php echo $bio; ?>

				</div>
			</div>
		</div>
		
	<?php endforeach; ?>
</div>

