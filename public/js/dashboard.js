$(document).ready(function () {
    $("#close-sidebar").click(() => {
        $(".page-wrapper").removeClass("toggled");
    });
    $("#show-sidebar").click(() => {
        $(".page-wrapper").addClass("toggled");
    });

});
