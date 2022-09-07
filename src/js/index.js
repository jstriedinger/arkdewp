import '../sass/arkdewp.scss';
import './tools.js';
import Navbar from './navigation.js';
import UIModal from './modal.js';
console.log( 'lets see' );

const topbar = new Navbar();
const modals = new UIModal();

document.addEventListener( 'DOMContentLoaded', () => {
	document.getElementById( 'temporal' ).addEventListener( 'click', ( event ) => {
		event.preventDefault();
		modals.openModal( 'course-preview-modal' );
	} );
} );
