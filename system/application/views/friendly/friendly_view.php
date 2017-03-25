<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/li-scroller.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/facebox.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/friendly.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.liveFilter.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/facebox.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.scrollTo.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/friendly.js"></script>
<script type="text/javascript">
  // Load/Call Reverse Ajax
  xajax.callback.global.onRequest = function() { $(".ajax_loading").css("display","block");}
  xajax.callback.global.beforeResponseProcessing = function() {$(".ajax_loading").css("display","none");}
</script>

<title>DirtyFootball Manager</title>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19350813-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript">
function stream(sender,receiver,senderName,formNb){
      var publish = {
      method: 'stream.publish',
      message:  '',
      picture : '<?php echo APP_URL_SERVER ?>images/fr/global/logo_dirty.png',
      link : '<?php echo APP_URL_CANVAS ?>',
      name: senderName+' <?php echo $this->lang->line('stream_message')?>',
      caption: 'DirtyFootball Manager',
      description: '<?php echo $this->lang->line('stream_description')?>',
      actions : { name : 'DirtyFootball Manager', link : '<?php echo APP_URL_CANVAS ?>'}
    };

   FB.api(
        '/'+receiver+'/feed', 'post',publish,
        function(response) {
  
          if (!response || response.error) {
            alert('Error occured');
          } else {
            xajax_join_friendly_process(xajax.getFormValues('form_friendly_'+formNb));
            jQuery(document).trigger('close.facebox');
            
          }
    });
        
}

function close_popin(){
    jQuery(document).trigger('close.facebox');
}
</script>
</head>

<body>

    <?php echo $this->load->view('includes/facebook_js_view');?>
<div id="conteneur">
    <?php echo $this->load->view('includes/applifier_view');?>
    <?php echo $this->load->view('includes/header_view');?>
    <!--<div id="top_frame"></div>-->
    <div class="center_frame">
    <?php echo $this->load->view('includes/main_menu_view');?>
        <div id="content">
            <div id="rotate">
                <ul>
                    <li><a href="#friends"><span><?=$this->lang->line('submenu_friends')?></span></a></li>
                    <li><a href="#ask"><span><?=$this->lang->line('submenu_ask')?></span></a></li>
                    <li><a href="#result"><span><?=$this->lang->line('submenu_result')?></span></a></li>
                    <li><a href="#others"><span><?=$this->lang->line('submenu_others')?></span></a></li>
                    
                </ul>
            <div id="background_tabs">
                <div id="friends">

                    <div id="friendly_join_infos"><?php $this->load->view('includes/infos_view',$messageInfos); ?></div>
                    <div id="search_friend"><label><?php echo $this->lang->line('search')?></label><input type="text" class="filter" name="liveFilter" /></div>
                    <div id="friendsFrame">
                        <ul id="friendsList">

                            <?php
                            $i=0;
                            foreach($friendsList as $friend){
                                /*$tab=explode("_",$friend);*/
                            ?>
                            <li class="friend" id="list_item_<?php echo $friend["uid"] /*echo  $tab[1]*/ ?>">
                                <form name="form_friendly_<?php echo $i ?>" id="form_friendly_<?php echo $i ?>" method="post">

                                      <img src="<?php if(!empty($friend['pic_square']))echo $friend['pic_square'] ?>" alt="pic" />

                                    <div><?php echo substr($friend['first_name']." ".$friend['last_name'],0,16) ?></div>
                                    <input type="hidden" name="receiver" value="<?php echo $friend["uid"] /*echo  $tab[1]*/ ?>" />
                                    <!--<div ><input type="button" class="btn_defier input_invisible" name="join_friendly_<?php echo $i ?>" value="" onclick="stream('<?php echo $this->session->userdata("userId") ?>','<?php echo $friend["uid"] /*echo  $tab[1]*/ ?>','<?php echo $this->session->userdata("username")." ".$this->session->userdata("userfirstname") ?>','<?php echo $i ?>')"/></div>-->
                                    <div><a href="#popin_<?php echo $i ?>" rel="facebox"><div class="btn_defier"></div></a></div>
                                    <div id="popin_<?php echo $i ?>" style="display:none">
                                        <a name="popin_<?php echo $i ?>"></a>
                                        <div class="ajax_loading" style="display:none;width:160px;margin:5px auto 5px auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                                        <div class="message_defi">
     
                                            <div style="float:left;margin:0 10px 10px 0"><img src="<?php if(!empty($friend['pic_square']))echo $friend['pic_square'] ?>" alt="pic" /></div>


                                            <?php echo str_replace('%data1',$friend['first_name']." ".$friend['last_name'],$this->lang->line("popin_msg"))?>
                                        </div>
                                        <div class="btn">
                                            <input type="button" class="btn_defier input_invisible" name="join_friendly_<?php echo $i ?>" value="" onclick="javascript:stream('<?php echo $this->session->userdata("userId") ?>','<?php echo $friend["uid"] /*echo  $tab[1]*/ ?>','<?php echo $this->session->userdata("username")." ".$this->session->userdata("userfirstname") ?>','<?php echo $i ?>')"/>
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
                    
                </div>
                <div id="ask">
                    <div id="friendly_request_infos"></div>
                    <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                    <div id="requests_list">
                        <table id="tab_offers_received">
                            <th><?=$this->lang->line("request_player")?></th>
                            <th><?=$this->lang->line("request_team")?></th>
                            <th colspan="2"><?=$this->lang->line("request_choice")?></th>
                        <?php
                        $flag=true;
                        $i=0;
                        foreach($requests as $row)
                        {
                        ?>
                            <tr  <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                                <td >
                                    <?php echo $row["username"]." ".$row["userfirstname"]; ?>
                                </td>
                                <td >
                                    <?php echo anchor('team/team_profil/'.$row["team_id"],$teamInfos=$this->team_model->get_team_name($row["team_id"]));?>
                                </td>
                                <td >
                                    <form name="form_accept_request_<?php echo $i ?>" id="form_accept_request_<?php echo $i ?>" method="post">
                                        <input type="hidden" name="sender" value="<?php echo $row["user_id"]; ?>"/>
                                        <input type="button" name="accept_request" class="accept_request_button input_invisible" value="" onclick="xajax_accept_request_process(xajax.getFormValues('form_accept_request_<?php echo $i ?>'))"/>
                                    </form>
                                </td>
                                <td >
                                    <form name="form_refuse_request_<?php echo $i ?>" id="form_refuse_request_<?php echo $i ?>" method="post">
                                        <input type="hidden" name="sender" value="<?php echo $row["user_id"]; ?>"/>
                                        <input type="button" name="refuse_request"  class="refuse_request_button input_invisible" value="" onclick="xajax_refuse_request_process(xajax.getFormValues('form_refuse_request_<?php echo $i ?>'))"/>
                                    </form>
                                </td>
                            </tr>

                        <?php $i++;
                        }
                        ?>
                            <tr id="pagination">
                                <td colspan="11" align="center"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="result">
                        <div id="match_championship">
                            <?php if(!empty($friendlyMatchs)){?>
                                <div id="middle_match">
                            <?php
                                foreach($friendlyMatchs as $row)
                                { ?>
                                <div class="match">
                                    <div class="match_title"><div class="date"><?php echo $row["date"] ?></div></div>
                                    <div class="equipes">
                                        <div class="home_team"><?php echo anchor("team/team_profil/".$row["home_team_id"],$row["home_team_name"]) ?></div>
                                        <div class="score">
                                              <?php echo $row["home_team_score"] ?> - <?php echo $row["away_team_score"] ?>
                                        </div>
                                        <div class="away_team"><?php echo anchor("team/team_profil/".$row["away_team_id"],$row["away_team_name"]) ?></div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                                 </div>
                          <?php

                          }else{
                               //$data["messageInfos"]=$this->lang->line("scheduler_message_infos");
                               //$this->load->view('includes/infos_view',$data);
                          }
                          ?>
                         </div>
                </div>
                <div id="others">
                        <div id="match_championship">
                            <?php if(!empty($othersResults)){?>
                                <div id="middle_match">
                            <?php
                                foreach($othersResults as $row)
                                { ?>
                                <div class="match">
                                    <div class="match_title"><div class="date"><?php echo $row["date"] ?></div></div>
                                    <div class="equipes">
                                        <div class="home_team"><?php echo anchor("team/team_profil/".$row["home_team_id"],$row["home_team_name"]) ?></div>
                                        <div class="score">
                                              <?php echo $row["home_team_score"] ?> - <?php echo $row["away_team_score"] ?>
                                        </div>
                                        <div class="away_team"><?php echo anchor("team/team_profil/".$row["away_team_id"],$row["away_team_name"]) ?></div>
                                    </div>
                                </div>
                            <?php
                                }
                            ?>
                                 </div>
                          <?php

                          }else{
                               //$data["messageInfos"]=$this->lang->line("scheduler_message_infos");
                               //$this->load->view('includes/infos_view',$data);
                          }
                          ?>
                         </div>
                </div>
            </div>
       </div>
    </div>
  </div>
<?php echo $this->load->view('includes/footer_view');?>

</div>
</body>
</html>
