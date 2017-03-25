$(document).ready(function() {

	$(".tooltip").easyTooltip();
        $('#rotate > ul').tabs({ fx: { opacity: 'toggle' } });
        $('.buy_button').click(function() {

              /*xajax.callback.global.onRequest = function() {xajax.$('loadingMessage').style.display = 'block';}
              xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loadingMessage').style.display='none';}
              xajax.callback.global.onFailure = function(args){
                    jAlert('La transaction est un échec', 'Alert Box');
              }
              xajax.callback.global.onSuccess = function(args){
                    jAlert('La transaction est un succes', 'Alert Box');
              }*/

        });


});



