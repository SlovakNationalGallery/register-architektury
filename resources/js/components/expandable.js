import Readmore from 'readmore-js/dist/readmore.es6.js';

new Readmore('.expandable', {
    moreLink: '<a href="#" class="link-no-underline d-inline">Zobraz viac ↷</a>',
    lessLink: '<a href="#" class="link-no-underline d-inline">Zobraz menej ↺</a>'
});