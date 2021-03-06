function initializeBuildingCards(scope) {
    scope.querySelectorAll('.card-carousel').forEach(obj => {
        const nextButton = obj.querySelector('.next-button')
        const prevButton = obj.querySelector('.prev-button')

        new Flickity(obj, {
            prevNextButtons: false,
            pageDots: false,
            lazyLoad: 1,
            cellSelector: '.carousel-cell',

            on: {
                ready() {
                    nextButton.onclick = this.next.bind(this)
                    prevButton.onclick = this.previous.bind(this)

                    nextButton.disabled = this.selectedIndex === this.slides.length - 1
                    prevButton.disabled = this.selectedIndex === 0
                },
                change(event, index) {
                    nextButton.disabled = this.selectedIndex === this.slides.length - 1
                    prevButton.disabled = this.selectedIndex === 0
                },
                lazyLoad(event, cell) {
                    const image = cell.querySelector('img')
                    image.sizes = Math.ceil(cell.getBoundingClientRect().width / window.innerWidth * 100 ) + 'vw'
                },
            }
        });
    });
}

// First initialization
initializeBuildingCards(document)

export {
    initializeBuildingCards
}
