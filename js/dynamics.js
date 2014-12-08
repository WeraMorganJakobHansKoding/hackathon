$(document).ready(function() {
    $('#slider').slider({
        min: 1995,
        max: 2010,
        change: function(event, ui) {
            alert(ui.value);
        }
    });
});
