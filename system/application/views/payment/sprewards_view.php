<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/payment.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/tabs.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/game_page.js"></script>
<title>Composez votre équipe</title>
</head>

<body>
<div id="fb-root" style="width: 200px;"></div>
<script>
window.fbAsyncInit = function() {
 FB.init({
   appId  : '<?=APP_ID?>',
   status : true, // check login status
   cookie : false, // enable cookies to allow the server to access the session
   xfbml  : true  // parse XFBML
 });
 /*FB.Canvas.setSize({ width: 760, height: 900 });*/
 FB.Canvas.setAutoResize();

};

(function() {
var e = document.createElement('script');
e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
e.async = true;
document.getElementById('fb-root').appendChild(e);
}());
</script>
<div id="conteneur">
    <?php echo $this->load->view('includes/header_view');?>
    <div class="center_frame">
    <?php echo $this->load->view('includes/main_menu_view');?>
<div id="content">
         <div id="rotate">
            <ul>
                <li><a href="#sponsorpay"><span>SuperRewards</span></a></li>
            </ul>
            <div id="background_tabs">

                <div id="sponsorpay">
                   <iframe src="http://www.superrewards-offers.com/super/offers?h=exmqipj.823233156137&uid=<?=$this->session->userdata('userId')?>" frameborder="0" width="100%" height="1424px" scrolling="no"></iframe>
                </div>
           </div>
        </div>
       </div>
 </div>

<?php echo $this->load->view('includes/footer_view');?>
 </div>
</body>
</html>
