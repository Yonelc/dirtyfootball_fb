<?php echo $this->load->view('includes/facebook_asyn_js_view');?>
<div id="friendly_join_infos"></div>
<div id="search_friend"><label><?php echo $this->lang->line('search')?></label><input type="text" class="filter" name="liveFilter" /></div>
<div id="friendsFrame">
<ul id="friendsList">

    <?php
    $i=0;
    foreach($friendsList as $friend){
        $tab=explode("_",$friend);
    ?>
    <li class="friend" id="list_item_<?php echo $tab[1] ?>">
        <form name="form_friendly_<?php echo $i ?>" id="form_friendly_<?php echo $i ?>" method="post">
              <?php //if (ereg("MSIE 8.0", $_SERVER["HTTP_USER_AGENT"])) //pour détecter si le navigateur est IE6
                    //{ ?>

                         <!-- <div><img src="<?=base_url() ?>images/<?=$this->session->userdata("langage")?>/global/profile-pic.jpg" width="50" height="50" alt="profile-pic"/></div>-->

              <?php //}else{ ?>
                          <!--<div><fb:profile-pic uid="<?php echo $tab[1] ?>"  linked="false" facebook-logo="false" size="square"> <fb:profile-pic/></div>-->
              <?php //} ?>

            <div><img src="<?=base_url() ?>images/<?=$this->session->userdata("langage")?>/global/profile-pic.jpg" width="50" height="50" alt="profile-pic"/></div>
            <div><?php echo substr($tab[0],0,16) ?></div>
            <input type="hidden" name="receiver" value="<?php echo $tab[1] ?>" />
            <!--<div ><input type="button" class="btn_defier input_invisible" name="join_friendly_<?php echo $i ?>" value="" onclick="stream('<?php echo $this->session->userdata("userId") ?>','<?php echo $tab[1] ?>','<?php echo $this->session->userdata("username")." ".$this->session->userdata("userfirstname") ?>','<?php echo $i ?>')"/></div>-->
            <div><a href="#popin_<?php echo $i ?>" rel="facebox"><div class="btn_defier"></div></a></div>
            <div id="popin_<?php echo $i ?>" style="display:none">
                <div class="ajax_loading" style="display:none;width:160px;margin:5px auto 5px auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                <div class="message_defi">
                      <?php //if (ereg("MSIE 8.0", $_SERVER["HTTP_USER_AGENT"])) //pour détecter si le navigateur est IE6
                            //{ ?>

                                  <!--<div style="float:left;margin:0 10px 10px 0"><img src="<?=base_url() ?>images/<?=$this->session->userdata("langage")?>/global/profile-pic.jpg" width="50" height="50" alt="profile-pic"/></div>-->

                      <?php //}else{ ?>
                                  <div style="float:left;margin:0 10px 10px 0"><fb:profile-pic uid="<?php echo $tab[1] ?>"  linked="false" facebook-logo="false" size="square"> <fb:profile-pic/></div>
                      <?php //} ?>

                    <?php echo str_replace('%data1',$tab[0],$this->lang->line("popin_msg"))?>
                </div>
                <div class="btn">
                    <input type="button" class="btn_defier input_invisible" name="join_friendly_<?php echo $i ?>" value="" onclick="javascript:stream('<?php echo $this->session->userdata("userId") ?>','<?php echo $tab[1] ?>','<?php echo $this->session->userdata("username")." ".$this->session->userdata("userfirstname") ?>','<?php echo $i ?>')"/>
                    <input type="button" class="btn_cancel input_invisible" name="cancel_friendly_<?php echo $i ?>" value="" onclick="javascript:close_popin()"/>
                </div>
           </div>
        </form>
    </li>
    <?php
    $i++;
    } ?>
</ul>
</div>