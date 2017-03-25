<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/manager.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/li-scroller.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.li-scroller.1.0.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.currency.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/game_page.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/swfobject.js"></script>
<title>Accueil DirtyFootball</title>

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
<div id="fb-root" style="width: 200px;"></div>
<script>
window.fbAsyncInit = function() {
 FB.init({
   appId  : '<?=APP_ID?>',
   status : true, // check login status
   cookie : false, // enable cookies to allow the server to access the session
   xfbml  : true  // parse XFBML
 });
 /*FB.Canvas.setSize({ width: 760, height: 900 });*/
 FB.Canvas.setAutoResize();

};

(function() {
var e = document.createElement('script');
e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
e.async = true;
document.getElementById('fb-root').appendChild(e);
}());
</script>
<div id="conteneur">
    <?php echo $this->load->view('includes/header_view');?>
    <!--<div id="top_frame"></div>-->
    <div class="center_frame">
    <?php echo $this->load->view('includes/main_menu_view');?>
    <?php //echo $this->load->view('includes/my_info_view');?>
        <div id="content">
            <div id="rotate">
                <ul>
                    <li><a href="#backend"><span>Backend</span></a></li>
                    <li><a href="#newplayer"><span>New players</span></a></li>
                </ul>

            <div id="background_tabs">
            <div id="backend">

                <table>
                    <tr>
                        <td>Nb joueurs :</td>
                        <td><?php echo $allUsers[0]["nb"]; ?></td>
                    </tr>
                    <tr>
                        <td>Nb joueurs non confirmé :</td>
                        <td><?php echo $allUserNotConnected[0]["nb"]; ?></td>
                    </tr>
                    <tr>
                        <td>Nb d'équipes :</td>
                        <td><?php echo $allTeams[0]["nb"]; ?></td>
                    </tr>
                    <tr>
                        <td>Nb de payments :</td>
                        <td><?php echo $allPayment[0]["nb"]; ?></td>
                    </tr>
                    <tr>
                        <td>Somme des payments</td>
                        <td><?php echo $sumPayment[0]["nb"]; ?></td>
                    </tr>
                </table>

            </div>
                            <div id="newplayer">
                 <?php $attributes = array('id' => 'form_new_player','name' => 'form_newplayer'); ?>
                 <?php echo form_open("backend/insertNewPlayer",$attributes);?>
                    <div><label>Player name </label><input type="text" name="player_name" value=""/></div>
                    <div>
                        <label>Position </label>
                        <select name="position">
                            <option value="ATT">ATT</option>
                            <option value="MILL">MIL</option>
                            <option value="DEF">DEF</option>
                            <option value="GB">GB</option>
                        </select>
                    </div>
                    <div><label>Value </label><input type="text" name="value" value="100000"/></div>
                    <div><label>Nationality </label><input type="text" name="nationality" value="fr"/></div>
                    <div><label>Age </label><input type="text" name="age" value="22"/></div>
                    <div><label>ATT </label><input type="text" name="experience_att" value=""/></div>
                    <div><label>MIL </label><input type="text" name="experience_mil" value=""/></div>
                    <div><label>DEF </label><input type="text" name="experience_def" value=""/></div>
                    <div><label>GB </label><input type="text" name="experience_gb" value=""/></div>
                    <div><label>Date end </label><input type="text" name="date_end" value="<?php echo date('Y-m-d 00:00:00'); ?>"/></div>
                    <div><input type="submit" value="Submit" name="submit" /></div>
                 <?php echo form_close();?>
            </div>
            </div>

        </div>
    </div>

</div>
<?php echo $this->load->view('includes/footer_view');?>
</div>
</body>
</html>
