   
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