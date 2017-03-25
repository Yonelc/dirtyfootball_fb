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
                    <li><a href="#find_team"><span><?=$this->lang->line('submenu_find_team')?></span></a></li>
                </ul>
            <div id="background_tabs">
                <div id="find_team">
<?php if(isset($research)){ ?>
                    <div id="back_button"><?=anchor('research/',$this->lang->line("back"))?></div>
<?php } ?>
                    <div id="research">
                         <?php $attributes = array('id' => 'form_research_team','name' => 'form_research_team'); ?>
                         <?php echo form_open("research/researchTeam",$attributes);?>
                             <div id="criteres">
                                 <label for="Nom de l'équipe"><?=$this->lang->line("research_team"); ?></label>
                                 <input type="text"  name="team_name" value="" />
                                 <input type="submit" id="research_ok" class="input input_invisible" value=""  />
                             </div>
                        </form>
                    </div>
                    <div id="team_center">
                        <table id="team_table">
                           <th><?=$this->lang->line("team_name")?></th>
                           <th><?=$this->lang->line("victories")?></th>
                           <th><?=$this->lang->line("tie")?></th>
                           <th><?=$this->lang->line("lost")?></th>
                        <?php
                            //put a num on an offer
                            $flag=true;
                            foreach($allTeams as $team){ ?>
                            <tr  <?php if($flag==true){echo "style='background-color:#d5d5d5'";$flag=false;}else{echo "style='background-color:#eeeeee'";$flag=true;} ?>>
                                <td>
                                    <?php echo anchor('team/team_profil/'.$team["team_id"], $team["team_name"]); ?>

                                </td>
                                <td><?php echo $team["nb_victory"]?></td>
                                <td><?php echo $team["nb_tie"]?></td>
                                <td><?php echo $team["nb_lost"]?></td>
                             </tr>
                        <?php } ?>
                        <tr id="pagination">
                            <td colspan="11" align="center">
                            <?php echo $this->pagination->create_links(); ?>
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
