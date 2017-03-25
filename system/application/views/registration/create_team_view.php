<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />


<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/create_team.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/fr/validationEngine.jquery.css" />


<script src="<?php echo base_url() ?>js/jquery-1.4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/jquery.validationEngine.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/create_team.js" type="text/javascript"></script>
<title>Créer votre équipe</title>
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
    <?php echo $this->load->view('includes/header_view');?>
    <!--<div id="top_frame"></div>-->
    <div class="center_frame">
        <?php echo $this->load->view('includes/main_menu_view');?>
        <div id="content">

            <div class="entete">
                <img src="<?=base_url() ?>images/fr/global/1.png" alt="1"/>
                <h1><?=$this->lang->line('create_language');?></h1>
            </div>
            <div id="lang">
                
                <?=anchor('start/begin_game/fr', '<img src="'.base_url().'images/fr/global/fr.png" border="none" alt="fr"/>');?>
                <?=anchor('start/begin_game/eng', '<img src="'.base_url().'images/fr/global/eng.png" border="none" alt="eng"/>');?>
                <?//=anchor('start/index/eng', '<img src="'.base_url().'images/".$this->session->userdata("langage")."/global/ger_off.png" border="none" alt="ger"/>');?>
                <?//=anchor('start/index/eng', '<img src="'.base_url().'images/".$this->session->userdata("langage")."/global/esp_off.png" border="none" alt="esp"/>');?>
                <?//=anchor('start/index/eng', '<img src="'.base_url().'images/".$this->session->userdata("langage")."/global/it_off.png" border="none" alt="it"/>');?>

            </div>

            <?php $attributes = array('id' => 'form_selection','name' => 'form_selection'); ?>
            <?php echo form_open("start/add_player_team",$attributes);?>
 
            <div class="entete">
                <img src="<?=base_url() ?>images/fr/global/2.png" alt="2"/>
                <h1><?=$this->lang->line('create_team');?></h1>
            </div>
            <div class="create_team">
                <div class="create_team_left"><div class="bloc_input"><label for="Nom de l'équipe" class="label"><?=$this->lang->line('create_team_name');?> </label><div class="input_background"><input type="text" name="team_name" id="team_name" value="<?php if(isset($team_name)) echo $team_name; ?>"  class="validate[required]" title="Invalide"/></div></div></div>
                <div class="create_team_right"><div class="bloc_input"><label for="Nom du stade" class="label"><?=$this->lang->line('create_stadium_name');?> </label><div class="input_background"><input type="text" name="stadium" id="stadium" value="<?php if(isset($stadium)) echo $stadium; ?>"  class="validate[required]" title="Invalide"/></div></div></div>
            </div>

            <div class="entete">
                <img src="<?=base_url() ?>images/fr/global/3.png" alt="3"/>
                <h1><?=$this->lang->line('create_players');?></h1>
            </div>

            <div class="create_team">
            <?php $attributes = array('id' => 'form_selection','name' => 'form_selection'); ?>
            <?php echo form_open("start/add_player_team",$attributes);?>

                <div class="create_team_left">
                    
                      <div class="bloc_input"><label for="Nom joueur 1" class="label"><?=$this->lang->line('create_joueur1');?> </label><div class="input_background"><input type="text"  name="player1" id="player1" value="Fordy" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                      <select name="position_1" id="position_1"  >
                        <option value="GB" selected="selected"><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF"><?=$this->lang->line('create_def');?></option>
                        <option value="MILL"><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT"><?=$this->lang->line('create_att');?></option>
                      </select>

   
                      <?php 
                          $flagsArr=team_rules::getAllFlags();
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_1" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_1"/>
                          

                      </div>
                      <div class="bloc_input"><label for="Nom joueur 2" class="label"><?=$this->lang->line('create_joueur2');?> </label><div class="input_background"><input type="text"  name="player2" id="player2" value="Alca" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_2" id="position_2">
                        <option value="GB" ><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" selected="selected"><?=$this->lang->line('create_def');?></option>
                        <option value="MILL"><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT"><?=$this->lang->line('create_att');?></option>
                        </select>

                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_2" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_2"/>


                      </div>
                      <div class="bloc_input"><label for="Nom joueur 3" class="label"><?=$this->lang->line('create_joueur3');?> </label><div class="input_background"><input type="text"  name="player3" id="player3" value="Estefer" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_3" id="position_3">
                        <option value="GB" ><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" selected="selected"><?=$this->lang->line('create_def');?></option>
                        <option value="MILL"><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT"><?=$this->lang->line('create_att');?></option>
                        </select>

                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_3" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_3"/>
                      </div>
                      <div class="bloc_input"><label for="Nom joueur 4" class="label"><?=$this->lang->line('create_joueur4');?> </label><div class="input_background"><input type="text"  name="player4" id="player4" value="Clarkdion" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_4" id="position_4">
                        <option value="GB" ><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" selected="selected"><?=$this->lang->line('create_def');?></option>
                        <option value="MILL"><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT"><?=$this->lang->line('create_att');?></option>
                          </select>
                      
                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_4" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_4"/>
                      </div>
                      <div class="bloc_input"><label for="Nom joueur 5" class="label"><?=$this->lang->line('create_joueur5');?> </label><div class="input_background"><input type="text"  name="player5" id="player5" value="Ouda" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_5" id="position_5">
                        <option value="GB" ><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" selected="selected"><?=$this->lang->line('create_def');?></option>
                        <option value="MILL"><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT"><?=$this->lang->line('create_att');?></option>
                        </select>

                      <?php
                            $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_5" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_5"/>
                      </div>
                      <div class="bloc_input"><label for="Nom joueur 6" class="label"><?=$this->lang->line('create_joueur6');?> </label><div class="input_background"><input type="text"  name="player6" id="player6" value="Tamir" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_6" id="position_6">
                        <option value="GB" ><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" ><?=$this->lang->line('create_def');?></option>
                        <option value="MILL" selected="selected"><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT"><?=$this->lang->line('create_att');?></option>
                        </select>
                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_6" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_6"/>
                      </div>
                      <div class="bloc_input"><label for="Nom joueur 7" class="label"><?=$this->lang->line('create_joueur7');?> </label><div class="input_background"><input type="text"  name="player7" id="player7" value="Grefar" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_7" id="position_7">
                        <option value="GB" ><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" ><?=$this->lang->line('create_def');?></option>
                        <option value="MILL" selected="selected"><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT"><?=$this->lang->line('create_att');?></option>
                        </select>

                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_7" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_7"/>
                      </div>
                      <div class="bloc_input"><label for="Nom joueur 8" class="label"><?=$this->lang->line('create_joueur8');?> </label><div class="input_background"><input type="text"  name="player8" id="player8" value="Solao" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_8" id="position_8">
                        <option value="GB" ><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" ><?=$this->lang->line('create_def');?></option>
                        <option value="MILL" selected="selected"><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT"><?=$this->lang->line('create_att');?></option>
                        </select>

                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_8" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_8"/>
                      </div>

               </div>
               <div class="create_team_right">

                      <div class="bloc_input"><label for="Nom joueur 9" class="label"><?=$this->lang->line('create_joueur9');?> </label><div class="input_background"><input type="text"  name="player9" id="player9" value="Tampaio" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_9" id="position_9">
                        <option value="GB" ><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" ><?=$this->lang->line('create_def');?></option>
                        <option value="MILL" selected="selected"><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT"><?=$this->lang->line('create_att');?></option>
                        </select>

                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_9" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_9"/>
                      </div>

                      <div class="bloc_input"><label for="Nom joueur 10" class="label"><?=$this->lang->line('create_joueur10');?> </label><div class="input_background"><input type="text"  name="player10" id="player10" value="Glujik" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_10" id="position_10">
                        <option value="GB" ><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" ><?=$this->lang->line('create_def');?></option>
                        <option value="MILL" ><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT" selected="selected"><?=$this->lang->line('create_att');?></option>
                        </select>

                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_10" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_10"/>
                      </div>
                      <div class="bloc_input"><label for="Nom joueur 11" class="label"><?=$this->lang->line('create_joueur11');?> </label><div class="input_background"><input type="text"  name="player11" id="player11" value="Johnsson" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_11" id="position_11">
                        <option value="GB"> <?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" ><?=$this->lang->line('create_def');?></option>
                        <option value="MILL" ><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT" selected="selected"><?=$this->lang->line('create_att');?></option>
                        </select>

                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_11" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_11"/>
                      </div>
                      <div class="bloc_input"><label for="Nom joueur 12" class="label"><?=$this->lang->line('create_joueur12');?> </label><div class="input_background"><input type="text"  name="player12" id="player12" value="Gert" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_12" id="position_12">
                        <option value="GB" selected="selected"><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" ><?=$this->lang->line('create_def');?></option>
                        <option value="MILL" ><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT" ><?=$this->lang->line('create_att');?></option>
                        </select>
                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_12" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_12"/>
                      </div>
                      <div class="bloc_input"><label for="Nom joueur 13" class="label"><?=$this->lang->line('create_joueur13');?> </label><div class="input_background"><input type="text"  name="player13" id="player13" value="Hemmer" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_13" id="position_13">
                        <option value="GB" ><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" selected="selected"><?=$this->lang->line('create_def');?></option>
                        <option value="MILL" ><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT" ><?=$this->lang->line('create_att');?></option>
                        </select>

                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_13" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_13"/>
                      </div>
                      <div class="bloc_input"><label for="Nom joueur 14" class="label"><?=$this->lang->line('create_joueur14');?> </label><div class="input_background"><input type="text"  name="player14" id="player14" value="abdela" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_14" id="position_14">
                        <option value="GB" ><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" ><?=$this->lang->line('create_def');?></option>
                        <option value="MILL" selected="selected"><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT" ><?=$this->lang->line('create_att');?></option>
                        </select>

                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_14" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_14"/>
                      </div>
                   <div class="bloc_input"><label for="Nom joueur 15" class="label"><?=$this->lang->line('create_joueur15');?> </label><div class="input_background"><input type="text"  name="player15" id="player15" value="Hassan" class="validate[required,custom[onlyLetter],length[0,100]]" /></div>
                        <select name="position_15" id="position_15">
                        <option value="GB" ><?=$this->lang->line('create_gb');?></option>
                        <option value="DEF" ><?=$this->lang->line('create_def');?></option>
                        <option value="MILL" ><?=$this->lang->line('create_mil');?></option>
                        <option value="ATT" selected="selected"><?=$this->lang->line('create_att');?></option>
                        </select>
                      <?php
                          $flag=array_rand($flagsArr,1);
                          $flagId=explode(".",$flagsArr[$flag]);
                          ?>
                          <input type="hidden" name="nationality_15" value="<?=$flagId[0]?>" />
                          <img src="<?=base_url()?>images/fr/flag_mini/<?=$flagsArr[$flag] ?>" alt="<?=$flagId[0]?>" id="nationality_15"/>
                      </div>
              </div>
              <div id="create_team_bottom">
                  <input id="validation" type="submit" class="btn_validation" value="<?=$this->lang->line('create_team_ok');?>" />
              </div>
              
              </form>
            </div>
        </div>
    </div>

        <?php echo $this->load->view('includes/footer_view');?>
</div>
</body>
</html>
