
<table id="teams_offers">
<?php
    $flag=TRUE;
    foreach($list_offer as $row)
    { ?>
        <tr <?php //if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
            <td class="team_name"><?php echo $row->team_name ?></td>
            <td class="team_offer"> <?php echo $row->offer ?> </td>
            <td class="value_logo"> <img id="value" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/wollars.png" alt="Wollars"/></td>
        </tr>
<?php }
?>
</table>