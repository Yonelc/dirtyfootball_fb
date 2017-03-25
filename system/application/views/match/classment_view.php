<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/match.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/validationEngine.jquery.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript">
  /*xajax.callback.global.onRequest = function() {xajax.$('loadingMessage').style.display = 'block';}
  xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loadingMessage').style.display='none';}*/
</script>

<script src="<?php echo base_url() ?>js/jquery-1.4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script src="<?php echo base_url() ?>js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/jquery.validationEngine.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/match.js"></script>

<title>Match</title>
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
                    <li><a href="#classment_champ"><span><?=$this->lang->line('submenu_classement'); ?></span></a></li>
                </ul>
                <div id="background_tabs">
                    
                    <div id="classment_champ">
                        <div id="back_button"><a  href="javascript:history.go(-1)"><?=$this->lang->line("back")?></a></div>
                            <div id="classement">
                                <!--<div  id="top_classement"></div>-->
                                <div id="middle_classement">
                                <table>
                                    <th></th>
                                    <th><?=$this->lang->line("championship_team")?></th>
                                    <th><?=$this->lang->line("championship_j")?></th>
                                    <th><?=$this->lang->line("championship_g")?></th>
                                    <th><?=$this->lang->line("championship_n")?></th>
                                    <th><?=$this->lang->line("championship_p")?></th>
                                    <th><?=$this->lang->line("championship_pris")?></th>
                                    <th><?=$this->lang->line("championship_c")?></th>
                                    <th><?=$this->lang->line("championship_dif")?></th>
                                    <th><?=$this->lang->line("championship_pts")?></th>
                       <?php    $flag=true;
                                $i=1;
                                foreach($classement as $row)
                                { ?>
                                    <tr <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                                        <td  <?php if($i<=3){echo "style='color:#0003e9'";}if($i>=8){echo "style='color:#bd0000'";} ?>><?php echo $i ?></td>
                                        <td><?php echo anchor("team/team_profil/".$row->team_id,$row->team_name) ?></td>
                                        <td><?php echo $row->nb_match ?></td>
                                        <td><?php echo $row->win ?></td>
                                        <td><?php echo $row->draw ?></td>
                                        <td><?php echo $row->lose ?></td>
                                        <td><?php echo $row->goal_p ?></td>
                                        <td><?php echo $row->goal_c ?></td>
                                        <td><?php echo $row->goal_average ?></td>
                                        <td><?php echo $row->point ?></td>
                                    </tr>

                          <?php
                                $i++;
                            }
                            ?>
                                    <tr id="pagination">
                                        <td colspan="11" align="center"></td>
                                    </tr>
                                </table>
                                </div>
                                <!--<div id="bottom_classement"></div>-->
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
