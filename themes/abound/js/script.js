$(function () {
    $.ajaxSetup({
        data: {
            'YII_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    setInterval(function () {
        $(".callout:not(.message)").fadeOut('fast', function () {
            $(this).remove();
        });
    },5000);
});