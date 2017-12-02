$(function () {
    setInterval(function () {
        $(".callout:not(.message)").fadeOut('fast', function () {
            $(this).remove();
        });
    },5000);

    $(".nicescroll").each(function () {
        var options = $(this).data();

        $.each(options, function (key, value) {
            if (typeof value == "string" && value.indexOf("js:") != -1)
                options[key] = JSON.parse(value.substr(3));
        });

        $(this).niceScroll(options);
    });
});


function submitAjaxForm(form ,url ,loading ,callback) {
    loading = typeof loading !== 'undefined' ? loading : null;
    callback = typeof callback !== 'undefined' ? callback : null;
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        dataType: "json",
        beforeSend: function () {
            if(loading)
                loading.show();
        },
        success: function (html) {
            if(loading)
                loading.hide();
            if (typeof html === "object" && typeof html.status === 'undefined') {
                $.each(html, function (key, value) {
                    form.find("#" + key + "_em_").show().html(value.toString()).parent().removeClass('success').addClass('error');
                });
            }else
                eval(callback);
        }
    });
}