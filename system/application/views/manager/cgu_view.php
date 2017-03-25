<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/manager.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />


<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.currency.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/game_page.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/swfobject.js"></script>
<title>Accueil DirtyFootball</title>
</head>

<body>
    <?php echo $this->load->view('includes/facebook_js_view');?>
<div id="conteneur">
    <?php echo $this->load->view('includes/header_view');?>
    <!--<div id="top_frame"></div>-->
    <div class="center_frame">
    <?php echo $this->load->view('includes/main_menu_view');?>
    <?php //echo $this->load->view('includes/my_info_view');?>
        <div id="content">
            <div id="rotate">
                <ul>
                    <li><a href="#cgu"><span>CGU</span></a></li>
                </ul>
            <div id="background_tabs">
            
            <div id="cgu">
                <div id="back_button"><a  href="javascript:history.go(-1)"><?=$this->lang->line("back")?></a></div>
                <?=$this->lang->line("cgu");?>

            </div>
            </div>
            </div>
        </div>
    </div>
<?php echo $this->load->view('includes/footer_view');?>
</div>
</body>
</html>
