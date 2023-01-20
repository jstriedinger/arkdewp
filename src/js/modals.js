import { gsap } from 'gsap/all'
class UIModals {
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
		//get all modals on page
		this.uimodals = document.querySelectorAll( '.ui-modal' )

		//Last loaded preview frame
		this.lastLoadedPreview = null;

		//attach close events
		[ ...this.uimodals ].forEach( ( uimodal ) => {
			const closeBtn = uimodal.querySelector( '.modal-close' )
			closeBtn.addEventListener( 'click', () => this.closeModal( uimodal ) )
		} )

		// Add a keyboard event to close all modals
		document.addEventListener( 'keydown', ( event ) => {
			const e = event || window.event
			if ( e.code === 'Escape' ) { // Escape key
				this.closeAllModals()
			}
		} )
		//Close modal when click in background
		document.addEventListener( 'click', ( event ) => {
			const target = event.target
			if ( target.classList.contains( 'modal-background' ) ) {
				const activeModal = target.closest( '.ui-modal' )
				this.closeModal( activeModal )
			}
		} )
	}

	closeModal = ( uimodal ) => {
		if ( uimodal ) {
			if ( uimodal.classList.contains( 'is-active' ) ) {
				gsap.to( uimodal, { duration: 0.35, opacity: 0, onComplete() {
					gsap.delayedCall( 0.5, function() {
						uimodal.classList.remove( 'is-active' )
					} )
				} } )
			}
		}
	}

	openModal = ( id ) => {
		const foundModal = 	[ ...this.uimodals ].find( ( uim ) => uim.id === id )
		if ( foundModal ) {
			//check if modal is alread openend. Is another is open, close it
			if ( ! foundModal.classList.contains( 'is-active' ) ) {
				foundModal.classList.add( 'is-active' )
				gsap.to( foundModal, { duration: 0.35, opacity: 1, onComplete() {
					gsap.delayedCall( 0.5, function() {
						foundModal.classList.remove( 'in-transition' )
						foundModal.classList.add( 'is-active' )
					} )
				}, onStart() {
					foundModal.classList.add( 'in-transition' )
				} } )
			}
		}
	}

	closeAllModals = () => {
		[ ...this.uimodals ].forEach( ( uimodal ) => {
			this.closeModal( uimodal )
		} )
	}
}
export const modals = new UIModals()
