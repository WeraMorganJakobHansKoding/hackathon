$(document).ready(function() {
    $('#slider').slider({
        min: 1995,
        max: 2010,
        value: 2010,
        slide: function(event, ui) {
            console.log(ui.value);
            $('div#slider_current').text(ui.value);
        },
        change: function(event, ui) {
            console.log(ui.value);
        }
    });
});
