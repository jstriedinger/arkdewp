<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$white          = isset( $args[0] ) ? $args[0] : false;
$course_content = get_the_content();
?>

<div class="mt-6"></div>
<h3 class="subtitle is-size-4 has-text-weight-bold pt-2 <?php echo $white ? 'has-text-white' : ''; ?>"><?php esc_html_e( 'Descripción', 'arkdewp' ); ?></h3>
<div class="course-description content has-text-justified <?php echo $white ? 'has-text-white' : ''; ?>">
	<?php echo $course_content; ?>
</div>
<div class="course-desc-show <?php echo $white ? 'has-text-white' : ''; ?>">
	<a href="#" class="has-text-weight-bold <?php echo $white ? 'has-text-white' : ''; ?>"><span><?php esc_html_e( 'Leer más ', 'arkdewp' ); ?></span><i class="fa-solid fa-chevron-down"></i></a>
</div>
