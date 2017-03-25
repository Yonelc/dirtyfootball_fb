             <?php if(isset($nextMatch)&& !empty($nextMatch)){ ?>



                 <?php if(!isset($corruptedMatch)&& empty($corruptedMatch)){ ?>
                    <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                    <div id="buy_match">
                        <div class="next_match">
                            <div class="match_opponent">
                                <ul>
                                <li><?=substr($nextMatch[0]["home_team_name"],0,12)?></li>
                                <li><?=substr($nextMatch[0]["away_team_name"],0,12)?></li>
                                </ul>
                            </div>
                            <div class="proposition">
                                <form name="form_buy_match" id="form_buy_match" method="post">
                                    <input type="button" class="buy_match_button input_invisible" name="buy_match" value="" onclick="xajax_buy_match_process(xajax.getFormValues('form_buy_match'))"/>
                                    <input type="text" name="offer" id="offer" value="100000" class="validate[required,custom[onlyNumber],length[0,100]]"/> <img src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/wollars.png" alt="Wollars"/><br/>
                                    <input type="hidden" name="matchId" value="<?=$nextMatch[0]["match_id"]?>" />
                                    <input type="hidden" name="receiver" value="<?=corruption_rules::getOpponentId($this->session->userdata('teamId'), $nextMatch[0]["home_team_id"], $nextMatch[0]["away_team_id"])?>" />
                                </form>
                                <div id="submit_feedback"></div>
                            </div>
                            <div id="bottom_proposition"></div>
                        </div>
              <?php }else{ ?>
                <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                 <div class="next_match">

                        <div class="match_opponent">
                            <ul>
                            <li><?=substr($nextMatch[0]["home_team_name"],0,12)?></li>
                            <li><?=substr($nextMatch[0]["away_team_name"],0,12)?></li>
                            </ul>
                        </div>

                        <div class="proposition">
                            <div id="comment_offer"><?=$this->lang->line("corruption_proposed");?> <strong><?=$corruptedMatch[0]["value"]?></strong> <img src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/wollars.png" alt="Wollars"/></div>
                            <div id="accept">
                                <form name="form_accepted" id="form_accepted" method="post">
                                    <input type="button" class="corruption_accepted_button input_invisible" name="corruption_accepted" value="" onclick="xajax_corruption_accepted_process(xajax.getFormValues('form_accepted'))"/>
                                </form>
                            </div>
                            <div id="refuse">
                                <form name="form_refused" id="form_refused" method="post">
                                    <input type="button" class="corruption_refused_button input_invisible" name="corruption_refused" value="" onclick="xajax_corruption_refused_process(xajax.getFormValues('form_refused'))"/>
                                </form>
                            </div>
                        </div>
                        <div id="bottom_proposition"></div>
                  </div>
                  <?php } ?>


                <?php } ?>
                </div>
            </div>
            </div>
