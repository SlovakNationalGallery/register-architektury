$(document).ready(function(){
    $('#hide-news').on('click', function(e) {
        e.preventDefault();
        $.post( "/settings", {hide_news_ticker: true}, function( result ) {
            $('#news').fadeOut();
        });
    })
});