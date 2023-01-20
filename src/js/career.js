import { modals } from './modals.js'
import YTPlayer from 'yt-player'
import { gsap } from 'gsap'

class Career {
	/**
	 * This method is run automatically when the module is imported,
	 * because it exports a new instance of itself.
	 */
	constructor() {
		document.addEventListener(
			'DOMContentLoaded', () => {
				this.setup()
			}
		)
	}

	setup() {
		//animations
		this.careerPreviewModal = document.getElementById( 'career-preview-modal' )

		if ( this.careerPreviewModal ) {
			this.showMoreBtn = document.querySelector( '.course-desc-show' )
			this.careerDesc = document.querySelector( '.course-description' )
			//lets add the click listener to preview
			this.previewLauncher = document.getElementById( 'career-preview-launcher' )
			this.previewLauncher.addEventListener( 'click', ( event ) => this.showCareerPreview( event ) )
			this.previewUrl = this.previewLauncher.dataset.preview

			this.ytPlayer = new YTPlayer( '#course-video-preview', { related: false, modestBranding: true } )
			this.ytPlayer.load( this.previewUrl, { autoplay: false, keyboard: false } )
			this.ytPlayer.mute()

			//attach close events to close button of preview modal
			//lets get buy now and more info btn text for the modal
			const closeBtn = this.careerPreviewModal.querySelector( '.modal-close' )
			closeBtn.addEventListener( 'click', () => {
				if ( this.ytPlayer ) {
					this.ytPlayer.pause()
					this.ytPlayer.mute()
				}
			} )
			//Close modal when click in background
			document.addEventListener( 'click', ( event ) => {
				const target = event.target
				if ( target.classList.contains( 'modal-background' ) ) {
					if ( this.ytPlayer ) {
						this.ytPlayer.pause()
						this.ytPlayer.mute()
					}
				}
			} )
			document.addEventListener( 'keydown', ( event ) => {
				const e = event || window.event
				if ( e.code === 'Escape' && this.ytPlayer ) { // Escape key
					this.ytPlayer.pause()
					this.ytPlayer.mute()
				}
			} )
			//course description show more button
			this.showMoreBtn.addEventListener( 'click', ( event ) => {
				event.preventDefault()
				if ( this.careerDesc.classList.contains( 'is-showing' ) ) {
					this.careerDesc.classList.remove( 'is-showing' )
					this.showMoreBtn.querySelector( 'i' ).classList.remove( 'fa-chevron-up' )
					this.showMoreBtn.querySelector( 'i' ).classList.add( 'fa-chevron-down' )
				} else {
					this.careerDesc.classList.add( 'is-showing' )
					this.showMoreBtn.querySelector( 'i' ).classList.remove( 'fa-chevron-down' )
					this.showMoreBtn.querySelector( 'i' ).classList.add( 'fa-chevron-up' )
				}
			} )
		}
	}

	//Opens the course preview modal
	showCareerPreview = ( event ) => {
		event.preventDefault()
		//Lets check the video has not been loaded yet

		if ( ! this.previewLoaded ) {
			this.ytPlayer.load( this.previewUrl, { autoplay: false, keyboard: false } )
			this.ytPlayer.play()
			this.ytPlayer.unMute()
			this.previewLoaded = true
		} else {
			this.ytPlayer.seek( 0 )
			this.ytPlayer.play()
			this.ytPlayer.unMute()
		}

		modals.openModal( 'career-preview-modal' )
	}
}
export const CareerPage = new Career()

