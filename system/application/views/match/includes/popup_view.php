                        <div id="match_championship">
                                <!--<div  id="top_match"></div>-->
                                <div id="middle_match">
                            <?php
                                $i=1;
                                foreach($matchsChampArr as $row)
                                { ?>
                                <div class="match">
                                    <div class="match_title"> Journée <?php echo $i ?> <div class="date"><?php echo $row->date ?></div></div>
                                    <div class="equipes">
                                        <div class="home_team"><?php echo $row->home_team_name ?></div>
                                        <div class="score">
                                              <?php echo $row->home_team_score ?> - <?php echo $row->away_team_score ?>
                                        </div>
                                        <div class="away_team"><?php echo $row->away_team_name ?></div>
                                    </div>
                                </div>
                            <?php $i++;
                                }
                            ?>
                                 </div>
                                <!--<div id="bottom_match"></div>-->
                         </div>