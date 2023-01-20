<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$course_content = get_the_content();
?>

<h3 class="subtitle is-size-4 has-text-weight-bold pt-4"><?php esc_html_e( 'Descripción', 'arkdewp' ); ?></h3>
<div class="course-description content has-text-justified">
	<?php echo $course_content; ?>
</div>
<div class="course-desc-show">
	<a href="#" class="has-text-weight-bold"><span><?php esc_html_e( 'Leer más ', 'arkdewp' ); ?></span><i class="fa-solid fa-chevron-down"></i></a>
</div>
<div class="mb-6"></div>
