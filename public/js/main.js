$(document).ready(function()  {
    console.log('test')
    $(window).on("resize", function() {
        height = $(".test").css("width");
        $(".test").css("min-height", height)
    });
})