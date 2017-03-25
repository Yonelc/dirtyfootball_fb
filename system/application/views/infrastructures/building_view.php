<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/building.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/jquery.alerts.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.currency.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.alerts.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/building.js"></script>
<script type="text/javascript">
  // Load/Call Reverse Ajax
  xajax.callback.global.onRequest = function() { $(".ajax_loading").css("display","block");}
  xajax.callback.global.beforeResponseProcessing = function() {$(".ajax_loading").css("display","none");}
</script>
<title>Infrastructures</title>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19350813-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body>
    <?php echo $this->load->view('includes/facebook_js_view');?>
<div id="conteneur">
    <?php echo $this->load->view('includes/applifier_view');?>
    <?php echo $this->load->view('includes/header_view');?>
    <div class="center_frame">
    <?php echo $this->load->view('includes/main_menu_view');?>
        <div id="content">
        <div id="rotate">
            <ul>
                <li><a href="#stade"><span><?=$this->lang->line("submenu_stade");?></span></a></li>
                <!--<li><a href="#formation"><span><?//=$this->lang->line("submenu_formation");?></span></a></li>
                <li><a href="#merchandising"><span><?//=$this->lang->line("bonus_qt");?>Merchandising</span></a></li>-->
                <li><a href="#labs"><span><?=$this->lang->line("submenu_labs");?></span></a></li>
                
            </ul>
            <div id="background_tabs">
            <div id="stade">

                <div id="stadium_frame">

                    <div id="stadium_infos"></div>
                    <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                <?php foreach($stadiums as $row){
                        $type=infrastructures_rules::getCurrencyType($row["type"]);
                    ?>
                    <form name="form_stadium_<?=$row["stadium_id"]?>" id="form_stadium_<?=$row["stadium_id"]?>" method="post">
                        <div class="product_<?=$type ?>">
                            <div class="title"><?=$this->lang->line($row["title"]);?><?php //echo $row["title"] ?></div>
                            <img class="stade_img tooltip" title="<?=$this->lang->line($row["description"]);?>"  src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/building/stadiums/<?=$row["image"]?>" alt="stade" />
                            <div class="price"><?php echo $row["value"];  ?></div>
                            <div class="capacity"><?php echo $row["capacity"] ?><label> <?=$this->lang->line('stade_place');?></label></div>
                            <div class="level"><label><?=$this->lang->line('stade_niveau');?> </label><?php echo $row["level"] ?></div>
                            <div id="stadium_<?=$row["stadium_id"]?>"></div>
                            <input type="hidden" name="stadiumId" value="<?=$row["stadium_id"]?>" />
                            <?php
                            //echo "mon ".$my_infos[0][$type]." prix ".$row["value"]." mon nv ".$my_infos[0]["level"]." le nv".$row["level"];

                            $state=infrastructures_rules::getAction($my_infos[0][$type], $row["value"], $row["stadium_id"], $myStadium[0]["stadium_id"],$my_infos[0]["level"],$row["level"]);

                            switch($state){

                                    case infrastructures_rules::BUY_BUTTON:
                                         ?><input type="button" class="buy_button input_invisible" name="buy_stadium" value="" onclick="xajax_buy_stadium_process(xajax.getFormValues('form_stadium_<?=$row["stadium_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::SELL_BUTTON:
                                         ?><input type="button" class="sell_button input_invisible" name="sell_stadium" value="" onclick="xajax_sell_stadium_process(xajax.getFormValues('form_stadium_<?=$row["stadium_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::GET_DIRTYGOLD_BUTTON:
                                        ?><input type="button" class="get_dirty_gold input_invisible" name="get_dirty_gold" value="" onclick="self.location.href='<?=base_url()?>index.php/payment/index'"/><?php
                                    break;

                                    case infrastructures_rules::LOCKED_BUTTON:
                                        ?><input type="button" class="locked input_invisible" name="locked" value="" /><?php
                                    break;

                                    default:

                                    break;
                                }
                            ?>

                        </div>
                    </form>
            <?php } ?>
                </div>
            </div>
            <!--<div id="formation">
                <div id="formation_frame">
                <?php  foreach($formation_centers as $row){
                        $type=infrastructures_rules::getCurrencyType($row["type"]);
                    ?>

                
                <form name="form_formation_<?=$row["formation_center_id"]?>" id="form_formation_<?=$row["formation_center_id"]?>" method="post">
                        <div class="product_<?=$type ?>">
                            <div class="title"><p><?php echo $row["title"] ?></p></div>
                            <img class="stade_img" src="<?php echo base_url() ?>images/fr/building/formation_centers/<?=$row["image"] ?>" alt="formation center" />
                            <div class="price"><?php echo $row["value"]; ?></div>
                            <div class="capacity"><?php echo $row["capacity"] ?><label></label></div>
                            <div class="level"><?php echo $row["level"] ?></div>
                            
                            <div id="formation_center_<?=$row["formation_center_id"]?>"></div>
                            <input type="hidden" name="formationCenterId" value="<?=$row["formation_center_id"]?>" />
                     <?php 
                            $state=infrastructures_rules::getAction($my_infos[0][$type], $row["value"], $row["formation_center_id"], $myFormationCenter,$my_infos[0]["level"],$row["level"]);
                            
                            switch($state){

                                    case infrastructures_rules::BUY_BUTTON:
                                         ?><input type="button" class="buy_button input_invisible" name="buy_formation_center" value="" onclick="xajax_buy_formation_center_process(xajax.getFormValues('form_formation_<?=$row["formation_center_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::SELL_BUTTON:
                                         ?><input type="button" class="sell_button input_invisible" name="sell_formation_center" value="" onclick="xajax_sell_formation_center_process(xajax.getFormValues('form_formation_<?=$row["formation_center_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::GET_DIRTYGOLD_BUTTON:
                                        ?><input type="button" class="get_dirty_gold input_invisible" name="get_dirty_gold" value="" /><?php
                                    break;

                                    case infrastructures_rules::LOCKED_BUTTON:
                                        ?><input type="button" class="locked input_invisible" name="locked" value="" /><?php
                                    break;

                                    default:

                                    break;
                                }
                            ?>

                        </div>
                </form>
                <?php } ?>
                </div>
            </div>

            <div id="merchandising">
                <div id="merchandising_frame">
                <?php /*foreach($merchandisings as $row){
                    $type=infrastructures_rules::getCurrencyType($row["type"]);*/
                    ?>

                <form name="form_merchandising_<?//=$row["merchandising_id"]?>" id="form_merchandising_<?//=$row["merchandising_id"]?>" method="post">
                        <div class="product_<?//=$type ?>">
                            <div class="title"><?php// echo $row["title"] ?></div>
                            <img class="stade_img" src="<?php// echo base_url() ?>images/building/merchandisings/<?//=$row["image"] ?>" alt="stade" />
                            <div class="price"><?php// echo $row["value"]; ?></div>
                            <div class="capacity"><?php //echo $row["capacity"] ?></div>
                            <div class="level"><?php //echo $row["level"] ?></div>
                            
                            <div id="merchandising_<?//=$row["merchandising_id"]?>"></div>
                            <input type="hidden" name="merchandisingId" value="<?//=$row["merchandising_id"]?>" />
                     
                      <?php /*
                            $state=infrastructures_rules::getAction($my_infos[0][$type], $row["value"], $row["merchandising_id"], $myMerchandising,$my_infos[0]["level"],$row["level"]);
                            
                            switch($state){

                                    case infrastructures_rules::BUY_BUTTON:
                                         ?><input type="button" class="buy_button input_invisible" name="buy_merchandising" value="" onclick="xajax_buy_merchandising_process(xajax.getFormValues('form_merchandising_<?=$row["merchandising_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::SELL_BUTTON:
                                         ?><input type="button" class="sell_button input_invisible" name="sell_merchandising" value="" onclick="xajax_sell_merchandising_process(xajax.getFormValues('form_merchandising_<?=$row["merchandising_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::GET_DIRTYGOLD_BUTTON:
                                        ?><input type="button" class="get_dirty_gold input_invisible" name="get_dirty_gold" value="" /><?php
                                    break;

                                    case infrastructures_rules::LOCKED_BUTTON:
                                        ?><input type="button" class="locked input_invisible" name="locked" value="" /><?php
                                    break;

                                    default:

                                    break;
                                }*/
                            ?>
                        </div>
                </form>
                <?php //} ?>
                </div>
            </div>-->
            <div id="labs">

                <div id="labs_frame">
                <div id="labs_infos"></div>
                <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                <?php foreach($laboratories as $row){
                    $type=infrastructures_rules::getCurrencyType($row["type"]);
                    ?>
                    <form name="form_laboratory_<?=$row["laboratory_id"]?>" id="form_laboratory_<?=$row["laboratory_id"]?>" method="post">
                            <div class="product_<?=$type ?>">
                                <div class="title"><?=$this->lang->line($row["title"]);?><?php //echo $row["title"] ?></div>
                                <img class="stade_img tooltip" title="<?=$this->lang->line($row["description"]);?>" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/building/laboratories/<?=$row["image"] ?>" alt="stade" />
                                <div class="price"><?php echo $row["value"]; ?></div>
                                <div class="capacity"><?=$this->lang->line('debloque_labs');?> <?php echo $row["level"] ?></div>
                                <div class="level"><?=$this->lang->line('stade_niveau');?> <?php echo $row["level"] ?></div>
                                <div id="laboratory_<?=$row["laboratory_id"]?>"></div>
                                <input type="hidden" name="laboratoryId" value="<?=$row["laboratory_id"]?>" />
                       <?php
                            $state=infrastructures_rules::getAction($my_infos[0][$type], $row["value"], $row["laboratory_id"], $myLaboratory,$my_infos[0]["level"],$row["level"]);
                            
                            switch($state){

                                    case infrastructures_rules::BUY_BUTTON:
                                         ?><input type="button" class="buy_button input_invisible" name="buy_laboratory" value="" onclick="xajax_buy_laboratory_process(xajax.getFormValues('form_laboratory_<?=$row["laboratory_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::SELL_BUTTON:
                                         ?><input type="button" class="sell_button input_invisible" name="sell_laboratory" value="" onclick="xajax_sell_laboratory_process(xajax.getFormValues('form_laboratory_<?=$row["laboratory_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::GET_DIRTYGOLD_BUTTON:
                                        ?><input type="button" class="get_dirty_gold input_invisible" name="get_dirty_gold" value="" onclick="self.location.href='<?=base_url()?>index.php/payment/index'"/><?php
                                    break;

                                    case infrastructures_rules::LOCKED_BUTTON:
                                        ?><input type="button" class="locked input_invisible" name="locked" value="" /><?php
                                    break;

                                    default:

                                    break;
                                }
                        ?>
                            </div>
                    </form>
                <?php } ?>
                </div>
            </div>
            </div>
        </div>

    </div>
    </div>
    <div id="bottom_frame"></div>
        <?php echo $this->load->view('includes/footer_view');?>
</div>
</body>
</html>

