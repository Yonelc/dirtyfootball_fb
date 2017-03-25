<?php

class building extends Controller {

/*
|==========================================================
| Constructor
|==========================================================
|
*/
    public function __construct()
    {

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
                $this->lang->load('building', $langageFile);
                $this->lang->load('construction', $langageFile);
                
            }else{
                redirect("start/begin_game");
            }
	            
    }

/*
|==========================================================
|  Main page in building boarding
|==========================================================
|
*/

    public function index()
    {

        $connected = $this->session->userdata('connected_ok');
        $teamId = $this->session->userdata('teamId');
        if($connected){

            //XAJAX init functions
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'buy_stadium_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'sell_stadium_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'buy_formation_center_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'sell_formation_center_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'buy_merchandising_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'sell_merchandising_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'buy_laboratory_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'sell_laboratory_process'));
            /*$this->xajax->configure('debug', true);*/
            $this->xajax->processRequest();

            //load own elements
            $data["myStadium"]=$this->stadium_model->getStadiumId($teamId);
            $data["myFormationCenter"]=$this->formation_center_model->getFormationCenterId($teamId);
            /*$data["myMerchandising"]=$this->merchandising_model->getMerchandisingId($teamId);*/
            $data["myLaboratory"]=$this->laboratory_model->getLaboratoryId($teamId);

            //load elements to buy
            $data["stadiums"]=$this->stadium_model->getStadiums();
            $data["formation_centers"]=$this->formation_center_model->getFormationCenters();
            /*$data["merchandisings"]=$this->merchandising_model->getMerchandisings();*/
            $data["laboratories"]=$this->laboratory_model->getLaboratories();
            
            //load own infos
            $data["my_infos"]=$this->manager_model->get_my_infos();
            $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

            //load view
            $this->load->view('infrastructures/building_view',$data);

        }else{
            redirect('start/begin_game');
        }
    }

/*
|==========================================================
|  Ajax buy stadium process
|==========================================================
|
*/
    public function buy_stadium_process($form_data){

        $objResponse = new xajaxResponse();

        $connected = $this->session->userdata('connected_ok');

        if($connected){
            //load var session
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            //load stadium product infos
            $stadiumInfos=$this->stadium_model->getStadiumInfos($form_data["stadiumId"]);
            if(!$this->stadium_model->checkStadiumAlreadyBought($teamId,$form_data["stadiumId"]))
            {
                $checkCredits=$this->checkPriceAndType($stadiumInfos[0]["value"],$stadiumInfos[0]["type"],$userId);
                if($checkCredits)
                {

                        $this->stadium_model->updateStadiumType($stadiumInfos[0]["stadium_id"],$teamId);
                        $this->refreshBuildingElements($objResponse,$teamId,$userId);

                        $data["messageInfos"]=$this->lang->line('stade_transaction_succes');
                        $stadiumInfos = $this->load->view('includes/infos_view',$data,true);
                        $objResponse->assign("stadium_infos","innerHTML",$stadiumInfos);


                }
            }
        }else{
            redirect("start/begin_game");
        }
        
        sleep(2);
        return $objResponse;

    }

/*
|==========================================================
|  Ajax sell stadium process
|==========================================================
|
*/
    public function sell_stadium_process($form_data){

        $objResponse = new xajaxResponse();

        $connected = $this->session->userdata('connected_ok');

        if($connected){
            //load var session
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            if($this->stadium_model->checkStadiumAlreadyBought($teamId,$form_data["stadiumId"]))
            {
                //load stadium product infos
                $stadiumInfos=$this->stadium_model->getStadiumInfos($form_data["stadiumId"]);

                //sell stadium and update money
                if($stadiumInfos[0]["type"]==infrastructures_rules::MONEY_TYPE)
                    $this->money_model->updateSellMoney($stadiumInfos[0]["value"],$userId);
                else
                    $this->money_model->updateSellDirtyGold($stadiumInfos[0]["value"],$userId);

                $this->stadium_model->sellStadium($teamId);
                $this->refreshBuildingElements($objResponse,$teamId,$userId);

                $data["messageInfos"]= $this->lang->line('stade_sold_succes');
                $stadiumInfos = $this->load->view('includes/infos_view',$data,true);
                $objResponse->assign("stadium_infos","innerHTML",$stadiumInfos);
            }
        }else{
            redirect('start/begin_game');
        }
        sleep(2);
        return $objResponse;

    }

/*
|==========================================================
|  Ajax buy formation center process
|==========================================================
|
*/
    public function buy_formation_center_process($form_data){

        $objResponse = new xajaxResponse();

        $connected = $this->session->userdata('connected_ok');

        if($connected){
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            //load formation center product infos
            $formationCenterInfos=$this->formation_center_model->getFormationCenterInfos($form_data["formationCenterId"]);

            $checkCredits=$this->checkPriceAndType($formationCenterInfos[0]["value"],$formationCenterInfos[0]["type"],$userId);
            if($checkCredits)
            {
                $this->formation_center_model->deleteFormationCenter($teamId);
                $this->formation_center_model->addFormationCenter($formationCenterInfos[0]["formation_center_id"],$teamId);
                $this->refreshBuildingElements($objResponse,$teamId,$userId);
            }
        }else{
            redirect('start/begin_game');
        }
        return $objResponse;

    }

/*
|==========================================================
|  Ajax sell formation center process
|==========================================================
|
*/
    public function sell_formation_center_process($form_data){

        $objResponse = new xajaxResponse();

        $connected = $this->session->userdata('connected_ok');

        if($connected){
            //load var session
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            //load formation center product infos
            $formationCenterInfos=$this->formation_center_model->getFormationCenterInfos($form_data["formationCenterId"]);

            //sell formation center and update money
            if($formationCenterInfos[0]["type"]==infrastructures_rules::MONEY_TYPE)
                $this->money_model->updateSellMoney($formationCenterInfos[0]["value"],$userId);
            else
                $this->money_model->updateSellDirtyGold($formationCenterInfos[0]["value"],$userId);

            $this->formation_center_model->deleteFormationCenter($teamId);

            $this->refreshBuildingElements($objResponse,$teamId,$userId);
        }else{
            redirect('start/begin_game');
        }
        return $objResponse;

    }

/*
|==========================================================
|  Ajax buy laboratory process
|==========================================================
|
*/
    public function buy_laboratory_process($form_data){

        $objResponse = new xajaxResponse();

        $connected = $this->session->userdata('connected_ok');

        if($connected){

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            if(!$this->laboratory_model->checkLabsAlreadyBought($teamId,$form_data["laboratoryId"]))
            {
                //load laboratory product infos
                $laboratoryInfos=$this->laboratory_model->getLaboratoryInfos($form_data["laboratoryId"]);

                $checkCredits=$this->checkPriceAndType($laboratoryInfos[0]["value"],$laboratoryInfos[0]["type"],$userId);
                if($checkCredits)
                {
                    $this->laboratory_model->deleteLaboratory($teamId);
                    $this->laboratory_model->addLaboratory($laboratoryInfos[0]["laboratory_id"],$teamId);
                    $this->refreshBuildingElements($objResponse,$teamId,$userId);
                    $data["messageInfos"]=$this->lang->line('labs_transaction_succes');
                    $stadiumInfos = $this->load->view('includes/infos_view',$data,true);
                    $objResponse->assign("labs_infos","innerHTML",$stadiumInfos);
                }
            }

        }else{
            redirect('start/begin_game');
        }
        sleep(2);
        return $objResponse;

    }

/*
|==========================================================
|  Ajax sell laboratory process
|==========================================================
|
*/
    public function sell_laboratory_process($form_data){

        $objResponse = new xajaxResponse();

        $connected = $this->session->userdata('connected_ok');

        if($connected){
            //load var session
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            
            if($this->laboratory_model->checkLabsAlreadyBought($teamId,$form_data["laboratoryId"]))
            {
                //load formation center product infos
                $laboratoryInfos=$this->laboratory_model->getLaboratoryInfos($form_data["laboratoryId"]);

                //sell formation center and update money
                if($laboratoryInfos[0]["type"]==infrastructures_rules::MONEY_TYPE)
                    $this->money_model->updateSellMoney($laboratoryInfos[0]["value"],$userId);
                else
                    $this->money_model->updateSellDirtyGold($laboratoryInfos[0]["value"],$userId);

                $this->laboratory_model->deleteLaboratory($teamId);

                $this->refreshBuildingElements($objResponse,$teamId,$userId);
                $data["messageInfos"]=$this->lang->line('labs_sold_succes');
                $labsInfos = $this->load->view('includes/infos_view',$data,true);
                $objResponse->assign("labs_infos","innerHTML",$labsInfos);
            }
        }else{
            redirect('start/begin_game');
        }
        sleep(2);
        return $objResponse;

    }


/*
|==========================================================
|  Ajax buy merchandising process
|==========================================================
|
*/
    public function buy_merchandising_process($form_data){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            //load laboratory product infos
            $merchandisingInfos=$this->merchandising_model->getMerchandisingInfos($form_data["merchandisingId"]);

            $checkCredits=$this->checkPriceAndType($merchandisingInfos[0]["value"],$merchandisingInfos[0]["type"],$userId);
            if($checkCredits)
            {
                $this->merchandising_model->deleteMerchandising($teamId);
                $this->merchandising_model->addMerchandising($merchandisingInfos[0]["merchandising_id"],$teamId);
                $this->refreshBuildingElements($objResponse,$teamId,$userId);
            }
        }else{
            redirect('start/begin_game');
        }
        return $objResponse;

    }

/*
|==========================================================
|  Ajax sell merchandising process
|==========================================================
|
*/
    public function sell_merchandising_process($form_data){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            //load var session
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            //load formation center product infos
            $merchandisingInfos=$this->merchandising_model->getMerchandisingInfos($form_data["merchandisingId"]);

            //sell formation center and update money
            if($merchandisingInfos[0]["type"]==infrastructures_rules::MONEY_TYPE)
                $this->money_model->updateSellMoney($merchandisingInfos[0]["value"],$userId);
            else
                $this->money_model->updateSellDirtyGold($merchandisingInfos[0]["value"],$userId);

            $this->merchandising_model->deleteMerchandising($teamId);

            $this->refreshBuildingElements($objResponse,$teamId,$userId);
        }else{
            redirect('start/begin_game');
        }
        return $objResponse;

    }

    /*
|==========================================================
|  Ajax resfresh frames on html page
|==========================================================
|
*/
    public function refreshBuildingElements($objResponse,$teamId,$userId)
    {
        //load own elements
        $data["myStadium"]=$this->stadium_model->getStadiumId($teamId);
        /*$data["myFormationCenter"]=$this->formation_center_model->getFormationCenterId($teamId);
        $data["myMerchandising"]=$this->merchandising_model->getMerchandisingId($teamId);*/
        $data["myLaboratory"]=$this->laboratory_model->getLaboratoryId($teamId);

        //load elements to buy
        $data["stadiums"]=$this->stadium_model->getStadiums();
        /*$data["formation_centers"]=$this->formation_center_model->getFormationCenters();
        $data["merchandisings"]=$this->merchandising_model->getMerchandisings();*/
        $data["laboratories"]=$this->laboratory_model->getLaboratories();

        //load own infos
        $data["my_infos"]=$this->manager_model->get_my_infos();

        $stadiumView = $this->load->view('infrastructures/includes/stadium_content_view',$data,true);
        $objResponse->assign("stadium_frame","innerHTML",$stadiumView);

        $labsView = $this->load->view('infrastructures/includes/labs_content_view',$data,true);
        $objResponse->assign("labs_frame","innerHTML",$labsView);

        /*$merchandisingView = $this->load->view('infrastructures/includes/merchandising_content_view',$data,true);
        $objResponse->assign("merchandising_frame","innerHTML",$merchandisingView);

        $formationCenterView = $this->load->view('infrastructures/includes/formation_center_content_view',$data,true);
        $objResponse->assign("formation_frame","innerHTML",$formationCenterView);*/

        $moneyView = $this->load->view('includes/header_view',$data,true);
        $objResponse->assign("header","innerHTML",$moneyView);

        /*$dirtyGoldView = $this->load->view('includes/dirty_gold_view',$data,true);
        $objResponse->assign("dirty_gold","innerHTML",$dirtyGoldView);*/
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

}
?>