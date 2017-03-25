<?php if(isset($sponsorTeam)&& empty($sponsorTeam)){ ?>

        <form name="form_accept_sponsor" id="form_accept_sponsor" method="post">
    <?php foreach( $sponsors as $row){ ?>
            <div class="sponsor_item">
                <div class="labeltext"><label><?=$row["sponsor_name"] ?> </label><input checked="checked" type= "radio" name="sponsorId" value="<?=$row["sponsor_id"] ?>" /> </div>
                <?=sponsors_rules::getSponsors($row["link"]);?>
            </div>
    <?php } ?>
            <input type="button" name="accept_sponsor" class="accept_sponsor_button input_invisible" value="" onclick="xajax_add_sponsor_process(xajax.getFormValues('form_accept_sponsor'))"/>
        </form>
<?php }else{?>
    <div style="position:relative;margin-left:auto;margin-right:auto;overflow:auto;background-color: #d2ebfa;color:#626262;
   font-weight:bold;
   width: 500px;margin-top:15px;margin-bottom:15px;border:1px;border-color:#36a0a5;border-style:solid; ">
    <div style="float:left;margin:10px;
         background-image:url(<?=base_url() ?>/images/<?=$this->session->userdata("langage")?>/global/info.png);
    width:32px;
    height:32px;"></div>
    <div style="float:left;
    color:#626262;
    font-size:12px;
    width:400px;
    margin-top:18px;
    font-weight:bold;"><?=str_replace("%data1",$sponsorTeam[0]["value"],$this->lang->line('sponsor_infos2'))?></div>
</div>

   <?php   } ?>