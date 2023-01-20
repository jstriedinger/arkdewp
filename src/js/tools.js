let isMobile = false
document.addEventListener(
	'DOMContentLoaded', () => {
		isMobile = window.innerWidth < 768
	}
)

export { isMobile }

