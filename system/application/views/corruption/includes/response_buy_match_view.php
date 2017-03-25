             <?php if(isset($nextMatch)&& !empty($nextMatch)){ ?>

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
                                <!--<form name="form_buy_match" id="form_buy_match" method="post">
                                    <input type="button" class="buy_match_button input_invisible" name="buy_match" value="" onclick="xajax_buy_match_process(xajax.getFormValues('form_buy_match'))"/>
                                    <input type="text" name="offer" id="offer" value="100000" class="validate[required,custom[onlyNumber],length[0,100]]"/> <img src="<?php //echo base_url() ?>images/global/wollars.png" alt="Wollars"/><br/>
                                    <input type="hidden" name="matchId" value="<?//=$nextMatch[0]["match_id"]?>" />
                                    <input type="hidden" name="receiver" value="<?//=corruption_rules::getOpponentId($this->session->userdata('teamId'), $nextMatch[0]["home_team_id"], $nextMatch[0]["away_team_id"])?>" />
                                </form>-->
                                <div id="submit_feedback"><?=$messageInfos?></div>
                            </div>
                            <div id="bottom_proposition"></div>
                        </div>


                <?php } ?>
                </div>
  
