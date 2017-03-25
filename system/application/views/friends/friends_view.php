<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/jquery.alerts.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.currency.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.alerts.js"></script>
<title>Friends</title>
</head>

<body>

<div id="conteneur">
    <?php echo $this->load->view('includes/applifier_view');?>
    <?php echo $this->load->view('includes/header_view');?>
    <div class="center_frame">
    <?php echo $this->load->view('includes/main_menu_view');?>
        <div id="content">
            <div style="width:620px;margin-left:auto;margin-right:auto;">
                    <?php echo $this->load->view('includes/facebook_js_view');?>
                    
                    <fb:serverFbml width="700px" >
                       <script type="text/fbml">
                         <fb:fbml>
                         <fb:request-form action="<?=APP_URL_SERVER?>index.php/friends/invite" method="POST"  invite="true" type=" " fb_protected="true" content="<?=$this->lang->line("content_invite");?>
                             <fb:req-choice url='<?=APP_URL_CANVAS?>' label='Accept' />" >
                             <fb:multi-friend-selector showborder="true" cols="4"  actiontext="Invite your friends to use DirtyFootball Manager.">
                           </fb:request-form>
                         </fb:fbml>
                       </script>
                  </fb:serverFbml>

            </div>
        </div>
    </div>
    <?php echo $this->load->view('includes/footer_view');?>
</div>
</body>
</html>

