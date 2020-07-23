require('readmore-js');

$('.expandable').readmore({
  afterToggle: function(trigger, element, expanded) {
    if(! expanded) {
      $('html, body').animate( { scrollTop: element.offset().top }, {duration: 100 } );
    }
  }
});