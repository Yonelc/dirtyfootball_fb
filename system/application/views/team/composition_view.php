<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/composition.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/game_page.js"></script>
<script type="text/javascript">
  // Load/Call Reverse Ajax
  xajax.callback.global.onRequest = function() { $(".ajax_loading").css("display","block");}
  xajax.callback.global.beforeResponseProcessing = function() {$(".ajax_loading").css("display","none");}
</script>
<title>Composez votre équipe</title>
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
                <li><a href="#effectif"><span><?=$this->lang->line('submenu_effectif')?></span></a></li>
                <li><a href="#tactic"><span><?=$this->lang->line('submenu_tactic')?></span></a></li>
                <li><a href="#training"><span><?=$this->lang->line('submenu_training')?></span></a></li>
                <li><a href="#sponsor"><span><?=$this->lang->line('submenu_sponsor')?></span></a></li>
                <li><a href="#naturalisation"><span><?=$this->lang->line('submenu_naturalisation')?></span></a></li>
            </ul>
            <div id="background_tabs">
                <div id="effectif">
                    <!--<div id="effectif_top"></div>-->
                    <div id="effectif_center">
                     <?php $this->load->view("includes/infos_view",$this->lang->line('effectif_info_transfert')) ?>
                     <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                     <table >
                         
                       <th></th>
                       <th><?=$this->lang->line('effectif_joueur')?></th>
                       <th><?=$this->lang->line('effectif_nat')?></th>
                       <th><?=$this->lang->line('effectif_age')?></th>
                       <th><?=$this->lang->line('effectif_att')?></th>
                       <th><?=$this->lang->line('effectif_mil')?></th>
                       <th><?=$this->lang->line('effectif_def')?></th>
                       <th><?=$this->lang->line('effectif_gb')?></th>
                       <th><?=$this->lang->line('effectif_type')?></th>
                       <th><?=$this->lang->line('effectif_transfert')?></th>
                        <?php 
                        $flag=true;
                        foreach($players as $player){
                            ?>

                        <tr <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                            <td><?php echo players_rules::getInjuryFlag($player->injury) ?></td>
                            <td><?php echo anchor("transferts/player_profil/".$player->player_id,$player->player_name) ?></td>
                            <td><img src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/flags/<?php echo $player->nationality ?>.png" /></td>
                            <td><?php echo $player->age ?></td>
                            <td ><div class="att"><?php echo $player->experience_att ?></div></td>
                            <td ><div class="mil"><?php echo $player->experience_mil ?></div></td>
                            <td ><div class="def"><?php echo $player->experience_def ?></div></td>
                            <td ><div class="gb"><?php echo $player->experience_gb ?></div></td>
                            <td><?=$this->lang->line($player->position); ?></td>
                            <?php if($player->statut==0){ ?>
                            <td><a href="#effectif" onclick="xajax_changeTransfertStatut_process('<?php echo $player->player_id ?>','1')"><?=$this->lang->line('effectif_no')?></a></td>
                            <?php }else{ ?>
                            <td><a href="#effectif" onclick="xajax_changeTransfertStatut_process('<?php echo $player->player_id ?>','0')"><?=$this->lang->line('effectif_yes')?></a></td>
                            <?php } ?>
                        </tr>

                        <?php } ?>
                      <tr id="pagination">
                        <td colspan="12" align="center"></td>
                      </tr>
                      </table>
                      </div>
                    <!--<div id="effectif_bottom"></div>-->
                </div>
                <div id="tactic">
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
                        font-weight:bold;"><?=$this->lang->line('composition_infos'); ?></div>
                    </div>
                    <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                    <div id="experience">
                      <div id="experience_top">
                          <div id="help_potentiel" class="tooltip" title="<?=$this->lang->line('help_potentiel')?>"></div>
                      </div>
                      
                          <div id="exp_team">
                              <div id="potentiel_primaire">
                                  <h1><?=$this->lang->line('potentiel_title1')?></h1>
                                  <ul id="exp_primaire">
                                    <li><div class="gb_experience"><p><?php echo $teamExperiences["experience_gb"]."<br/>"; ?></p></div></li>
                                    <li><div class="def_experience"><p><?php echo $teamExperiences["experience_def"]."<br/>";?></p></div></li>
                                    <li><div class="mill_experience"><p><?php echo $teamExperiences["experience_mil"]."<br/>";?></p></div></li>
                                    <li><div class="att_experience"><p><?php echo $teamExperiences["experience_att"]."<br/>";?></p></div></li>
                                  </ul>
                              </div>
                              <div id="potentiel_secondaire">
                                  <h2><?=$this->lang->line('potentiel_title2')?></h2>
                                  <ul id="exp_secondaire">
                                    <li><div class="gb_experience"><p><?php echo $teamExperiences["secondary_experience_gb"]."<br/>";?></p></div></li>
                                    <li><div class="def_experience"><p><?php echo $teamExperiences["secondary_experience_def"]."<br/>";?></p></div></li>
                                    <li><div class="mill_experience"><p><?php echo $teamExperiences["secondary_experience_mil"]."<br/>";?></p></div></li>
                                    <li><div class="att_experience"><p><?php echo $teamExperiences["secondary_experience_att"]."<br/>";?></p></div></li>
                                  </ul>
                              </div>
                            </div>
                            <div id="experience_bottom"></div>
                     </div>
                            <!--<div id="team_validation">
                                <form name="form_team_validation" id="form_team_validation"  >
                                    <?php //if(!$ready && $team_ok){ ?>
                                    <input type="button" class="input_invisible" id="validation_button" value="<?=$this->lang->line('team_validation')?>" onclick="xajax_validation_team_process(xajax.getFormValues('form_team_validation'))" />
                                    <?php //}else{ ?>
                                    <input type="button" class="input_invisible" id="validation_button_off" value="<?=$this->lang->line('team_validation')?>" />
                                    <?php //} ?>
                                </form>
                           </div>-->
                       
                       
                  
                    <div id="composition">
                            <div id="composition_top"></div>
                            <div id="composition_center">
                                <div id="composition_frame">
                                    <div id="team_tactic">
                                            <form name="form_tactic" id="form_tactic"  >
                                                                              
                                                <select name="tacticId" <?php //if($ready){?>  <?php //} ?> <?php //if(!$ready){?> onchange="xajax_tactic_team_process(xajax.getFormValues('form_tactic'))" <?php //}?>id="tacticId">
                                            <?php 
                                                $formation='';
                                                foreach($tactics as $tactic){
                                                            foreach($tacticId as $id){?>
                                                                <option value="<?php echo $tactic->tactic_id ?>" <?php if($id->tactic_id==$tactic->tactic_id){echo "selected='selected'";$formation=$tactic->name;} ?> ><?php echo $tactic->name ?></option>
                                            <?php           }
                                                 } ?>
                                                </select>
                                            
                                            </form>
                                            <div id="football_field">
                                                                                   
                                                <div id="formation" style="background-image: url(<?php echo base_url()."images/fr/field/".$formation.".png" ?>);z-index:0;height:403px;width:272px;">
                                                    <div id="player_name" style="z-index:2;">
                                                         <?php echo $this->load->view('team/includes/tactics/tactic_css_'.$tacticInfos[0]["tactic_id"].'_view');?>
                                                        <?php echo $this->load->view('team/includes/tactics/tactic_name_'.$tacticInfos[0]["tactic_id"].'_view');?>
                                                    </div>
                                                </div>
                                                <!--<img style="z-index:0;" src="<?php //echo base_url()."images/field/".$formation.".png" ?>" alt=""/>-->
                                            </div>
                                     </div>
                                </div>
                            </div>
                            <div id="composition_bottom"></div>
                     </div>
                     <div id="team_sheet">

                            <div id="team_sheet_top">
                                <div id="help_team_sheet" class="tooltip" title="<?=$this->lang->line('help_compo')?>"></div>
                            </div>
                            
                            <div id="team_sheet_center">
                                <div id="team_frame">

                                    <?php  if($team_ok==FALSE){ ?>
                                            <form name="form_position" id="form_position"  >
                                                <center>
                                                    <select name="playerId" >
                                                    <?php foreach($players_free as $player){ ?>
                                                        <option value="<?php echo $player->player_id ?>"><?php echo $player->player_name ?> (<?=$this->lang->line($player->position); ?>)</option>
                                                    <?php } ?>
                                                    </select>
                                                </center><br/>
                                                <center>
                                                    <select name="shirt_number" >

                                                    <?php  for($i=1;$i<=11;$i++){
                                                               $flg='';
                                                               foreach($numbers_selected as $number){
                                                                   echo $number->shirt_number;
                                                                   if($number->shirt_number==$i){

                                                                       $flg=1;
                                                                    }
                                                               }
                                                               if($flg=='') {?>
                                                                <option value="<?php echo $i ?>"><?php echo "position ".$i ?></option>
                                                   <?php       }
                                                          } ?>
                                                    </select>
                                                 </center><br/>
                                                 <center>
                                                    <input type="button" class="input_invisible" id="select_ok" value="" onclick="xajax_position_team_process(xajax.getFormValues('form_position'))" />
                                                 </center>
                                            </form>
                                        <?php } ?>
                                        <center><div id="composition_message"><?php echo $team_completed;?></div></center>
                                        <?php
                                           $i=0;
                                           foreach($team_sheet as $player){


                                           $class=team_rules::getColorPosition($player->shirt_number, $tacticInfos[0]["att"], $tacticInfos[0]["mil"], $tacticInfos[0]["def"], $tacticInfos[0]["gb"]);

                                        ?>

                                            <form name="form_delete_<?php echo $i ?>" id="form_delete_<?php echo $i ?>"  >
                                                       <input type="hidden" id="hidden_<?php echo $i ?>" name="playerId" value="<?php echo $player->player_id ?>" />
                                                       
                                                        <div class="<?php echo $class ?>">
                                                            <?php //if(!$ready){?>
                                                            <input type="button"  value="" class="delete_player input_invisible"  onclick="xajax_delete_player_process(xajax.getFormValues('form_delete_<?php echo $i ?>'))" />
                                                            <?php //}else{ ?>
                                                            <!--<input type="button"  value="" class="delete_player_off input_invisible" />-->
                                                            <?php //} ?>
                                                            <div class="name_player"><?php echo $player->player_name ?></div>
                                                            <div class="position_player"><?=$this->lang->line($player->position); ?></div>
                                                            <div class="shirt_player"><?php echo $player->shirt_number ?></div>
                                                        </div>
                                            </form>

                                      <?php $i++; } ?>
                                   </div>
                               </div>
                            <div id="team_sheet_bottom"></div>
                      </div>

                </div>
                <div id="training">
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
                        font-weight:bold;"><?=$this->lang->line('training_infos'); ?></div>
                    </div>
                    <div id="progress_tube">
                        <div id="tubes">
                            <div class="tube">
                                <div class="title_tube"><?=$this->lang->line('GB'); ?></div>
                                <?=training_rules::getTube($trainingInfos[0]["gb"]);?>
                            </div>
                            <div class="tube">
                                <div class="title_tube"><?=$this->lang->line('DEF'); ?></div>
                                <?=training_rules::getTube($trainingInfos[0]["def"]);?>
                            </div>
                            <div class="tube">
                                <div class="title_tube"><?=$this->lang->line('MILL'); ?></div>
                                <?=training_rules::getTube($trainingInfos[0]["mil"]);?>
                            </div>
                            <div class="tube">
                                <div class="title_tube"><?=$this->lang->line('ATT'); ?></div>
                                <?=training_rules::getTube($trainingInfos[0]["att"]);?>
                            </div>
                        </div>
                    </div>
                    <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                    <div id="training_buttons">
                        <form name="form_train_gb" id="form_train_gb"  >
                            <?php if($trainingInfos[0]["gb_estate"]==0){ ?>
                            <input type="button"  value="" id="training_gb" class="input_invisible" onclick="xajax_train_team_process(xajax.getFormValues('form_train_gb'))"/>
                            <?php }else{?>
                            <input type="button"  value="" id="training_gb_off" class="input_invisible" />
                            <?php }?>
                            <input type="hidden" name="type" value="<?=training_rules::GB_TYPE?>" />
                        </form>
                        <form name="form_train_def" id="form_train_def"  >
                            <?php if($trainingInfos[0]["def_estate"]==0){ ?>
                            <input type="button"  value="" id="training_def" class="input_invisible" onclick="xajax_train_team_process(xajax.getFormValues('form_train_def'))"/>
                            <?php }else{?>
                            <input type="button"  value="" id="training_def_off" class="input_invisible" />
                            <?php }?>
                            <input type="hidden" name="type" value="<?=training_rules::DEF_TYPE?>" />
                        </form>
                        <form name="form_train_mil" id="form_train_mil"  >
                            <?php if($trainingInfos[0]["mil_estate"]==0){ ?>
                            <input type="button"  value="" id="training_mil" class="input_invisible" onclick="xajax_train_team_process(xajax.getFormValues('form_train_mil'))"/>
                            <?php }else{?>
                            <input type="button"  value="" id="training_mil_off" class="input_invisible" />
                            <?php }?>
                            <input type="hidden" name="type" value="<?=training_rules::MIL_TYPE?>" />
                        </form>
                        <form name="form_train_att" id="form_train_att"  >
                            <?php if($trainingInfos[0]["att_estate"]==0){ ?>
                            <input type="button"  value="" id="training_att" class="input_invisible" onclick="xajax_train_team_process(xajax.getFormValues('form_train_att'))"/>
                            <?php }else{?>
                            <input type="button"  value="" id="training_att_off" class="input_invisible" />
                            <?php }?>
                            <input type="hidden" name="type" value="<?=training_rules::ATT_TYPE?>" />
                        </form>
                    </div>

                </div>
                <div id="sponsor">

                    <div id="sponsor_list">

                    <?php if(isset($sponsorTeam)&& empty($sponsorTeam)){ ?>
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
                        font-weight:bold;"><?=$this->lang->line('sponsor_infos')?></div>
                        </div>
                        <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                            <form name="form_accept_sponsor" id="form_accept_sponsor" method="post">
                        <?php foreach( $sponsors as $row){ ?>
                                <div class="sponsor_item">
                                    <div class="labeltext"><label><?=$row["value"] ?> DirtyGold </label><input checked="checked" type= "radio" name="sponsorId" value="<?=$row["sponsor_id"] ?>" /> </div>
                                    <div><?=sponsors_rules::getSponsors($row["link"]);?></div>
                                </div>
                        <?php } ?>
                                <input type="button" name="accept_sponsor" class="accept_sponsor_button input_invisible" value="" onclick="xajax_add_sponsor_process(xajax.getFormValues('form_accept_sponsor'))"/>
                            </form>
                    <?php }else{ ?>
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
                                    font-weight:bold;"><?=str_replace("%data1",$sponsorTeam[0]["value"],$this->lang->line('sponsor_infos2'))?></div>
                                </div>
                                <div id="sponsor_used"><?=sponsors_rules::getSponsors($sponsorTeam);?></div>
                    <?php } ?>
                    </div>
                </div>
                <div id="naturalisation">
                    <div id="effectif">
                        <!--<div id="effectif_top"></div>-->
                        <div id="effectif_center">
                         <?php //$this->load->view("includes/infos_view",$this->lang->line('edit_player_infos')) ?>
                         <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                         <table >

                           <th></th>
                           <th><?=$this->lang->line('effectif_joueur')?></th>
                           <th><?=$this->lang->line('effectif_nat')?></th>
                           <th><?=$this->lang->line('effectif_age')?></th>
                           <th><?=$this->lang->line('effectif_type')?></th>
                           <th></th>
                            <?php
                            $flag=true;
                            foreach($players as $player){
                                ?>

                            <tr <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                                <td><?php echo players_rules::getInjuryFlag($player->injury) ?></td>
                                <td><?php echo anchor("transferts/player_profil/".$player->player_id,$player->player_name) ?></td>
                                <td><img src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/flags/<?php echo $player->nationality ?>.png" /></td>
                                <td><?php echo $player->age ?></td>
                                <td><?=$this->lang->line($player->position); ?></td>
                                <td>
                                    <?php echo anchor('transferts/naturalisation/'.$player->player_id,$this->lang->line('edit_link')); ?>
                                </td>

                            </tr>

                            <?php } ?>
                          <tr id="pagination">
                            <td colspan="12" align="center"></td>
                          </tr>
                          </table>
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
