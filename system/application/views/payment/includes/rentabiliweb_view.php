<div id="rentabiliweb">

<table border="0" cellpadding="0" cellspacing="0" style="border:5px solid #E5E5E5; margin: 5px auto;"><tr><td>
	<table cellpadding="0" cellspacing="0" style="width: 436px;  border: solid 1px #AAAAAA;">
    <tr>
        <td colspan="2">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #FFFFFF;">
                <tr>
                    <td>
                        <img src="http://payment.rentabiliweb.com/data/i/component/logo-form.gif" width="173" height="20" alt="Paiement sécurisé par Rentabiliweb" style="padding: 1px 0 0 5px"/>
                    </td>
                    <td>
                        <div style="text-align: right; padding: 2px; font-family: Arial, Helvetica, sans-serif; min-height:30px; ">
                            <span style="color: #3b5998; font-weight:bold; font-size: 12px;">Solutions de paiements sécurisés</span>
                            <br/>
                            														<span style="color: #5c5c5c; font-size: 11px; font-style: italic;">Secure payment solution</span>
														                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border-top: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA;background-color: #F7F7F7;">
            <div style="text-align: center; padding: 2px; font-family: Arial, Helvetica, sans-serif; min-height:30px;">
                <span style="color: #3b5998; font-weight:bold; font-size: 12px;">Choisissez votre pays et votre moyen de paiement pour obtenir votre code</span>
                <br/>
                                <span style="color: #5c5c5c; font-size: 11px; font-style: italic;">Please choose your country and your kind of payment to obtain a code</span>
								            </div>
        </td>
    </tr>
    <tr height="250">
        <td width="280"  style="background-color: #FFFFFF;">
            <iframe name="rweb_display_frame" width="280" height="250" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="http://payment.rentabiliweb.com/form/acte/frame_display.php?docId=<?=$docId ?>&siteId=<?=$siteId ?>&cnIso=geoip&lang=fr&skin=default">
            </iframe>
        </td>
        <td width="156" style="border-left: 1px solid #AAAAAA; background-color: #FFFFFF;">
            <iframe name="rweb_flags_frame" width="156" height="250" frameborder="0" marginheight="0" marginwidth="0" scrolling="no" src="http://payment.rentabiliweb.com/form/acte/frame_flags.php?docId=<?=$docId ?>&siteId=<?=$siteId ?>&lang=fr&skin=default">
            </iframe>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border-top: 1px solid #AAAAAA; background-color: #F7F7F7;">
            <form id="rweb_tickets_<?=$docId ?>" method="get" action="http://payment.rentabiliweb.com/access.php" style="margin: 0px; padding: 0px;" >
                <table width="400" cellpadding="0" cellspacing="0" style=" margin: 2px auto;">
                	<tr>
                		<td style="text-align: center"><label for="code_0" style=" font-family:Arial, Helvetica, sans-serif;font-size: 12px; font-weight:bold; color:#3b5998; padding: 2px; margin: 0px;">
                        Saisissez votre code d'accès et validez :
										<br/>
										                		<span style="font-size: 11px; font-style: italic;color:#5c5c5c;">Please enter your access code :</span>
                    										</label></td>
                	</tr>
                	<tr>
                		<td style="text-align: center">
                																	<input name="code[0]" type="text" id="code_0" size="10" style="border: solid 1px #3b5998; padding: 2px; font-weight: bold; color:#3b5998; text-align: center;"/>
																					<input type="hidden" name="docId" value="<?=$docId ?>" /><input type="button"  alt="Ok" onclick="getElementById('rweb_sub_<?=$docId ?>').disabled=true;document.getElementById('rweb_tickets_<?=$docId ?>').submit();" id="rweb_sub_<?=$docId ?>"  style="width: 40px; height:20px; vertical-align:middle; margin-left: 5px; border: none; background:url(http://payment.rentabiliweb.com/data/i/component/button_okdefault.gif);"/></td>
                	</tr>
                </table>
            </form>
            <div style="text-align: center; padding: 2px; font-family: Arial, Helvetica, sans-serif; clear: both;">
                <span style="font-weight:bold; font-size: 10px; color: #3b5998;">Votre navigateur doit accepter les cookies</span>
                								<br/>
                <span style="font-style: italic; font-size: 10px; color: #5c5c5c;">Please check that your browser accept the cookies</span>
								            </div>
			<div style="text-align: center; padding: 2px; font-family: Arial, Helvetica, sans-serif;">
                <a href="javascript:;"  onclick="javascript:window.open('http://payment.rentabiliweb.com/support/?docId=<?=$docId ?>&siteId=<?=$siteId ?>〈=fr','rentabiliweb_help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=1,copyhistory=0,menuBar=0,width=995,height=630');" style="color: #3b5998; font-weight:bold; font-size: 12px; text-decoration: none;">Support technique</a><span style="color: #AAAAAA;"> / </span><a href="javascript:;"  onclick="javascript:window.open('http://payment.rentabiliweb.com/support/?docId=<?=$docId ?>&siteId=<?=$siteId ?>〈=en','rentabiliweb_help','toolbar=0,location=0,directories=0,status=0,scrollbars=1,resizable=1,copyhistory=0,menuBar=0,width=995,height=630');" style="color: #5c5c5c; font-weight:normal; font-size: 12px; text-decoration: none;">Technical support</a>            </div>
        </td>
    </tr>
	</table>
</td></tr>
</table>
</div>