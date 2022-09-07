/**
 * Class Navbar
 */
export default class Navbar {
	/**
	 * This method is run automatically when the module is imported,
	 * because it exports a new instance of itself.
	 */
	constructor() {
		document.addEventListener(
			'DOMContentLoaded', () => {
				this.setup();
			}
		);
	}

	setup() {
		//get neccesarry elements
		this.navbarBurger = document.getElementById( 'navbar-burger' );
		this.navbarMenu = document.getElementById( 'navbar-top' );
		this.currentOpenDropdown = null;
		if ( this.navbarMenu ) {
			this.dropdownTogglers = this.navbarMenu.querySelectorAll( '.navbar-item.has-dropdown > .navbar-link' );
		}

		//Events
		//close all open dropdown if clicked outside
		document.addEventListener( 'click', ( event ) => {
			const target = event.target;
			if ( ! target.classList.contains( 'dropdown' ) &&
					! target.classList.contains( 'navbar-link' ) ) {
				//close all open dropdowns
				[ ...this.dropdownTogglers ].forEach( ( toggler ) => {
					const itemDropdown =	toggler.closest( '.navbar-item.has-dropdown' );
					if ( itemDropdown.classList.contains( 'is-active' ) ) {
						itemDropdown.classList.remove( 'is-active' );
						toggler.setAttribute( 'aria-expanded', false );
					}
				} );
			}
		} );

		if ( this.navbarBurger ) {
			this.navbarBurger.addEventListener( 'click', () => this.toggleMenu() );
		}

		if ( this.dropdownTogglers ) {
			[ ...this.dropdownTogglers ].forEach( ( toggler ) => {
				toggler.addEventListener( 'click', ( event ) => this.toggleDropdown( event ) );
				const dropMenu =	toggler.parentElement.querySelector( '.navbar-dropdown' );
				const id = Date.now();
				toggler.setAttribute( 'aria-controls', `dd-${ id }` );
				dropMenu.id = `dd-${ id }`;
			} );
		}
	}

	/**
	 * Handle menu toggling when the navbar burger is clicked.
	 */
	toggleMenu() {
		this.navbarBurger.classList.toggle( 'is-active' );
		this.navbarMenu.classList.toggle( 'is-active' );

		const currentAriaExpanded = this.navbarBurger.getAttribute( 'aria-expanded' );
		this.navbarBurger.setAttribute( 'aria-expanded', currentAriaExpanded ? false : true );
	}

	toggleDropdown( el ) {
		el.preventDefault();
		const target = el.target;
		const itemDropdown =	target.closest( '.navbar-item.has-dropdown' );
		if ( ! itemDropdown.classList.contains( 'is-active' ) &&
				this.currentOpenDropdown &&
				this.currentOpenDropdown !== itemDropdown ) {
			//another dropdown is open. Lets close it
			this.currentOpenDropdown.classList.remove( 'is-active' );
			this.currentOpenDropdown.querySelector( '.navbar-link' ).setAttribute( 'aria-expanded', false );
		}
		itemDropdown.classList.toggle( 'is-active' );
		const currentAriaExpanded = target.getAttribute( 'aria-expanded' );
		target.setAttribute( 'aria-expanded', currentAriaExpanded === 'true' ? false : true );
		if ( itemDropdown.classList.contains( 'is-active' ) ) {
			this.currentOpenDropdown = itemDropdown;
		} else {
			this.currentOpenDropdown = null;
		}
	}
}
