<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/payment.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/game_page.js"></script>
<title>Composez votre équipe</title>
</head>

<body>
    <?php echo $this->load->view('includes/facebook_js_view');?>
<div id="conteneur">
    <?php echo $this->load->view('includes/header_view');?>
    <div class="center_frame">
    <?php echo $this->load->view('includes/main_menu_view');?>
<div id="content">
         <div id="rotate">
            <ul>
                <li><a href="#sponsorpay"><span><?=$this->lang->line('title_sponsorpay');?></span></a></li>
            </ul>
            <div id="background_tabs">

                <div id="sponsorpay">
                    <iframe width="100%" height="1424px" frameborder="0" scrolling="no"  src="http://iframe.sponsorpay.com/?appid=713&uid=<?=$this->session->userdata('userId')?>"></iframe>
                </div>
           </div>
        </div>
       </div>
 </div>

<?php echo $this->load->view('includes/footer_view');?>
 </div>
</body>
</html>
