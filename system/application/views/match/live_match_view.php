<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/match.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/validationEngine.jquery.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script src="<?php echo base_url() ?>js/jquery-1.4.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script src="<?php echo base_url() ?>js/jquery.validationEngine-en.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/jquery.validationEngine.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/match.js"></script>

<title>Match</title>
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
    <div class="center_frame">
    <?php echo $this->load->view('includes/main_menu_view');?>
        <div id="content">

            <div id="rotate">
                <ul>
                    <li><a href="#live"><span><?=$this->lang->line("observations_title")?></span></a></li>

                </ul>
                <div id="background_tabs">
                    <div id="live">
                        <div id="back_button"><a  href="javascript:history.go(-1)"><?=$this->lang->line("back")?></a></div>
                        <div class="match_opponent">
                            <div id="home_team_resume"><?=substr($matchInfos[0]["home_team_name"],0,12)?></div>
                            <div id="home_score_resume"><?=$matchInfos[0]["home_team_score"]?></div>
                            <div id="away_team_resume"><?=substr($matchInfos[0]["away_team_name"],0,12)?></div>
                            <div id="away_score_resume"><?=$matchInfos[0]["away_team_score"]?></div>
                            
                        </div>
                        <div id="comment">
                            <div id="comment_att"><?php if(!empty($resumeAtt[0]["comment"])) echo $resumeAtt[0]["comment"];?></div>
                            <div id="comment_mil"><?php if(!empty($resumeMil[0]["comment"])) echo $resumeMil[0]["comment"]?></div>
                            <div id="comment_def"><?php if(!empty($resumeDef[0]["comment"])) echo $resumeDef[0]["comment"]?></div>
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
