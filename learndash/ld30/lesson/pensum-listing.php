<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( $topics && ! empty( $topics ) ) : ?>
<ul>
	<?php
	foreach ( $topics as $topic ) :
		$is_assignment        = get_field( 'is_assignment', $topic->ID );
		$topic_settings       = learndash_get_setting( $topic );
		$lesson_video_enabled = isset( $topic_settings['lesson_video_enabled'] ) ? $topic_settings['lesson_video_enabled'] : null;
		?>
	<li>
		<?php if ( $is_assignment ) : ?>
			<i class="fa-solid fa-feather mr-3"></i>
		<?php elseif ( $lesson_video_enabled ) : ?>
			<i class="fa-solid fa-circle-play mr-3"></i>
			<?php else : ?>
				<i class="fa-solid fa-align-left mr-3"></i>
		<?php endif; ?>
		<?php if ( $free ) : ?>
			<a href="<?php echo esc_url( get_the_permalink( $topic->ID ) ); ?>" class="is-size-14px"><?php echo esc_html( $topic->post_title ); ?></a>
		<?php else : ?>
			<span class="is-size-14px"><?php echo esc_html( $topic->post_title ); ?></span>
		<?php endif; ?>
		<span class="is-size-14px item-duration has-text-grey"><?php echo esc_html( get_field( 'duration', $topic->ID ) ); ?></span>
	</li>
		<?php
	endforeach;
	?>
</ul>
<?php endif; ?>
