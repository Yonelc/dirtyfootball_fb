<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/facebox.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/match.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/validationEngine.jquery.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>

<script src="<?php echo base_url() ?>js/jquery-1.4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/facebox.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script src="<?php echo base_url() ?>js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/jquery.validationEngine.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/match.js"></script>
<script type="text/javascript">
  // Load/Call Reverse Ajax
  xajax.callback.global.onRequest = function() { $(".ajax_loading").css("display","block");}
  xajax.callback.global.beforeResponseProcessing = function() {$(".ajax_loading").css("display","none");}
</script>

<title>Match</title>
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
<script type="text/javascript">
function publish_champ(){
      var champName=document.getElementById('championshipName').value;

      var publish = {
      method: 'stream.publish',
      message:  '',
      picture : '<?php echo APP_URL_SERVER ?>images/fr/global/logo_dirty.png',
      link : '<?php echo APP_URL_CANVAS ?>',
      name:' <?php echo $this->lang->line('stream_message_champ')?>'+champName,
      caption: 'DirtyFootball Manager',
      description: '<?php echo $this->lang->line('stream_description')?>',
      actions : { name : 'DirtyFootball Manager', link : '<?php echo APP_URL_CANVAS ?>'}
    };

   FB.api(
        '/me/feed', 'post',publish,
        function(response) {

          if (!response || response.error) {
            alert('Error occured');
          } else {
            jQuery(document).trigger('close.facebox');

          }
    });

}

function publish_join(){

      var publish = {
      method: 'stream.publish',
      message:  '',
      picture : '<?php echo APP_URL_SERVER ?>images/fr/global/logo_dirty.png',
      link : '<?php echo APP_URL_CANVAS ?>',
      name:' <?php echo $this->lang->line('stream_message_join_champ')?>',
      caption: 'DirtyFootball Manager',
      description: '<?php echo $this->lang->line('stream_description')?>',
      actions : { name : 'DirtyFootball Manager', link : '<?php echo APP_URL_CANVAS ?>'}
    };

   FB.api(
        '/me/feed', 'post',publish,
        function(response) {

          if (!response || response.error) {
            alert('Error occured');
          } else {
            jQuery(document).trigger('close.facebox');

          }
    });

}
function close_popin(){
    jQuery(document).trigger('close.facebox');
}
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
                    <li><a href="#championship"><span><?=$this->lang->line("submenu_champ"); ?><?=$this->session->userdata("level");?></span></a></li>
                    
                    <li><a href="#awards"><span><?=$this->lang->line('submenu_awards'); ?></span></a></li>
                    <li><a href="#calendrier"><span><?=$this->lang->line('submenu_scheduler'); ?></span></a></li>
                    <li><a href="#classment_champ"><span><?=$this->lang->line('submenu_classement'); ?></span></a></li>
                    <li><a href="#create_championship"><span><?=$this->lang->line('submenu_create_champ'); ?></span></a></li>
                </ul>
                <div id="background_tabs">
                    <div id="championship">
                        <div id="popin_join_champ" style="display:none">
                            <div class="message_defi">
                                <?php echo $this->lang->line("popin_join_champ_msg")?>
                            </div>
                            <div class="btn">
                                <input type="button" class="btn_share input_invisible" name="join_friendly" value="" onclick="javascript:publish_join()"/>
                                <input type="button" class="btn_cancel input_invisible" name="cancel_friendly" value="" onclick="javascript:close_popin()"/>
                            </div>
                        </div>
                        <?php
                           $data["messageInfos"]=$this->lang->line("message_infos");
                           $this->load->view('includes/infos_view',$data);
                        ?>
                        <div id="research">
                             <?php $attributes = array('id' => 'form_research_championship','name' => 'form_research_championship'); ?>
                             <?php echo form_open("match/research_championship",$attributes);?>
                                 <div id="criteres">
                                     <label for="Nom du championnat"><?=$this->lang->line("championship_search"); ?></label>
                                     <input type="text"  name="championship_name" value="" />
                                     <input type="submit" id="research_ok" class="input input_invisible" value=""  />
                                 </div>
                            </form>
                        </div>

                        <div id="recompenses">
                            <?//=anchor("match/index", "Championnat de niveau ".$this->session->userdata("level")); ?> 
                            <?//=anchor("match/index#create_championship", "Créer un championnat"); ?> 
                            <?//=anchor("match/awards", "Voir les récompenses"); ?>
                        </div>
                        <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                        <div id="list_championship">
                            <div id="championship_join_infos"></div>
                        <?php

                            foreach($championships as $row)
                            { ?>
                                <div class="championship_row_<?php echo $row->level ?>" >
                                  <form name="form_championship_<?php echo $row->championship_id ?>" id="form_championship_<?php echo $row->championship_id ?>" method="post">
                                    <div class="championship_title"><?php echo $row->title; ?></div>
                                    
                                    <input type="hidden" name="championshipId" value="<?php echo $row->championship_id; ?>" />
                                    <input type="hidden" name="championshipTitle" value="<?php echo substr($row->title,0,25); ?>" />
                             <?php if(!$teamInChampionship){
                                        if(!$this->championship_model->is_championship_full($row->championship_id) && $row->level==$this->session->userdata('level')){
                                        ?>
                                            <input type="button" class="join_championship input_invisible" name="join_championship" value="" onclick="xajax_join_championship_process(xajax.getFormValues('form_championship_<?php echo $row->championship_id ?>'));jQuery.facebox({ div: '#popin_join_champ' });"/>
                                            
                                         <?php }else{ ?>
                                           <input type="button" class="see_championship input_invisible" name="see_championship" value="" onclick="self.location.href='<?=base_url()?>index.php/match/classment/<?=$row->championship_id?>'"/>
                                         <?php } ?>
                                   <?php
                                    }else{
                                    ?>
                                     <input type="button" class="see_championship input_invisible" name="see_championship" value="" onclick="self.location.href='<?=base_url()?>index.php/match/classment/<?=$row->championship_id?>'"/>
                                    <?php } ?>
                                     
                                    <div class="championship_level"><?=$this->lang->line("create_champ_level")?> <?php echo $row->level; ?></div>
                                    <div class="championship_nb_players"><?php echo $row->nb_teams; ?>/10</div>
                                  </form>
                                </div>
                       <?php
                            }
                       ?>
                            <div id="championships_pagination"><?php echo $this->pagination->create_links(); ?></div>
                        </div>
                    </div>



                    <div id="awards">
    
                            <div id="awards">
                                <table id="tab_awards">
                                    <th colspan="2"><?=$this->lang->line("awards_title"); ?><?=$this->session->userdata("level"); ?></th>
                                    <?php
                                    $flag=true;
                                    for($i=1;$i<=10;$i++){ ?>
                                    <tr <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                                        <td class="award_place">Place <?=$i ?></td>
                                        <td class="award_value"><?=$allAwards[0]["place".$i]?> DirtyGold</td>

                                    </tr>
                                    <?php } ?>
                                    <tr id="pagination">
                                        <td colspan="11" align="center"></td>
                                    </tr>
                                </table>
                            </div>
                    </div>
                    <div id="calendrier">
                        <div id="match_championship">
                                <!--<div  id="top_match"></div>-->
                            <?php if(!empty($matchsChampArr)){?>
                                <div id="middle_match">
                            <?php
                                
                                $i=1;
                                foreach($matchsChampArr as $row)
                                { ?>
                                <div class="match">
                                    <div class="match_title"> <div class="day"><?=$this->lang->line("scheduler_day"); ?> <?php echo $i ?></div> <div class="date"><?php echo $row->date ?></div></div>
                                    <div class="equipes">
                                        <div class="home_team"><?php echo anchor("team/team_profil/".$row->home_team_id,$row->home_team_name) ?></div>
                                        <div class="score">
                                              <?php echo $row->home_team_score ?> - <?php echo $row->away_team_score ?>
                                        </div>
                                        <div class="away_team"><?php echo anchor("team/team_profil/".$row->away_team_id,$row->away_team_name) ?></div>
                                    </div>
                                    <div class="display_match"><?=anchor("match/live_match/".$row->match_id, $this->lang->line("observations"))?></div>
                                </div>
                            <?php $i++;
                                }

                            ?>
                                 </div>
                          <?php

                          }else{
                               $data["messageInfos"]=$this->lang->line("scheduler_message_infos");
                               $this->load->view('includes/infos_view',$data);
                          }
                          ?>
                                <!--<div id="bottom_match"></div>-->
                         </div>
                    </div>
                    <div id="classment_champ">
                    <?php
                    if(empty($matchsChampArr)){
                       $data["messageInfos"]=$this->lang->line("championship_message_infos");
                       $this->load->view('includes/infos_view',$data);
                    }
                    if($teamInChampionship)
                          {
                    ?>
                            <div id="classement">
                                <!--<div  id="top_classement"></div>-->
                                <div id="middle_classement">
                                <table>
                                    <th></th>
                                    <th><?=$this->lang->line("championship_team")?></th>
                                    <th><?=$this->lang->line("championship_j")?></th>
                                    <th><?=$this->lang->line("championship_g")?></th>
                                    <th><?=$this->lang->line("championship_n")?></th>
                                    <th><?=$this->lang->line("championship_p")?></th>
                                    <th><?=$this->lang->line("championship_pris")?></th>
                                    <th><?=$this->lang->line("championship_c")?></th>
                                    <th><?=$this->lang->line("championship_dif")?></th>
                                    <th><?=$this->lang->line("championship_pts")?></th>
                       <?php    $flag=true;
                                $i=1;
                                foreach($classement as $row)
                                { ?>
                                    <tr <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                                        <td  <?php if($i<=3){echo "style='color:#0003e9'";}if($i>=8){echo "style='color:#bd0000'";} ?>><?php echo $i ?></td>
                                        <td><?php echo anchor("team/team_profil/".$row->team_id,$row->team_name) ?></td>
                                        <td><?php echo $row->nb_match ?></td>
                                        <td><?php echo $row->win ?></td>
                                        <td><?php echo $row->draw ?></td>
                                        <td><?php echo $row->lose ?></td>
                                        <td><?php echo $row->goal_p ?></td>
                                        <td><?php echo $row->goal_c ?></td>
                                        <td><?php echo $row->goal_average ?></td>
                                        <td><?php echo $row->point ?></td>
                                    </tr>

                          <?php
                                $i++;
                            }
                            ?>
                                    <tr id="pagination">
                                        <td colspan="11" align="center"></td>
                                    </tr>
                                </table>
                                </div>
                                <!--<div id="bottom_classement"></div>-->
                             </div>
                        <div id="stats_champ">
                        <div id="last_matchs">
                            <div id="last_matchs_title"><?=$this->lang->line("last_matchs")?></div>
                            <?php
                            if(isset($lastMatchs)){
                                $flag=true;
                                $i=1;
                                foreach($lastMatchs as $row){ ?>

                                <div class="match_score" ><?="<div class='home_team_result'>".substr($row["home_team_name"], 0, 13)."</div><div class='home_team_score_result'> ".$row["home_team_score"]." - ".$row["away_team_score"]."</div> <div class='away_team_result'>".substr($row["away_team_name"], 0, 13)."</div>" ?></div>

                            <?php $i++;
                                }
                            }?>
                        </div>
                        <div id="next_matchs">
                            <div id="next_matchs_title"><?=$this->lang->line("next_matchs")?></div>
                            <?php
                            if(isset($nextMatchs)){
                                foreach($nextMatchs as $row){ ?>

                            <div class="match_score"><?="<div class='home_team_result'>".substr($row["home_team_name"], 0, 13)."</div><div class='home_team_score_result'> ".$row["home_team_score"]." - ".$row["away_team_score"]."</div> <div class='away_team_result'>".substr($row["away_team_name"], 0, 13)."</div>" ?></div>

                            <?php }
                            }?>
                        </div>
                        </div>
                        <?php }?>

                    </div>

                    <div id="create_championship">
                       <div id="popin_create_champ" style="display:none">
                            <div class="message_defi">
                                <?php echo $this->lang->line("popin_create_champ_msg")?>
                            </div>
                            <div class="btn">
                                <input type="button" class="btn_share input_invisible" name="join_friendly" value="" onclick="javascript:publish_champ()"/>
                                <input type="button" class="btn_cancel input_invisible" name="cancel_friendly" value="" onclick="javascript:close_popin()"/>
                            </div>
                        </div>
                        <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                        <div id="form_creation">
                            <div id="championship_infos"></div>
                            <div id="create_championship_top"></div>
                            <div id="create_championship_center">
                                 <form name="form_create_championship" id="form_create_championship" method="post">
                                     <div class="create_champ_input"><label><?=$this->lang->line("create_champ_name")?></label><input type="text" id="championshipName" name="championshipName" value=""  class="validate[required,length[0,100]]"/></div>
                                     <div class="create_champ_input"><label><?=$this->lang->line("create_champ_level")?></label><?=$this->session->userdata('level')?></div>
                                     <div class="create_champ_input"><label><?=$this->lang->line("create_champ_cost")?></label>1 <img id="cost_dirtygold" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/dirtygold.png" alt="DirtyGold"/></div>
                                     <input type="button" class="create_championship input_invisible" name="create_championship" value="" onclick="xajax_create_championship_process(xajax.getFormValues('form_create_championship'));jQuery.facebox({ div: '#popin_create_champ' });"/>
                                 </form>
                            </div>
                            <div id="create_championship_bottom"></div>
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
