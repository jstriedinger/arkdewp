<?php
$modal_id = $args['modal_id'];
?>
<div class="ui-modal course-preview" id="<?php echo esc_attr( $modal_id ); ?>">
  <div class="modal-background"></div>
  <div class="modal-content">
		<div class="card">
			<div class="video-header" >
				<div id="course-video-preview"></div>
	
			</div>
		</div>
		<button class="modal-close is-large close-button" data-modal="course-preview-modal" aria-label="close"></button>
	</div>
</div>
