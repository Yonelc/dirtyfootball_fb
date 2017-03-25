<?php

class corruption extends Controller {

	public function __construct(){

            //chargement de la page parent
            parent::Controller();
            date_default_timezone_set('Europe/Paris');
            $this->load->database();
            $this->load->library('pagination');

            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
                $this->lang->load('corruption', $langageFile);
            }else{
                redirect("start/begin_game");
            }
	}

/*
|==========================================================
|  Main page in corruption boarding
|==========================================================
|
*/

    public function index()
    {

        $connected = $this->session->userdata('connected_ok');
        
        if($connected){

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            //XAJAX init functions
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'buy_offensive_method_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'buy_defensive_method_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'buy_match_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'corruption_refused_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'corruption_accepted_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'delete_used_method_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'add_used_method_process'));

            /*$this->xajax->configure('debug', true);*/
            $this->xajax->processRequest();

            //Load infos about next match
            $nextMatchInfos=$this->match_model->getNextCompetitionMatch($teamId);

            if(!empty($nextMatchInfos))
            {
                $corruptedMatch=$this->corruption_model->getCorruptedMatchProposal($nextMatchInfos[0]["match_id"],$teamId);
                if(!empty($corruptedMatch))
                    $data["corruptedMatch"]=$corruptedMatch;

                $data["nextMatch"]=$nextMatchInfos;
                $data["usedOffensiveMethods"]=$this->corruption_model->getUsedOffensiveMethods($teamId/*,$nextMatchInfos[0]["match_id"]*/);
                $data["usedDefensiveMethods"]=$this->corruption_model->getUsedDefensiveMethods($teamId/*,$nextMatchInfos[0]["match_id"]*/);
            }

            $data["usedOffensiveMethods"]=$this->corruption_model->getUsedOffensiveMethods($teamId/*,$nextMatchInfos[0]["match_id"]*/);
            $data["usedDefensiveMethods"]=$this->corruption_model->getUsedDefensiveMethods($teamId/*,$nextMatchInfos[0]["match_id"]*/);

            //Own corruption elements
            $ownLaboratoryLevel=$this->corruption_model->getOwnLaboratoryLevel($teamId);
            $data["ownOffensiveMethods"]=$this->corruption_model->getOwnOffensiveMethods($teamId);
            $data["ownDefensiveMethods"]=$this->corruption_model->getOwnDefensiveMethods($teamId);
            $data["ownFriendsLevel"]=$this->friends_model->getNbUserFriends($userId);


            if(count($ownLaboratoryLevel)!=0)
            {
                $data["ownLaboratoryLevel"]=$ownLaboratoryLevel[0]["level"];
            }else{
                $data["ownLaboratoryLevel"]=0;
            }
                
            //Corruption elements to buy
            $data["offensiveMethods"]=$this->corruption_model->getOffensiveMethods();
            $data["defensiveMethods"]=$this->corruption_model->getDefensiveMethods();

            $data["potentielPrimaire"]=$this->team_model->get_primary_skills();
            $data["potentielSecondaire"]=$this->team_model->get_secondary_skills();

            $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);
 
            //load own infos
            $data["my_infos"]=$this->manager_model->get_my_infos();
            $data["holiday"]=$this->manager_model->checkHoliday($teamId);

            //load view
            $this->load->view('corruption/corruption_view',$data);

        }else{
            redirect('start/begin_game');
        }
    }

/*
|==========================================================
|  ajax buy match process
|==========================================================
|
*/

    public function buy_match_process($form_data)
    {
        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            //load var session
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            //check if user has enough money
            $enoughMoney=$this->money_model->checkEnoughMoney($form_data["offer"],$userId);

            if($enoughMoney){

                if(!empty($form_data["offer"]))
                {
                    if(!$this->match_model->checkMatchAlreadyBought($form_data["matchId"]))
                    {
                        $this->match_model->buyNextMatch($form_data["matchId"],$form_data["offer"],$teamId,$form_data["receiver"]);
                        $teamName=$this->team_model->get_team_name($teamId);
                        $this->notification_model->addNotification(notifications_rules::CORRUPTION_PROPOSE,$form_data["receiver"],notifications_rules::TYPE_INFORMATION,$teamName,$form_data["offer"]);
                        $objResponse->assign("submit_feedback","innerHTML",$this->lang->line("corruption_buy_transmitted"));
                    }
                    else
                    {
                        $objResponse->assign("submit_feedback","innerHTML",$this->lang->line("corruption_buy_aborted"));
                    }

                }
                else
                {
                    $objResponse->assign("submit_feedback","innerHTML",$this->lang->line("corruption_empty"));
                }
            }else{
                $objResponse->assign("submit_feedback","innerHTML",$this->lang->line("corruption_money"));
            }
        }
        sleep(2);
        return $objResponse;
    }

/*
|==========================================================
|  ajax corruption refused
|==========================================================
|
*/

    public function corruption_refused_process()
    {
        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            //load var session
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            $nextMatchInfos=$this->match_model->getNextCompetitionMatch($teamId);

            $teamName=$this->team_model->get_team_name($teamId);
            $corruptionInfos=$this->corruption_model->getCorruptionInfos($nextMatchInfos[0]["match_id"]);

            $this->notification_model->addNotification(notifications_rules::CORRUPTION_REFUSE,$corruptionInfos[0]["sender"],notifications_rules::TYPE_INFORMATION,$teamName,$corruptionInfos[0]["value"]);

            if(!empty($nextMatchInfos))
            {
                $corruptedMatch=$this->corruption_model->getCorruptedMatchProposal($nextMatchInfos[0]["match_id"],$teamId);
                if(!empty($corruptedMatch))
                    $data["corruptedMatch"]=$corruptedMatch;

                $data["nextMatch"]=$nextMatchInfos;
                $data["messageInfos"]=$this->lang->line("corruption_refused");

            }
            
            $this->corruption_model->corruptionRefused($nextMatchInfos[0]["match_id"]);
            $buyMatchView = $this->load->view('corruption/includes/response_buy_match_view',$data,true);
            $objResponse->assign("match_frame","innerHTML",$buyMatchView);
            /*$objResponse->assign("submit_feedback","innerHTML",'Vous avez refusé l\'offre de corruption' );*/
        }
        sleep(2);
        return $objResponse;
    }

/*
|==========================================================
|  ajax corruption accepted
|==========================================================
|
*/

    public function corruption_accepted_process($form_data)
    {
        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            //load var session
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            $nextMatchInfos=$this->match_model->getNextCompetitionMatch($teamId);
            $teamName=$this->team_model->get_team_name($teamId);
            
            $data["corruptedMatch"]=$this->corruption_model->getCorruptedMatchProposal($nextMatchInfos[0]["match_id"],$teamId);
            $data["nextMatch"]=$nextMatchInfos;
            $corruptionInfos=$this->corruption_model->getCorruptionInfos($nextMatchInfos[0]["match_id"]);

            $senderId=$this->manager_model->getUserIdByTeamId($corruptionInfos[0]["sender"]);

            //check if user has enough money
            $enoughMoney=$this->money_model->checkEnoughMoney($corruptionInfos[0]["value"],$senderId[0]["user_id"]);

            if($enoughMoney){
                
                //money transaction
                $this->money_model->updateMoney($corruptionInfos[0]["value"],$senderId[0]["user_id"]);
                $this->money_model->updateSellMoney($corruptionInfos[0]["value"],$userId);
                $this->notification_model->addNotification(notifications_rules::CORRUPTION_ACCEPTE,$corruptionInfos[0]["sender"],notifications_rules::TYPE_INFORMATION,$teamName,$corruptionInfos[0]["value"]);
                $this->corruption_model->corruptionAccepted($nextMatchInfos[0]["match_id"]);
                $data["messageInfos"]=$this->lang->line("corruption_accepted");

            }else{
                $this->notification_model->addNotification(notifications_rules::CORRUPTION_ABORTED,$corruptionInfos[0]["sender"],notifications_rules::TYPE_INFORMATION,$teamName,$corruptionInfos[0]["value"]);
                $data["messageInfos"]=$this->lang->line("corruption_not_enought_money");
            }

            $buyMatchView = $this->load->view('corruption/includes/response_buy_match_view',$data,true);
            $objResponse->assign("match_frame","innerHTML",$buyMatchView);
            
        }
        sleep(2);
        return $objResponse;
    }
    
/*
|==========================================================
|  Ajax buy defensive methods process
|==========================================================
|
*/
    public function buy_defensive_method_process($form_data){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            //load var session
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            //load items product infos
            $defensiveMethodInfos=$this->corruption_model->getDefensiveMethodInfos($form_data["defensiveMethodId"]);

            //check if player have money and update his wallet
            $checkCredits=$this->checkPriceAndType($defensiveMethodInfos[0]["value"],$defensiveMethodInfos[0]["type"],$userId);
            if($checkCredits)
            {
              $check=$this->corruption_model->checkDefensiveMethod($defensiveMethodInfos[0]["corruption_defensive_id"],$teamId);
              //check if player already has this defensive method
              if($check==TRUE)
              {
                $this->corruption_model->updateDefensiveMethod($defensiveMethodInfos[0]["corruption_defensive_id"],$teamId,corruption_rules::ADD_ACTION);
              }else{
                $this->corruption_model->addDefensiveMethod($defensiveMethodInfos[0]["corruption_defensive_id"],$teamId);
              }
              
              $this->refreshCorruptionElements($objResponse,$teamId,$userId);
              $data["messageInfos"]=$this->lang->line("bonus_transaction_succes_defensif");
              $defensiveInfos = $this->load->view('includes/infos_view',$data,true);
              $objResponse->assign("defensive_infos","innerHTML",$defensiveInfos);

            }
        }
        sleep(2);
        return $objResponse;

    }

/*
|==========================================================
|  Ajax buy offensive methods process
|==========================================================
|
*/
    public function buy_offensive_method_process($form_data){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            //load var session
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            //load items product infos
            $offensiveMethodInfos=$this->corruption_model->getOffensiveMethodInfos($form_data["offensiveMethodId"]);

            //check if player have money and update his wallet
            $checkCredits=$this->checkPriceAndType($offensiveMethodInfos[0]["value"],$offensiveMethodInfos[0]["type"],$userId);
            if($checkCredits)
            {

              //check if player already has this defensive method
              $check=$this->corruption_model->checkOffensiveMethod($offensiveMethodInfos[0]["corruption_offensive_id"],$teamId);
              if($check==TRUE)
              {
                $this->corruption_model->updateOffensiveMethod($offensiveMethodInfos[0]["corruption_offensive_id"],$teamId,corruption_rules::ADD_ACTION);
              }else{
                $this->corruption_model->addOffensiveMethod($offensiveMethodInfos[0]["corruption_offensive_id"],$teamId,corruption_rules::ADD_ACTION);
              }

              $this->refreshCorruptionElements($objResponse,$teamId,$userId);
              $data["messageInfos"]=$this->lang->line("bonus_transaction_succes_offensif");
              $offensiveInfos = $this->load->view('includes/infos_view',$data,true);
              $objResponse->assign("offensive_infos","innerHTML",$offensiveInfos);

            }
        }
        sleep(2);
        return $objResponse;

    }

 /*
|==========================================================
|  check money type and value and update credits on bought
|==========================================================
|
*/
    public function checkPriceAndType($price,$type,$userId)
    {
        if($type==infrastructures_rules::MONEY_TYPE)
        {
            if($this->money_model->checkEnoughMoney($price,$userId))
            {
                $this->money_model->updateMoney($price,$userId);
                return TRUE;
            }else{
                return FALSE;
            }
                $this->money_model->updateDirtyGold($price,$userId);
        }

        if($type==infrastructures_rules::DIRTYGOLD_TYPE)
        {
            if($this->money_model->checkEnoughDirtyGold($price,$userId))
            {
                $this->money_model->updateDirtyGold($price,$userId);
                return TRUE;
            }else{
                return FALSE;
            }
        }
    }

/*
|==========================================================
|  Ajax resfresh frames on html page
|==========================================================
|
*/
    public function refreshCorruptionElements($objResponse,$teamId,$userId)
    {
        //Load infos about next match
        $nextMatchInfos=$this->match_model->getNextCompetitionMatch($teamId);

        if(!empty($nextMatchInfos))
        {
            $corruptedMatch=$this->corruption_model->getCorruptedMatchProposal($nextMatchInfos[0]["match_id"],$teamId);
            if(!empty($corruptedMatch))
                $data["corruptedMatch"]=$corruptedMatch;

            $data["nextMatch"]=$nextMatchInfos;
            $data["usedOffensiveMethods"]=$this->corruption_model->getUsedOffensiveMethods($teamId,$nextMatchInfos[0]["match_id"]);
            $data["usedDefensiveMethods"]=$this->corruption_model->getUsedDefensiveMethods($teamId,$nextMatchInfos[0]["match_id"]);
        }
            $data["usedOffensiveMethods"]=$this->corruption_model->getUsedOffensiveMethods($teamId/*,$nextMatchInfos[0]["match_id"]*/);
            $data["usedDefensiveMethods"]=$this->corruption_model->getUsedDefensiveMethods($teamId/*,$nextMatchInfos[0]["match_id"]*/);
        //Own corruption elements
        $ownLaboratoryLevel=$this->corruption_model->getOwnLaboratoryLevel($teamId);
        $data["ownOffensiveMethods"]=$this->corruption_model->getOwnOffensiveMethods($teamId);
        $data["ownDefensiveMethods"]=$this->corruption_model->getOwnDefensiveMethods($teamId);
        $data["ownFriendsLevel"]=$this->friends_model->getNbUserFriends($userId);


        $ownLaboratoryLevel=$this->corruption_model->getOwnLaboratoryLevel($teamId);
        $data["ownFriendsLevel"]=$this->friends_model->getNbUserFriends($userId);
        
        if(count($ownLaboratoryLevel)!=0)
        {
            $data["ownLaboratoryLevel"]=$ownLaboratoryLevel[0]["level"];
        }else{
            $data["ownLaboratoryLevel"]=0;
        }


        //load elements to buy
        $data["offensiveMethods"]=$this->corruption_model->getOffensiveMethods();
        $data["defensiveMethods"]=$this->corruption_model->getDefensiveMethods();

        //load own infos
        $data["my_infos"]=$this->manager_model->get_my_infos();
        $data["holiday"]=$this->manager_model->checkHoliday($teamId);

        $ownBonusUsedListView = $this->load->view('corruption/includes/own_bonus_used_list_view',$data,true);
        $objResponse->assign("own_bonus_used_list","innerHTML",$ownBonusUsedListView);

        $ownBonusListView = $this->load->view('corruption/includes/own_bonus_list_view',$data,true);
        $objResponse->assign("own_bonus_list","innerHTML",$ownBonusListView);

        $stadiumView = $this->load->view('corruption/includes/offensive_content_view',$data,true);
        $objResponse->assign("offensive_frame","innerHTML",$stadiumView);

        $labsView = $this->load->view('corruption/includes/defensive_content_view',$data,true);
        $objResponse->assign("defensive_frame","innerHTML",$labsView);

        $moneyView = $this->load->view('includes/header_view',$data,true);
        $objResponse->assign("header","innerHTML",$moneyView);

    }

/*
|==========================================================
|  Ajax add used methods process
|==========================================================
|
*/
    public function add_used_method_process($form_data){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            //load var session
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            if($form_data["methodType"]==corruption_rules::OFFENSIVE_METHOD){
                $methodExist=$this->corruption_model->checkCountOffensiveMethod($form_data["methodId"],$teamId);


                if($methodExist){
                    $offensiveInfos=$this->corruption_model->getOffensiveMethodInfos($form_data["methodId"]);
                    $this->corruption_model->updateOffensiveMethod($form_data["methodId"],$teamId,corruption_rules::USE_ACTION);
                    $this->corruption_model->increaseTeamPrimaryPotential($offensiveInfos[0]["capacity"],$teamId,$offensiveInfos[0]["sector"]);
                    $this->corruption_model->increaseTeamSecondaryPotential($offensiveInfos[0]["capacity"],$teamId,$offensiveInfos[0]["sector"]);

                    $this->corruption_model->insertUsedMethod($form_data["methodId"],$teamId,$form_data["matchId"],$form_data["methodType"]);
                }
            }else{

                $methodExist=$this->corruption_model->checkCountDefensiveMethod($form_data["methodId"],$teamId);

                if($methodExist){
                    $defensiveInfos=$this->corruption_model->getDefensiveMethodInfos($form_data["methodId"]);
                    $this->corruption_model->updateDefensiveMethod($form_data["methodId"],$teamId,corruption_rules::USE_ACTION);
                    $this->corruption_model->increaseTeamPrimaryPotential($defensiveInfos[0]["capacity"],$teamId,$defensiveInfos[0]["sector"]);
                    $this->corruption_model->increaseTeamSecondaryPotential($defensiveInfos[0]["capacity"],$teamId,$defensiveInfos[0]["sector"]);

                    $this->corruption_model->insertUsedMethod($form_data["methodId"],$teamId,$form_data["matchId"],$form_data["methodType"]);
                }
            }

            $this->refreshCorruptionElements($objResponse,$teamId,$userId);

            $data["potentielPrimaire"]=$this->team_model->get_primary_skills();
            $data["potentielSecondaire"]=$this->team_model->get_secondary_skills();

            $infosView = $this->load->view('corruption/includes/potential_view',$data,true);
            $objResponse->assign("experience","innerHTML",$infosView);
        }
        sleep(2);
        return $objResponse;

    }


/*
|==========================================================
|  Ajax delete used methods process
|==========================================================
|
*/
    public function delete_used_method_process($form_data){

        $objResponse = new xajaxResponse();
        //load var session
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            if($form_data["methodType"]==corruption_rules::OFFENSIVE_METHOD){

                $methodExist=$this->corruption_model->checkUsedMethod($teamId,$form_data["usedId"],2);

                if($methodExist){
                    $this->corruption_model->deleteUsedMethod($form_data["usedId"]);
                    $offensiveInfos=$this->corruption_model->getOffensiveMethodInfos($form_data["methodId"]);
                    $this->corruption_model->updateOffensiveMethod($form_data["methodId"],$teamId,corruption_rules::ADD_ACTION);
                    $this->corruption_model->decreaseTeamPrimaryPotential($offensiveInfos[0]["capacity"],$teamId,$offensiveInfos[0]["sector"]);
                    $this->corruption_model->decreaseTeamSecondaryPotential($offensiveInfos[0]["capacity"],$teamId,$offensiveInfos[0]["sector"]);

                }

            }else{

                $methodExist=$this->corruption_model->checkUsedMethod($teamId,$form_data["usedId"],1);
                
                if($methodExist){
                    $this->corruption_model->deleteUsedMethod($form_data["usedId"]);
                    $defensiveInfos=$this->corruption_model->getDefensiveMethodInfos($form_data["methodId"]);
                    $this->corruption_model->updateDefensiveMethod($form_data["methodId"],$teamId,corruption_rules::ADD_ACTION);
                    $this->corruption_model->decreaseTeamPrimaryPotential($defensiveInfos[0]["capacity"],$teamId,$defensiveInfos[0]["sector"]);
                    $this->corruption_model->decreaseTeamSecondaryPotential($defensiveInfos[0]["capacity"],$teamId,$defensiveInfos[0]["sector"]);

                }
            }
            $this->refreshCorruptionElements($objResponse,$teamId,$userId);

            $data["potentielPrimaire"]=$this->team_model->get_primary_skills();
            $data["potentielSecondaire"]=$this->team_model->get_secondary_skills();

            $infosView = $this->load->view('corruption/includes/potential_view',$data,true);
            $objResponse->assign("experience","innerHTML",$infosView);
        }
        sleep(2);
        return $objResponse;

    }

}?>