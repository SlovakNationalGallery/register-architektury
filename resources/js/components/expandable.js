import Readmore from 'readmore-js/dist/readmore.js';

var more_text, less_text;

if (document.documentElement.lang == 'sk') {
	more_text = 'Zobraz viac';
	less_text = 'Zobraz menej';
} else  {
	more_text = 'Show more';
	less_text = 'Show less';
}

new Readmore('.expandable', {
    moreLink: '<a href="#" class="link-no-underline d-inline">' + more_text + ' ↷</a>',
    lessLink: '<a href="#" class="link-no-underline d-inline">' + less_text + ' ↺</a>'
});
