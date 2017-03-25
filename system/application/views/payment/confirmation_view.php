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
<title>Confirmation achat</title>
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
                <li><a href="#achat"><span><?=$this->lang->line('title_succes');?></span></a></li>
            </ul>
            <div id="background_tabs">
                <div id="achat">

                    <div style="position:relative;margin-left:auto;margin-right:auto;overflow:auto;background-color: #d2ebfa;color:#626262;
                       font-weight:bold;
                       width: 500px;margin-top:15px;margin-bottom:15px;border:1px;border-color:#36a0a5;border-style:solid; ">
                        <div style="float:left;margin:10px;
                             background-image:url(<?=base_url() ?>/images/<?=$this->session->userdata("langage")?>/global/info.png);
                        width:32px;
                        height:32px;"></div>
                        <div style="float:left;
                        color:#626262;
                        font-size:12px;
                        width:400px;
                        margin-top:18px;
                        padding-bottom: 10px;
                        font-weight:bold;"><?=$this->lang->line('succes_message');?></div>
                    </div>
   

                </div>
           </div>
        </div>
       </div>
 </div>

<?php echo $this->load->view('includes/footer_view');?>
 </div>
</body>
</html>
