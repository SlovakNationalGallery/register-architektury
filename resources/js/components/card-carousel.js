function initializeCardCarousels(scope) {
    scope.querySelectorAll('.card-carousel').forEach(obj => {
        const nextButton = obj.querySelector('.next-button')
        const prevButton = obj.querySelector('.prev-button')

        new Flickity(obj, {
            prevNextButtons: false,
            pageDots: false,
            lazyLoad: 2,
            fullscreen: false,
            cellSelector: '.carousel-cell',

            on: {
                ready() {
                    nextButton.onclick = this.next.bind(this)
                    prevButton.onclick = this.previous.bind(this)

                    nextButton.disabled = this.selectedIndex === this.slides.length - 1 || this.slides.length === 0
                    prevButton.disabled = this.selectedIndex === 0
                },
                change(event, index) {
                    nextButton.disabled = this.selectedIndex === this.slides.length - 1 || this.slides.length === 0
                    prevButton.disabled = this.selectedIndex === 0
                }
            }
        });
    });
}

// First initialization
initializeCardCarousels(document)

export {
    initializeCardCarousels
}
