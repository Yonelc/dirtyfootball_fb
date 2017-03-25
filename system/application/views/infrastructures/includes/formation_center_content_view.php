<div id="loadingMessage"></div>
                <?php  foreach($formation_centers as $row){
                        $type=infrastructures_rules::getCurrencyType($row["type"]);
                    ?>


                <form name="form_formation_<?=$row["formation_center_id"]?>" id="form_formation_<?=$row["formation_center_id"]?>" method="post">
                        <div class="product_<?=$type ?>">
                            <div class="title"><p><?php echo $row["title"] ?></p></div>
                            <img class="stade_img" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/building/formation_centers/<?=$row["image"] ?>" alt="formation center" />
                            <div class="price"><?php echo $row["value"]; ?></div>
                            <div class="capacity"><?php echo $row["capacity"] ?><label></label></div>
                            <div class="level"><?php echo $row["level"] ?></div>

                            <div id="formation_center_<?=$row["formation_center_id"]?>"></div>
                            <input type="hidden" name="formationCenterId" value="<?=$row["formation_center_id"]?>" />
                     <?php
                            $state=infrastructures_rules::getAction($my_infos[0][$type], $row["value"], $row["formation_center_id"], $myFormationCenter,$my_infos[0]["level"],$row["level"]);

                            switch($state){

                                    case infrastructures_rules::BUY_BUTTON:
                                         ?><input type="button" class="buy_button input_invisible" name="buy_formation_center" value="" onclick="xajax_buy_formation_center_process(xajax.getFormValues('form_formation_<?=$row["formation_center_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::SELL_BUTTON:
                                         ?><input type="button" class="sell_button input_invisible" name="sell_formation_center" value="" onclick="xajax_sell_formation_center_process(xajax.getFormValues('form_formation_<?=$row["formation_center_id"]?>'))"/><?php
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