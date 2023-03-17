import { modals } from './modals.js'
import YTPlayer from 'yt-player'
import { isMobile } from './tools'

class UICoursesGrid {
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

	prepareCoursePreviews = async () => {
		if ( this.courses ) {
			const fetchData = new FormData()
			fetchData.append( 'action', 'courses_preview_info' )
			fetchData.append( 'nonce', arkde_ajax.nonce )
			fetchData.append( 'courseids', this.coursesIds )
			fetchData.append( 'currency', this.currency )
			let coursesData = await fetch( arkde_ajax.ajaxurl, {
				method: 'POST',
				credentials: 'same-origin',
				body: fetchData,
			} )
				.then( ( response ) => response.json() )

			//lets map the course preview data
			if ( coursesData.success ) {
				//const buyNowBtn = coursesData.cta_text
				coursesData = coursesData.data
				this.coursePreviews = coursesData;
				//Lets get course preview data ready when click
				[ ...this.coursePreviews ].forEach( ( coursePreviewData ) => {
					const courseCard = document.getElementById( `course-card-${ coursePreviewData.id }` )
					const cardHeader = courseCard.querySelector( '.card-header' )
					console.log(coursePreviewData);
					if ( coursePreviewData.preview_url ) {
						//add the class
						cardHeader.classList.add( 'course-card-preview-link' )
						cardHeader.addEventListener( 'click', ( event ) => this.showCoursePreview( event, coursePreviewData ) )
					} else {
						cardHeader.addEventListener( 'click', ( event ) => window.location = cardHeader.dataset.href )
					}
				} )
			}
		}
	}
	setup() {
		this.currency = document.body.dataset.currency
		this.courses = document.querySelectorAll( '.course-card' )
		this.coursesIds = Array.from( [ ...this.courses ], ( item ) => item.dataset.course )
		this.container = document.getElementById( 'anim-course-grids' )

		//only do previews when is not mobile
		if ( ! isMobile ) {
			//get course preview modal on the page
			this.coursePreviewModal = document.querySelector( '#course-card-preview-modal' )
			this.prepareCoursePreviews()
			this.ytPlayer = new YTPlayer( '#course-video-preview', { related: false, modestBranding: true } )
			this.ytPlayer.mute()

			//lets map add_to_cart buttons
			this.addToCartBtns = document.getElementsByClassName( 'add_to_cart_button' )
			if ( this.addToCartBtns.length > 0 ) {
				[ ...this.addToCartBtns ].forEach( ( cartBtn ) => {
					cartBtn.addEventListener( 'click', ( event ) => {
						event.target.classList.add( 'is-loading' )
					} )
				} )
			}

			//attach close events to close button of preview modal
			if ( this.coursePreviewModal !== null ) {
				//lets get buy now and more info btn text for the modal
				this.btnBuyText = this.coursePreviewModal.dataset.btnBuy
				this.btnInfoText = this.coursePreviewModal.dataset.btnInfo

				const closeBtn = this.coursePreviewModal.querySelector( '.modal-close' )
				closeBtn.addEventListener( 'click', () => {
					if ( this.ytPlayer ) {
						this.ytPlayer.stop()
						this.ytPlayer.mute()
						console.log( 'stop from X' )
					}
				} )
				//Close modal when click in background
				document.addEventListener( 'click', ( event ) => {
					const target = event.target
					if ( target.classList.contains( 'modal-background' ) ) {
						if ( this.ytPlayer ) {
							this.ytPlayer.stop()
							this.ytPlayer.mute()
							console.log( 'Stopping from clicking away' )
						}
					}
				} )
				document.addEventListener( 'keydown', ( event ) => {
					const e = event || window.event
					if ( e.code === 'Escape' && this.ytPlayer ) { // Escape key
						this.ytPlayer.stop()
						this.ytPlayer.mute()
						console.log( 'stopping from ESC' )
					}
				} )
			}
		} else {
			//lets put the card header as link to the course itself in mobile
			[ ...this.courses ].forEach( ( courseCard ) => {
				const cardHeader = courseCard.querySelector( '.card-header' )
				const url = cardHeader.dataset.href
				cardHeader.addEventListener( 'click', ( ) => window.location = url )
			} )
		}
	}

	//Opens the course preview modal
	showCoursePreview = ( event, courseData ) => {
		event.preventDefault()
		//Lets check the video has not been loaded yet
		const videoPreviewUrl = courseData.preview_url
		if ( ! this.lastLoadedPreview ||
			( this.lastLoadedPreview && videoPreviewUrl !== this.lastLoadedPreview ) ) {
			//we were not the last loaded preview

			//1. load the yt preview video
			this.ytPlayer.load( courseData.preview_url, { autoplay: false, keyboard: false } )
			this.ytPlayer.stop()
			this.ytPlayer.unMute()
			this.ytPlayer.play()
			this.lastLoadedPreview = videoPreviewUrl

			//2. put the info
			const courseTitle = document.getElementById( 'course-preview-card-title' )
			courseTitle.textContent = courseData.title
			const courseDesc = document.getElementById( 'course-preview-card-desc' )
			courseDesc.textContent = courseData.description

			const courseDetails = document.getElementById( 'course-preview-card-details' )
			const courseDetailsItems = courseDetails.getElementsByClassName( 'level-item' )
			courseDetailsItems[ 1 ].querySelectorAll( 'span' )[ 3 ].textContent = courseData.students
			courseDetailsItems[ 2 ].lastElementChild.textContent = courseData.duration

			const courseLevelIndicator = courseDetailsItems[ 3 ].querySelector( '.course-level-icon' )
			courseLevelIndicator.classList = ''
			courseLevelIndicator.classList.add( 'course-level-icon', `level-${ courseData.level }`, 'mr-2' )

			courseDetailsItems[ 3 ].lastElementChild.textContent = courseData.level

			//Now the teachers
			const teachersDiv = courseDetailsItems[ 0 ].querySelector( '.course-teachers' )
			let multiTeacher = ''
			if ( courseData.teachers.length > 1 ) {
				multiTeacher = ' +1'
			}
			teachersDiv.innerHTML = `<div class='course-teacher-item'> <img src='${ courseData.teachers[ 0 ].image }'/><p class='is-size-14px'>${ courseData.teachers[ 0 ].name + multiTeacher }</p></div>`

			//the permalink
			const ctaButton = this.coursePreviewModal.querySelector( '.button' )
			ctaButton.href = courseData.cta_link
			ctaButton.classList = ''
			ctaButton.dataset.product_id = courseData.pricing_info.product_id

			if ( courseData.pricing_info.price_type !== 'free' ) {
				ctaButton.classList.add( 'button', 'product_type_course', 'add_to_cart_button', 'ajax_add_to_cart', 'is-primary', 'is-medium' )
				ctaButton.innerHTML = courseData.cta_txt
				//prices
				this.coursePreviewModal.querySelector( '#course-preview-price-free' ).classList.add( 'is-hidden' )
				const coursePriceNode = this.coursePreviewModal.querySelector( '#course-preview-price-not-free' )
				coursePriceNode.classList.remove( 'is-hidden' )
				coursePriceNode.innerHTML = ''

				const currentPriceNode = document.createElement( 'p' )
				currentPriceNode.append( document.createTextNode( '$' + courseData.pricing_info.price ) )
				const currencyNode = document.createElement( 'small' )
				currencyNode.classList.add( 'is-size-5' )
				currencyNode.textContent = this.currency
				currentPriceNode.append( currencyNode )
				currentPriceNode.classList.add( 'is-size-3', 'has-text-weight-bold', 'has-lh-1-2' )

				if ( courseData.pricing_info.on_sale ) {
					const beforePriceNode = document.createElement( 'p' )
					beforePriceNode.append( document.createTextNode( '$' + courseData.pricing_info.regular_price ) )
					beforePriceNode.classList.add( 'is-size-5', 'is-line-through', 'mr-3', 'has-text-grey' )
					coursePriceNode.append( beforePriceNode )
				}
				coursePriceNode.append( currentPriceNode )
			} else {
				//Now we check if already enrolled or not
				ctaButton.classList.add( 'button', 'is-primary', 'is-medium' )
				ctaButton.innerHTML = courseData.cta_txt

				//prices
				this.coursePreviewModal.querySelector( '#course-preview-price-not-free' ).classList.add( 'is-hidden' )
				this.coursePreviewModal.querySelector( '#course-preview-price-not-free' ).innerHTML = ''
				this.coursePreviewModal.querySelector( '#course-preview-price-free' ).classList.remove( 'is-hidden' )
			}
		} else {
			this.ytPlayer.seek( 0 )
			this.ytPlayer.unMute()
			this.ytPlayer.play()
			console.log( 'playing again' )
		}

		modals.openModal( 'course-card-preview-modal' )
	}
}
export const CoursesGrid = new UICoursesGrid()

