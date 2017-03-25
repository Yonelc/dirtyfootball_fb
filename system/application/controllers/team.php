<?php

class team extends Controller {

    const PLAYERS_IN=11;
    const CHOICE="DELETE";


/*
|==========================================================
| Constructor
|==========================================================
|
*/
    public function __construct(){

        //chargement de la page parent
        parent::Controller();
        date_default_timezone_set('Europe/Paris');
        $this->load->database();

        //langage loading
        $langageFile=$this->session->userdata('langage');

        if(!empty($langageFile)){
            $this->lang->load('team', $langageFile);
            $this->lang->load('menu', $langageFile);
            $this->lang->load('footer', $langageFile);
        }else{
            redirect("start/begin_game");
        }

        //configuration facebook
       $this->load->plugin('facebook');
        $this->facebook = new Facebook(array(
              'appId'  => APP_ID,
              'secret' => SECRET_KEY,
              'cookie' => False,
              'domain'=>FACEBOOK_DOMAIN,
        ));
    }

/*
|==========================================================
| Index TODO
|==========================================================
|
*/
    public function index()
    {
        $this->composition();
    }

/*
|==========================================================
| First time to composition/tactic view
|==========================================================
|
*/

    public function composition(){
        
        $connected = $this->session->userdata('connected_ok');
        
        if($connected){

            //Init XAJAX
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'tactic_team_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'position_team_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'delete_player_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'validation_team_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'add_sponsor_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'train_team_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'changeTransfertStatut_process'));
            /*$this->xajax->configure('debug', true);*/
            $this->xajax->processRequest();

            $teamId = $this->session->userdata('teamId');
            //return user infos
            $data["my_infos"]=$this->manager_model->get_my_infos();
            //return all players of the team
            $data["players"] = $this->players_model->get_all_players();
            //return the selection
            $data["team_sheet"] = $this->players_model->get_team_sheet();
            //return all free players in team
            $data["players_free"] = $this->players_model->get_players_free();
            //return selected shirt numbers
            $data["numbers_selected"] = $this->players_model->get_selected_shirt_numbers();
            //return the number of selected players
            $data["nb_players"]=count($data["players_free"]);

            //return the database informations of a team
            $data["team_infos"] = $this->team_model->get_team_infos($teamId);
            //return the number of selected player in the team
            foreach($data["team_infos"] as $row){

                $selectedPlayers=$row->selected_players;
            }

            //Return player skills
            $playersSkillsArr=$this->players_model->get_all_selected_players_skills($teamId);
            //Calculate basic team experience
            $data["teamExperiences"]=$this->team_model->estimate_team_experiences($playersSkillsArr);

            //Calculate team experience with bonus
            $offensiveBonusUsed=$this->corruption_model->getOffensiveBonusUsed($teamId);
            $defensiveBonusUsed=$this->corruption_model->getDefensiveBonusUsed($teamId);

            $this->estimate_experience_bonus($offensiveBonusUsed,$teamId);
            $this->estimate_experience_bonus($defensiveBonusUsed,$teamId);

            //Check if the team is ready
            if($selectedPlayers==11)
            {
                $data["team_ok"]=TRUE;
                $data["team_completed"]=$this->lang->line('team_complete');
            }else{
                $data["team_ok"]=FALSE;
                $data["team_completed"]=$this->lang->line('team_not_complete');
            }
            //return all tactics
            $data["tactics"] = $this->team_model->get_all_tactics();
            //return tactic's team
            $data["tacticId"] = $this->team_model->get_one_tactic_by_team();

            $data["tacticInfos"]=$this->team_model->get_team_tactic_infos($teamId);

            $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);
            $data["sponsors"]=$this->sponsors_model->getSponsors();
            
            //return if a team is ready for a match
            $data["ready"]=$this->team_model->is_team_ready($teamId);

            //reset training team
            $this->training_model->resetTraining($teamId);
            
            //reset injury players
            $this->players_model->playerInjuryEnd($teamId);

            $data["trainingInfos"]=$this->training_model->getTeamTraining($teamId);

            $data["messageInfos"]=$this->lang->line('effectif_info_transfert');

            $this->load->view('team/composition_view',$data);

        }else{
            
            redirect('start/begin_game');
        }
    }
/*
|==========================================================
| Ajax Validation team
|==========================================================
|
*/

   /* public function validation_team_process($form_data){


        $teamId = $this->session->userdata('teamId');
        $objResponse = new xajaxResponse();
        //update validation team
        $this->team_model->update_team_ready($teamId);

        //return user infos
        $data["my_infos"]=$this->manager_model->get_my_infos();

        //return the selection
        $data["team_sheet"] = $this->players_model->get_team_sheet();
        //return all free players in team
        $data["players_free"] = $this->players_model->get_players_free();
        //return selected shirt numbers
        $data["numbers_selected"] = $this->players_model->get_selected_shirt_numbers();
        //return the number of selected players
        $data["nb_players"]=count($data["players_free"]);

        //return the database informations of a team
        $data["team_infos"] = $this->team_model->get_team_infos($teamId);
        //return the number of selected player in the team
        foreach($data["team_infos"] as $row){

            $selectedPlayers=$row->selected_players;
        }

        //return the tactic of the team
        $tacticsId = $this->team_model->get_one_tactic_by_team();
        $data["tacticId"] = $tacticsId;

        foreach($tacticsId as $row)
        {
           $tacticId=$row->tactic_id;
        }

        //return the tactic selected
        $data["tactics"] = $this->team_model->get_one_tactic($tacticId);

        //Return players skills
        $playerSkills=$this->players_model->get_all_selected_players_skills($teamId);
        //Calculate team experience
        $data["teamExperiences"]=$this->team_model->estimate_team_experiences($playerSkills);
        //Calculate team experience with bonus
        $offensiveBonusUsed=$this->corruption_model->getOffensiveBonusUsed($teamId);
        $defensiveBonusUsed=$this->corruption_model->getDefensiveBonusUsed($teamId);

        $this->estimate_experience_bonus($offensiveBonusUsed,$teamId);
        $this->estimate_experience_bonus($defensiveBonusUsed,$teamId);

        if($selectedPlayers==11)
        {
          $data["team_ok"]=TRUE;
          $data["team_completed"]=$this->lang->line('team_complete');
        }else{
          $data["team_ok"]=FALSE;
          $data["team_completed"]=$this->lang->line('team_not_complete');
        }

        $data["tacticInfos"]=$this->team_model->get_team_tactic_infos($teamId);
        //return if a team is ready for a match
        $data["ready"]=$this->team_model->is_team_ready($teamId);
        $result =$this->load->view('team/includes/validation_team_view',$data,true);
        $objResponse->assign("tactic","innerHTML",$result);

        return $objResponse;

    }*/

/*
|==========================================================
| Ajax player team position(attribue la position du joueur)
|==========================================================
|
*/
    
    public function position_team_process($formData){

        
        $objResponse = new xajaxResponse();

        $connected = $this->session->userdata('connected_ok');

        if($connected){
            $teamId = $this->session->userdata('teamId');

            $shirtNumberExist=$this->team_model->checkShirtNumberAlreadyUsed($formData["shirt_number"],$teamId);

            if(!$shirtNumberExist && !empty($formData["playerId"])){
                //update the shirt number of a player
                $updateShirtNumber=$this->players_model->update_shirt_number($formData);

                if($updateShirtNumber){
                    //update the number of players selected in the team
                    $this->team_model->update_selected_players($teamId);
                }
            }

            //Return player skills
            $playersSkillsArr=$this->players_model->get_all_selected_players_skills($teamId);
            //Calculate team experience
            $data["teamExperiences"]=$this->team_model->estimate_team_experiences($playersSkillsArr);
            //Calculate team experience with bonus
            $offensiveBonusUsed=$this->corruption_model->getOffensiveBonusUsed($teamId);
            $defensiveBonusUsed=$this->corruption_model->getDefensiveBonusUsed($teamId);

            $this->estimate_experience_bonus($offensiveBonusUsed,$teamId);
            $this->estimate_experience_bonus($defensiveBonusUsed,$teamId);

            $data["team_infos"] = $this->team_model->get_team_infos($teamId);
            //return the number of selected player in the team
            foreach($data["team_infos"] as $row){

                $selectedPlayers=$row->selected_players;
            }

            //Check if the team is ready
            if($selectedPlayers==11)
            {
                $this->team_model->update_team_ready($teamId);
                $data["team_ok"]=TRUE;
                $data["team_completed"]=$this->lang->line('team_complete');
            }else{
                $this->team_model->update_team_not_ready($teamId);
                $data["team_ok"]=FALSE;
                $data["team_completed"]=$this->lang->line('team_not_complete');
            }

            //return the players in the sheet
            $data["team_sheet"] = $this->players_model->get_team_sheet();
            //return the player who are free yet
            $data["players_free"] = $this->players_model->get_players_free();
            //return the shirt numbers selected
            $data["numbers_selected"] = $this->players_model->get_selected_shirt_numbers();
            //return the number of free players
            $data["nb_players"]=count($data["players_free"]);

            $tacticInfos=$this->team_model->get_team_tactic_infos($teamId);
            $data["tacticInfos"]=$tacticInfos;

            $data["ready"]=$this->team_model->is_team_ready($teamId);

            $result = $this->load->view('team/includes/selection_view',$data,true);
            $objResponse->assign("team_frame","innerHTML",$result);

            $result = $this->load->view('team/includes/experiences_view',$data,true);
            $objResponse->assign("exp_team","innerHTML",$result);

            $result = $this->load->view('team/includes/button_validation_view',$data,true);
            $objResponse->assign("team_validation","innerHTML",$result);

            /*$result = $this->load->view('team/includes/tactics/tactic_css_'.$tacticInfos[0]["tactic_id"].'_view',$data,true);
            $objResponse->assign("style","innerHTML",$result);*/

            $result = $this->load->view('team/includes/tactics/tactic_name_'.$tacticInfos[0]["tactic_id"].'_view',$data,true);
            $objResponse->assign("player_name","innerHTML",$result);

        }else{

            redirect('start/begin_game');
        }

        return $objResponse;

    }

/*
|==========================================================
| Ajax Delete player from team sheet
|==========================================================
|
*/
    
    public function delete_player_process($formData){
        
        $objResponse = new xajaxResponse();

        $connected = $this->session->userdata('connected_ok');

        if($connected){
            $teamId = $this->session->userdata('teamId');
            //Insert into the database

            $shirtNumberExist=$this->players_model->checkPlayerInTeam($formData["playerId"],$teamId);
            if($shirtNumberExist){
                $deletePlayerTeam=$this->players_model->delete_player_team($formData["playerId"]);
                if($deletePlayerTeam){
                    //update the number of players selected in the team
                    $this->team_model->update_deleted_players($teamId);
                }
            }

            //load all player sheet
            $data["team_sheet"] = $this->players_model->get_team_sheet();
            //load players are not selected yet
            $data["players_free"] = $this->players_model->get_players_free();
            //load shirt numbers already selected
            $data["numbers_selected"] = $this->players_model->get_selected_shirt_numbers();
            //return the number of free players
            $data["nb_players"]=count($data["players_free"]);

            //Return players skills
            $playerSkills=$this->players_model->get_all_selected_players_skills($teamId);
            //Calculate team experience
            $data["teamExperiences"]=$this->team_model->estimate_team_experiences($playerSkills);
            //Calculate team experience with bonus
            $offensiveBonusUsed=$this->corruption_model->getOffensiveBonusUsed($teamId);
            $defensiveBonusUsed=$this->corruption_model->getDefensiveBonusUsed($teamId);

            $this->estimate_experience_bonus($offensiveBonusUsed,$teamId);
            $this->estimate_experience_bonus($defensiveBonusUsed,$teamId);

            //return the database informations of a team
            $data["team_infos"] = $this->team_model->get_team_infos($teamId);
            //return the number of selected player in the team
            foreach($data["team_infos"] as $row){

                $selectedPlayers=$row->selected_players;
            }

            //Check if the team is ready
            if($selectedPlayers==11)
            {
                $this->team_model->update_team_ready($teamId);
                $data["team_ok"]=TRUE;
                $data["team_completed"]=$this->lang->line('team_complete');
            }else{
                $this->team_model->update_team_not_ready($teamId);
                $data["team_ok"]=FALSE;
                $data["team_completed"]=$this->lang->line('team_not_complete');
            }

            $data["selected_players"]=$selectedPlayers;
            $data["nb_players"]=count($data["players_free"]);
            $tacticInfos=$this->team_model->get_team_tactic_infos($teamId);
            $data["tacticInfos"]=$tacticInfos;

            $data["ready"]=$this->team_model->is_team_ready($teamId);


            $result = $this->load->view('team/includes/selection_view',$data,true);
            $objResponse->assign("team_frame","innerHTML",$result);

            $result = $this->load->view('team/includes/experiences_view',$data,true);
            $objResponse->assign("exp_team","innerHTML",$result);

            $result = $this->load->view('team/includes/button_validation_view',$data,true);
            $objResponse->assign("team_validation","innerHTML",$result);

            /*$result = $this->load->view('team/includes/tactics/tactic_css_'.$tacticInfos[0]["tactic_id"].'_view',$data,true);
            $objResponse->assign("style","innerHTML",$result);*/

            $result = $this->load->view('team/includes/tactics/tactic_name_'.$tacticInfos[0]["tactic_id"].'_view',$data,true);
            $objResponse->assign("player_name","innerHTML",$result);

        }else{

            redirect('start/begin_game');
        }
        return $objResponse;

    }

/*
|==========================================================
| Ajax change team tactics
|==========================================================
|
*/

    public function tactic_team_process($form_data){

        
        
        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');
        
        if($connected){
            $teamId = $this->session->userdata('teamId');

            //load all player sheet
            $data["team_sheet"] = $this->players_model->get_team_sheet();
            //load players are not selected yet
            $data["players_free"] = $this->players_model->get_players_free();
            //load shirt numbers already selected
            $data["numbers_selected"] = $this->players_model->get_selected_shirt_numbers();
            //return the number of free players
            $data["nb_players"]=count($data["players_free"]);

            //update the tactic of the team
            $this->team_model->update_tactic_team($form_data["tacticId"]);
            //return the tactic selected
            $data["tactics"] = $this->team_model->get_one_tactic($form_data["tacticId"]);

            //Return players skills
            $playerSkills=$this->players_model->get_all_selected_players_skills($teamId);
            //Calculate team experience
            $data["teamExperiences"]=$this->team_model->estimate_team_experiences($playerSkills);
            //Calculate team experience with bonus
            $offensiveBonusUsed=$this->corruption_model->getOffensiveBonusUsed($teamId);
            $defensiveBonusUsed=$this->corruption_model->getDefensiveBonusUsed($teamId);

            $this->estimate_experience_bonus($offensiveBonusUsed,$teamId);
            $this->estimate_experience_bonus($defensiveBonusUsed,$teamId);

            $tacticInfos=$this->team_model->get_team_tactic_infos($teamId);
            $data["tacticInfos"]=$tacticInfos;



            //return the database informations of a team
            $data["team_infos"] = $this->team_model->get_team_infos($teamId);
            //return the number of selected player in the team
            foreach($data["team_infos"] as $row){

                $selectedPlayers=$row->selected_players;
            }

            //Check if the team is ready
            if($selectedPlayers==11)
            {
                $data["team_ok"]=TRUE;
                $data["team_completed"]=$this->lang->line('team_complete');
            }else{
                $data["team_ok"]=FALSE;
                $data["team_completed"]=$this->lang->line('team_not_complete');
            }

            $data["selected_players"]=$selectedPlayers;
            $data["nb_players"]=count($data["players_free"]);
            $data["ready"]=$this->team_model->is_team_ready($teamId);

            $result = $this->load->view('team/includes/tactic_view',$data,true);
            $objResponse->assign("football_field","innerHTML",$result);

            $result = $this->load->view('team/includes/experiences_view',$data,true);
            $objResponse->assign("exp_team","innerHTML",$result);

            $result = $this->load->view('team/includes/selection_view',$data,true);
            $objResponse->assign("team_frame","innerHTML",$result);

            /*$result = $this->load->view('team/includes/tactics/tactic_css_'.$tacticInfos[0]["tactic_id"].'_view',$data,true);
            $objResponse->assign("style","innerHTML",$result);*/

            $result = $this->load->view('team/includes/tactics/tactic_name_'.$tacticInfos[0]["tactic_id"].'_view',$data,true);
            $objResponse->assign("player_name","innerHTML",$result);

        }else{

            redirect('start/begin_game');
        }
        

        return $objResponse;

    }

/*
|==========================================================
| Team profil
|==========================================================
|
*/
    public function team_profil()
    {
        $teamId=$this->uri->segment(3);

        if(!empty($teamId))
        {
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'challenge_team_process'));
            /*$this->xajax->configure('debug', true);*/
            $this->xajax->processRequest();
            
            $data["my_infos"]=$this->manager_model->get_my_infos();
            $teamInfos=$this->team_model->get_team_infos($teamId);
            
            $data["teamTactic"]=$this->team_model->get_one_tactic($teamInfos[0]->tactic_id);
            $data["teamInfos"]=$teamInfos;
            $data["userInfos"]=$this->manager_model->getUserInfos($teamInfos[0]->user_id);
            $data["palmares"]=$this->championship_model->get_palmares($teamId);

            $ownOffensiveMethods=$this->corruption_model->getOwnOffensiveMethods($teamId);
            $ownDefensiveMethods=$this->corruption_model->getOwnDefensiveMethods($teamId);

            $data["nbOffensiveMethods"]=count($ownOffensiveMethods);
            $data["nbDefensiveMethods"]=count($ownDefensiveMethods);
            $data["players"] = $this->players_model->getAllPlayersByTeamId($teamId);
        
            $this->load->view('team/team_profil_view',$data);
        }else{
            redirect('game');
        }
    }

    /*
|==========================================================
| AJAX challenge team process
|==========================================================
|
*/
    public function challenge_team_process($form_data)
    {
        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            $level = $this->session->userdata('level');

            //check if already sent to this user
            $checkSent=$this->friendly_model->checkFriendAlreadySent($userId,$form_data["receiver"]);

            if(!$checkSent){
                //add friendly and send notificaion
                $this->friendly_model->addFriendlyRequest($userId,$form_data["receiver"]);
                $this->notification_model->addFriendlyNotification(notifications_rules::FRIENDLY_PROPOSE,$form_data["receiver"],notifications_rules::TYPE_INFORMATION);
                $data["messageInfos"]=$this->lang->line('infos_defier_ok');    
            }else{
                $data["messageInfos"]=$this->lang->line('infos_defier_nop');
            }
            
            $result = $this->load->view('includes/infos_view',$data,true);
            $objResponse->assign("challenge_infos","innerHTML",$result);
        }

        return $objResponse;
    }


/*
|==========================================================
| Ajax add sponsor
|==========================================================
|
*/

    public function add_sponsor_process($form_data)
    {
        $objResponse = new xajaxResponse();

        $connected = $this->session->userdata('connected_ok');

        if($connected){


            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            $sponsorTeam=$this->sponsors_model->getSponsorsByTeam($teamId);

            if(!empty($sponsorTeam)){

               /*$identification=array('sponsor'=>$sponsorTeam[0]["link"]);
               $this->session->set_userdata($identification);
               $data["sponsorInfos"]=$sponsorTeam;
               $data["sponsorUsed"]=$sponsorTeam[0]["link"];*/
               $data["sponsorTeam"]=$sponsorTeam;
               $data["sponsorInfos"]=$sponsorTeam;
               $data["sponsorUsed"]=$sponsorTeam[0]["link"];
               $data["messageInfos"]=$this->lang->line('sponsor_infos3');

            }else{

               $this->sponsors_model->addSponsorByTeam($form_data["sponsorId"],$teamId);
               $this->money_model->updateSellDirtyGold(2,$userId);
               $sponsorTeam=$this->sponsors_model->getSponsorsByTeam($teamId);
               /*$identification=array('sponsor'=>$sponsorTeam[0]["link"]);
               $this->session->set_userdata($identification);*/
               $data["sponsorTeam"]=$sponsorTeam;
               $data["sponsorInfos"]=$sponsorTeam;
               $data["sponsorUsed"]=$sponsorTeam[0]["link"];

            }

            $data["my_infos"]=$this->manager_model->get_my_infos();

            $result = $this->load->view('includes/header_view',$data,true);
            $objResponse->assign("header","innerHTML",$result);

            $result = $this->load->view('team/includes/sponsor_display_view',$data,true);
            $objResponse->assign("sponsor_display","innerHTML",$result);

            $result = $this->load->view('team/includes/sponsor_list_view',$data,true);
            $objResponse->assign("sponsor_list","innerHTML",$result);

        }else{

            redirect('start/begin_game');
        }
        return $objResponse;
    }

/*
|==========================================================
| Ajax train team
|==========================================================
|
*/

    public function train_team_process($form_data)
    {
        $objResponse = new xajaxResponse();

        $connected = $this->session->userdata('connected_ok');

        if($connected){

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            $enoughMoney=$this->money_model->checkEnoughMoney(training_rules::TRAINING_VALUE,$userId);

            if($enoughMoney){

                $this->training_model->updateTeamTraining($teamId,$form_data["type"]);
                $this->training_model->updateTrainingValue($teamId,training_rules::TRAINING_VALUE);
                $this->money_model->updateMoney(training_rules::TRAINING_VALUE,$userId);
                $data["trainingInfos"]=$this->training_model->getTeamTraining($teamId);
                $data["messageInfos"]=$this->lang->line('training_succes');

            }else{

                $data["messageInfos"]=$this->lang->line('training_fail');

            }

            $data["my_infos"]=$this->manager_model->get_my_infos();

            $result = $this->load->view('includes/header_view',$data,true);
            $objResponse->assign("header","innerHTML",$result);

            $result = $this->load->view('team/includes/training_view',$data,true);
            $objResponse->assign("training","innerHTML",$result);

            $result = $this->load->view('includes/infos_view',$data,true);
            $objResponse->assign("training_infos","innerHTML",$result);

        }else{
            redirect("start/begin_game");
        }

        return $objResponse;
    }

/*
|==========================================================
| Cron update training estate
|==========================================================
|
*/

    public function reset_training_estate()
    {
        $this->training_model->resetTraining();
    }

 /*
|==========================================================
| Cron formation center
|==========================================================
|
*/

    public function generate_player_formation_center()
    {
        $formationCenters=$this->players_model->get_formation_centers();

        foreach($formationCenters as $row){
            
            $nbPlayers=players_rules::getNbPlayersToGenerate($row["level"]);
        }
    }


/*
|==========================================================
|
|==========================================================
|
*/

    public function estimate_experience_bonus($bonus,$teamId)
    {
        foreach($bonus as $row){
            $this->corruption_model->increaseTeamPrimaryPotential($row["capacity"],$teamId,$row["sector"]);
            $this->corruption_model->increaseTeamSecondaryPotential($row["capacity"],$teamId,$row["sector"]);
        }
    }
     //Ajax change transfert statut
    public function changeTransfertStatut_process($playerId,$statut){

        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){

            if($statut==0){

                $this->transferts_model->deletePlayerOffers($playerId);
            }

            $this->players_model->updatePlayerStatut($playerId,$statut);
            //return all players of the team
            $data["players"] = $this->players_model->get_all_players();
            $data["messageInfos"]=$this->lang->line('effectif_info_transfert');

            $result = $this->load->view('team/includes/effectif_view',$data,true);
            $objResponse->assign("effectif","innerHTML",$result);
        }

        sleep(2);
        return $objResponse;

    }
}

?>