<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/game.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/payment.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/<?=$this->session->userdata("langage")?>/tabs.css" />

<?php echo $this->xajax->printJavascript(base_url()); ?>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/easyTooltip.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/tabs.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/game_page.js"></script>
<script type="text/javascript">
  // Load/Call Reverse Ajax
  xajax.callback.global.onRequest = function() { $(".ajax_loading").css("display","block");}
  xajax.callback.global.beforeResponseProcessing = function() {$(".ajax_loading").css("display","none");}
</script>
<title>Composez votre équipe</title>
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
                <li><a href="#achat"><span><?=$this->lang->line('submenu_buy');?></span></a></li>
                <li><a href="#obtenir"><span><?=$this->lang->line('submenu_get');?></span></a></li>
                <li><a href="#conversion"><span><?=$this->lang->line('submenu_convert');?></span></a></li>
            </ul>
            <div id="background_tabs">
                <div id="achat">
                    <div id="payment_cadre_haut"></div>
                    <div id="payment_cadre_centre">
                    <!--    -->
                    <div id="countries_list">
                        <div id="choose_country">
                            <div id="label_pays"><label ><?=$this->lang->line('title_payment');?> &nbsp;</label></div>

                            <div id="list_pays">
                                <form name="form_countries" id="form_countries"  >
                                <select name="country" onchange="xajax_list_countries_process(xajax.getFormValues('form_countries'))">
                                <?php foreach($countries as $country){ ?>
                                    <option <?php if($country["country_id"]=="fr"){?>selected="selected"<?php } ?> value="<?=$country["country_id"] ?>"><?=$country["country_name"]." (".$country["devise"].")"?></option>
                                <?php } ?>
                                </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                    <div id="price_list">
                        <!--<div align="center">Bientôt/Coming Soon</div>-->
                        
                            <div id="choose_price">
                                <br/>
                                <form name="form_price" id="form_price"  >
                                    <?php foreach($prices as $price){ ?>
                                    <div class="cadre_prix">
                                        <div class="prix">
                                        <div class="value_radio"><input type="radio" checked="checked" name="code" value="<?=$price["code"] ?>" /> </div>
                                        <div class="value_dirtygold">&nbsp;<?=$price["gold"]?></div>
                                        <div class="value_logo"><img  src="<?php echo base_url() ?>images/<?=$this->session->userdata("langage")?>/global/dirtygold.png" alt="Dirtygold"/> </div>
                                        <div class="value_price">&nbsp;<?=$price["prix"]." ".$price["devise"] ?></div>
                                        <div class="value_payment">&nbsp;<?=payment_rules::getPaymentLogo($price["type"]) ?></div>
                                        </div>
                                    </div>
                                    <?php } ?><br/><br/>
                                    <input type="button" name="buy" class="buy_button input_invisible" value="" onclick="xajax_list_prices_process(xajax.getFormValues('form_price'))"/>
                                </form>
                            </div>

                    </div>
       
                    </div>
                <div id="payment_cadre_bas"></div>
                </div>
                <div id="obtenir">
                    <iframe width="100%" height="1424px" frameborder="0" scrolling="no"  src="http://iframe.sponsorpay.com/?appid=713&uid=<?=$this->session->userdata('userId')?>"></iframe>
                    <div id="sponsorpayment">
                        
                    <?//=anchor('payment/sponsorpay_iframe','<img src="'.base_url().'images/'.$this->session->userdata("langage").'/payment/sponsorpay.jpg" border="0" alt="sponsorpay"  />')?>
                    <?//=anchor('payment/superewards_iframe','<img src="'.base_url().'images/payment/superewards.jpg" border="0" alt="superrewards"  />')?>
                    </div>
                </div>
                <div id="conversion">
                    <div class="ajax_loading" style="display:none;width:160px;margin:0 auto 0 auto;"><img src="<?php echo base_url()?>images/<?=$this->session->userdata("langage")?>/global/loading.gif" alt="ajax loading"/></div>
                    <div id="payment_cadre_haut"></div>
                        <div id="payment_cadre_centre">
                            <div id="outil_conversion">
                                <div id="taux">1 DirtyGold = 500 000 Wollars</div>
                                <form name="form_conversion" id="form_conversion"  >
                                    <div id="value_conversion"><input type="text" name="conversion_value" value="" /> DirtyGold </div>
                                    <input type="button" name="buy" class="conversion_button input_invisible" value="" onclick="xajax_conversion_process(xajax.getFormValues('form_conversion'))"/>
                                </form>
                            </div>
                        </div>
                    <div id="payment_cadre_bas"></div>
                </div>
           </div>
        </div>
       </div>
 </div>

<?php echo $this->load->view('includes/footer_view');?>
 </div>
</body>
</html>
