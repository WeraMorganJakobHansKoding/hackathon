$(document).ready(function() {
    $('#slider').slider({
        min: 1995,
        max: 2010,
        value: 2010,
        slide: function(event, ui) {
            $('div#currentTimes').html(ui.value);
        },
        change: function(event, ui) {
            alert(ui.value);
        }
    });
});
