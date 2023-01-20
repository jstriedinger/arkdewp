<?php
$bullets = $args['bullets'];
?>
<h2 class="subtitle is-size-4  has-text-weight-bold"><?php esc_html_e( 'Lo que vas a aprender', 'arkdewp' ); ?></h2>
<ul class="is-flex is-flex-wrap-wrap bullet-points mr-3 mb-6" id="course-bulletpoints">
	<?php foreach ( $bullets as $bullet ) : ?>
		<li style="flex: 50%;" class="is-flex is-align-items-baseline mb-2 ">
			<i class="fa-solid fa-check mr-3 "></i><span class="is-size-14px"><?php echo esc_html( $bullet['txt'] ); ?></span>
		</li>
	<?php endforeach; ?>

</ul>

