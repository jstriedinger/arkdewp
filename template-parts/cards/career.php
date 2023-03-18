<?php

$career = $args['career'];
if ( $career ) :
	$teachers    = get_field( 'teachers', $career->ID );
	$permalink   = esc_url( get_permalink( $career->ID ) );
	$thumbnail   = esc_url( get_the_post_thumbnail_url( $career->ID, 'large' ) );
	$icon        = esc_url( get_field( 'icon', $career->ID ) );
	$num_courses = strval( count( get_field( 'courses', $career->ID ) ) );
	$duration    = get_field( 'duration', $career->ID );
	$header      = get_field( 'header', $career->ID );

	$wc_product = get_field( 'wc_product', $career->ID );
	$product    = wc_get_product( $wc_product->ID );

	// find the discount
	$discount = strval( ceil( 100 - ( ( $product->get_price() * 100 ) / $product->get_regular_price() ) ) );

	?>
	<a href="<?php echo $permalink; ?>">
	<div class="stack-cards hoverable">
			<div class="stack-card"></div>
			<div class="stack-card"></div>
			<div class="card career-card ">
				<div class="card-background" style="background-image: url(<?php echo $thumbnail; ?>)"></div>
				<div class="card-header" >
					<img src="<?php echo $icon; ?>" alt="" width="80px">
					<div>
						<p class="is-size-4 is-size-3-widescreen has-lh-one"><?php echo esc_html( $header['tech'] ); ?></p>
						<p class="is-size-4 is-size-3-widescreen has-text-weight-bold has-lh-1-2"><?php echo esc_html( $header['name'] ); ?></p>
					</div>
				</div>
				<div class="card-content has-gap-64 responsive-gap">
					<ul>
						<li>
							<span class="icon-text">
								<span class="icon">
									<i class="fa-solid fa-layer-group fa-lg"></i>
								</span>
								<span class="is-size-6 ml-2"><?php echo sprintf( esc_html__( '%s cursos', 'arkdewp' ), esc_attr( $num_courses ) ); ?></span>
							</span>
						</li>
						<li class="mt-4">
							<span class="icon-text">
								<span class="icon">
									<i class="fa-solid fa-clock fa-lg"></i>
								</span>
								<span class="is-size-6 ml-2"><?php echo esc_html( $duration ); ?></span>
							</span>
						</li>
						<li class="mt-4">
							<span class="icon-text">
								<span class="icon">
									<i class="fa-solid fa-percent fa-lg"></i>
								</span>
								<span class="is-size-6 ml-2"><?php echo sprintf( esc_html__( 'Con %s%% de Dto', 'arkdewp' ), esc_attr( $discount ) ); ?></span>
							</span>
						</li>
					</ul>
					<div class="card-footer">
						<span class="icon-text">
							<span class="is-size-6 has-text-primary has-text-weight-bold"><?php esc_html_e( 'Más información', 'arkdewp' ); ?></span>
							<span class="icon has-text-primary">
								<i class="fa-solid fa-chevron-right"></i>
							</span>
						</span>
					</div>
					
				</div>
			</div>	
			
	</div>
	</a>
<?php endif; ?>
