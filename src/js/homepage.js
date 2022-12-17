import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

gsap.registerPlugin( ScrollTrigger )
const tl = gsap.timeline()

document.addEventListener( 'DOMContentLoaded', () => {
	//course grids
	tl.add( gsap.fromTo( '#anim-course-grids .column', { autoAlpha: 0, y: 120 }, { autoAlpha: 1, y: 0, duration: 1, stagger: 0.15,
		scrollTrigger: {
			trigger: '#anim-course-grids',
			start: 'top 50%', // when the top of the trigger hits the top of the viewport
		} } ) )
} )
