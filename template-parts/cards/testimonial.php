<?php 
$t = $args['testimonial'];
if($t) : 
$txt = $t->post_content;
//lets get the author
$avatar = get_avatar_url($t->post_author);
$user =  get_user_by('id', $t->post_author);
$name = $user->first_name." ".$user->last_name;
$rating = get_post_meta($t->ID,'wdm_course_review_review_rating')[0];
?>

<div class="card testimonial-card">
	<div class="card-content">
		<p class="is-size-7-mobile is-size-14px"><?php echo esc_html($txt);?></p>
		<hr class="mb-0 mt-3">
	</div>
	<div class="card-footer pt-0">
			<div class="testimonial-avatar">
				<img src="<?php echo esc_url($avatar)?>" alt="<?php echo sprintf( esc_html( 'ARKDE user %s', 'arkdewp' ), esc_attr( $name ) )?>" width="60px" height="60px">
			</div>
			<div>
				<div class='course-average-rating rating-5 icon-text has-gap-4 has-lh-one' >
					<span class='fa-regular arkde-rating-star'></span>
					<span class='fa-regular arkde-rating-star'></span>
					<span class='fa-regular arkde-rating-star'></span>
					<span class='fa-regular arkde-rating-star'></span>
					<span class='fa-regular arkde-rating-star'></span>
				</div>
				<p class="is-size-14px-mobile has-text-weight-bold mb-0 mt-1"><?php echo esc_html($name);?></p>
			</div>
	</div>
</div>
<?php endif; ?>