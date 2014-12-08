$(document).ready(function() {
    $('#slider').slider({
        min: 1995,
        max: 2010,
        value: 2010,
        slide: function(event, ui) {
            $('div#slider_current').text(ui.value);
        },
        change: function(event, ui) {
        }
    });

    $('.country_link').click(function() {
        var country = $(this).attr('data-country');
        $.ajax({
            url: "http://jakobhans.koding.io/dataProcess.php?c=" + country,
        }).done(function(data) {
            $('#tilesWrapper').empty().append(data);
        });

        return false;
    });
});
