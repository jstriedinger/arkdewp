<?php 
$teachers = $args['teachers'];
if( $teachers) : 
	echo '<div class="course-teachers">';
	foreach ($teachers as $teacher) {
		echo '<div class="course-teacher-item">';
		echo get_the_post_thumbnail($teacher->ID);
		echo "<p class='is-size-14px'>{$teacher->post_title}</p>";
		echo '</div>';
	}
	echo '</div>';
endif;
?>