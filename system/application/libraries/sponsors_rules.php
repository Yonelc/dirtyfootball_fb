<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sponsors_rules {

    //SPONSORS TYPE
    const TYPE_GOOGLE=1;
    const TYPE_FMEUROPE=2;

    public static function getSponsors($type)
    {
       switch($type){

           case sponsors_rules::TYPE_GOOGLE:
                return $pub='<script type="text/javascript"><!--
google_ad_client = "pub-3410930049832680";
/* 468x60, date de création 02/11/10 */
google_ad_slot = "1047413326";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
           break;

           case sponsors_rules::TYPE_FMEUROPE:
                return $pub='<script type="text/javascript"><!--
google_ad_client = "pub-3410930049832680";
/* 468x60, date de création 02/11/10 */
google_ad_slot = "1047413326";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
           break;

           default:
                return $pub='<script type="text/javascript"><!--
google_ad_client = "pub-3410930049832680";
/* 468x60, date de création 02/11/10 */
google_ad_slot = "1047413326";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
           break;
       }
    }
}
