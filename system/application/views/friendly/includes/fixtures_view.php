                        <div id="match_championship">
                            <?php if(!empty($friendlyMatchs)){?>
                                <div id="middle_match">
                            <?php
                                foreach($friendlyMatchs as $row)
                                { ?>
                                <div class="match">
                                    <div class="match_title"><div class="date"><?php echo $row["date"] ?></div></div>
                                    <div class="equipes">
                                        <div class="home_team"><?php echo anchor("team/team_profil/".$row["home_team_id"],$row["home_team_name"]) ?></div>
                                        <div class="score">
                                              <?php echo $row["home_team_score"] ?> - <?php echo $row["away_team_score"] ?>
                                        </div>
                                        <div class="away_team"><?php echo anchor("team/team_profil/".$row["away_team_id"],$row["away_team_name"]) ?></div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                                 </div>
                          <?php

                          }else{
                               //$data["messageInfos"]=$this->lang->line("scheduler_message_infos");
                               //$this->load->view('includes/infos_view',$data);
                          }
                          ?>
                         </div>