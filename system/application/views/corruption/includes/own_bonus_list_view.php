<?php if(!$holiday){ ?>
                        <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                        <div id="own_offensive">
                            <?php
                            foreach($ownOffensiveMethods as $row)
                            {
                                if($row["qt"]!=0){
                                ?>
                            <form name="form_own_offensive_<?=$row["offensive_method_id"]?>" id="form_own_offensive_<?=$row["offensive_method_id"]?>" method="post">
                                <div class="product_use">
                                    <div class="title_use"><?=$this->lang->line($row["title"]);?></div>
                                    <img class="stade_img_use tooltip" title="<?=$this->lang->line($row["description"]);?>" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/corruption/offensive_methods/<?=$row["image"] ?>" alt="offensive methods" />
                                    <div class="capacity_use"><?=$this->lang->line($row["sector"]);?> +<?=$row["capacity"]; ?></div>
                                    <div class="quantity_use"><label><?=$this->lang->line("bonus_qt");?> </label><?=$row["qt"]?></div>
                                    <input type="hidden" name="methodType" value="<?=corruption_rules::OFFENSIVE_METHOD?>" />
                                    <input type="hidden" name="matchId" value="1<?//=$nextMatch[0]["match_id"]?>" />
                                    <input type="hidden" name="methodId" value="<?=$row["offensive_method_id"]?>" />
                                    <input type="button" class="use_button input_invisible" name="own_offensive_methods" value="" onclick="xajax_add_used_method_process(xajax.getFormValues('form_own_offensive_<?=$row["offensive_method_id"]?>'))"/>
                                </div>
                            </form>
                       <?php 
                                }
                            }
                            ?>
                        </div>
                        <div id="own_defensive">
                            <?php
                            foreach($ownDefensiveMethods as $row)
                            {
                                if($row["qt"]!=0){
                                    ?>


                            <form name="form_own_defensive_<?=$row["defensive_method_id"]?>" id="form_own_defensive_<?=$row["defensive_method_id"]?>" method="post">
                                <div class="product_use">
                                    <div class="title_use"><?=$this->lang->line($row["title"]);?></div>
                                    <img class="stade_img_use" title="<?=$this->lang->line($row["description"]);?>" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/corruption/defensive_methods/<?=$row["image"] ?>" alt="defensive methods" />
                                    <div class="capacity_use"><?=$this->lang->line($row["sector"]);?> +<?=$row["capacity"]; ?></div>
                                    <div class="quantity_use"><label><?=$this->lang->line("bonus_qt");?> </label><?=$row["qt"]?></div>
                                    <input type="hidden" name="methodType" value="<?=corruption_rules::DEFENSIVE_METHOD?>" />
                                    <input type="hidden" name="matchId" value="1<?//=$nextMatch[0]["match_id"]?>" />
                                    <input type="hidden" name="methodId" value="<?=$row["defensive_method_id"]?>" />
                                    <input type="button" class="use_button input_invisible" name="own_defensive_methods" value="" onclick="xajax_add_used_method_process(xajax.getFormValues('form_own_defensive_<?=$row["defensive_method_id"]?>'))"/>
                                </div>
                            </form>
                      <?php     }

                            }
                            ?>
                        </div>
<?php }?>