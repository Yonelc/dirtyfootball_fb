<?php

class transferts extends Controller {

	public function __construct(){

            //chargement de la page parent
            parent::Controller();
            date_default_timezone_set('Europe/Paris');
            $this->load->database();
            $this->load->library('pagination');
          
            //configuration facebook
            $this->load->plugin('facebook');
            $this->facebook = new Facebook(array(
                  'appId'  => APP_ID,
                  'secret' => SECRET_KEY,
                  'cookie' => False,
                  'domain'=>FACEBOOK_DOMAIN,
            ));
	}


    //Main page in game boarding
	public function index(){

        $connected = $this->session->userdata('connected_ok');
        $teamId = $this->session->userdata('teamId');
        if($connected){

            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('transfert', $langageFile);
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{
                redirect("start/begin_game");
            }
            
            //XAJAX init functions
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'make_offer_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'accept_offer_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'refuse_offer_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'cancel_offer_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'changeTransfertStatut_process'));

            /*$this->xajax->configure('debug', true);*/
            $this->xajax->processRequest();

            $config['total_rows'] = $this->transferts_model->count_available_transferts($teamId);
            $config['per_page'] = '20';
            $config['base_url'] = base_url().'/index.php/transferts/index';
            $this->pagination->initialize($config);
            
            $data["my_infos"]=$this->manager_model->get_my_infos();
            $data["transferts"]=$this->transferts_model->get_available_transferts($teamId,$config['per_page'],$this->uri->segment(3));

            $data["encheres"]=$this->transferts_model->get_available_encheres();
            
            $data["transferts_received"]=$this->transferts_model->get_offer_received($teamId);
            $data["transferts_sent"]=$this->transferts_model->get_offer_sent($teamId);
            $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

            $this->load->view('transferts/transfert_view',$data);

        }else{
            redirect('start/begin_game');
        }
}



    public function research_transferts(){

        $connected = $this->session->userdata('connected_ok');
        $teamId = $this->session->userdata('teamId');
        
        if($connected){

            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('transfert', $langageFile);
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{
                redirect("start/begin_game");
            }
            //Xajax init function
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'make_offer_process'));
            $this->xajax->processRequest();

            if(isset($_POST) && !empty($_POST))
            {
               $array_items = array(
                   "playerName"=>"",
                   "playerAge"=>"",
                   "playerPosition"=>"",
                   "playerValue"=>"",);

               $this->session->unset_userdata($array_items);

               $session=array(
                   "playerName"=>$_POST["player_name"],
                   "playerAge"=>$_POST["player_age"],
                   "playerPosition"=>$_POST["player_position"],
                   "playerValue"=>$_POST["player_value"],
               );
               $this->session->set_userdata($session);
            }

            $config['total_rows'] = $this->transferts_model->count_transferts_by_measure($this->session->userdata("playerName"),
                                                                                         $this->session->userdata("playerAge"),
                                                                                         $this->session->userdata("playerPosition"),
                                                                                         $this->session->userdata("playerValue"));
            $config['per_page'] = '20';
            $config['base_url'] = base_url().'/index.php/transferts/research_transferts';
            $this->pagination->initialize($config);



            $data["my_infos"]=$this->manager_model->get_my_infos();
            $data["transferts"]=$this->transferts_model->get_transferts_by_measure($config['per_page'],$this->uri->segment(3),
                                                                                    $this->session->userdata("playerName"),
                                                                                    $this->session->userdata("playerAge"),
                                                                                    $this->session->userdata("playerPosition"),
                                                                                    $this->session->userdata("playerValue")
                                                                                    );

            $data["encheres"]=$this->transferts_model->get_available_encheres();

            $data["transferts_received"]=$this->transferts_model->get_offer_received($teamId);
            $data["transferts_sent"]=$this->transferts_model->get_offer_sent($teamId);
            $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

            $this->load->view('transferts/transfert_view',$data);

        }else{

            redirect('start/begin_game');

        }
    }

    //Ajax make offer
    public function make_offer_process($form_data){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            //check if user has enough money
            $enoughMoney=$this->money_model->checkEnoughMoney($form_data["offer"],$userId);
            //check if an offer has been already done
            $offerAlreadyDone=$this->transferts_model->check_offer_already_done($form_data,$teamId);

            if($enoughMoney && !empty($form_data["offer"])){
                //add an offer in database
                if($offerAlreadyDone==TRUE){
                    
                    $this->transferts_model->update_offer($form_data,$teamId);
                    $this->notification_model->addNotification(notifications_rules::TRANSFERT_MODIFIED,$form_data["teamId"],notifications_rules::TYPE_TRANSFERT,$form_data["playerName"],$form_data["playerId"]);
                    
                    $data["confirm_transfert"]=$this->lang->line("offer_modified");
                }else{
                    
                    //$opponentId=$this->manager_model->getUserIdByTeamId($form_data["teamId"]);
                    $this->transferts_model->add_offer($form_data,$teamId,$form_data["teamId"]);
                    //$this->facebook->api($opponentId.'/apprequest?message=test&data=&'.$this->session->userdata('access_token').'&method=post');
                    $this->notification_model->addNotification(notifications_rules::TRANSFERT_PURPOSED,$form_data["teamId"],notifications_rules::TYPE_TRANSFERT,$form_data["playerName"],$form_data["playerId"]);
                    $data["confirm_transfert"]=$this->lang->line("offer_transmitted");
                }
            }else{
                $data["confirm_transfert"]=$this->lang->line("offer_wollars_missing");
            }

            $data["list_offer"]=$this->transferts_model->getOffersByPlayer($form_data["playerId"]);

            $result = $this->load->view('transferts/includes/player_offers_view',$data,true);
            $objResponse->assign("player_offer_center","innerHTML",$result);

            $result = $this->load->view('transferts/includes/confirm_offer_view',$data,true);
            $objResponse->assign("offer","innerHTML",$result);
        }
        sleep(2);
        return $objResponse;

    }

    //Ajax make offer
    public function make_auction_process($form_data){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            $checkEnchere=$this->transferts_model->checkPlayerEnchere($form_data["playerId"]);

            if($checkEnchere){
                //check if user has enough money
                $enoughMoney=$this->money_model->checkEnoughMoney($form_data["offer"],$userId);
                //check if an offer has been already done
                $offerAlreadyDone=$this->transferts_model->check_offer_already_done($form_data,$teamId);
                $lastOffer=$this->transferts_model->getLastOffer($form_data["playerId"]);

                if(!empty($lastOffer)){
                    $lastOffer=$lastOffer[0]["offer"]+1;

                }else{
                    $lastOffer=$form_data["playerValue"]+1;
                }

                if($enoughMoney && !empty($form_data["offer"]) && $lastOffer<=$form_data["offer"]){
                    //add an offer in database
                    if($offerAlreadyDone==TRUE){
                        $this->transferts_model->update_offer($form_data,$teamId);
                        //$this->notification_model->addNotification(notifications_rules::TRANSFERT_MODIFIED,$form_data["teamId"],notifications_rules::TYPE_TRANSFERT,$form_data["playerName"],$form_data["playerId"]);
                        $data["confirm_transfert"]=$this->lang->line("offer_modified");
                    }else{
                        $this->transferts_model->add_offer($form_data,$teamId,0);
                        //$this->notification_model->addNotification(notifications_rules::TRANSFERT_PURPOSED,$form_data["teamId"],notifications_rules::TYPE_TRANSFERT,$form_data["playerName"],$form_data["playerId"]);
                        $data["confirm_transfert"]=$this->lang->line("offer_transmitted");
                    }
                }else{
                    $data["confirm_transfert"]=$this->lang->line("offer_wollars_missing");
                }

                $data["list_offer"]=$this->transferts_model->getOffersByPlayer($form_data["playerId"]);

                $result = $this->load->view('transferts/includes/player_offers_view',$data,true);
                $objResponse->assign("player_offer_center","innerHTML",$result);

                $result = $this->load->view('transferts/includes/confirm_offer_view',$data,true);
                $objResponse->assign("offer","innerHTML",$result);
            }else{
                $objResponse->redirect(base_url().'index.php/transferts/index');
            }
        }
        sleep(2);
        return $objResponse;

    }

    //Ajax make offer
    public function close_auction_process(){

        $players=$this->transferts_model->getPlayersAuction();

        foreach($players as $player){
            $lastOffer=$this->transferts_model->getLastOffer($player["player_id"]);

            if(!empty($lastOffer)){
                $userInfos=$this->manager_model->getUserIdByTeamId($lastOffer[0]["team_sender_id"]);

                //check if user has enough money
                $enoughMoney=$this->money_model->checkEnoughMoney($lastOffer[0]["offer"],$userInfos[0]["user_id"]);

                if($enoughMoney){

                    //money transaction
                    $this->money_model->updateMoney($lastOffer[0]["offer"],$lastOffer[0]["user_id"]);
                    //player transaction
                    $this->players_model->updateTeamPlayer($lastOffer[0]["team_sender_id"],$lastOffer[0]["player_id"]);
                    $this->transferts_model->updateAuctionStatut($player["player_id"],$lastOffer[0]["team_sender_id"],1);
                    $this->transferts_model->deletePlayerOffers($lastOffer[0]["player_id"]);
                }else{
                    $this->transferts_model->deletePlayerOffers($lastOffer[0]["player_id"]);
                    $this->transferts_model->updateAuctionStatut($player["player_id"],0,2);
                }
            }else{
                $this->transferts_model->deletePlayerOffers($player["player_id"]);
                $this->transferts_model->updateAuctionStatut($player["player_id"],0,2);
            }
        }

    }

    //Ajax accept offer
    public function accept_offer_process($form_data){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            $offerInfos=$this->transferts_model->getOffer($form_data["transfertId"]);

            if(!empty($offerInfos)){

                $buyerId=$this->manager_model->getUserIdByTeamId($offerInfos[0]["team_sender_id"]);
                $enoughMoney=$this->money_model->checkEnoughMoney($offerInfos[0]["offer"],$buyerId[0]["user_id"]);

                if($enoughMoney){

                    //money transaction
                    $this->money_model->updateMoney($offerInfos[0]["offer"],$buyerId[0]["user_id"]);
                    $this->money_model->updateSellMoney($offerInfos[0]["offer"],$userId);

                    //player transaction
                    $playerInTeam=$this->players_model->checkPlayerInTeam($offerInfos[0]["player_id"],$teamId);
                    $playerInjuried=$this->players_model->checkPlayerInjury($offerInfos[0]["player_id"]);

                    if($playerInjuried)
                        $this->players_model->updateTeamInjury($offerInfos[0]["player_id"],$offerInfos[0]["team_sender_id"]);

                    if($playerInTeam){
                        $this->team_model->update_deleted_players($teamId);
                        $this->team_model->update_team_not_ready($teamId);
                    }
                    
                    $this->players_model->updateTeamPlayer($offerInfos[0]["team_sender_id"],$offerInfos[0]["player_id"]);
                    $this->players_model->delete_player_team($offerInfos[0]["player_id"]);

                    $selectedPlayers=$this->team_model->get_team_infos($teamId);

                    /*if($selectedPlayers[0]->selected_players!=11)
                    {
                        $this->team_model->update_team_not_ready($teamId);
                    }*/

                    //check player selected in team
                    /*$playerInTeam=$this->players_model->checkPlayerInTeam($offerInfos[0]["player_id"],$teamId);
                    if($playerInTeam)
                        $this->team_model->update_deleted_players($teamId);*/

                    $this->notification_model->addNotification(notifications_rules::TRANSFERT_ACCEPTED,$offerInfos[0]["team_sender_id"],notifications_rules::TYPE_TRANSFERT,$form_data["playerName"],$form_data["playerId"]);
                    $this->transferts_model->deleteOffer($form_data["transfertId"]);

                    //Delete all other offers and send notification
                    $allOffers=$this->transferts_model->getOffersByPlayer($offerInfos[0]["player_id"]);
                    foreach($allOffers as $offer){

                        $this->notification_model->addNotification(notifications_rules::TRANSFERT_REFUSED,$offer->team_sender_id,notifications_rules::TYPE_TRANSFERT,$form_data["playerName"],$form_data["playerId"]);

                    }
                    $this->transferts_model->deleteAllOffers($offerInfos[0]["team_receiver_id"],$offerInfos[0]["player_id"]);

                    $data["messageInfos"]=$this->lang->line("offer_succes");

                }else{

                    $data["messageInfos"]=$this->lang->line("offer_aborted");
                    $this->transferts_model->deleteOffer($form_data["transfertId"]);

                }
            }else{
                $data["messageInfos"]=$this->lang->line("offer_missing");
            }

            $data["transferts_received"]=$this->transferts_model->get_offer_received($teamId);
            $data["my_infos"]=$this->manager_model->get_my_infos();

            $result = $this->load->view('includes/header_view',$data,true);
            $objResponse->assign("header","innerHTML",$result);

            $result = $this->load->view('transferts/includes/received_offer_view',$data,true);
            $objResponse->assign("offers_received","innerHTML",$result);
            
            $result = $this->load->view('includes/infos_view',$data,true);
            $objResponse->assign("message_offer_received","innerHTML",$result);
        }
        
        sleep(2);
        return $objResponse;

    }

    //Ajax refuse offer
    public function refuse_offer_process($form_data){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            $teamId = $this->session->userdata('teamId');

            //send notification and delete offer
            $offerInfos=$this->transferts_model->getOffer($form_data["transfertId"]);

            if(!empty($offerInfos)){

                $this->notification_model->addNotification(notifications_rules::TRANSFERT_REFUSED,$offerInfos[0]["team_sender_id"],notifications_rules::TYPE_TRANSFERT,$form_data["playerName"],$form_data["playerId"]);
                $this->transferts_model->deleteOffer($form_data["transfertId"]);

                //message infos
                $data["transferts_received"]=$this->transferts_model->get_offer_received($teamId);
                $data["messageInfos"]=$this->lang->line("offer_deleted");

            }else{
                $data["transferts_received"]=$this->transferts_model->get_offer_received($teamId);
                $data["messageInfos"]=$this->lang->line("offer_canceled");
            }

            $result = $this->load->view('transferts/includes/received_offer_view',$data,true);
            $objResponse->assign("offers_received","innerHTML",$result);

            $result = $this->load->view('includes/infos_view',$data,true);
            $objResponse->assign("message_offer_received","innerHTML",$result);
        }
        
        sleep(2);
        return $objResponse;

    }

    //Ajax cancel offer
    public function cancel_offer_process($form_data){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            $teamId = $this->session->userdata('teamId');

            //send notification and delete offer
            $offerInfos=$this->transferts_model->getOffer($form_data["transfertId"]);

            if(!empty($offerInfos)){

                $this->notification_model->addNotification(notifications_rules::TRANSFERT_CANCELED,$offerInfos[0]["team_receiver_id"],notifications_rules::TYPE_TRANSFERT,$form_data["playerName"],$form_data["playerId"]);
                $this->transferts_model->deleteOffer($form_data["transfertId"]);

                $data["transferts_sent"]=$this->transferts_model->get_offer_sent($teamId);
                $data["messageInfos"]=$this->lang->line("offer_deleted");

            }else{
                $data["transferts_sent"]=$this->transferts_model->get_offer_sent($teamId);
                $data["messageInfos"]=$this->lang->line("offer_missed");
            }

            $result = $this->load->view('transferts/includes/sent_offer_view',$data,true);
            $objResponse->assign("offers_send","innerHTML",$result);

            $result = $this->load->view('includes/infos_view',$data,true);
            $objResponse->assign("message_offer_sent","innerHTML",$result);
        }
        
        sleep(2);
        return $objResponse;

    }

        //Ajax make offer
    public function modify_price_process($form_data){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            if(!empty($form_data["playerPrice"])){

                //update player price
                $this->players_model->updatePlayerPrice($form_data["playerPrice"],$form_data["playerId"]);
                $objResponse->assign("playerPrice","innerHTML",$form_data["playerPrice"]);

                $data["confirm_transfert"]=$this->lang->line("profil_price_modified");

            }else{
                $data["confirm_transfert"]=$this->lang->line("profil_price_wrong");
            }

            $result = $this->load->view('transferts/includes/confirm_offer_view',$data,true);
            $objResponse->assign("offer","innerHTML",$result);
        }
        
        sleep(2);
        return $objResponse;

    }
    
    public function player_profil()
    {

        $connected = $this->session->userdata('connected_ok');

        if($connected)
        {
            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('transfert', $langageFile);
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{
                redirect("start/begin_game");
            }

            $teamId = $this->session->userdata('teamId');
            //Xajax init function
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'make_offer_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'modify_price_process'));
            /*$this->xajax->configure('debug', true);*/
            $this->xajax->processRequest();
            
            $playerId=$this->uri->segment(3);

            $data["ownPlayer"]=$this->players_model->checkOwnPlayer($teamId,$playerId);

            $teamInfos=$this->players_model->getPlayerTeam($playerId);

            if(!empty($teamInfos)){

                $data["teamName"]=$teamInfos[0]["team_name"];
                $data["teamId"]=$teamInfos[0]["team_id"];

            }else{
                $data["teamId"]=$teamId;
            }

            $data["list_offer"]=$this->transferts_model->getOffersByPlayer($playerId);
            $data["player_infos"]=$this->players_model->get_player_details($playerId);
            $data["my_infos"]=$this->manager_model->get_my_infos();
            $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

            $data["data_url"]=site_url('ofc2/get_data_bar');
            $this->load->view('transferts/player_profil_view',$data);
        }
        else
        {
            redirect('start/begin_game');
        }
    }

    public function naturalisation()
    {

        $connected = $this->session->userdata('connected_ok');

        if($connected)
        {
            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('transfert', $langageFile);
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{
                redirect("start/begin_game");
            }

            $teamId = $this->session->userdata('teamId');
            //Xajax init function
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'naturalisation_process'));
            /*$this->xajax->configure('debug', true);*/
            $this->xajax->processRequest();

            $playerId=$this->uri->segment(3);

            $data["ownPlayer"]=$this->players_model->checkOwnPlayer($teamId,$playerId);

            $teamInfos=$this->players_model->getPlayerTeam($playerId);

            if(!empty($teamInfos)){

                $data["teamName"]=$teamInfos[0]["team_name"];
                $data["teamId"]=$teamInfos[0]["team_id"];

            }else{
                $data["teamId"]=$teamId;
            }

            $data["list_offer"]=$this->transferts_model->getOffersByPlayer($playerId);
            $data["player_infos"]=$this->players_model->get_player_details($playerId);
            $data["my_infos"]=$this->manager_model->get_my_infos();
            $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

            $data["data_url"]=site_url('ofc2/get_data_bar');
            $this->load->view('transferts/naturalisation_view',$data);
        }
        else
        {
            redirect('start/begin_game');
        }
    }



    public function player_auction()
    {

        $connected = $this->session->userdata('connected_ok');

        if($connected)
        {
            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('transfert', $langageFile);
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{
                redirect("start/begin_game");
            }
            
            $teamId = $this->session->userdata('teamId');
            //Xajax init function
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'make_auction_process'));

            //$this->xajax->configure('debug', true);
            $this->xajax->processRequest();

            $playerId=$this->uri->segment(3);

            //$data["ownPlayer"]=$this->players_model->checkOwnPlayer($teamId,$playerId);

            //$teamInfos=$this->players_model->getPlayerTeam($playerId);

            /*if(!empty($teamInfos)){

                $data["teamName"]=$teamInfos[0]["team_name"];
                $data["teamId"]=$teamInfos[0]["team_id"];

            }else{
                $data["teamId"]=$teamId;
            }*/

                $data["list_offer"]=$this->transferts_model->getOffersByPlayer($playerId);
                $data["lastOffer"]=$this->transferts_model->getLastOffer($playerId);
                $data["player_infos"]=$this->players_model->get_player_details($playerId);

                $data["my_infos"]=$this->manager_model->get_my_infos();
                $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

                $this->load->view('transferts/player_auction_view',$data);
        }
        else
        {
            redirect('start/begin_game');
        }
    }

    //Ajax make offer
    public function naturalisation_process($form_data){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            $this->transferts_model->update_player_name($form_data);

            $objResponse->assign("player_name_modified","innerHTML",$form_data["playerName"]);

        }
        sleep(2);
        return $objResponse;

    }
}
?>