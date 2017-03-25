<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/corruption.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/template.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/validationEngine.jquery.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script src="<?php echo base_url() ?>js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/jquery.validationEngine.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/corruption.js"></script>
<script type="text/javascript">
  // Load/Call Reverse Ajax
  xajax.callback.global.onRequest = function() { $(".ajax_loading").css("display","block");}
  xajax.callback.global.beforeResponseProcessing = function() {$(".ajax_loading").css("display","none");}
</script>

<title>Corruptions</title>
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
                <li><a href="#offensive"><span><?=$this->lang->line("submenu_offensif")?></span></a></li>
                <li><a href="#defensive"><span><?=$this->lang->line("submenu_defensif")?></span></a></li>
                <li><a href="#use_bonus"><span><?=$this->lang->line("submenu_use_bonus")?></span></a></li>
                <li><a href="#matchs"><span><?=$this->lang->line("submenu_buy")?></span></a></li>
            </ul>
            <div id="background_tabs">
            <div id="offensive">
                <div id="offensive_frame">
                    
                    <div id="offensive_infos"></div>
                    <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                    <?php
                    foreach($offensiveMethods as $row){
                        $type=corruption_rules::getCurrencyType($row["type"]);
                        ?>

                    <form name="form_offensive_<?=$row["corruption_offensive_id"]?>" id="form_offensive_<?=$row["corruption_offensive_id"]?>" method="post">
                        <div class="product_<?=$type ?>">
                            <div class="title"><?=$this->lang->line($row["title"]);?><?//=$row["title"]?></div>
                            <img class="stade_img tooltip" title="<?=$this->lang->line($row["description"]);?>"  src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/corruption/offensive_methods/<?=$row["image"] ?>" alt="offensive methods" />
                            <div class="price"><?=$row["value"]; ?></div>
                            <div class="capacity"><?=$this->lang->line($row["sector"]);?> +<?=$row["capacity"]; ?></div>
                            <div class="level"><label><?=$this->lang->line('bonus_labs_level');?> </label><?=$row["lab_level"]; ?></div>
                            <input type="hidden" name="offensiveMethodId" value="<?=$row["corruption_offensive_id"]?>" />
                            <?php
                            $state=corruption_rules::getAction($my_infos[0][$type],$row["value"],$ownLaboratoryLevel,$row["lab_level"],$ownFriendsLevel,$row["friends_level"]);

                            switch($state){

                                    case corruption_rules::BUY_BUTTON:
                                         ?><input type="button" class="buy_button input_invisible" name="buy_offensive_method" value="" onclick="xajax_buy_offensive_method_process(xajax.getFormValues('form_offensive_<?=$row["corruption_offensive_id"]?>'))"/><?php
                                    break;

                                    case corruption_rules::GET_DIRTYGOLD_BUTTON:
                                        ?><input type="button" class="get_dirty_gold input_invisible" name="get_dirty_gold" value="" onclick="self.location.href='<?=base_url()?>index.php/payment/index'"/><?php
                                    break;
                                    case corruption_rules::FRIENDS_BUTTON:
                                        ?><input type="button" class="friends_button input_invisible" name="friends" value="" onclick="self.location.href='<?php echo base_url() ?>index.php/friends'" /><?php
                                    break;
                                    default:
                                        ?><input type="button" class="locked input_invisible" name="locked" value="" /><?php
                                    break;
                                }
                            ?>

                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
            <div id="defensive">
                <div id="defensive_frame">
                    
                    <div id="defensive_infos"></div>
                    <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                    <?php foreach($defensiveMethods as $row){
                        $type=corruption_rules::getCurrencyType($row["type"]);
                        ?>

                    <form name="form_defensive_<?=$row["corruption_defensive_id"]?>" id="form_defensive_<?=$row["corruption_defensive_id"]?>" method="post">
                        <div class="product_<?=$type ?>">
                            <div class="title"><?=$this->lang->line($row["title"]);?><?//=$row["title"]?></div>
                            <img class="stade_img tooltip" title="<?=$this->lang->line($row["description"]);?>" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/corruption/defensive_methods/<?=$row["image"] ?>" alt="defensive methods" />
                            <div class="price"><?=$row["value"]; ?></div>
                            <div class="capacity"><?=$this->lang->line($row["sector"]);?> +<?=$row["capacity"]; ?></div>
                            <div class="level"><label><?=$this->lang->line('bonus_labs_level');?>  </label><?=$row["lab_level"]; ?></div>
                            <input type="hidden" name="defensiveMethodId" value="<?=$row["corruption_defensive_id"]?>" />
                            <?php

                            $state=corruption_rules::getAction($my_infos[0][$type],$row["value"],$ownLaboratoryLevel,$row["lab_level"],$ownFriendsLevel,$row["friends_level"]);

                            switch($state){

                                    case corruption_rules::BUY_BUTTON:
                                         ?><input type="button" class="buy_button input_invisible" name="buy_defensive_method" value="" onclick="xajax_buy_defensive_method_process(xajax.getFormValues('form_defensive_<?=$row["corruption_defensive_id"]?>'))"/><?php
                                    break;

                                    case corruption_rules::GET_DIRTYGOLD_BUTTON:
                                        ?><input type="button" class="get_dirty_gold input_invisible" name="get_dirty_gold" value="" onclick="self.location.href='<?=base_url()?>index.php/payment/index'"/><?php
                                    break;
                                    case corruption_rules::FRIENDS_BUTTON:
                                        ?><input type="button" class="friends_button input_invisible" name="friends" value="" onclick="self.location.href='<?php echo base_url() ?>index.php/friends'" /><?php
                                    break;
                                    default:
                                        ?><input type="button" class="locked input_invisible" name="locked" value="" /><?php
                                    break;
                                }
                            ?>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>

                
             <div id="use_bonus">
             <?php if(!$holiday){ ?>
                 <?php //if(isset($nextMatch)&& !empty($nextMatch)){ ?>
                   <!--<div id="next_match_bonus">


                            <div class="next_match_bonus_opponent">
                                <ul>
                                <li><div id="home_team"><?php //if(isset($nextMatch)&& !empty($nextMatch)){ echo substr($nextMatch[0]["home_team_name"],0,12);}?></div></li>
                                <li><div id="away_team"><?php //if(isset($nextMatch)&& !empty($nextMatch)){ echo substr($nextMatch[0]["away_team_name"],0,12);}?></div></li>
                                </ul>
                            </div>

                    </div>-->
                    <div id="own_bonus_used_list">
                        <div id="bonus_top"></div>
                        <div id="bonus_center">
                        <div id="used_offensive_methods">
                            <?php

                            foreach($usedOffensiveMethods as $row)
                            { ?>
                            <form name="form_used_offensive_methods_<?=$row["used_id"]?>" id="form_used_offensive_methods_<?=$row["used_id"]?>" method="post">
                                <div class="product">
                                    <div class="title_product"><?=$this->lang->line($row["title"]);?><?//=$row["title"]?></div>
                                    <input type="hidden" name="methodType" value="<?=$row["method_type"]?>" />
                                    <input type="hidden" name="usedId" value="<?=$row["used_id"]?>" />
                                    <input type="hidden" name="methodId" value="<?=$row["corruption_id"]?>" />
                                    <input type="button" class="delete_bonus input_invisible" name="used_offensive_methods" value="" onclick="xajax_delete_used_method_process(xajax.getFormValues('form_used_offensive_methods_<?=$row["used_id"]?>'))"/>
                                </div>
                            </form>
                      <?php
                      }
                            ?>
                        </div>
                        <div id="used_defensive_methods">
                            <?php
                                foreach($usedDefensiveMethods as $row)
                                { ?>
                                <form name="form_used_defensive_methods_<?=$row["used_id"]?>" id="form_used_defensive_methods_<?=$row["used_id"]?>" method="post">
                                    <div class="product">
                                        <div class="title_product"><?=$this->lang->line($row["title"]);?><?//=$row["title"]?></div>
                                        <input type="hidden" name="methodType" value="<?=$row["method_type"]?>" />
                                        <input type="hidden" name="usedId" value="<?=$row["used_id"]?>" />
                                        <input type="hidden" name="methodId" value="<?=$row["corruption_id"]?>" />
                                        <input type="button" class="delete_bonus input_invisible" name="used_defensive_methods" value="" onclick="xajax_delete_used_method_process(xajax.getFormValues('form_used_defensive_methods_<?=$row["used_id"]?>'))"/>
                                    </div>
                                </form>
                          <?php }
                            ?>
                        </div>
                        </div>
                        <div id="bonus_bottom"></div>
                    </div>
                     <div id="bloc_droit">

                          <div id="experience">
                          <div id="experience_top">
                              <div id="help_potentiel" class="tooltip" title="<?=$this->lang->line("potentiel_help");?>"></div>
                          </div>

                              <div id="exp_team">
                                  <div id="potentiel_primaire">
                                      <h1><?=$this->lang->line("potentiel_title1");?></h1>
                                      <ul id="exp_primaire">
                                        <li><div class="gb_experience"><p><?php echo $potentielPrimaire[0]->experience_gb."<br/>"; ?></p></div></li>
                                        <li><div class="def_experience"><p><?php echo $potentielPrimaire[0]->experience_def."<br/>";?></p></div></li>
                                        <li><div class="mill_experience"><p><?php echo $potentielPrimaire[0]->experience_mil."<br/>";?></p></div></li>
                                        <li><div class="att_experience"><p><?php echo $potentielPrimaire[0]->experience_att."<br/>";?></p></div></li>
                                      </ul>
                                  </div>
                                  <div id="potentiel_secondaire">
                                      <h2><?=$this->lang->line("potentiel_title2");?></h2>
                                      <ul id="exp_secondaire">
                                        <li><div class="gb_experience"><p><?php echo $potentielSecondaire[0]->secondary_experience_gb."<br/>";?></p></div></li>
                                        <li><div class="def_experience"><p><?php echo $potentielSecondaire[0]->secondary_experience_def."<br/>";?></p></div></li>
                                        <li><div class="mill_experience"><p><?php echo $potentielSecondaire[0]->secondary_experience_mil."<br/>";?></p></div></li>
                                        <li><div class="att_experience"><p><?php echo $potentielSecondaire[0]->secondary_experience_att."<br/>";?></p></div></li>
                                      </ul>
                                  </div>
                                </div>
                                <div id="experience_bottom"></div>
                         </div>

                    
                     <div id="own_bonus_list">
                         <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                            <div id="own_offensive">
                                <?php
                                foreach($ownOffensiveMethods as $row)
                                {   if($row["qt"]!=0){
                                    ?>
                                <form name="form_own_offensive_<?=$row["offensive_method_id"]?>" id="form_own_offensive_<?=$row["offensive_method_id"]?>" method="post">
                                    <div class="product_use">
                                        <div class="title_use"><?=$this->lang->line($row["title"]);?><?//=$row["title"]?></div>
                                        <img class="stade_img_use tooltip" title="<?=$this->lang->line($row["description"]);?>" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/corruption/offensive_methods/<?=$row["image"] ?>" alt="offensive methods" />
                                        <div class="capacity_use"><?=$this->lang->line($row["sector"]);?> +<?=$row["capacity"]; ?></div>
                                        <div class="quantity_use"><label><?=$this->lang->line("bonus_qt");?></label><?=$row["qt"]?></div>
                                        <input type="hidden" name="methodType" value="<?=corruption_rules::OFFENSIVE_METHOD?>" />
                                        <input type="hidden" name="matchId" value="1<?//=$nextMatch[0]["match_id"]?>" />
                                        <input type="hidden" name="methodId" value="<?=$row["offensive_method_id"]?>" />
                                        <input type="button" class="use_button input_invisible" name="own_offensive_methods" value="" onclick="xajax_add_used_method_process(xajax.getFormValues('form_own_offensive_<?=$row["offensive_method_id"]?>'))"/>
                                    </div>
                                </form>
                           <?php }
                                }
                                ?>
                            </div>
                            <div id="own_defensive">
                                <?php
                                foreach($ownDefensiveMethods as $row)
                                {
                                    if($row["qt"]!=0){
                                    ?>

                                <form name="form_own_defensive_<?=$row["defensive_method_id"]?>" id="form_own_defensive_<?=$row["defensive_method_id"]?>" method="post">
                                    <div class="product_use">
                                        <div class="title_use"><?=$this->lang->line($row["title"]);?><?//=$row["title"]?></div>
                                        <img class="stade_img_use tooltip" title="<?=$this->lang->line($row["description"]);?>" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/corruption/defensive_methods/<?=$row["image"] ?>" alt="defensive methods" />
                                        <div class="capacity_use"><?=$this->lang->line($row["sector"]);?> +<?=$row["capacity"]; ?></div>
                                        <div class="quantity_use"><label><?=$this->lang->line("bonus_qt");?> </label><?=$row["qt"]?></div>
                                        <input type="hidden" name="methodType" value="<?=corruption_rules::DEFENSIVE_METHOD?>" />
                                        <input type="hidden" name="matchId" value="1<?//=$nextMatch[0]["match_id"]?>" />
                                        <input type="hidden" name="methodId" value="<?=$row["defensive_method_id"]?>" />
                                        <input type="button" class="use_button input_invisible" name="own_defensive_methods" value="" onclick="xajax_add_used_method_process(xajax.getFormValues('form_own_defensive_<?=$row["defensive_method_id"]?>'))"/>
                                    </div>
                                </form>
                          <?php     }
                                }
                                ?>
                            </div>
                        </div>
                <?php /*}else{

                    $data["messageInfos"]=$this->lang->line("bonus_disabled");
                    $this->load->view('includes/infos_view',$data);
                }
            } */   ?><?php }else{
                $data["messageInfos"]=$this->lang->line("bonus_disabled_vac");
                    $this->load->view('includes/infos_view',$data);
            }?>
                 </div>
            </div>



            <div id="matchs">
                <div id="match_frame">
             <?php if(isset($nextMatch)&& !empty($nextMatch)){ ?>



                 <?php if(!isset($corruptedMatch)&& empty($corruptedMatch)){ ?>
<div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                    <div id="buy_match">
                        <div class="next_match">
                            <div class="match_opponent">
                                <ul>
                                <li><?=substr($nextMatch[0]["home_team_name"],0,12)?></li>
                                <li><?=substr($nextMatch[0]["away_team_name"],0,12)?></li>
                                </ul>
                            </div>
                            <div class="proposition">
                                <form name="form_buy_match" id="form_buy_match" method="post">
                                    <input type="button" class="buy_match_button input_invisible" name="buy_match" value="" onclick="xajax_buy_match_process(xajax.getFormValues('form_buy_match'))"/>
                                    <input type="text" name="offer" id="offer" value="100000" class="validate[required,custom[onlyNumber],length[0,100]]"/> <img src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/wollars.png" alt="Wollars"/><br/>
                                    <input type="hidden" name="matchId" value="<?=$nextMatch[0]["match_id"]?>" />
                                    <input type="hidden" name="receiver" value="<?=corruption_rules::getOpponentId($this->session->userdata('teamId'), $nextMatch[0]["home_team_id"], $nextMatch[0]["away_team_id"])?>" />
                                </form>
                                <div id="submit_feedback"></div>
                            </div>
                            <div id="bottom_proposition"></div>
                        </div>
              <?php }else{ ?>
                <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                 <div class="next_match">

                        <div class="match_opponent">
                            <ul>
                            <li><?=substr($nextMatch[0]["home_team_name"],0,12)?></li>
                            <li><?=substr($nextMatch[0]["away_team_name"],0,12)?></li>
                            </ul>
                        </div>

                        <div class="proposition">
                            <div id="comment_offer"><?=$this->lang->line("corruption_proposed")?><strong><?=$corruptedMatch[0]["value"]?></strong> <img src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/wollars.png" alt="Wollars"/></div>
                            <div id="accept">
                                <form name="form_accepted" id="form_accepted" method="post">
                                    <input type="button" class="corruption_accepted_button input_invisible" name="corruption_accepted" value="" onclick="xajax_corruption_accepted_process(xajax.getFormValues('form_accepted'))"/>
                                </form>
                            </div>
                            <div id="refuse">
                                <form name="form_refused" id="form_refused" method="post">
                                    <input type="button" class="corruption_refused_button input_invisible" name="corruption_refused" value="" onclick="xajax_corruption_refused_process(xajax.getFormValues('form_refused'))"/>
                                </form>
                            </div>
                        </div>
                        <div id="bottom_proposition"></div>
                  </div>
                  <?php }
             }else{
                  
               $data["messageInfos"]=$this->lang->line("corruption_disabled");
                $this->load->view('includes/infos_view',$data);}
                ?>
                </div>
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

