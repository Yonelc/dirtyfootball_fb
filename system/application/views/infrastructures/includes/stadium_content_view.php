
                <div id="stadium_infos"></div>
                <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                <?php foreach($stadiums as $row){
                        $type=infrastructures_rules::getCurrencyType($row["type"]);
                    ?>
                    <form name="form_stadium_<?=$row["stadium_id"]?>" id="form_stadium_<?=$row["stadium_id"]?>" method="post">
                        <div class="product_<?=$type ?>">
                            <div class="title"><?=$this->lang->line($row["title"]);?><?php //echo $row["title"] ?></div>
                            <img class="stade_img tooltip" title="<?=$this->lang->line($row["description"]);?>"  src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/building/stadiums/<?=$row["image"]?>" alt="stade" />
                            <div class="price"><?php echo $row["value"];  ?></div>
                            <div class="capacity"><?php echo $row["capacity"] ?><label> <?=$this->lang->line('stade_place');?></label></div>
                            <div class="level"><label><?=$this->lang->line('stade_niveau');?> </label><?php echo $row["level"] ?></div>
                            <div id="stadium_<?=$row["stadium_id"]?>"></div>
                            <input type="hidden" name="stadiumId" value="<?=$row["stadium_id"]?>" />
                            <?php
                            //echo "mon ".$my_infos[0][$type]." prix ".$row["value"]." mon nv ".$my_infos[0]["level"]." le nv".$row["level"];

                            $state=infrastructures_rules::getAction($my_infos[0][$type], $row["value"], $row["stadium_id"], $myStadium[0]["stadium_id"],$my_infos[0]["level"],$row["level"]);

                            switch($state){

                                    case infrastructures_rules::BUY_BUTTON:
                                         ?><input type="button" class="buy_button input_invisible" name="buy_stadium" value="" onclick="xajax_buy_stadium_process(xajax.getFormValues('form_stadium_<?=$row["stadium_id"]?>'))"/><?php
                                    break;

                                    case infrastructures_rules::SELL_BUTTON:
                                         ?><input type="button" class="sell_button input_invisible" name="sell_stadium" value="" onclick="xajax_sell_stadium_process(xajax.getFormValues('form_stadium_<?=$row["stadium_id"]?>'))"/><?php
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