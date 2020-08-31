import noUiSlider from 'nouislider';

$(document).ready(function(){
    if($('#year_from').length > 0) {

        function filterPips(value, type) {
            if (
                ($(window).width() < 768) &&
                ($('#year_until').data('max') - $('#year_from').data('min') >= 70)
            ) {
                return value % 20 ? 0 : 1;
            }
            return type;
        }

        var timeline = noUiSlider.create($('#years')[0], {
            start: [$("#year_from").val(), $("#year_until").val()],
            connect: true,
            step: 10,
            range: {
                'min': $('#year_from').data('min'),
                'max': $('#year_until').data('max'),
            },
            tooltips: [ true, true ],
            pips: {
                mode: 'steps',
                stepped: true,
                filter: filterPips,
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
             $("#year_until").change();
        });

    }
});