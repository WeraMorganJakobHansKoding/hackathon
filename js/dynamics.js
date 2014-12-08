$(document).ready(function() {
    $('#slider').slider({
        min: 1995,
        max: 2010,
        value: 2010,
        slide: function(event, ui) {
            $('div#slider_current').text(ui.value);
        },
        change: function(event, ui) {
            $('.activeTile').fadeOut(400, function() {
                $('.activeTile').removeClass('activeTile');
                $('.year' + ui.value).addClass('activeTile');
                $('.year' + ui.value).fadeIn();
            });
        }
    });

    $('.country_link').click(function() {
        $('#countryBox').slideToggle('fast');
        $('div#overlay').fadeIn();

        var countryName = $(this).text();
        var country = $(this).attr('data-country');
        $.ajax({
            url: "http://jakobhans.koding.io/dataProcess.php?c=" + country,
        }).done(function(data) {
            $('div#overlay').fadeOut();
            $('#tilesWrapper').empty().append(data);
            $('.year' + $('#slider').slider("value")).slideDown();
            $('.year' + $('#slider').slider("value")).addClass('activeTile');
            $('h3#countryTitle').text(countryName);
            startPulse();
        });

        return false;
    });

    $('.countries_toggle_button').click(function() {
        $('#countryBox').slideToggle();
    });

});

function startPulse() {
    var tiles = $('.activeTile').children('.tile');
    $(tiles).each(function() {
        var pulseRate = parseFloat($(this).attr('data-lapse'));
        $(this).effect("pulsate", {times:1000}, pulseRate);
    });
}
