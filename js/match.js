$(document).ready(function() {

    $(".tooltip").easyTooltip();
    $('#rotate > ul').tabs({ fx: { opacity: 'toggle' } })
    $("#form_create_championship").validationEngine({scroll:true});
    $("a[rel*=facebox]").facebox();



});



