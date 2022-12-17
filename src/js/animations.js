import { gsap } from 'gsap'
gsap.registerPlugin( ScrollTrigger )

class PageAnimations {

	constructor() {
		document.addEventListener (
			'DOMContentLoaded', () => {
				this.setup()
			}
		)
	}

	setup = () => {
		//top section animation
		const topSection = document.getElementById( 'anim-top-section' )
		if ( topSection ) {
			gsap.fromTo( '#anim-top-section > *:not(.megagrants-badge)', { autoAlpha: 0, y: 50 }, { autoAlpha: 1, y: 0, duration: 1, stagger: 0.2 } )
			gsap.from( '#anim-top-section .megagrants-badge span', { scaleX: 0, duration: 2, delay: 1 } )
			gsap.fromTo( '#anim-top-section .megagrants-badge img', { autoAlpha: 0, y: 50 }, { autoAlpha: 1, y: 0, duration: 1 } )
		}

		const homeTeacherSection = document.getElementById( 'anim-teacher-section' )
		if ( homeTeacherSection ) {
			const tl = gsap.timeline( {
				scrollTrigger: {
					trigger: homeTeacherSection,
					start: 'top 70%',
				},
			} )
			tl.add( gsap.fromTo( '#anim-teacher-section .card.teacher-card', { autoAlpha: 0, x: 50 }, { autoAlpha: 1, x: 0, duration: 1, stagger: 0.2 } ) )
		}
	}
}
export const PageAnimations = new PageAnimations()