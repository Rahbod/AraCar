$(document).ready(function() {
    $(document).on("click", ".content-box .filter-box .head .toggle-icon", function () {
        $(this).toggleClass("plus").toggleClass("minus");
    }).on('keyup', '.range-min-input', function(){
        $(this).parent().find('.range-slider').slider("option", "values", [parseInt($(this).val()), parseInt($('.range-max-input').val())]);
    }).on('keyup', '.range-max-input', function(){
        $(this).parent().find('.range-slider').slider("option", "values", [parseInt($('.range-min-input').val()), parseInt($(this).val())]);
    }).on('keyup', '.filter-box.by-brand .text-field', function() {
        var query = $(this).val();

        if (query == '')
            $(this).parent().find('.brands-list li').removeClass('hidden');
        else {
            $(this).parent().find('.brands-list li').each(function () {
                var regex = new RegExp(query + ".*");
                if ($(this).find('label .title').text().match(regex) == null)
                    $(this).addClass('hidden');
                else
                    $(this).removeClass('hidden');
            });
        }
    }).on('click', '.advertise-info-box .image-container .image-slider-item', function(e) {
        e.preventDefault();
        var src = $(this).find('img').attr('src');

        $(this).parents('.image-container').find('.main-image-container img').attr('src', src);
    }).on('click', '.advertise-info-box #show-full-phone', function(e) {
        e.preventDefault();
        $(this).parent().find('.visible-num').removeClass('hidden');
        $(this).parent().find('.hidden-num').addClass('hidden');
        $(this).addClass('hidden');
    });

    $(".nicescroll").each(function () {
        var options = $(this).data();

        $.each(options, function (key, value) {
            if (typeof value == "string" && value.indexOf("js:") != -1)
                options[key] = JSON.parse(value.substr(3));
        });

        $(this).niceScroll(options);
    });

    $(".datepicker").each(function () {
        $(this).persianDatepicker(eval($(this).data("config")));
    });

    $(".is-carousel").each(function () {
        var nestedItemSelector = $(this).data('item-selector'),
            dots = ($(this).data('dots') == 1) ? true : false,
            nav = ($(this).data('nav') == 1) ? true : false,
            responsive = $(this).data('responsive'),
            margin = $(this).data('margin'),
            loop = ($(this).data('loop') == 1) ? true : false,
            autoPlay = ($(this).data('autoplay') == 1) ? true : false,
            autoPlayHoverPause = ($(this).data('autoplay-hover-pause') == 1) ? true : false,
            mouseDrag = ($(this).data('mouse-drag') == 1) ? true : false;
        if (typeof nestedItemSelector == 'undefined') {
            $(this).owlCarousel({
                slideBy: 1,
                loop: loop,
                autoplay: autoPlay,
                items: 1,
                dots: dots,
                nav: nav,
                margin: margin,
                autoplayHoverPause: autoPlayHoverPause,
                mouseDrag: mouseDrag,
                navText: ["<i class='arrow-icon'></i>", "<i class='arrow-icon'></i>"],
                responsive: responsive,
                rtl: true
            });
        } else {
            $(this).owlCarousel({
                slideBy: 1,
                loop: loop,
                autoplay: autoPlay,
                items: 1,
                nestedItemSelector: nestedItemSelector,
                dots: dots,
                nav: nav,
                autoplayHoverPause: autoPlayHoverPause,
                mouseDrag: mouseDrag,
                navText: ["<i class='arrow-icon'></i>", "<i class='arrow-icon'></i>"],
                responsive: responsive,
                rtl: true
            });
        }
    });

    $('.range-slider').each(function () {
        $(this).slider({
            range: true,
            min: $(this).data('min'),
            max: $(this).data('max'),
            step: $(this).data('step'),
            values: $(this).data('values'),
            slide: function (event, ui) {
                $($(this).data('min-input')).val(ui.values[0]);
                $($(this).data('max-input')).val(ui.values[1]);
            }
        });
    });

    //$('.currency-format').currencyFormat();
});

$.fn.currencyFormat = function() {
    var value = $(this).val(),
        temp,
        str ='';

    console.log();

    temp = value.split("").reverse().join("");
    temp = temp.match(/.{1,3}/g);
    for (var i = temp.length; i > 0;i--) {
        if (i == 1)
            str += (temp[i - 1].split("").reverse().join(""));
        else
            str += (temp[i - 1].split("").reverse().join("")) + '/';
    }

    $(this).val(str);
};