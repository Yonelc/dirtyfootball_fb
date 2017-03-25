<div id="experience_top">
                          <div id="help_potentiel" class="tooltip" title="<?=$this->lang->line("potentiel_help");?>"></div>
                      </div>

                          <div id="exp_team">
                              <div id="potentiel_primaire">
                                  <h1><?=$this->lang->line("potentiel_title1");?></h1>
                                  <ul id="exp_primaire">
                                    <li><div class="gb_experience"><p><?php echo $potentielPrimaire[0]->experience_gb."<br/>"; ?></p></div></li>
                                    <li><div class="def_experience"><p><?php echo $potentielPrimaire[0]->experience_def."<br/>";?></p></div></li>
                                    <li><div class="mill_experience"><p><?php echo $potentielPrimaire[0]->experience_mil."<br/>";?></p></div></li>
                                    <li><div class="att_experience"><p><?php echo $potentielPrimaire[0]->experience_att."<br/>";?></p></div></li>
                                  </ul>
                              </div>
                              <div id="potentiel_secondaire">
                                  <h2><?=$this->lang->line("potentiel_title2");?></h2>
                                  <ul id="exp_secondaire">
                                    <li><div class="gb_experience"><p><?php echo $potentielSecondaire[0]->secondary_experience_gb."<br/>";?></p></div></li>
                                    <li><div class="def_experience"><p><?php echo $potentielSecondaire[0]->secondary_experience_def."<br/>";?></p></div></li>
                                    <li><div class="mill_experience"><p><?php echo $potentielSecondaire[0]->secondary_experience_mil."<br/>";?></p></div></li>
                                    <li><div class="att_experience"><p><?php echo $potentielSecondaire[0]->secondary_experience_att."<br/>";?></p></div></li>
                                  </ul>
                              </div>
                            </div>
                            <div id="experience_bottom"></div>