$(document).ready(function() {

	$(".tooltip").easyTooltip();
        $('#rotate > ul').tabs({ fx: { opacity: 'toggle' } });
        $('#friends').liveFilter('ul');
        $('.btn_defier').click(function() {
            //$('#anchor').focus();
            
        });
        /*$('.fb_dialog').css({top:'300px'});*/
        
        $("a[rel*=facebox]").facebox();

        //$(".btn_skip").click(function(){

            //alert("test");
            /*var topPos=e.pageY - this.offsetTop;
            $('.popup').css({top:topPos+'px'});*/
            
        //});
        
});



