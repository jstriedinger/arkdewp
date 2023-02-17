import '../sass/arkdewp.scss'
import './tools.js'
import topbar from './navigation.js'
import { modals } from './modals'
import { CoursesGrid } from './courses'
import { CoursePage } from './course'
import { CareerPage } from './career'
import { InfiniteSlider } from './infiniteSlider'

import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
gsap.registerPlugin( ScrollTrigger )

gsap.set( '#anim-top-section > *:not(.hr-badge), #anim-teacher-section .card.teacher-card, .anim-bottom-top-children > *, .anim-right-left-children > *', { autoAlpha: 0 } )
gsap.set( '#anim-top-section .hr-badge span', { scaleX: 0 } )
gsap.set( '#course-top-section .columns > .column > *', { autoAlpha: 0 } )
gsap.set( '.popup', { autoAlpha: 0, display: 'none' } )

const setupAnimnations = () => {
	//top section animation
	const topSection = document.getElementById( 'anim-top-section' )
	if ( topSection ) {
		gsap.fromTo( '#anim-top-section > *:not(.hr-badge)', { autoAlpha: 0, y: 50 }, { autoAlpha: 1, y: 0, duration: 1, stagger: 0.2 } )
		gsap.to( '#anim-top-section .hr-badge span', { scaleX: 1, duration: 2, delay: 1 } )
		gsap.fromTo( '#anim-top-section .hr-badge img', { autoAlpha: 0, y: 50 }, { autoAlpha: 1, y: 0, duration: 1 } )
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
	} } )

	gsap.fromTo( '.anim-right-left-children > *', { autoAlpha: 0, x: 50 }, { autoAlpha: 1, x: 0, duration: 1, stagger: 0.2, scrollTrigger: {
		trigger: '.anim-right-left-children',
		start: 'top 75%',
	} } )

	//course page stuff
	const courseTopSection = document.getElementById( 'course-top-section' )
	if ( courseTopSection ) {
		const tl2 = gsap.timeline( {} )
		tl2.add( gsap.fromTo( '#course-top-section .columns > .column:first-child > *', { autoAlpha: 0, x: -50 }, { autoAlpha: 1, x: 0, duration: 0.8, stagger: 0.2 } ) )
		tl2.add( gsap.to( '#course-top-section .columns > .column:not(:first-child) > *', { autoAlpha: 1, x: 0, duration: 0.6, stagger: 0.2 } ) )
	}

	//numbers animation
	const numbersDom = document.querySelectorAll( '.anim-numbers-up .anim-number' )
	if ( numbersDom ) {
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
	}

	//Career reminder in course page
	const careerReminderpopup = document.querySelector( '.popup' )
	if ( careerReminderpopup ) {
		gsap.to( '.popup', { autoAlpha: 1, display: 'flex', duration: 0.8, scrollTrigger: {
			trigger: '.bullet-points',
			start: 'top 75%',
		} } )
		const careerReminderCloseBtn = careerReminderpopup.querySelector( '.close-button' )
		careerReminderCloseBtn.addEventListener( 'click', () => {
			gsap.to( '.popup', { autoAlpha: 0, duration: 0.25, onComplete() {
				careerReminderpopup.remove()
			} } )
		} )
	}

	//remove woocommerce notices after a while
	if ( document.querySelectorAll( '.woocommerce-notices-wrapper .woocommerce-message' ).length > 0 ) {
		gsap.to( '.woocommerce-notices-wrapper .woocommerce-message', { autoAlpha: 0, duration: 0.8, stagger: 0.2, delay: 2, onComplete( ) {
			this.targets()[ 0 ].remove()
		} } )
	}
}

document.addEventListener( 'DOMContentLoaded', () => {
	setupAnimnations()

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

