<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/transfert.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/countdown.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jExpand.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/countdown.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>js/transferts.js"></script>
<script type="text/javascript">
  // Load/Call Reverse Ajax
  xajax.callback.global.onRequest = function() { $(".ajax_loading").css("display","block");}
  xajax.callback.global.beforeResponseProcessing = function() {$(".ajax_loading").css("display","none");}


</script>
<title>Transferts</title>
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
</head>

<body>
    <?php echo $this->load->view('includes/facebook_js_view');?>
<div id="conteneur">
    <?php echo $this->load->view('includes/applifier_view');?>
    <?php echo $this->load->view('includes/header_view');?>
    <div class="center_frame">
    <?php echo $this->load->view('includes/main_menu_view');?>
        <div id="content">

        <div id="rotate">
            <ul>
                <li><a href="#transferts"><span><?=$this->lang->line("submenu_transfert")?></span></a></li>
                <li><a href="#enchere"><span><?=$this->lang->line("submenu_enchere")?></span></a></li>
                <li><a href="#offers_send"><span><?=$this->lang->line("submenu_offer_sent")?></span></a></li>
                <li><a href="#offers_received"><span><?=$this->lang->line("submenu_offer_received")?></span></a></li>

            </ul>
            <div id="background_tabs">
            <div id="transferts">
                <div id="research">

                         <?php $attributes = array('id' => 'form_research','name' => 'form_research'); ?>
                         <?php echo form_open("transferts/research_transferts",$attributes);?>
                             <div id="criteres">
                             <label for="Nom du joueur"><?=$this->lang->line("search_name")?> </label>
                             <input type="text"  name="player_name" value="" />
                         
                         
                             <label for="Nom du joueur"><?=$this->lang->line("search_type")?></label>
                             
                             <select name="player_position" >
                                <option value="all" selected="selected"><?=$this->lang->line("search_all")?></option>
                                <option value="GB"><?=$this->lang->line("search_gb")?></option>
                                <option value="DEF"><?=$this->lang->line("search_def")?></option>
                                <option value="MILL"><?=$this->lang->line("search_mil")?></option>
                                <option value="ATT"><?=$this->lang->line("search_att")?></option>
                             </select>
                         
                            <label for="Nom du joueur"><?=$this->lang->line("search_age")?></label>
                            
                            <select name="player_age" >
                                     <option value="all" selected="selected"><?=$this->lang->line("search_all")?></option>
                              <?php  for($i=17;$i<=35;$i++){ ?>
                                     <option value="<?php echo $i ?>"><?php echo $i ?></option>
                              <?php  } ?>
                            </select>
                         
                             <label for="Prix du joueur"><?=$this->lang->line("search_price")?></label>
                             
                             <select name="player_value" >
                                <option value="all" selected="selected"><?=$this->lang->line("search_all")?></option>
                                <option value="1000000">< 1 000 000</option>
                                <option value="5000000">< 5 000 000</option>
                                <option value="10000000">< 10 000 000</option>
                                <option value="20000000">< 20 000 000</option>
                                <option value="50000000">< 50 000 000</option>
                                <option value="100000000">< 100 000 000</option>
                             </select>
                             </div>
                
                             <div id="research_submit">
                                <input type="submit" id="research_ok" class="input input_invisible" value=""  />
                             </div>
                         </form>
                  </div>
            
            <div id="transfert">

                <div id="transfert_center">
                    <table id="transfert_table">
                       <th><?=$this->lang->line("transfert_player")?></th>
                       <th><?=$this->lang->line("transfert_nat")?></th>
                       <th><?=$this->lang->line("transfert_age")?></th>
                       <th><?=$this->lang->line("transfert_position")?></th>
                       <th><?=$this->lang->line("transfert_wollars")?></th>

                    <?php
                        //put a num on an offer
                        $numOffer=0;
                        $flag=true;
                        foreach($transferts as $transfert){ ?>
                        <tr  <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                            <td>
                                <?php echo anchor('transferts/player_profil/'.$transfert->player_id, $transfert->player_name); ?>

                            </td>
                            <td><img src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/flags/<?php echo $transfert->nationality ?>.png" /></td>
                            <td><?php echo $transfert->age; ?></td>
                            <td><?=$this->lang->line($transfert->position); ?></td>
                            <td><?php echo $transfert->value; ?></td>
                         </tr>
                    <?php
                        $numOffer++;
                    } ?>
                    <tr id="pagination">
                        <td colspan="11" align="center">
                        <?php echo $this->pagination->create_links(); ?>
                        </td>
                    </tr>
                    </table>
                    </div>
                </div>
            </div>
            <div id="offers_send">
                <div id="message_offer_sent"></div>
                <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                <table id="tab_offers_sent">
                    <th><?=$this->lang->line("offer_player")?></th>
                    <th><?=$this->lang->line("offer_team")?></th>
                    <th><?=$this->lang->line("offer_offer")?></th>
                    <th><?=$this->lang->line("offer_choice")?></th>
                <?php
                $flag=true;
                foreach($transferts_sent as $row)
                {
                ?>
                    <tr  <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                        <td >
                            <?php echo $row->player_name; ?>
                        </td>
                        <td >
                            <?php if($row->team_receiver_id!=0)echo anchor('team/tream_profil/'.$row->team_receiver_id,$teamInfos=$this->team_model->get_team_name($row->team_receiver_id));?>
                        </td>
                        <td >
                            <?php echo $row->offer; ?>
                        </td>
                        <td >
                            <form name="form_cancel_offer" id="form_cancel_offer" method="post">
                                <input type="hidden" name="playerId" value="<?php echo $row->player_id; ?>"/>
                                <input type="hidden" name="playerName" value="<?php echo $row->player_name; ?>"/>
                                <input type="hidden" name="teamId" value="<?php echo $row->team_id; ?>"/>
                                <input type="hidden" name="transfertId" value="<?php echo $row->transfert_id; ?>"/>
                                <input type="button" name="cancel_offer" class="cancel_offer_button input_invisible" value="" onclick="xajax_cancel_offer_process(xajax.getFormValues('form_cancel_offer'))"/>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
                    <tr id="pagination">
                        <td colspan="11" align="center"></td>
                    </tr>
                </table>
            </div>
            <div id="offers_received">
                <div id="message_offer_received"></div>
                <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                <table id="tab_offers_received">
                    <th><?=$this->lang->line("offer_player")?></th>
                    <th><?=$this->lang->line("offer_team")?></th>
                    <th><?=$this->lang->line("offer_offer")?></th>
                    <th colspan="2"><?=$this->lang->line("offer_choice")?></th>
                <?php
                $flag=true;
                foreach($transferts_received as $row)
                {
                ?>
                    <tr  <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                        <td >
                            <?php echo $row->player_name; ?>
                        </td>
                        <td >
                            <?php echo anchor('team/team_profil/'.$row->team_sender_id,$teamInfos=$this->team_model->get_team_name($row->team_sender_id));?>
                        </td>
                        <td >
                            <?php echo $row->offer; ?>
                        </td>
                        <td >
                            <form name="form_accept_offer" id="form_accept_offer" method="post">
                                <input type="hidden" name="playerId" value="<?php echo $row->player_id; ?>"/>
                                <input type="hidden" name="teamId" value="<?php echo $row->team_id; ?>"/>
                                <input type="hidden" name="playerName" value="<?php echo $row->player_name; ?>"/>
                                <input type="hidden" name="transfertId" value="<?php echo $row->transfert_id; ?>"/>
                                <input type="button" name="make_offer" class="accept_offer_button input_invisible" value="" onclick="xajax_accept_offer_process(xajax.getFormValues('form_accept_offer'))"/>
                            </form>
                        </td>
                        <td >
                            <form name="form_refuse_offer" id="form_refuse_offer" method="post">
                                <input type="hidden" name="playerId" value="<?php echo $row->player_id; ?>"/>
                                <input type="hidden" name="teamId" value="<?php echo $row->team_id; ?>"/>
                                <input type="hidden" name="playerName" value="<?php echo $row->player_name; ?>"/>
                                <input type="hidden" name="transfertId" value="<?php echo $row->transfert_id; ?>"/>
                                <input type="button" name="make_offer" class="refuse_offer_button input_invisible" value="" onclick="xajax_refuse_offer_process(xajax.getFormValues('form_refuse_offer'))"/>
                            </form>
                        </td>
                    </tr>
                    
                <?php
                }
                ?>
                    <tr id="pagination">
                        <td colspan="11" align="center"></td>
                    </tr>
                </table>
            </div>
                <div id="enchere">
                    <div id="transfert_center">
                        <table id="transfert_table">
                           <th><?=$this->lang->line("transfert_player")?></th>
                           <th><?=$this->lang->line("transfert_nat")?></th>
                           <th><?=$this->lang->line("transfert_age")?></th>
                           <th><?=$this->lang->line("transfert_position")?></th>
                           <th><?=$this->lang->line("transfert_bid")?></th>
                           <th><?=$this->lang->line("transfert_delay")?></th>

                        <?php
                            //put a num on an offer
                            $flag=true;
                            $i=0;
                            foreach($encheres as $row){ ?>
                            <tr  <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                                <td>
                                    <?php echo anchor('transferts/player_auction/'.$row->player_id, $row->player_name); ?>

                                </td>
                                <td><img src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/flags/<?php echo $row->nationality ?>.png" /></td>
                                <td><?php echo $row->age; ?></td>
                                <td><?=$this->lang->line($row->position); ?></td>
                                <td><?php echo $this->transferts_model->countAuction($row->player_id) ?></td>
                                <td width="200px;">
                                    <?php 
                                    //explode date
                                    $date=explode(" ",$row->date_end); 
                                    $date=explode("-",$date[0]);
                                    $year=$date[0];
                                    $day=$date[2];
                                    $month=$date[1]-1;
                                    ?>
                                    <script type="text/javascript">
                                        $(function () {

                                            $('#countdown_<?php echo $i ?>').countdown({until: new Date('<?php echo $year ?>', '<?php echo $month ?>', '<?php echo $day ?>'), format: 'dHMhms'});

                                        });

                                    </script>
                                    <div id="countdown_<?php echo $i ?>"></div>
                                </td>
                             </tr>
                        <?php $i++;} ?>
                        <tr id="pagination">
                            <td colspan="11" align="center">
                            
                            </td>
                        </tr>
                        </table>
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

