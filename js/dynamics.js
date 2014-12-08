$(document).ready(function() {
    $('#slider').slider({
        min: 1995,
        max: 2010,
        value: 2010,
        slide: function(event, ui) {
            $('div#slider_current').text(ui.value);
        },
        change: function(event, ui) {
            $('.yearWrapper').fadeOut(400, function() {
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
            $('h3#countryTitle').text(countryName);
        });

        return false;
    });

    $('.countries_toggle_button').click(function() {
        $('#countryBox').slideToggle();
    });

});
