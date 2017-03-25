   <form name="form_team_validation" id="form_team_validation"  >
   <?php if($team_ok){ ?>
   <input type="button" class="input_invisible" id="validation_button" value="<?=$this->lang->line('team_validation')?>" onclick="xajax_validation_team_process(xajax.getFormValues('form_team_validation'))" />
   <?php }else{ ?>
   <input type="button" class="input_invisible" id="validation_button_off" value="<?=$this->lang->line('team_validation')?>" />
   <?php } ?>
   </form>
