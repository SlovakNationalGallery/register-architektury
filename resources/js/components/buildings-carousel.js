function initializeBuildingsCarousels(scope) {
    scope.querySelectorAll('.buildings-carousel').forEach(container => {
        const nextButton = container.querySelector('.next-button')
        const prevButton = container.querySelector('.prev-button')

        new Flickity(container.querySelector('.carousel'), {
            cellAlign: 'left',
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
            }
        })
    })
}

// First initialization
initializeBuildingsCarousels(document)


export {
    initializeBuildingsCarousels
}
