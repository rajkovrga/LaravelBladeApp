jQuery(function ($) {

    if($(window).width() > 900)
    {
        let menu  = $('#menu')
        document.getElementById('menu').classList.add('toggled')
    }

    $("#close-sidebar").click(() => {
        $(".page-wrapper").removeClass("toggled");
    });
    $("#show-sidebar").click(() => {
        $(".page-wrapper").addClass("toggled");
    });

});
