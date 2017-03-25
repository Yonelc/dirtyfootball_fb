                        <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                        <div id="form_creation">
                            <div id="championship_infos"></div>
                            <div id="create_championship_top"></div>
                            <div id="create_championship_center">
                                 <form name="form_create_championship" id="form_create_championship" method="post">
                                     <div class="create_champ_input"><label><?=$this->lang->line("create_champ_name")?></label><input type="text" id="championshipName" name="championshipName" value=""  class="validate[required,length[0,100]]"/></div>
                                     <div class="create_champ_input"><label><?=$this->lang->line("create_champ_level")?> </label><?=$this->session->userdata('level')?></div>
                                     <div class="create_champ_input"><label><?=$this->lang->line("create_champ_cost")?> </label>1 <img id="cost_dirtygold" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/dirtygold.png" alt="DirtyGold"/></div>
                                     <input type="button" class="create_championship input_invisible" name="create_championship" value="" onclick="xajax_create_championship_process(xajax.getFormValues('form_create_championship'))"/>
                                 </form>
                            </div>
                            <div id="create_championship_bottom"></div>
                        </div>