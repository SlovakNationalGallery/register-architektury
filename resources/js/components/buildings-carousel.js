function initializeBuildingsCarousels(scope) {
    scope.querySelectorAll('.buildings-carousel').forEach(container => {
        const nextButton = container.querySelector('.next-button')
        const prevButton = container.querySelector('.prev-button')

        new Flickity(container.querySelector('.carousel'), {
            cellAlign: 'left',
            lazyLoad: 10,
            freeScroll: true,
            prevNextButtons: false,
            pageDots: false,
            setGallerySize: false,
            cellSelector: '.carousel-cell',

            on: {
                ready() {
                    nextButton.onclick = this.next.bind(this)
                    prevButton.onclick = this.previous.bind(this)

                    nextButton.disabled = this.selectedIndex === this.slides.length - 1 || this.slides.length === 0
                    prevButton.disabled = this.selectedIndex === 0
                },
                change(index) {
                    nextButton.disabled = this.selectedIndex === this.slides.length - 1 || this.slides.length === 0
                    prevButton.disabled = this.selectedIndex === 0
                },
                lazyLoad(event, cell) {
                    const image = cell.querySelector('img')
                    image.sizes = Math.ceil(image.getBoundingClientRect().width / window.innerWidth * 100 ) + 'vw'
                },
            }
        })
    })
}

// First initialization
initializeBuildingsCarousels(document)


export {
    initializeBuildingsCarousels
}
