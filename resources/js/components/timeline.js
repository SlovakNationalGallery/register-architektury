import noUiSlider from 'nouislider';

$(document).ready(function(){

    var timeline = noUiSlider.create($('#years')[0], {
        start: [$("#year_from").val(), $("#year_until").val()],
        connect: true,
        step: 10,
        range: {
            'min': $('#year_from').data('min'),
            'max': $('#year_until').data('max'),
        },
        behaviour: 'tap-drag',
        tooltips: [ true, true ],
        pips: {
            mode: 'steps',
            stepped: true,
            density: 10
        },
        format: {
            from: function(value) {
                return parseInt(value);
            },
            to: function(value) {
                return parseInt(value);
            }
        }
    });

    timeline.on('update', function( values, handle ) {
         if ( handle ) {
             $("#year_until").val(values[handle]);
         } else {
             $("#year_from").val(values[handle]);
         }
     });

    timeline.on('end', function( values, handle ) {
         // var form = $('#filters form');
         // form.submit();
         $("#year_until").change();
    });

});