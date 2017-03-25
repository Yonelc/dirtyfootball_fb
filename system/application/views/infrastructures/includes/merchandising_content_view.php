<div id="loadingMessage"></div>
               <?php foreach($merchandisings as $row){
                    $type=infrastructures_rules::getCurrencyType($row["type"]);
                    ?>

                <form name="form_merchandising_<?=$row["merchandising_id"]?>" id="form_merchandising_<?=$row["merchandising_id"]?>" method="post">
                        <div class="product_<?=$type ?>">
                            <div class="title"><?php echo $row["title"] ?></div>
                            <img class="stade_img" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/building/merchandisings/<?=$row["image"] ?>" alt="stade" />
                            <div class="price"><?php echo $row["value"]; ?></div>
                            <div class="capacity"><?php echo $row["capacity"] ?></div>
                            <div class="level"><?php echo $row["level"] ?></div>

                            <div id="merchandising_<?=$row["merchandising_id"]?>"></div>
                            <input type="hidden" name="merchandisingId" value="<?=$row["merchandising_id"]?>" />

                      <?php
                            $state=infrastructures_rules::getAction($my_infos[0][$type], $row["value"], $row["merchandising_id"], $myMerchandising,$my_infos[0]["level"],$row["level"]);

                            switch($state){

                                    case infrastructures_rules::BUY_BUTTON:
                                         ?><input type="button" class="buy_button input_invisible" name="buy_merchandising" value="" onclick="xajax_buy_merchandising_process(xajax.getFormValues('form_merchandising_<?=$row["merchandising_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::SELL_BUTTON:
                                         ?><input type="button" class="sell_button input_invisible" name="sell_merchandising" value="" onclick="xajax_sell_merchandising_process(xajax.getFormValues('form_merchandising_<?=$row["merchandising_id"]?>'))"/><?php
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