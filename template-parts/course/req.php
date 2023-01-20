<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$reqs = $args[0];
?>

<h3 class="subtitle is-size-4  has-text-weight-bold pt-4"><?php esc_html_e( '¿Qué necesitas para este curso?', 'arkdewp' ); ?></h2>
<ul class="is-flex is-flex-wrap-wrap bullet-points mr-3 mb-6">
	<?php foreach ( $reqs as $req ) : ?>
		<li style="flex: 50%;" class="is-flex mb-2 ">
			<i class="fa-solid fa-circle mr-3 mt-2"></i><span class="is-size-14px"><?php echo esc_html( $req['txt'] ); ?></span>
		</li>
	<?php endforeach; ?>

</ul>
