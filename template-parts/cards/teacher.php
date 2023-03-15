<?php
$teacher = $args['teacher'];
if ( $teacher ) :
	$imgbg   = esc_url( get_field( 'bgimg', $teacher->ID ) );
	$company = get_field( 'company', $teacher->ID );

	?>
	
	<div class="card teacher-card" >
		<div class="card-header" >
			<?php echo get_the_post_thumbnail( $teacher->ID, 'medium' ); ?>
		</div>
		<div class="card-content" style="background-image: url(<?php echo $imgbg; ?>)">
			<p class="is-size-4 is-size-3-fullhd has-text-weight-bold"><?php echo $teacher->post_title; ?></p>
			<p class="mb-5 mt-4"><?php echo get_field( 'mini_bio', $teacher->ID ); ?></p>
			<?php if ( ! empty( $company ) ) : ?>
				<img src="<?php echo esc_url( $company['img_bw'] ); ?>" alt="<?php echo esc_attr( $company['name'] ); ?>">
			<?php endif; ?>
		</div>
	</div>	
	
	</a>
	<?php
endif;
?>
