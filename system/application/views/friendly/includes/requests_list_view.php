<table id="tab_offers_received">
        <th><?=$this->lang->line("request_player")?></th>
        <th><?=$this->lang->line("request_team")?></th>
        <th colspan="2"><?=$this->lang->line("request_choice")?></th>
    <?php
    $flag=true;
    foreach($requests as $row)
    {
    ?>
        <tr  <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
            <td >
                <?php echo $row["username"]." ".$row["userfirstname"]; ?>
            </td>
            <td >
                <?php echo anchor('team/team_profil/'.$row["team_id"],$teamInfos=$this->team_model->get_team_name($row["team_id"]));?>
            </td>
            <td >
                <form name="form_accept_request" id="form_accept_request" method="post">
                    <input type="hidden" name="sender" value="<?php echo $row["user_id"]; ?>"/>
                    <input type="button" name="accept_request" class="accept_request_button input_invisible" value="" onclick="xajax_accept_request_process(xajax.getFormValues('form_accept_request'))"/>
                </form>
            </td>
            <td >
                <form name="form_refuse_request" id="form_refuse_request" method="post">
                    <input type="hidden" name="sender" value="<?php echo $row["user_id"]; ?>"/>
                    <input type="button" name="refuse_request" class="refuse_request_button input_invisible" value="" onclick="xajax_refuse_request_process(xajax.getFormValues('form_refuse_request'))"/>
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