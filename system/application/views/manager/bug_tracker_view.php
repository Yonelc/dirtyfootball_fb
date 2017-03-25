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
                    <li><a href="#bug"><span>Bug Tracker</span></a></li>
                </ul>
            <div id="background_tabs">
            
            <div id="bug">
                <div id="bug_tracker">
                    <?php
                    if(isset($messageInfos))
                        $this->load->view('includes/infos_view',$messageInfos);
                    ?>
                    <?php $attributes = array('id' => 'form_bug_tracker','name' => 'form_bug_tracker'); ?>
                    <?php echo form_open("game/bug_tracker",$attributes);?>

                    <div id="bug_consigne"><?=$this->lang->line('bug_explain')?></div>
                    <div id="bug_text"><textarea name="bug" cols="50" rows="8"></textarea></div>
                    <br/>
                    <div id="bug_control"><label><?php $nb1=rand(0,10);$nb2=rand(0,10); echo $nb1." + ".$nb2." = "; ?></label><input type="text"  name="nbControle" id="nbControle" value="" class="validate[required]" /></div>

                    <input type="hidden" name="userId" value="<?=$this->session->userdata("userId")?>" />
                    <input type="hidden" name="nb1" value="<?=$nb1?>" />
                    <input type="hidden" name="nb2" value="<?=$nb2?>" />
                    <input type="hidden" name="email" value="<?=$this->session->userdata("email")?>" />
                    <input type="hidden" name="username" value="<?=$this->session->userdata("username")?>" />
                    <input type="hidden" name="userfirstname" value="<?=$this->session->userdata("userfirstname")?>" />
                    <br/>
                    <input name="validation_bug" type="submit" class="btn_validation" value="<?=$this->lang->line('bug_validate')?>" />
                    </form>        
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
