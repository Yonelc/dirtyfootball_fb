<table>
      <th><?=$this->lang->line("offer_player")?></th>
      <th><?=$this->lang->line("transfert_age")?>Age</th>
      <th><?=$this->lang->line("transfert_position")?></th>
      <th><?=$this->lang->line("transfert_experience")?></th>
      <?php foreach($custom_transferts as $transfert){ ?>
      <tr>
          <td><?php echo $transfert->player_name; ?></td>
          <td><?php echo $transfert->age; ?></td>
          <td><?=$this->lang->line($transfert->position)?></td>
          <td><?php echo $transfert->experience_pt; ?></td>
      </tr>
      <?php } ?>
</table>
