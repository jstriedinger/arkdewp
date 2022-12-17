export class InfiniteSlider {
	constructor( sliderDOM ) {
		this.setup( sliderDOM )
	}

	/**
	 * Check if the slider is infinite and move the first/last element to the start/back
	 * if it has to and depending on the movement
	 *
	 */
	checkInfiniteSlider = ( ) => {
		const scrollLeft = this.slider.scrollLeft,
			scrollWidth = this.slider.scrollWidth,
			containerWidth = this.slider.offsetWidth
		//Going right
		//get the current last element of the slider & width
		if ( containerWidth + scrollLeft >= ( scrollWidth - this.elemWidth ) ) {
			//No more scroll left, move it!
			const first = this.slider.firstElementChild
			this.slider.appendChild( first )
			//- 32 because that is the width of the gap in the grid. Im too lazy to get the value by code
			this.slider.scrollLeft = scrollLeft - first.offsetWidth - 32
		}
	}

	scrollInfinite = () => {
		requestAnimationFrame( () => {
			this.scrollInfinite()
		} )

		const now = Date.now()
		this.elapsed = now - this.then

		// if enough time has elapsed, draw the next frame
		if ( this.elapsed > this.fpsInterval ) {
			// Get ready for next frame by setting then=now, but also adjust for your
			// specified fpsInterval not being a multiple of RAF's interval (16.7ms)
			this.then = now - ( this.elapsed % this.fpsInterval )

			// Put your drawing code here
			const target = 1
			this.slider.scrollBy( target, 0 )
		}
	}

	setup = ( sliderDOM ) => {
		this.slider = sliderDOM
		this.slider.addEventListener( 'scroll', () => this.checkInfiniteSlider( ) )
		this.elemWidth = this.slider.firstElementChild.offsetWidth
		this.fpsInterval = 1000 / 30
		this.startTime = this.then
		this.then = Date.now()
		this.scrollInfinite()

		/*window.requestAnimationFrame( () => {
			this.scrollInfinite()
		} )*/
	}
}
