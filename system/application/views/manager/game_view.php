<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<meta property="og:title" content="DirtyFootball Manager"/>
<meta property="og:type" content="game"/>
<meta property="og:image" content="http://appfacebook.dirtyfootball.com/images/fr/global/logo_dirty.png"/>
<meta property="og:url" content="http://apps.facebook.com/dirtyfootball"/>
<meta property="og:site_name" content="Dirtyfootball Manager"/>
<meta property="fb:app_id" content="137164579648926"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/manager.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/li-scroller.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.li-scroller.1.0.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/facebox.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.currency.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/game_page.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/swfobject.js"></script>
<title>DirtyFootball Manager</title>
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
    <!--<div id="top_frame"></div>-->
    <div class="center_frame">
    <?php echo $this->load->view('includes/main_menu_view');?>
    <?php //echo $this->load->view('includes/my_info_view');?>
        <div id="content">
            <div id="rotate">
                <ul>
                    <li><a href="#infos"><span><?=$this->lang->line('submenu_infos')?></span></a></li>
                    <li><a href="#complexe"><span><?=$this->lang->line('submenu_complexe')?></span></a></li>
                    <li><a href="#palmares"><span><?=$this->lang->line('submenu_palmares')?></span></a></li>
                    <li><a href="#pantheon"><span><?=$this->lang->line('submenu_pantheon')?></span></a></li>
                    <li><a href="#options"><span><?=$this->lang->line('submenu_options')?></span></a></li>
                    <!--<li><a href="#faq"><span><?//=$this->lang->line('submenu_faq')?></span></a></li>-->
                </ul>
            <div id="background_tabs">
            <script type="text/javascript">
                swfobject.embedSWF(
                  "<?php echo base_url() ?>assets/swf/open-flash-chart.swf", "pie_stats",
                  "270", "160",
                  "9.0.0", "expressInstall.swf",
                  {"data-file":"<?= $data_url ?>"},
                  {'wmode':'transparent'}
                  
                );
            </script>
            <div id="infos">
                <ul id="ticker">
                    <?php for($i=1;$i<=5;$i++){ ?>
                    <li><?php echo $this->lang->line("infos_".$i);?></li>
                    <?php } ?>
                </ul>
                <div id="progress_bar">
                    <div id="progress1"><?php echo anchor("match",$this->lang->line('progress_champ')) ?></div>
                    <div id="progress2"><?php echo anchor("team/index#tactic",$this->lang->line('progress_compose')) ?></div>
                    <div id="progress3"><?php echo anchor("friendly/index#friends",$this->lang->line('progress_valide')) ?></div>
                </div>
                <div id="message">
                    <div id="message_top"></div>
                    <div id="message_center">
                        <table id="message_tab">
                            <?php 
                            $flag=true;
                            foreach($notifications as $row){ ?>
                            
                            <tr <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                                <td class="logo_message"><?=notifications_rules::getLogoMessage($row["type"])?></td>
                                <td><?=str_replace(array("%data1","%data2","%data3","%data4"),array($row["data1"],$row["data2"],$row["data3"],$row["data4"]),$this->lang->line($row["message"]));?></td>
                            </tr>
                            
                            <?php } ?>
                        </table>
                    </div>
                    <div id="message_bottom"></div>
                </div>

                <div id="bloc_right">
                    <div id="team">
                        <div id="top_team"></div>
                        <div id="center_team">
                            <div id="comment_team"><?=$contentTeam?></div>
                        </div>
                        <div id="bottom_team"></div>
                    </div>
                    <div id="championship">
                        <div id="top_championship"></div>
                        <div id="center_matchs">
                            <div id="comment_match"><?=$contentChamp?></div>
                        </div>
                        <div id="bottom_matchs"></div>
                    </div>
                    <div id="matchs">
                        <div id="top_matchs"></div>
                        <div id="center_matchs">
                            <div id="comment_match"><div id="competMatchs"><?=$contentMatch?></div><hr/><div id="friendlyMatchs"><?=$friendlyMatch?></div></div>
                        </div>
                        <div id="bottom_matchs"></div>
                    </div>
                    <div id="statistiques">
                        <div id="top_stats"></div>
                        <div id="center_stats">
                           <div id="pie_stats"></div>
                        </div>
                        <div id="bottom_stats"></div>
                    </div>
                </div>
            </div>
            <div id="complexe">
                <div id="terrain">
                    <div id="carre_1"><?=infrastructures_rules::checkFormationCenter($ownFormationCenter) ?></div>
                    <div id="carre_2"><?=infrastructures_rules::checkLaboratory($ownLaboratory) ?></div>
                    <div id="carre_3"><?=infrastructures_rules::checkStadium($ownStadium) ?></div>
                    <div id="carre_4"><?=infrastructures_rules::checkMerchandising1($ownMerchandising) ?></div>
                    <div id="carre_5"><?=infrastructures_rules::checkMerchandising2($ownMerchandising) ?></div>
                    <div id="carre_6"><?=infrastructures_rules::checkMerchandising3($ownMerchandising) ?></div>
                    <div id="carre_7"><?=infrastructures_rules::checkMerchandising4($ownMerchandising) ?></div>
                    <div id="carre_8"><?=infrastructures_rules::checkMerchandising5($ownMerchandising) ?></div>
                </div>
            </div>
            <div id="palmares">
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
            <div id="pantheon">
                <table id="top_amis_table">
                    <th colspan="7"><?=$this->lang->line('top_amis')?></th>
                <?php
                $i=1;
                foreach($friends as $row){ ?>
                        
                    <tr <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                        <td ><?php echo $i ?></td>
                        <td >

                        </td>
                
                        <td ><?php echo anchor("team/team_profil/".$row["team_id"],substr($row["team_name"], 0, 15)) ?></td>
                        <td ><?php echo substr($row["username"], 0, 1).".".$row["userfirstname"] ?></td>
                        <td ><?php echo $row["dirtyGold"] ?></td>
                        <td> <img id="value" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/dirtygold.png" alt="DirtyGold"/></td>
                        <td ><?php echo $this->lang->line('top_level').$row["level"] ?></td>
                    </tr>                
                <?php 
                    $i++;
                } ?>
                <tr><td colspan="7" id="pagination"></td></tr>
                </table>

                <table id="top_table">
                <th colspan="7"><?=$this->lang->line('top_mondial')?></th>
                <?php
                $i=1;
                foreach($top as $row){ ?>

                    <tr <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                        <td ><?php echo $i ?></td>
                        <td >

                        </td>
                        <td ><?php echo anchor("team/team_profil/".$row["team_id"],substr($row["team_name"], 0, 15)) ?></td>
                        <td ><?php echo substr($row["username"], 0, 1).".".$row["userfirstname"] ?></td>
                        <td ><?php echo $row["dirtyGold"] ?></td>
                        <td> <img id="value" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/dirtygold.png" alt="DirtyGold"/></td>
                        <td ><?php echo $this->lang->line('top_level').$row["level"] ?></td>
                    </tr>
                <?php
                    $i++;
                } ?>
                <tr><td colspan="7" id="pagination"></td></tr>
                </table>
                </div>
                </div>
                <div id="options">
                    <fieldset>
                        <legend align=top><?=$this->lang->line('change_langage')?></legend>
                        <label id="holiday_label"><?=$this->lang->line('langage')?></label>
                        <?php $attributes = array('id' => 'form_lang','name' => 'form_lang'); ?>
                        <?php echo form_open("game/changeLangage",$attributes);?>
                            <select name="lang" onchange="javascript:this.form.submit();">
                                <option <?php if($this->session->userdata('langage')=="fr")echo 'selected="selected"'; ?> value="fr"><?=$this->lang->line('langage_french')?></option>
                                <option <?php if($this->session->userdata('langage')=="eng")echo 'selected="selected"'; ?> value="eng"><?=$this->lang->line('langage_english')?></option>
                            </select>
                        </form>
                    </fieldset>
                    <fieldset>
                        <legend align=top><?=$this->lang->line('confirm_assistant')?></legend>
                        <label id="holiday_label"><?=$this->lang->line('holidays')?></label>
                        <form name="form_holiday" id="form_holiday" method="post">
                            <?php if(!$holiday){ ?>
                            <input type="hidden" name="holiday" value="1" />
                            <input type="button" class="holiday_button input_invisible" name="holiday_method" value="" onclick="xajax_holiday_process(xajax.getFormValues('form_holiday'))"/>
                            <?php }else{ ?>
                            <input type="hidden" name="holiday" value="0" />
                            <input type="button" class="holiday_back_button input_invisible" name="holiday_method" value="" onclick="xajax_holiday_process(xajax.getFormValues('form_holiday'))"/>                           
                            <?php } ?>
                        </form>
                    </fieldset>
                </div>

            </div>
        </div>
    </div>
<?php echo $this->load->view('includes/footer_view');?>
</div>
</body>
</html>
