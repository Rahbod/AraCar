$(document).ready(function() {
    if($('.select-picker').length && $.fn.selectpicker)
        $('.select-picker').selectpicker();
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
    }).on('show.bs.collapse', '.car-list.accordion', function(e) {
        $(".car-list.accordion .collapse.in").each(function(){
            $(this).collapse('hide');
        });
    }).on('click', '.linear-link', function(e) {
        e.preventDefault();
        var href = $(this).attr('href');
        if($(href).parents(".nicescroll").length)
            $(href).parents(".nicescroll").getNiceScroll(0).doScrollTop($(href).offset().top, 2000);
        else if(href.substr(1,href.length))
            $('html, body').animate({
                scrollTop: ($(href).offset().top)
            },2000);
    }).on("click", ".carousel-item", function () {
        var parent = $(this).parents(".carousel");
        if(!parent.data("multiple"))
            parent.find(".carousel-item").not($(this)).removeClass("active");
        $(this).toggleClass("active");
    }).on("show.bs.modal", "#suggest-way-modal", function () {
        $(this).find(".tab-content > .tab-pane:not(:first-of-type)").removeClass("active in");
        $(this).find(".tab-content > .tab-pane:first-of-type").addClass("active in");
    }).on("show.bs.modal", "#login-modal", function () {
        $(this).find("form input[type=text], form input[type=tel], form input[type=password], form input[type=email], form textarea").val("");
        $(this).find("form .error").removeClass("error");
        $(this).find("form .errorMessage").hide();
        $(this).find(".tab-content > .tab-pane:not(:first-of-type)").removeClass("active in");
        $(this).find(".tab-content > .tab-pane:first-of-type").addClass("active in");
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

    $("body").on("keyup", ".brand-search-trigger", function () {
        var $table = $(this).parents('.panel').find('.car-list');
        var rex = new RegExp($(this).val(), 'i');
        $table.find('.brand-list').hide();
        $table.find('.brand-list').filter(function() {
            return rex.test($(this).find(".list-title").text());
        }).show();
        if ( $table.find('.brand-list:visible').length === 0 ) {
            $table.find('.not-found').show();
        } else {
            $table.find('.not-found').hide();
        }
    });
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