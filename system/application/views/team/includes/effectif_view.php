
<div id="effectif_center">
    <?php $this->load->view("includes/infos_view",$messageInfos) ?>
    <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
     <table >

       <th></th>
       <th><?=$this->lang->line('effectif_joueur')?></th>
       <th><?=$this->lang->line('effectif_nat')?></th>
       <th><?=$this->lang->line('effectif_age')?></th>
       <th><?=$this->lang->line('effectif_att')?></th>
       <th><?=$this->lang->line('effectif_mil')?></th>
       <th><?=$this->lang->line('effectif_def')?></th>
       <th><?=$this->lang->line('effectif_gb')?></th>
       <th><?=$this->lang->line('effectif_type')?></th>
       <th><?=$this->lang->line('effectif_transfert')?></th>
        <?php
        $flag=true;
        foreach($players as $player){
            ?>

        <tr <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
            <td><?php echo players_rules::getInjuryFlag($player->injury) ?></td>
            <td><?php echo anchor("transferts/player_profil/".$player->player_id,$player->player_name) ?></td>
            <td><img src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/flags/<?php echo $player->nationality ?>.png" /></td>
            <td><?php echo $player->age ?></td>
            <td ><div class="att"><?php echo $player->experience_att ?></div></td>
            <td ><div class="mil"><?php echo $player->experience_mil ?></div></td>
            <td ><div class="def"><?php echo $player->experience_def ?></div></td>
            <td ><div class="gb"><?php echo $player->experience_gb ?></div></td>
            <td><?=$this->lang->line($player->position); ?></td>
            <?php if($player->statut==0){ ?>
            <td><a href="#effectif" onclick="xajax_changeTransfertStatut_process('<?php echo $player->player_id ?>','1')"><?=$this->lang->line('effectif_no')?></a></td>
            <?php }else{ ?>
            <td><a href="#effectif" onclick="xajax_changeTransfertStatut_process('<?php echo $player->player_id ?>','0')"><?=$this->lang->line('effectif_yes')?></a></td>
            <?php } ?>
        </tr>

        <?php } ?>
      <tr id="pagination">
        <td colspan="12" align="center"></td>
      </tr>
      </table>
  </div>



