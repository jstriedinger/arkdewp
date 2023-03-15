<div class="ui-modal course-preview" id="course-card-preview-modal" data-btn-info="<?php esc_html_e('Más información','arkdewp'); ?>" data-btn-buy="<?php esc_html_e('Comprar ahora','arkdewp'); ?>">
  <div class="modal-background"></div>
  <div class="modal-content">
		<div class="card">
			<div class="video-header" >
				<div id="course-video-preview"></div>
	
			</div>
			<div class="card-content">
				<p class="is-size-4 has-text-weight-bold" id="course-preview-card-title">lorem ipsum joder</p>
				<div class="level mb-4 mt-2 has-text-grey-light" id="course-preview-card-details">
						<div class="level-item is-justify-content-flex-start">
							<div class="course-teachers">
								<img src="" alt="">
								<p class="is-size-14px"></p>
							</div>
						</div>
						<div class="level-item is-justify-content-flex-start ">
							<span class="icon mr-2">
								<span class="fa-solid fa-users fa-lg"></span>
							</span>
							<span class="is-size-14px" >
								<span></span><span><?php echo "&nbsp;".esc_html__('estudiantes','arkdewp');?></span>
							</span>
						</div>
						<div class="level-item is-justify-content-flex-start">
							<span class="icon mr-1">
								<span class="fa-solid fa-clock fa-lg"></span>
							</span>
							<span class="is-size-14px" ></span>
						</div>
						<div class="level-item is-justify-content-flex-start ">
							<span class="course-level-icon level-basic mr-2">
								<div class="level-bar"></div>
								<div class="level-bar"></div>
								<div class="level-bar"></div>
							</span>
							<span  class="is-size-14px">
								<span><?php echo esc_html__( 'Nivel: ','arkdewp' ).'&nbsp;'?></span>
								<span></span>
							</span>
						</div>
				</div>
				<p id="course-preview-card-desc" class="is-size-14px">Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime rerum, nisi reiciendis cumque saepe amet deleniti molestiae inventore alias voluptates ipsum sapiente, non nulla voluptate sit ratione? Non, rerum tenetur</p>
				<div class="level is-mobile has-gap-10 mt-6" id="course-preview-price">
						<div class="level-item is-justify-content-flex-end is-align-items-flex-end " id="course-preview-price-not-free">
						</div>
						<div class="level-item is-justify-content-flex-end is-align-items-flex-end" id="course-preview-price-free">
							<p class="is-size-5 has-text-weight-bold"><?php esc_html_e('Gratis!','arkdewp');?></p>
						</div>
						<div class="level-item is-narrow">
							<a href="" class="button is-primary is-medium add_to_cart_button " data-quantity="1"><?php echo esc_html__('Más información','arkdewp');?></a>
						</div>
				</div>
			</div>
		</div>
		<button class="modal-close is-large close-button" data-modal="course-card-preview-modal" aria-label="close"></button>
	</div>
</div>