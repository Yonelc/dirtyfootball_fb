<div class="choose_price">
    <br/>
    <form name="form_price" id="form_price"  >
        <?php foreach($prices as $price){ ?>
        <div class="cadre_prix">
            <div class="prix">
        <div class="value_radio"><input type="radio" checked="checked" name="code" value="<?=$price["code"] ?>" /> </div>
        <div class="value_dirtygold" style="width:30px;">&nbsp;&nbsp;<?=$price["gold"]?></div>
        <div class="value_logo"><img  src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/dirtygold.png" alt="Dirtygold"/> </div>
        <div class="value_price" style="width:70px;">&nbsp;&nbsp;<?=$price["prix"]." ".$price["devise"] ?></div>
        <div class="value_payment">&nbsp;&nbsp;<?=payment_rules::getPaymentLogo($price["type"]) ?></div>
            </div>
        </div>
        <?php } ?><br/><br/>
        <input type="button" name="buy" class="buy_button input_invisible" value="" onclick="xajax_list_prices_process(xajax.getFormValues('form_price'))"/>
    </form>
</div>