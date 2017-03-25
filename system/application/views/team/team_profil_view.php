<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/facebox.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/composition.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.li-scroller.1.0.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/facebox.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/game_page.js"></script>
<title>Profil de l'équipe</title>
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
<script type="text/javascript">
function stream(sender,receiver,senderName){
    
    xajax_challenge_team_process(xajax.getFormValues('form_challenge'));
    jQuery(document).trigger('close.facebox');

}

function close_popin(){
    jQuery(document).trigger('close.facebox');
}
</script>

<div id="conteneur">
    <?php echo $this->load->view('includes/applifier_view');?>
    <?php echo $this->load->view('includes/header_view');?>
    <div class="center_frame">
    <?php echo $this->load->view('includes/main_menu_view');?>
        <div id="content">
            <div id="rotate">
                <ul>
                    <li><a href="#team_profil"><span><?=$this->lang->line('submenu_profile_team')?> <?=substr($teamInfos[0]->team_name,0,15)?></span></a></li>
                    <li><a href="#effectif"><span><?=$this->lang->line('submenu_profile_effectif')?> <?=substr($teamInfos[0]->team_name,0,15)?></span></a></li>
                    <li><a href="#palmares"><span><?=$this->lang->line('submenu_profile_palmares')?> <?=substr($teamInfos[0]->team_name,0,15)?></span></a></li>
                </ul>
                <div id="background_tabs">
                    
                    <div id="team_profil">
                        <div id="challenge_infos"></div>
                    <div id="back_button"><a  href="javascript:history.go(-1)"><?=$this->lang->line("back")?></a></div>
                           <?php $fql = "SELECT pic FROM user WHERE uid=".$userInfos[0]["user_id"];

                            $response = $this->facebook->api(array('method' => 'fql.query','query' =>$fql));

                            ?>
                          <div id="avatar"><img src="<?php if(!empty($response))echo $response[0]["pic"] ?>" alt="pic" /></div>

                        <table id="tab_team_stats">
 
                                <tr class="row_pair">
                                    <td class="col_title"><?=$this->lang->line('profile_manager')?></td>
                                    <td class="col_data" ><div class=""><?=$userInfos[0]["username"]." ".$userInfos[0]["userfirstname"]  ?></div></td>
                                </tr>
                                <tr class="row_impair">
                                    <td class="col_title"><?=$this->lang->line('profile_victoire')?></td>
                                    <td class="col_data"><div class=""><?=$teamInfos[0]->nb_victory   ?></div></td>
                                </tr>
                                <tr class="row_pair">
                                    <td class="col_title"><?=$this->lang->line('profile_nul')?></td>
                                    <td class="col_data"><div class=""><?=$teamInfos[0]->nb_tie   ?></div></td>
                                </tr>
                                <tr class="row_impair">
                                    <td class="col_title"><?=$this->lang->line('profile_defaite')?></td>
                                    <td class="col_data"><div class=""><?=$teamInfos[0]->nb_lost   ?></div></td>
                                </tr>
                                <tr class="row_pair">
                                    <td class="col_title"><?=$this->lang->line('profile_dirtygold')?></td>
                                    <td class="col_data"><div class=""><?=$userInfos[0]["dirtyGold"] ?></div></td>
                                </tr>
                                <tr class="row_impair">
                                    <td class="col_title"><?=$this->lang->line('profile_wollars')?></td>
                                    <td class="col_data"><div class=""><?=$userInfos[0]["money"] ?></div></td>
                                </tr>
                                <tr class="row_pair">
                                    <td class="col_title"><?=$this->lang->line('profile_tactic')?></td>
                                    <td class="col_data"><div class=""><?=$teamTactic[0]->name   ?></div></td>
                                </tr>
                                <tr class="row_impair">
                                    <td class="col_title"><?=$this->lang->line('profile_bonus_off')?></td>
                                    <td class="col_data"><div class=""><?=$nbOffensiveMethods ?></div></td>
                                </tr>
                                <tr class="row_pair">
                                    <td class="col_title"><?=$this->lang->line('profile_bonus_def')?></td>
                                    <td class="col_data"><div class=""><?=$nbDefensiveMethods ?></div></td>
                                </tr>
                                <tr class="row_impair">
                                    <td class="col_title"><?=$this->lang->line('potentiel_title1')?></td>
                                    <td class="col_data">
                                        <div class="">
                                              <ul id="exp_primaire">
                                                <li><div class="gb_experience"><p><?php echo $teamInfos[0]->experience_gb."<br/>"; ?></p></div></li>
                                                <li><div class="def_experience"><p><?php echo $teamInfos[0]->experience_def."<br/>";?></p></div></li>
                                                <li><div class="mill_experience"><p><?php echo $teamInfos[0]->experience_mil."<br/>";?></p></div></li>
                                                <li><div class="att_experience"><p><?php echo $teamInfos[0]->experience_att."<br/>";?></p></div></li>
                                              </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="row_pair">
                                    <td class="col_title"><?=$this->lang->line('potentiel_title2')?></td>
                                    <td class="col_data">
                                        <div class="">
                                              <ul id="exp_secondaire">
                                                <li><div class="gb_experience"><p><?php echo $teamInfos[0]->secondary_experience_gb."<br/>"; ?></p></div></li>
                                                <li><div class="def_experience"><p><?php echo $teamInfos[0]->secondary_experience_def."<br/>";?></p></div></li>
                                                <li><div class="mill_experience"><p><?php echo $teamInfos[0]->secondary_experience_mil."<br/>";?></p></div></li>
                                                <li><div class="att_experience"><p><?php echo $teamInfos[0]->secondary_experience_att."<br/>";?></p></div></li>
                                              </ul>
                                        </div>
                                    </td>
                                </tr>

                        </table>
                    
                        <div id="popin" style="display:none">
                          <div class="message_defi">
                           <?php $fql = "SELECT pic_square FROM user WHERE uid=".$userInfos[0]["user_id"];

                            $response = $this->facebook->api(array('method' => 'fql.query','query' =>$fql));

                            ?>
                          <div style="float:left;margin:0 10px 10px 0"><img src="<?php if(!empty($response))echo $response[0]["pic_square"] ?>" alt="pic" /></div>
                             <?php echo str_replace('%data1',$userInfos[0]["username"]." ".$userInfos[0]["userfirstname"],$this->lang->line("popin_msg"))?>
                            <div class="btn">
                                <input type="button" class="btn_defier input_invisible" name="join_friendly" value="" onclick="javascript:stream('<?php echo $this->session->userdata("userId") ?>','<?=$userInfos[0]["user_id"]?>','<?php echo $this->session->userdata("username")." ".$this->session->userdata("userfirstname") ?>')"/>
                                <input type="button" class="btn_cancel input_invisible" name="cancel_friendly" value="" onclick="javascript:close_popin()"/>
                            </div>
                          </div>
                        </div>
                        <form method="post" name="form_challenge" id="form_challenge">
                            <input type="hidden" name="receiver" value="<?=$userInfos[0]["user_id"]?>" />
                            <a href="#popin" rel="facebox"><div id="invitation_challenge"></div></a>
                        </form>
                    </div>
                    <div id="effectif">
                        <div id="back_button"><a  href="javascript:history.go(-1)"><?=$this->lang->line("back")?></a></div>
                        <div id="effectif_center">
                         <table >
                             <th></th>
                       <th><?=$this->lang->line('effectif_joueur')?></th>
                       <th><?=$this->lang->line('effectif_nat')?></th>
                       <th><?=$this->lang->line('effectif_age')?></th>
                       <th><?=$this->lang->line('effectif_att')?></th>
                       <th><?=$this->lang->line('effectif_mil')?></th>
                       <th><?=$this->lang->line('effectif_def')?></th>
                       <th><?=$this->lang->line('effectif_gb')?></th>
                       <th><?=$this->lang->line('effectif_xp')?></th>
                       <th><?=$this->lang->line('effectif_type')?></th>
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
                                <td><?php echo $player->experience_pt ?></td>
                                <td><?=$this->lang->line($player->position); ?></td>
                            </tr>

                            <?php } ?>
                              <tr id="pagination">
                                <td colspan="10" align="center"></td>
                              </tr>
                          </table>
                          </div>
                    </div>
                    <div id="palmares">
                        <div id="back_button"><a  href="javascript:history.go(-1)"><?=$this->lang->line("back")?></a></div>
                        <div id="palmares_center">
                             <table >

                       <th><?=$this->lang->line('palmarestab_nom')?></th>
                       <th><?=$this->lang->line('palmarestab_position')?></th>
                       <th><?=$this->lang->line('palmarestab_niveau')?></th>
                       <th><?=$this->lang->line('palmarestab_date')?></th>

                                <?php
                                $flag=true;
                                foreach($palmares as $row){
                                    ?>

                                <tr <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                                    <td ><?php echo anchor("game/palmares_details/".$row["championship_id"],$row["champ_name"]) ?></td>
                                    <td ><?php echo $row["position"] ?></td>
                                    <td ><?php echo $row["level"] ?></td>
                                    <td ><?php echo $row["champ_date"] ?></td>
                                </tr>

                                <?php } ?>
                              <tr id="pagination">
                                <td colspan="11" align="center"></td>
                              </tr>
                              </table>
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

