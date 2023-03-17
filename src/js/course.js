import { modals } from './modals.js'
import YTPlayer from 'yt-player'
import { gsap } from 'gsap'

class Course {
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
		this.coursePreviewModal = document.getElementById( 'course-preview-modal' )
		this.sideBarToggle = document.getElementById( 'course-sidebar-toggle' )
		this.courseSidebar = document.getElementById( 'course-sidebar' )

		if ( this.coursePreviewModal ) {
			this.showMoreBtn = document.querySelector( '.course-desc-show' )
			this.courseDesc = document.querySelector( '.course-description' )
			this.pensumToggles = document.querySelectorAll( '.lesson-row-header' )
			//lets add the click listener to preview
			this.previewLauncher = document.getElementById( 'course-preview-launcher' )
			this.previewUrl = this.previewLauncher.dataset.preview
			this.previewLauncher.addEventListener( 'click', ( event ) => this.showCoursePreview( event ) )

			this.ytPlayer = new YTPlayer( '#course-video-preview', { related: false, modestBranding: true } )
			this.ytPlayer.load( this.previewUrl, { autoplay: false, keyboard: false } )
			this.ytPlayer.mute()
			this.ytPlayer.stop()

			//attach close events to close button of preview modal
			//lets get buy now and more info btn text for the modal
			const closeBtn = this.coursePreviewModal.querySelector( '.modal-close' )
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
				if ( this.courseDesc.classList.contains( 'is-showing' ) ) {
					this.courseDesc.classList.remove( 'is-showing' )
					this.showMoreBtn.querySelector( 'i' ).classList.remove( 'fa-chevron-up' )
					this.showMoreBtn.querySelector( 'i' ).classList.add( 'fa-chevron-down' )
				} else {
					this.courseDesc.classList.add( 'is-showing' )
					this.showMoreBtn.querySelector( 'i' ).classList.remove( 'fa-chevron-down' )
					this.showMoreBtn.querySelector( 'i' ).classList.add( 'fa-chevron-up' )
				}
			} );

			[ ...this.pensumToggles ].forEach( ( pensumToggle ) => {
				pensumToggle.addEventListener( 'click', ( event ) => {
					const pensumToggleIcon = pensumToggle.querySelector( 'i.fa-solid' )
					const lessonRow = pensumToggle.parentNode
					const lessonTopicsRow = pensumToggle.nextElementSibling

					event.preventDefault()
					if ( lessonRow.classList.contains( 'is-showing' ) ) {
						gsap.to( lessonTopicsRow, { height: 0, duration: 0.3, onComplete() {
							lessonRow.classList.remove( 'is-showing' )
							pensumToggleIcon.classList.remove( 'fa-chevron-up' )
							pensumToggleIcon.classList.add( 'fa-chevron-down' )
						} } )
					} else {
						gsap.to( lessonTopicsRow, { height: 'auto', duration: 0.3, onComplete() {
							lessonRow.classList.add( 'is-showing' )
							pensumToggleIcon.classList.remove( 'fa-chevron-down' )
							pensumToggleIcon.classList.add( 'fa-chevron-up' )
						} } )
					}
				} )
			} )
			this.pensumToggles[ 0 ].click()
		}

		if ( this.sideBarToggle ) {
			this.sideBarToggle.addEventListener( 'click', ( ) => {
				if ( this.courseSidebar.classList.contains( 'is-active' ) ) {
					this.courseSidebar.classList.remove( 'is-active' )
					document.cookie = 'coursesidebar=closed; path=/;'
				} else {
					this.courseSidebar.classList.add( 'is-active' )
					document.cookie = 'coursesidebar=open; path=/;'
				}
			} )
		}
	}

	//Opens the course preview modal
	showCoursePreview = ( event ) => {
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

		modals.openModal( 'course-preview-modal' )
	}
}
export const CoursePage = new Course()

