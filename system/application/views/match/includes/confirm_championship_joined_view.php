
                        <div id="list_championship">
                            <div id="championship_join_infos"></div>
                        <?php

                            foreach($championships as $row)
                            { ?>
                                <div class="championship_row_<?php echo $row->level ?>" >
                                  <form name="form_championship_<?php echo $row->championship_id ?>" id="form_championship_<?php echo $row->championship_id ?>" method="post">
                                    <div class="championship_title"><?php echo $row->title; ?></div>

                                    <input type="hidden" name="championshipId" value="<?php echo $row->championship_id; ?>" />
                             <?php if(!$teamInChampionship){
                                        if(!$this->championship_model->is_championship_full($row->championship_id) && $row->level==$this->session->userdata('level')){
                                        ?>
                                            <input type="button" class="join_championship input_invisible" name="join_championship" value="" onclick="xajax_join_championship_process(xajax.getFormValues('form_championship_<?php echo $row->championship_id ?>'))"/>

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

                        </div>