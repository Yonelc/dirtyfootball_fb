                    <div id="experience">
                      <div id="experience_top">
                          <div id="help_potentiel"></div>
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
                            <div id="team_validation">
                                <form name="form_team_validation" id="form_team_validation"  >
                                    <?php if(!$ready && $team_ok){ ?>
                                    <input type="button" class="input_invisible" id="validation_button" value="<?=$this->lang->line('team_validation')?>" onclick="xajax_validation_team_process(xajax.getFormValues('form_team_validation'))" />
                                    <?php }else{ ?>
                                    <input type="button" class="input_invisible" id="validation_button_off" value="<?=$this->lang->line('team_validation')?>" />
                                    <?php } ?>
                                </form>
                           </div>



                    <div id="composition">
                            <div id="composition_top"></div>
                            <div id="composition_center">
                                <div id="composition_frame">
                                    <div id="team_tactic">
                                            <form name="form_tactic" id="form_tactic"  >

                                                <select name="tacticId" <?php if($ready){?> disabled="disabled" <?php } ?> onchange="xajax_tactic_team_process(xajax.getFormValues('form_tactic'))" id="tacticId">
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
                                                <div id="formation" style="background-image: url(<?php echo base_url()."images/".$this->session->userdata("langage")."/field/".$formation.".png" ?>);z-index:0;height:403px;width:272px;">
                                                    <div id="player_name" style="z-index:2;">
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
                                <div id="help_team_sheet"></div>
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
                                                </center>
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
                                                 </center>
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
                                                            <?php if(!$ready){?>
                                                            <input type="button"  value="" class="delete_player input_invisible"  onclick="xajax_delete_player_process(xajax.getFormValues('form_delete_<?php echo $i ?>'))" />
                                                            <?php }else{ ?>
                                                            <input type="button"  value="" class="delete_player_off input_invisible" />
                                                            <?php } ?>
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