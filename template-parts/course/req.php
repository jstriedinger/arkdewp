<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$reqs  = $args[0];
$white = isset( $args[1] ) ? true : false;
?>
<div class="pt-6"></div>
<h3 class="subtitle is-size-4  has-text-weight-bold pt-2 <?php echo $white ? 'has-text-white' : ''; ?>"><?php esc_html_e( '¿Qué necesitas?', 'arkdewp' ); ?></h2>
<ul class="is-flex is-flex-wrap-wrap bullet-points">
	<?php foreach ( $reqs as $req ) : ?>
		<li class="is-flex is-align-items-baseline <?php echo $white ? 'has-text-white' : ''; ?>">
			<i class="fa-solid fa-circle mr-3"></i><span class="is-size-14px"><?php echo esc_html( $req['txt'] ); ?></span>
		</li>
	<?php endforeach; ?>

</ul>
