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

<title>Récompenses championnat</title>
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
                    <li><a href="#awards"><span>Récompenses</span></a></li>
                </ul>
                <div id="background_tabs">
                    <div id="awards">
                        <table id="tab_awards">
                            <th colspan="2">Récompenses championnat de niveau <?=$this->session->userdata("level"); ?></th>
                            <?php
                            $flag=true;
                            for($i=1;$i<=10;$i++){ ?>
                            <tr <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                                <td class="award_place">Place <?=$i ?></td>
                                <td class="award_value"><?=$allAwards[0]["place".$i]?> DirtyGold</td>
                                
                            </tr>
                            <?php } ?>
                            <tr id="pagination">
                                <td colspan="11" align="center"></td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php echo $this->load->view('includes/footer_view');?>
</div>
</body>
</html>
