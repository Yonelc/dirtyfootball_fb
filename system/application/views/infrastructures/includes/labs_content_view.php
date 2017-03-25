
<div id="labs_infos"></div>
<div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
               <?php foreach($laboratories as $row){
                    $type=infrastructures_rules::getCurrencyType($row["type"]);
                    ?>
                    <form name="form_laboratory_<?=$row["laboratory_id"]?>" id="form_laboratory_<?=$row["laboratory_id"]?>" method="post">
                            <div class="product_<?=$type ?>">
                                <div class="title"><?=$this->lang->line($row["title"]);?><?php //echo $row["title"] ?></div>
                                <img class="stade_img tooltip" title="<?=$this->lang->line($row["description"]);?>" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/building/laboratories/<?=$row["image"] ?>" alt="stade" />
                                <div class="price"><?php echo $row["value"]; ?></div>
                                <div class="capacity"><?=$this->lang->line('debloque_labs');?> <?php echo $row["level"] ?></div>
                                <div class="level"><?=$this->lang->line('stade_niveau');?> <?php echo $row["level"] ?></div>
                                <div id="laboratory_<?=$row["laboratory_id"]?>"></div>
                                <input type="hidden" name="laboratoryId" value="<?=$row["laboratory_id"]?>" />
                       <?php
                            $state=infrastructures_rules::getAction($my_infos[0][$type], $row["value"], $row["laboratory_id"], $myLaboratory,$my_infos[0]["level"],$row["level"]);

                            switch($state){

                                    case infrastructures_rules::BUY_BUTTON:
                                         ?><input type="button" class="buy_button input_invisible" name="buy_laboratory" value="" onclick="xajax_buy_laboratory_process(xajax.getFormValues('form_laboratory_<?=$row["laboratory_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::SELL_BUTTON:
                                         ?><input type="button" class="sell_button input_invisible" name="sell_laboratory" value="" onclick="xajax_sell_laboratory_process(xajax.getFormValues('form_laboratory_<?=$row["laboratory_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::GET_DIRTYGOLD_BUTTON:
                                        ?><input type="button" class="get_dirty_gold input_invisible" name="get_dirty_gold" value="" /><?php
                                    break;

                                    case infrastructures_rules::LOCKED_BUTTON:
                                        ?><input type="button" class="locked input_invisible" name="locked" value="" /><?php
                                    break;

                                    default:

                                    break;
                                }
                        ?>
                            </div>
                    </form>
                <?php } ?>