                    <?php if($teamInChampionship)
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
                                        <td><?php echo $row->team_name ?></td>
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
                                </table>
                                </div>
                                <!--<div id="bottom_classement"></div>-->
                             </div>
                        <?php }?>