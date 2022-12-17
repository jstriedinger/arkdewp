import '../sass/arkdewp.scss'
import './tools.js'
import topbar from './navigation.js'
import { modals } from './modals'
import { CoursesGrid } from './courses'
import { InfiniteSlider } from './infiniteSlider'

import { gsap } from 'gsap'
gsap.set( '#anim-top-section > *:not(.megagrants-badge), #anim-teacher-section .card.teacher-card, .anim-bottom-top-children > *, .anim-right-left-children > *', { autoAlpha: 0 } )
gsap.set( '#anim-top-section .megagrants-badge span', { scaleX: 0 } )

document.addEventListener( 'DOMContentLoaded', () => {
	//handle course preview buttons

	//top section animation
	const topSection = document.getElementById( 'anim-top-section' )
	if ( topSection ) {
		gsap.fromTo( '#anim-top-section > *:not(.megagrants-badge)', { autoAlpha: 0, y: 50 }, { autoAlpha: 1, y: 0, duration: 1, stagger: 0.2 } )
		gsap.to( '#anim-top-section .megagrants-badge span', { scaleX: 1, duration: 2, delay: 1 } )
		gsap.fromTo( '#anim-top-section .megagrants-badge img', { autoAlpha: 0, y: 50 }, { autoAlpha: 1, y: 0, duration: 1 } )
	}

	const homeTeacherSection = document.getElementById( 'anim-teacher-section' )
	if ( homeTeacherSection ) {
		const tl = gsap.timeline( {
			scrollTrigger: {
				trigger: homeTeacherSection,
				start: 'top 75%',
			},
		} )
		tl.add( gsap.fromTo( '#anim-teacher-section .card.teacher-card', { autoAlpha: 0, x: 50 }, { autoAlpha: 1, x: 0, duration: 1, stagger: 0.2 } ) )
	}

	//Animations gsap
	gsap.fromTo( '.anim-bottom-top-children > *', { autoAlpha: 0, y: 50 }, { autoAlpha: 1, y: 0, duration: 1, stagger: 0.2, scrollTrigger: {
		trigger: '.anim-bottom-top-children',
		start: 'top 75%',
		markers: true,
	} } )

	gsap.fromTo( '.anim-right-left-children > *', { autoAlpha: 0, x: 50 }, { autoAlpha: 1, x: 0, duration: 1, stagger: 0.2, scrollTrigger: {
		trigger: '.anim-right-left-children',
		start: 'top 75%',
	} } )

	//numbers animation
	const numbersDom = document.querySelectorAll( '.anim-numbers-up .anim-number' )

	gsap.from( numbersDom, {
		textContent: 0,
		duration: 1,
		ease: 'power1.in',
		snap: { textContent: 1 },
		stagger: {
			each: 0,
			onUpdate() {
				this.targets()[ 0 ].innerHTML = Math.ceil( this.targets()[ 0 ].textContent )
			},
		},
		scrollTrigger: {
			trigger: '.anim-numbers-up',
			start: 'top 70%',
		},
	} )

	//course categories filter
	const courseCats = document.getElementById( 'arkde-course-category-filter' )
	if ( courseCats ) {
		courseCats.addEventListener( 'change', function() {
			const cat = courseCats.value
			if ( cat === 'all' ) {
				[ ...document.getElementsByClassName( 'card course-card' ) ].map( ( item ) => {
					item.classList.remove( 'is-hidden' )
				} )
			} else {
				[ ...document.getElementsByClassName( 'card course-card' ) ].map( ( item ) => {
					if ( item.dataset.categories.includes( cat ) ) {
						item.classList.remove( 'is-hidden' )
					} else {
						item.classList.add( 'is-hidden' )
					}
				} )
			}
		} )
	}

	//infinite slider for testimonials
	const sliderDom = document.getElementById( 'arkde-infinite-slider' )
	if ( sliderDom && sliderDom.firstChild ) {
		new InfiniteSlider( sliderDom )
	}

	//Video background on a page
	const videoBackground = document.getElementById( 'video-background' )
	if ( videoBackground ) {
		if ( window.matchMedia( '(min-width: 1023px)' ).matches ) {
			const url = videoBackground.dataset.src
			videoBackground.src = url
		}
	}
} )

