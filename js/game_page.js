$(document).ready(function() {

    $(".tooltip").easyTooltip();
    $('#rotate > ul').tabs({ fx: { opacity: 'toggle' } });
    $("a[rel*=facebox]").facebox();
    $("ul#ticker").liScroll();

});