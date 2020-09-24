require('flickity-as-nav-for');
require('flickity-fullscreen');

const mainCarousel = document.querySelector('.gallery-carousel-main')

if (mainCarousel) {
    const caption = mainCarousel.querySelector('.caption')
    const nextButton = mainCarousel.querySelector('.next-button')
    const prevButton = mainCarousel.querySelector('.prev-button')
    const fullscreenExitButton = mainCarousel.querySelector('.fullscreen-exit-button')

    // Initialize main carousel
    new Flickity(mainCarousel, {
        prevNextButtons: false,
        pageDots: false,
        lazyLoad: 2,
        fullscreen: true,
        cellSelector: '.carousel-cell',

        on: {
            ready() {
                nextButton.onclick = this.next.bind(this)
                prevButton.onclick = this.previous.bind(this)
                fullscreenExitButton.onclick = this.exitFullscreen.bind(this)

                nextButton.disabled = this.selectedIndex === this.slides.length - 1
                prevButton.disabled = this.selectedIndex === 0

                // Initialize first caption
                caption.innerHTML = this.selectedElement.getAttribute('data-caption')
            },
            change(index) {
                nextButton.disabled = this.selectedIndex === this.slides.length - 1
                prevButton.disabled = this.selectedIndex === 0

                // Update caption on cell change
                caption.innerHTML = this.selectedElement.getAttribute('data-caption')
            },
            fullscreenChange(isFullScreen) {
                this.cells
                .map(cell => cell.element.querySelector('img'))
                .forEach(img => {

                    // Remove size restriction when going fullscreen
                    if (isFullScreen) {
                        img.setAttribute('data-default-sizes', img.getAttribute('sizes'))
                        img.setAttribute('sizes', null)
                        return
                    }

                    // Revert to initial sizes when exiting fullscreen
                    img.setAttribute('sizes', img.getAttribute('data-default-sizes'))
                })
            },
            lazyLoad(event, cell) {
                const image = cell.querySelector('img')
                image.sizes = Math.ceil(cell.getBoundingClientRect().width / window.innerWidth * 100 ) + 'vw'
            },
            staticClick() {
                this.viewFullscreen()
            },
        }
    })


    // Initialize navigation carousel
    new Flickity(document.querySelector('.gallery-carousel-nav'), {
        cellAlign: 'left',
        freeScroll: true,
        contain: true,
        prevNextButtons: false,
        pageDots: false,
        setGallerySize: false,
        asNavFor: '.gallery-carousel-main',
        lazyLoad: 5,
        on: {
            lazyLoad(event, image) {
                image.sizes = Math.ceil(image.getBoundingClientRect().width / window.innerWidth * 100 ) + 'vw'
            },
        }
    })
}
