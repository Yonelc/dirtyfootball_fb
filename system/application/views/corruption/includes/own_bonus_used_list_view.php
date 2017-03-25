<?php if(!$holiday){ ?>
                    <div id="bonus_top"></div>
                    <div id="bonus_center">
                    <div id="used_offensive_methods">
                        <?php
                        foreach($usedOffensiveMethods as $row)
                        { ?>
                        <form name="form_used_offensive_methods_<?=$row["used_id"]?>" id="form_used_offensive_methods_<?=$row["used_id"]?>" method="post">
                            <div class="product">
                                <div class="title_product"><?=$this->lang->line($row["title"]);?></div>
                                <input type="hidden" name="methodType" value="<?=$row["method_type"]?>" />
                                <input type="hidden" name="usedId" value="<?=$row["used_id"]?>" />
                                <input type="hidden" name="methodId" value="<?=$row["corruption_id"]?>" />
                                <input type="button" class="delete_bonus input_invisible" name="used_offensive_methods" value="" onclick="xajax_delete_used_method_process(xajax.getFormValues('form_used_offensive_methods_<?=$row["used_id"]?>'))"/>
                            </div>
                        </form>
                  <?php }
                        ?>
                    </div>
                    <div id="used_defensive_methods">
                        <?php
                        foreach($usedDefensiveMethods as $row)
                        { ?>
                        <form name="form_used_defensive_methods_<?=$row["used_id"]?>" id="form_used_defensive_methods_<?=$row["used_id"]?>" method="post">
                            <div class="product">
                                <div class="title_product"><?=$this->lang->line($row["title"]);?></div>
                                <input type="hidden" name="methodType" value="<?=$row["method_type"]?>" />
                                <input type="hidden" name="usedId" value="<?=$row["used_id"]?>" />
                                <input type="hidden" name="methodId" value="<?=$row["corruption_id"]?>" />
                                <input type="button" class="delete_bonus input_invisible" name="used_defensive_methods" value="" onclick="xajax_delete_used_method_process(xajax.getFormValues('form_used_defensive_methods_<?=$row["used_id"]?>'))"/>
                            </div>
                        </form>
                  <?php }
                        ?>
                    </div>
                    </div>
                    <div id="bonus_bottom"></div>
<?php } ?>