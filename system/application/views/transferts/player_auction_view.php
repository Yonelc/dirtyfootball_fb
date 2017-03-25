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
<script type="text/javascript" src="<?php echo base_url() ?>js/transferts.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/countdown.js"></script>
<script type="text/javascript">
  // Load/Call Reverse Ajax
  xajax.callback.global.onRequest = function() { $(".ajax_loading").css("display","block");}
  xajax.callback.global.beforeResponseProcessing = function() {$(".ajax_loading").css("display","none");}
</script>
<title>Transferts</title>
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
                    <li><a href="#player_profil"><span><?=$this->lang->line("submenu_profil_player")?></span></a></li>
                </ul>
                <div id="background_tabs">
                    <div id="player_profil">
                        <div id="back_button"><a  href="javascript:history.go(-1)"><?=$this->lang->line("back")?></a></div>
                        <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                        <div id="bloc_left">
                            <div id="caracteristiques"></div>
                            <div id="image_player"></div>
                            <table id="experience_stats">
                                    <tr class="row_pair">
                                        <td class="col_title"><?=$this->lang->line("profil_att")?></td>
                                        <td class="col_data" ><div class="att"><?php echo $player_infos[0]["experience_att"] ?></div></td>
                                    </tr>
                                    <tr class="row_impair">
                                        <td class="col_title"><?=$this->lang->line("profil_mil")?></td>
                                        <td class="col_data"><div class="mil"><?php echo $player_infos[0]["experience_mil"] ?></div></td>
                                    </tr>
                                    <tr class="row_pair">
                                        <td class="col_title"><?=$this->lang->line("profil_def")?></td>
                                        <td class="col_data"><div class="def"><?php echo $player_infos[0]["experience_def"] ?></div></td>
                                    </tr>
                                    <tr class="row_impair">
                                        <td class="col_title"><?=$this->lang->line("profil_gb")?></td>
                                        <td class="col_data"><div class="gb"><?php echo $player_infos[0]["experience_gb"] ?></div></td>
                                    </tr>
                            </table>

                            <table id="tab_player_profil">
                                <tr class="row_pair">
                                    <td class="col_title"><?=$this->lang->line("profil_nat")?></td>
                                    <td class="col_data"><img src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/flags/<?php echo $player_infos[0]["nationality"] ?>.png" /></td>
                                </tr>
                                <tr class="row_impair">
                                    <td class="col_title"><?=$this->lang->line("profil_name")?></td>
                                    <td class="col_data"><?php echo $player_infos[0]["player_name"] ?></td>
                                </tr>
                                <tr class="row_pair">
                                    <td class="col_title"><?=$this->lang->line("profil_age")?></td>
                                    <td class="col_data"><?php echo $player_infos[0]["age"] ?></td>
                                </tr>
                                <tr class="row_impair">
                                    <td class="col_title"><?=$this->lang->line("profil_type")?></td>
                                    <td class="col_data"><?=$this->lang->line($player_infos[0]["position"]); ?></td>
                                </tr>
                                <tr class="row_pair" >
                                    <td class="col_title"><img id="value" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/wollars.png" alt="Wollars"/></td>
                                    <td class="col_data" id="playerPrice"><?php echo $player_infos[0]["value"] ?> </td>
                                </tr>
                                <tr class="row_impair" >
                                    <td class="col_title"><?=$this->lang->line("profil_health")?></td>
                                    <td class="col_data"><?php echo players_rules::getInjuryFlag($player_infos[0]["injury"]) ?></td>
                                </tr>
                            </table>
                            <div id="offer">

                                <form name="form_auction" id="form_auction" method="post">
                                <input type="hidden" name="playerId" value="<?php echo $player_infos[0]["player_id"] ?>"/>
                                <input type="hidden" name="playerName" value="<?php echo $player_infos[0]["player_name"] ?>"/>
                                <input type="hidden" name="playerValue" value="<?php echo $player_infos[0]["value"]; ?>"/>
                                <input type="button" name="make_auction" class="buy_match_button input_invisible" value="" onclick="xajax_make_auction_process(xajax.getFormValues('form_auction'))"/>
                                <input type="text" name="offer" value="<?php if(!empty($lastOffer)){echo $lastOffer[0]["offer"]+1;}else{echo $player_infos[0]["value"]+1;} ?>"/>
                                <img id="value_logo" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/wollars.png" alt="Wollars"/>
                                </form>

                            </div>
                        </div>
                    
                    <div id="bloc_right">
                        <?php
                        //explode date
                        $date=explode(" ",$player_infos[0]["date_end"]);
                        $date=explode("-",$date[0]);
                        $year=$date[0];
                        $day=$date[2];
                        $month=$date[1]-1;
                        ?>
                        <script type="text/javascript">
                            $(function () {

                                $('#countdown').countdown({until: new Date('<?php echo $year ?>', '<?php echo $month ?>', '<?php echo $day ?>'), format: 'dHMhms'});

                            });
                        </script>
                        <div id="countdown"></div>
                        
                        <div id="player_offer_top"></div>
                        <div id="player_offer_center">
                            <table id="teams_offers">

                            <?php
                                $flag=TRUE;
                                foreach($list_offer as $row)
                                { ?>
                                    <tr <?php /*if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} */?>>
                                        <td class="team_name"><?php echo $row->team_name ?></td>
                                        <td class="team_offer"> <?php echo $row->offer ?> </td>
                                        <td class="value_logo"> <img id="value" src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/wollars.png" alt="Wollars"/></td>
                                    </tr>
                          <?php }
                            ?>
                              <tr id="pagination">
                                <td colspan="11" align="center"></td>
                              </tr>
                            </table>
                        </div>
                        <div id="player_offer_bottom"></div>
                        </div>
                        
                    </div>
                </div>
           </div>
        </div>
    </div>
    <div id="bottom_frame"></div>
    <?php echo $this->load->view('includes/footer_view');?>
</div>
</body>
</html>

