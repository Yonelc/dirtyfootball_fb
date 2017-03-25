<?php

class payment extends Controller {

    private $facebook;

    public function __construct(){

	//chargement de la page parent
	parent::Controller();
        date_default_timezone_set('Europe/Paris');
        $this->load->database();
        $this->load->helper('url_helper');


        
        //configuration facebook
        $this->load->plugin('facebook');
        $this->facebook = new Facebook(array(
              'appId'  => APP_ID,
              'secret' => SECRET_KEY,
              'cookie' => False,
              'domain'=>FACEBOOK_DOMAIN,
        ));
    }



    public function index(){

        $connected = $this->session->userdata('connected_ok');
        if($connected){

            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('payment', $langageFile);
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{
                redirect("start/begin_game");
            }
            //Init XAJAX
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'list_countries_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'list_prices_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'conversion_process'));
            /*$this->xajax->configure('debug', true);*/
            $this->xajax->processRequest();

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            $data["userId"]=$userId;
            $data["my_infos"]=$this->manager_model->get_my_infos();

            //get payment
            $data["countries"]=$this->payment_model->getPaymentCountries();
            $data["prices"]=$this->payment_model->getPriceCountries("fr");
            $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

            $this->load->view('payment/payment_view',$data);

        }else{

            redirect('start/begin_game');
        }
        
    }

    public function list_countries_process($form_data)
    {
        $objResponse = new xajaxResponse();
        $teamId = $this->session->userdata('teamId');
        $userId = $this->session->userdata('userId');

        $data["prices"]=$this->payment_model->getPriceCountries($form_data["country"]);
        $data["my_infos"]=$this->manager_model->get_my_infos();

        $result = $this->load->view('payment/includes/list_prices_view',$data,true);
        $objResponse->assign("price_list","innerHTML",$result);

        sleep(2);

        return $objResponse;
    }

    public function list_prices_process($form_data)
    {
        $objResponse = new xajaxResponse();
        $teamId = $this->session->userdata('teamId');
        $userId = $this->session->userdata('userId');

        $data["my_infos"]=$this->manager_model->get_my_infos();

        $idArr=explode("/",$form_data["code"]);
        $data["docId"]=$idArr[0];
        $data["siteId"]=$idArr[1];

        $this->session->set_userdata('docId',$idArr[0]);
        $this->session->set_userdata('siteId',$idArr[1]);

        $result = $this->load->view('payment/includes/rentabiliweb_view',$data,true);
        $objResponse->assign("price_list","innerHTML",$result);

        sleep(2);

        return $objResponse;
    }

    /*    public function list_prices_process($form_data)
    {
        $objResponse = new xajaxResponse();
        $teamId = $this->session->userdata('teamId');
        $userId = $this->session->userdata('userId');

        $data["my_infos"]=$this->manager_model->get_my_infos();

        $idArr=explode("/",$form_data["code"]);
        $data["ids"]=$idArr[0];
        $data["idd"]=$idArr[1];

        $this->session->set_userdata('ids',$idArr[0]);
        $this->session->set_userdata('idd',$idArr[1]);
        $this->session->set_userdata('doc',$idArr[2]);

        $result = $this->load->view('payment/includes/allopass_view',$data,true);
        $objResponse->assign("price_list","innerHTML",$result);

        return $objResponse;
    }*/
    
    /*public function order_allopass()
    {

        $teamId = $this->session->userdata('teamId');
        $userId = $this->session->userdata('userId');

        // Identifiants de votre document
        $ids = $this->session->userdata('ids');
        $idd = $this->session->userdata('idd');
        $doc = $this->session->userdata('doc');
        $code=$ids."/".$idd."/".$doc;
        
        //parse url to retreive $_get values
        parse_str($_SERVER['QUERY_STRING'],$_GET);

        $RECALL = $_GET["RECALL"];
        if( trim($RECALL) == "" )
        {
            // La variable RECALL est vide, renvoi de l'internaute
            redirect('payment/error');
        }

        $smsCode=$RECALL;
        // $RECALL contient le code d'accès
        $RECALL = urlencode( $RECALL );
        // $AUTH doit contenir l'identifiant de VOTRE document
        $AUTH = urlencode( $code );
        $r = @file( "http://payment.allopass.com/api/checkcode.apu?code=$RECALL&auth=$AUTH" );

        // on teste la réponse du serveur
        if( substr( $r[0],0,2 ) != "OK" )
        {
            // Le serveur a répondu ERR ou NOK : l'accès est donc refusé
            redirect('payment/error');

        }else{
            
            //check if code is already in database
            $codeExist=$this->payment_model->checkPaymentAlreadyExist($smsCode);

            if(!$codeExist){

                   $productInfos=$this->payment_model->getProduct($code);
                   $this->payment_model->addPayment($userId,$code,$productInfos,$smsCode);
                   $this->money_model->updateSellDirtyGold($productInfos[0]["gold"],$userId);
                   redirect('payment/confirmation');

            }else{
                redirect('payment/error');
            }

        }
    }*/

    public function order()
    {

        $teamId = $this->session->userdata('teamId');
        $userId = $this->session->userdata('userId');

        // Identifiants de votre document
        $docId = $this->session->userdata('docId');
        $siteId = $this->session->userdata('siteId');
        $code=$docId."/".$siteId;

        //parse url to retreive $_get values
        parse_str($_SERVER['QUERY_STRING'],$_GET);

        // Construction de la requête pour vérifier le code
        $query      = 'http://payment.rentabiliweb.com/checkcode.php?';
        $query     .= 'docId='.$docId;
        $query     .= '&siteId='.$siteId;
        $query     .= '&code='.$_GET['code'];
        $query     .= "&REMOTE_ADDR=".$_SERVER['REMOTE_ADDR'];
        $result     = @file($query);

        //check if code is already in database
        $codeExist=$this->payment_model->checkPaymentAlreadyExist($_GET['code']);

        if(!$codeExist){
            //Vérification de la validité du code
            if(trim($result[0]) !== "OK") {


               redirect('payment/error');

            }else{

               $productInfos=$this->payment_model->getProduct($code);
               $this->payment_model->addPayment($userId,$code,$productInfos,$_GET['code']);
               $this->money_model->updateSellDirtyGold($productInfos[0]["gold"],$userId);
               redirect('payment/confirmation');

            }
        }else{
            redirect('payment/error');
        }

    }
    
    public function error()
    {
        //langage loading
        $langageFile=$this->session->userdata('langage');

        if(!empty($langageFile)){
            $this->lang->load('payment', $langageFile);
            $this->lang->load('menu', $langageFile);
            $this->lang->load('footer', $langageFile);
        }else{
            redirect("start/begin_game");
        }

        $teamId = $this->session->userdata('teamId');
        $userId = $this->session->userdata('userId');

        $data["my_infos"]=$this->manager_model->get_my_infos();
        $this->load->view('payment/error_view',$data);
        

    }

    public function confirmation()
    {
        //langage loading
        $langageFile=$this->session->userdata('langage');

        if(!empty($langageFile)){
            $this->lang->load('payment', $langageFile);
            $this->lang->load('menu', $langageFile);
            $this->lang->load('footer', $langageFile);
        }else{
            redirect("start/begin_game");
        }

        $teamId = $this->session->userdata('teamId');
        $userId = $this->session->userdata('userId');

        $data["my_infos"]=$this->manager_model->get_my_infos();
        $this->load->view('payment/confirmation_view',$data);

    }

    public function conversion_process($form_data)
    {
        $objResponse = new xajaxResponse();
        
        $teamId = $this->session->userdata('teamId');
        $userId = $this->session->userdata('userId');
        $dirtyGold=$form_data["conversion_value"];
        $checkGold=$this->money_model->checkEnoughDirtyGold($dirtyGold,$userId);

        if($checkGold && !empty($dirtyGold)){
            $wollars=$dirtyGold*500000;
            $this->money_model->updateDirtyGold($dirtyGold,$userId);
            $this->money_model->updateSellMoney($wollars,$userId);
            $data["messageInfos"]=$this->lang->line('conversion_succes');
        }else{
            $data["messageInfos"]=$this->lang->line('conversion_dirtygold_missing');
        }

        $data["my_infos"]=$this->manager_model->get_my_infos();

        $result = $this->load->view('includes/header_view',$data,true);
        $objResponse->assign("header","innerHTML",$result);

        $result = $this->load->view('payment/includes/conversion_view',$data,true);
        $objResponse->assign("conversion","innerHTML",$result);

        $result = $this->load->view('includes/infos_view',$data,true);
        $objResponse->assign("conversion_infos","innerHTML",$result);

        sleep(2);

        return $objResponse;

    }

    public function sponsorpay()
    {
        //parse url to retreive $_get values
        parse_str($_SERVER['QUERY_STRING'],$_GET);

        $securityToken="10L157XfretT";
        $userId=$_GET["uid"];
        $amount=$_GET["amount"];

        $sha1=sha1($securityToken.$userId.$amount.$_GET['_trans_id_']);

        if($_GET["sid"]==$sha1)
        {
            //check if code is already in database
            $transactionExist=$this->payment_model->checkSponsorPayAlreadyExist($_GET['_trans_id_'],$userId);
            
            if(!$transactionExist){
                $this->payment_model->addPaymentSponsorPay($_GET["uid"],$_GET["amount"],$_GET['_trans_id_']);
                $this->money_model->updateSellDirtyGold($_GET["amount"],$_GET["uid"]);
            }


        }


    }

    public function sponsorpay_iframe()
    {
        //langage loading
        $langageFile=$this->session->userdata('langage');

        if(!empty($langageFile)){
            $this->lang->load('payment', $langageFile);
            $this->lang->load('menu', $langageFile);
            $this->lang->load('footer', $langageFile);
        }else{
            redirect("start/begin_game");
        }
        $teamId = $this->session->userdata('teamId');
        $userId = $this->session->userdata('userId');

        $data["my_infos"]=$this->manager_model->get_my_infos();
        $this->load->view('payment/sponsorpay_view',$data);

    }

    public function supereward()
    {
        //parse url to retreive $_get values
        parse_str($_SERVER['QUERY_STRING'],$_GET);

        $SECRET="5336fead42e4bb502d82339d1df5c4b0";
        $sig = md5($_GET['id'] . ':' . $_GET['new'] . ':' . $_GET['uid'] . ':' . $SECRET);

        if($sig==$_GET['sig'])
        {
            //check if code is already in database
            $transactionExist=$this->payment_model->checkSponsorPayAlreadyExist($_GET['oid']);
            
            if(!$transactionExist){
                
                $this->money_model->addPaymentSuperRewards($_GET['uid'],$_GET['new'],$_GET['oid']);
                $this->money_model->updateSellDirtyGold($_GET["uid"],$_GET["new"],$_GET['oid']);
                print "1";

            }else{
                print "1";
            }

        }else{
            print "0";
        }


    }

    public function superewards_iframe()
    {

        $teamId = $this->session->userdata('teamId');
        $userId = $this->session->userdata('userId');

        $data["my_infos"]=$this->manager_model->get_my_infos();
        $this->load->view('payment/sprewards_view',$data);

    }



}
?>