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
                    <li><a href="#faq"><span>FAQ</span></a></li>
                </ul>
            <div id="background_tabs">
            
            <div id="faq">
                    <div id="back_button"><a  href="javascript:history.go(-1)"><?=$this->lang->line("back")?></a></div>

                    <div><?=$this->lang->line('faq_manager')?></div>
                    <div><?=$this->lang->line('faq_q1')?></div>
                    <div><?=$this->lang->line('faq_q2')?></div>
                    <div><?=$this->lang->line('faq_q3')?></div>
                    <div><?=$this->lang->line('faq_q4')?></div>

                    <div><?=$this->lang->line('faq_team')?></div>
                    <div><?=$this->lang->line('faq_q5')?></div>
                    <div><?=$this->lang->line('faq_q6')?></div>
                    <div><?=$this->lang->line('faq_q7')?></div>
                    <div><?=$this->lang->line('faq_q8')?></div>
                    <div><?=$this->lang->line('faq_q9')?></div>
                    <div><?=$this->lang->line('faq_q10')?></div>
                    <div><?=$this->lang->line('faq_q11')?></div>
                    <div><?=$this->lang->line('faq_q12')?></div>

                    <div><?=$this->lang->line('faq_match')?></div>
                    <div><?=$this->lang->line('faq_q13')?></div>
                    <div><?=$this->lang->line('faq_q14')?></div>
                    <div><?=$this->lang->line('faq_q15')?></div>

                    <div><?=$this->lang->line('faq_transfert')?></div>
                    <div><?=$this->lang->line('faq_q16')?></div>
                    <div><?=$this->lang->line('faq_q17')?></div>

                    <div><?=$this->lang->line('faq_corruption')?></div>
                    <div><?=$this->lang->line('faq_q18')?></div>
                    <div><?=$this->lang->line('faq_q19')?></div>
                    <div><?=$this->lang->line('faq_q20')?></div>

                    <div><?=$this->lang->line('faq_construction')?></div>
                    <div><?=$this->lang->line('faq_q21')?></div>
                    <div><?=$this->lang->line('faq_q22')?></div>

                    <div><?=$this->lang->line('faq_amis')?></div>
                    <div><?=$this->lang->line('faq_q23')?></div>

                    <div><?=$this->lang->line('faq_payment')?></div>
                    <div><?=$this->lang->line('faq_q24')?></div>
                    <div><?=$this->lang->line('faq_q25')?></div>

            </div>
            </div>
            </div>
        </div>
    </div>
<?php echo $this->load->view('includes/footer_view');?>
</div>
</body>
</html>
