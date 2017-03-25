<div id="options">
    <div id="infos_options"></div>
    <fieldset>
        <legend align=top> <?=$this->lang->line('change_langage')?> </legend>
        <label id="holiday_label"><?=$this->lang->line('langage')?></label>
        <?php $attributes = array('id' => 'form_lang','name' => 'form_lang'); ?>
        <?php echo form_open("game/changeLangage",$attributes);?>
            <select name="lang" onchange="javascript:this.form.submit();">
                <option <?php if($this->session->userdata('langage')=="fr")echo 'selected="selected"'; ?> value="fr"><?=$this->lang->line('langage_french')?></option>
                <option <?php if($this->session->userdata('langage')=="eng")echo 'selected="selected"'; ?> value="eng"><?=$this->lang->line('langage_english')?></option>
            </select>
        </form>
    </fieldset>
    <fieldset>
        <legend align=top> <?=$this->lang->line('confirm_assistant')?> </legend>
        <label id="holiday_label"><?=$this->lang->line('holidays')?></label>
        <form name="form_holiday" id="form_holiday" method="post">
            <?php if(!$holiday){ ?>
            <input type="hidden" name="holiday" value="1" />
            <input type="button" class="holiday_button input_invisible" name="holiday_method" value="" onclick="xajax_holiday_process(xajax.getFormValues('form_holiday'))"/>
            <?php }else{ ?>
            <input type="hidden" name="holiday" value="0" />
            <input type="button" class="holiday_back_button input_invisible" name="holiday_method" value="" onclick="xajax_holiday_process(xajax.getFormValues('form_holiday'))"/>
            <?php } ?>
        </form>
    </fieldset>
</div>