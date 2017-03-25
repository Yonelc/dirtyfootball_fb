
                    <div id="defensive_infos"></div>
                    <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                    <?php foreach($defensiveMethods as $row){
                        $type=corruption_rules::getCurrencyType($row["type"]);
                        ?>

                    <form name="form_defensive_<?=$row["corruption_defensive_id"]?>" id="form_defensive_<?=$row["corruption_defensive_id"]?>" method="post">
                        <div class="product_<?=$type ?>">
                            <div class="title"><?=$this->lang->line($row["title"]);?></div>
                            <img class="stade_img tooltip" title="<?=$this->lang->line($row["description"]);?>" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/corruption/defensive_methods/<?=$row["image"] ?>" alt="defensive methods" />
                            <div class="price"><?=$row["value"]; ?></div>
                            <div class="capacity"><?=$this->lang->line($row["sector"]);?> +<?=$row["capacity"]; ?></div>
                            <div class="level"><label><?=$this->lang->line("bonus_labs_level");?> </label><?=$row["lab_level"]; ?></div>
                            <input type="hidden" name="defensiveMethodId" value="<?=$row["corruption_defensive_id"]?>" />
                            <?php
                            $state=corruption_rules::getAction($my_infos[0][$type],$row["value"],$ownLaboratoryLevel,$row["lab_level"],$ownFriendsLevel,$row["friends_level"]);

                            switch($state){

                                    case corruption_rules::BUY_BUTTON:
                                         ?><input type="button" class="buy_button input_invisible" name="buy_defensive_method" value="" onclick="xajax_buy_defensive_method_process(xajax.getFormValues('form_defensive_<?=$row["corruption_defensive_id"]?>'))"/><?php
                                    break;

                                    case corruption_rules::GET_DIRTYGOLD_BUTTON:
                                        ?><input type="button" class="get_dirty_gold input_invisible" name="get_dirty_gold" value="" onclick="self.location.href=<?=base_url()?>'/index.php/payment/index'"/><?php
                                    break;
                                    case corruption_rules::FRIENDS_BUTTON:
                                        ?><input type="button" class="friends_button input_invisible" name="friends" value="" onclick="self.location.href='<?php echo base_url() ?>index.php/friends'" /><?php
                                    break;
                                    default:
                                        ?><input type="button" class="locked input_invisible" name="locked" value="" /><?php
                                    break;
                                }
                            ?>
                        </div>
                    </form>
                    <?php } ?>