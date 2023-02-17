<?php
$bullets = $args['bullets'];
$white   = $args['white'];
?>
<h2 class="subtitle is-size-4  has-text-weight-bold <?php echo $white ? 'has-text-white' : ''; ?>"><?php esc_html_e( 'Lo que vas a aprender', 'arkdewp' ); ?></h2>
<ul class="is-flex is-flex-wrap-wrap bullet-points mb-6" id="course-bulletpoints">
	<?php foreach ( $bullets as $bullet ) : ?>
		<li class="is-flex is-align-items-baseline <?php echo $white ? 'has-text-white' : ''; ?>">
			<i class="fa-solid fa-check mr-3 "></i><span class="is-size-14px"><?php echo esc_html( $bullet['txt'] ); ?></span>
		</li>
	<?php endforeach; ?>

</ul>

