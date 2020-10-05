$(document).ready(function(){
    $('#hide-news').on('click', function(e) {
        e.preventDefault();
        $.post( "/toggle-newsticker", function( data ) {
          $('#news').fadeOut();
        });
    })
});