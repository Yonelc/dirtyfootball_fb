                <div id="message_offer_received"></div>
                <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                <table id="tab_offers_received">
                    <th><?=$this->lang->line("offer_player")?></th>
                    <th><?=$this->lang->line("offer_team")?></th>
                    <th><?=$this->lang->line("offer_offer")?></th>
                    <th colspan="2"><?=$this->lang->line("offer_choice")?></th>
                <?php
                $flag=true;
                foreach($transferts_received as $row)
                {
                ?>
                    <tr  <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                        <td >
                            <?php echo $row->player_name; ?>
                        </td>
                        <td >
                            <?php echo anchor('team/team_profil/'.$row->team_sender_id,$teamInfos=$this->team_model->get_team_name($row->team_sender_id));?>
                        </td>
                        <td >
                            <?php echo $row->offer; ?>
                        </td>
                        <td >
                            <form name="form_accept_offer" id="form_accept_offer" method="post">
                                <input type="hidden" name="playerId" value="<?php echo $row->player_id; ?>"/>
                                <input type="hidden" name="teamId" value="<?php echo $row->team_id; ?>"/>
                                <input type="hidden" name="playerName" value="<?php echo $row->player_name; ?>"/>
                                <input type="hidden" name="transfertId" value="<?php echo $row->transfert_id; ?>"/>
                                <input type="button" name="make_offer" class="accept_offer_button input_invisible" value="" onclick="xajax_accept_offer_process(xajax.getFormValues('form_accept_offer'))"/>
                            </form>
                        </td>
                        <td >
                            <form name="form_refuse_offer" id="form_refuse_offer" method="post">
                                <input type="hidden" name="playerId" value="<?php echo $row->player_id; ?>"/>
                                <input type="hidden" name="teamId" value="<?php echo $row->team_id; ?>"/>
                                <input type="hidden" name="playerName" value="<?php echo $row->player_name; ?>"/>
                                <input type="hidden" name="transfertId" value="<?php echo $row->transfert_id; ?>"/>
                                <input type="button" name="make_offer" class="refuse_offer_button input_invisible" value="" onclick="xajax_refuse_offer_process(xajax.getFormValues('form_refuse_offer'))"/>
                            </form>
                        </td>
                    </tr>

                <?php
                }
                ?>
                    <tr id="pagination">
                        <td colspan="11" align="center"></td>
                    </tr>
                </table>