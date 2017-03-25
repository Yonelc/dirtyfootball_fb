                    <div id="training_infos">  </div>
                    <div id="progress_tube">
                        <div id="tubes">
                            <div class="tube">
                                <div class="title_tube"><?=$this->lang->line('GB'); ?></div>
                                <?=training_rules::getTube($trainingInfos[0]["gb"]);?>
                            </div>
                            <div class="tube">
                                <div class="title_tube"><?=$this->lang->line('DEF'); ?></div>
                                <?=training_rules::getTube($trainingInfos[0]["def"]);?>
                            </div>
                            <div class="tube">
                                <div class="title_tube"><?=$this->lang->line('MILL'); ?></div>
                                <?=training_rules::getTube($trainingInfos[0]["mil"]);?>
                            </div>
                            <div class="tube">
                                <div class="title_tube"><?=$this->lang->line('ATT'); ?></div>
                                <?=training_rules::getTube($trainingInfos[0]["att"]);?>
                            </div>
                        </div>
                    </div>
                    <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                    <div id="training_buttons">
                        <form name="form_train_gb" id="form_train_gb"  >
                            <?php if($trainingInfos[0]["gb_estate"]==0){ ?>
                            <input type="button"  value="" id="training_gb" class="input_invisible" onclick="xajax_train_team_process(xajax.getFormValues('form_train_gb'))"/>
                            <?php }else{?>
                            <input type="button"  value="" id="training_gb_off" class="input_invisible" />
                            <?php }?>
                            <input type="hidden" name="type" value="<?=training_rules::GB_TYPE?>" />
                        </form>
                        <form name="form_train_def" id="form_train_def"  >
                            <?php if($trainingInfos[0]["def_estate"]==0){ ?>
                            <input type="button"  value="" id="training_def" class="input_invisible" onclick="xajax_train_team_process(xajax.getFormValues('form_train_def'))"/>
                            <?php }else{?>
                            <input type="button"  value="" id="training_def_off" class="input_invisible" />
                            <?php }?>
                            <input type="hidden" name="type" value="<?=training_rules::DEF_TYPE?>" />
                        </form>
                        <form name="form_train_mil" id="form_train_mil"  >
                            <?php if($trainingInfos[0]["mil_estate"]==0){ ?>
                            <input type="button"  value="" id="training_mil" class="input_invisible" onclick="xajax_train_team_process(xajax.getFormValues('form_train_mil'))"/>
                            <?php }else{?>
                            <input type="button"  value="" id="training_mil_off" class="input_invisible" />
                            <?php }?>
                            <input type="hidden" name="type" value="<?=training_rules::MIL_TYPE?>" />
                        </form>
                        <form name="form_train_att" id="form_train_att"  >
                            <?php if($trainingInfos[0]["att_estate"]==0){ ?>
                            <input type="button"  value="" id="training_att" class="input_invisible" onclick="xajax_train_team_process(xajax.getFormValues('form_train_att'))"/>
                            <?php }else{?>
                            <input type="button"  value="" id="training_att_off" class="input_invisible" />
                            <?php }?>
                            <input type="hidden" name="type" value="<?=training_rules::ATT_TYPE?>" />
                        </form>
                    </div>