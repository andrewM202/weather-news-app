$(document).ready(function() {
    $(window).on("resize", function() {
        height = $(".test").css("width");
        $(".test").css("min-height", height)
    });
})