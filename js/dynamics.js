$(document).ready(function() {
    $('#slider').slider({
        min: 1995,
        max: 2010,
        slide: function(event, ui) {
            $('.currentTimes').html(ui.value);
        },
        change: function(event, ui) {
            alert(ui.value);
        }
    });
});
