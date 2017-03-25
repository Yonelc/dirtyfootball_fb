<?php

class match extends Controller {

/*
|==========================================================
| Constructor
|==========================================================
|
*/
	public function __construct(){

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

/*
|==========================================================
| Main page match
|==========================================================
|
*/
	public function index(){

            $connected = $this->session->userdata('connected_ok');

            if($connected){

                //langage loading
                $langageFile=$this->session->userdata('langage');

                if(!empty($langageFile)){
                    $this->lang->load('match', $langageFile);
                    $this->lang->load('menu', $langageFile);
                    $this->lang->load('footer', $langageFile);
                }else{
                    redirect("start/begin_game");

                }

                $teamId = $this->session->userdata('teamId');
                $userId = $this->session->userdata('userId');
                $userInfos=$this->manager_model->getUserInfos($userId);
                $identification=array('level'=>$userInfos[0]["level"]);
                $this->session->set_userdata($identification);
                $level = $this->session->userdata('level');

                //XAJAX init functions
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'join_championship_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'create_championship_process'));
                /*$this->xajax->configure('debug', true);*/
                $this->xajax->processRequest();

                $config['total_rows'] = $this->championship_model->countAvailableChampionshipsByLevel();
                $config['per_page'] = '20';
                $config['base_url'] = base_url().'/index.php/match/index';
                $this->pagination->initialize($config);
                $data["championships"]=$this->championship_model->getAllChampionshipsByLevel($level,$config['per_page'],$this->uri->segment(3));

                //return user infos
                $data["my_infos"]=$this->manager_model->get_my_infos();
                
                $teamInChampionship=$this->championship_model->is_team_in_championship($teamId);
                $data["teamInChampionship"]=$teamInChampionship;
                $data["matchsChampArr"]=$this->championship_model->get_matchs_championship($teamId);
                //$data["championships"]=$this->championship_model->get_all_championships();

                $teamChampInfos=$this->championship_model->get_team_championship($teamId);

                if(!empty($teamChampInfos))
                {
                    $championshipId=$teamChampInfos[0]["championship_id"];
                    $data["lastMatchs"]=$this->match_model->get_last_matchs_results($championshipId);
                    $data["nextMatchs"]=$this->match_model->get_next_matchs($championshipId);
                   
                }

                $data["classement"]=$this->championship_model->get_classement($teamId);
                $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);
                $data["allAwards"]=$this->championship_model->championshipAwards($level);

                $this->load->view('match/match_view',$data);
            }
            else
            {
                redirect('start/begin_game');
            }

	}
/*
|==========================================================
| get award list
|==========================================================
|
*/
        public function awards()
        {
            $connected = $this->session->userdata('connected_ok');

            if($connected){

                //langage loading
                $langageFile=$this->session->userdata('langage');

                if(!empty($langageFile)){
                    $this->lang->load('match', $langageFile);
                    $this->lang->load('menu', $langageFile);
                    $this->lang->load('footer', $langageFile);
                }else{
                    redirect("start/begin_game");

                }

                $teamId = $this->session->userdata('teamId');
                $userId = $this->session->userdata('userId');
                $level = $this->session->userdata('level');

                $data["my_infos"]=$this->manager_model->get_my_infos();
                $data["allAwards"]=$this->championship_model->championshipAwards($level);

                $this->load->view('match/awards_view',$data);

            }else{
                redirect('start/begin_game');
            }
        }

/*
|==========================================================
| Match page
|==========================================================
|
*/
    public function live_match()
    {
       $connected = $this->session->userdata('connected_ok');

       if($connected){

            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('match', $langageFile);
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{
                redirect("start/begin_game");

            }

            $teamId = $this->session->userdata('teamId');
            //return user infos
            $data["my_infos"]=$this->manager_model->get_my_infos();
            $data["matchInfos"]=$this->match_model->load_match($this->uri->segment(3));
            $data["resumeAtt"]=$this->match_model->getAttCommentsByTeam($this->uri->segment(3),$teamId);
            $data["resumeMil"]=$this->match_model->getMilCommentsByTeam($this->uri->segment(3),$teamId);
            $data["resumeDef"]=$this->match_model->getDefCommentsByTeam($this->uri->segment(3),$teamId);

            $this->load->view('match/live_match_view',$data);
       }
       else
       {
            redirect('start/begin_game');
       }

    }

/*
|==========================================================
| AJAX create championship process
|==========================================================
|
*/
    public function create_championship_process($form_data)
    {
        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){

            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('match', $langageFile);
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{
                redirect("start/begin_game");

            }

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            $level = $this->session->userdata('level');

            $isTeamIn=$this->championship_model->is_team_in_championship($teamId);

            if(!$isTeamIn)
            {
                if($this->money_model->checkEnoughDirtyGold(1,$userId)){

                    if(!empty($form_data["championshipName"])){
                        $this->championship_model->createChampionship($form_data["championshipName"],$userId,$level,$teamId);
                        $this->money_model->updateDirtyGold(1,$userId);
                        $this->update_players_experience($teamId);
                        $this->training_model->newTrainingSeason($teamId);

                        //reload list of champs
                        $config['total_rows'] = $this->championship_model->countAvailableChampionshipsByLevel();
                        $config['per_page'] = '20';
                        $config['base_url'] = base_url().'/index.php/match/index';
                        $this->pagination->initialize($config);
                        $data["championships"]=$this->championship_model->getAllChampionshipsByLevel($level,$config['per_page'],$this->uri->segment(3));
                        
                        $isTeamIn=$this->championship_model->is_team_in_championship($teamId);
                        $data["teamInChampionship"]=$isTeamIn;
                        $data["messageInfos"] = $this->lang->line("create_success");

                        $result =$this->load->view('match/includes/confirm_championship_joined_view',$data,true);
                        $objResponse->assign("championship","innerHTML",$result);
                    }else{
                        $data["messageInfos"]=$this->lang->line("create_name_missing");
                    }

                }else{

                    $data["messageInfos"] =$this->lang->line("create_dirtygold_missing");
                }


            }else{

                $data["messageInfos"] = $this->lang->line("create_already_exist");

            }

            $data["my_infos"]=$this->manager_model->get_my_infos();

            $result =$this->load->view('includes/header_view',$data,true);
            $objResponse->assign("header","innerHTML",$result);

            $result =$this->load->view('includes/infos_view',$data,true);
            $objResponse->assign("championship_infos","innerHTML",$result);
        }
        sleep(2);
        return $objResponse;
    }
 /*
|==========================================================
| update player experience
|==========================================================
|
*/

    public function update_players_experience($teamId)
    {
        $playersTeam=$this->players_model->getAllPlayersByTeamId($teamId);
        $trainingInfos=$this->training_model->getTeamTraining($teamId);
        
        foreach($playersTeam as $player){

            $playerUp=players_rules::experiencePlayerWon($player, $trainingInfos);
            $this->players_model->updatePlayerExperience($player->player_id,$playerUp);
        }
    }
/*
|==========================================================
| AJAX join championship process
|==========================================================
|
*/
    public function join_championship_process($form_data)
    {
        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){

            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('match', $langageFile);
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{
                redirect("start/begin_game");

            }

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            $level = $this->session->userdata('level');

            $isTeamIn=$this->championship_model->is_team_in_championship($teamId);

            if(!$isTeamIn)
            {
                if(!$this->championship_model->is_championship_full($form_data["championshipId"])){

                   if($this->money_model->checkEnoughDirtyGold(1,$userId)){
                       $this->championship_model->join_championship($form_data["championshipId"],$teamId);
                       $this->championship_model->updateNbTeamInChampionship($form_data["championshipId"]);
                       $this->money_model->updateDirtyGold(1,$userId);
                       $this->update_players_experience($teamId);
                       $this->training_model->newTrainingSeason($teamId);
                       $this->notification_model->addNotification(notifications_rules::JOIN_CHAMPIONSHIP,$teamId,notifications_rules::TYPE_INFORMATION,addslashes($form_data["championshipTitle"]));

                       $data["messageInfos"]=$this->lang->line("join_ok");

                       if($this->championship_model->is_championship_full($form_data["championshipId"])){

                          $this->championship_model->start_championship($form_data["championshipId"]);
                          $teamsChampArr=$this->championship_model->get_teams_championship($form_data["championshipId"]);
                          foreach($teamsChampArr as $team){

                              //send mail to start championship
                              $userInfos=$this->manager_model->getUserInfosByTeamId($team->team_id);
                              $this->sendChampionshipStartMail($userInfos[0]["email"]);

                              //send notificaion
                              $this->notification_model->addNotification(notifications_rules::START_CHAMPIONSHIP,$team->team_id,notifications_rules::TYPE_INFORMATION,addslashes($form_data["championshipTitle"]));

                          }
                          $data["messageInfos"]=$this->lang->line("join_start");
                        }
                   }else{
                       $data["messageInfos"]=$this->lang->line("join_dirtygold_missing");
                   }

                }else{

                    $data["messageInfos"]=$this->lang->line("join_full");
                }
            }else{
                $data["messageInfos"]=$this->lang->line("join_ok");
            }
            $data["my_infos"]=$this->manager_model->get_my_infos();

            $teamInChampionship=$this->championship_model->is_team_in_championship($teamId);
            $data["teamInChampionship"]=$teamInChampionship;
            $data["matchsChampArr"]=$this->championship_model->get_matchs_championship($teamId);

            $config['total_rows'] = $this->championship_model->countAvailableChampionshipsByLevel();
            $config['per_page'] = '50';
            $config['base_url'] = base_url().'/index.php/match/index';
            $this->pagination->initialize($config);
            $data["championships"]=$this->championship_model->getAllChampionshipsByLevel($level,$config['per_page'],$this->uri->segment(3));

            $data["classement"]=$this->championship_model->get_classement($teamId);

            $result =$this->load->view('includes/header_view',$data,true);
            $objResponse->assign("header","innerHTML",$result);

            $result =$this->load->view('match/includes/calendrier_view',$data,true);
            $objResponse->assign("calendrier","innerHTML",$result);

            $result =$this->load->view('match/includes/classement_view',$data,true);
            $objResponse->assign("classment_champ","innerHTML",$result);

            $result =$this->load->view('match/includes/create_championship_view',$data,true);
            $objResponse->assign("create_championship","innerHTML",$result);

            $result =$this->load->view('match/includes/confirm_championship_joined_view',$data,true);
            $objResponse->assign("championship","innerHTML",$result);

            $result =$this->load->view('includes/infos_view',$data,true);
            $objResponse->assign("championship_join_infos","innerHTML",$result);
        }
        sleep(1);
        return $objResponse;
    }

    /*
|==========================================================
| Send mail start
|==========================================================
|
*/
public function sendChampionshipStartMail($email)
{

    $this->load->library('email');

    $config['mailtype'] = 'html';
    $this->email->initialize($config);

    $this->email->from('contact@bigbang-interactive.com', 'Football Manager game');
    $this->email->to($email);

    $this->email->subject($this->lang->line("mail_title"));
    $this->email->message($this->lang->line("mail_message"));

    $this->email->send();
}


/*
|==========================================================
| Execute match
|==========================================================
|
*/
    public function start_match()
    {
        
         $allMatchs=$this->match_model->load_all_matchs();

         if(!empty($allMatchs)){

            foreach($allMatchs as $match)
            {
                $this->db->trans_start();
                $this->execute_match($match->home_team_id,$match->away_team_id,$match->match_id);
                $this->db->trans_complete();
            }
         }

    }



/*
|==========================================================
| calculate match
|==========================================================
|
*/
    public function execute_match($homeTeam,$awayTeam,$matchId){

        /*$homeTeam=47;
        $awayTeam=52;
        $matchId=11753;*/

        $championshipInfos=$this->championship_model->getOwnChampionship($homeTeam);
        $championshipId=$championshipInfos[0]["championship_id"];

        //load the informations of the two teams
        $homeTeamInfos=$this->match_model->load_team_info($homeTeam);
        $awayTeamInfos=$this->match_model->load_team_info($awayTeam);
        $homeTeamTactic=$this->team_model->get_team_tactic_infos($homeTeam);
        $awayTeamTactic=$this->team_model->get_team_tactic_infos($awayTeam);

        //check if teams are complete
        $homeTeamComplete=$this->match_model->checkTeamValidate($homeTeamInfos);
        $awayTeamComplete=$this->match_model->checkTeamValidate($awayTeamInfos);

        $checkCorruption=$this->corruption_model->checkCorruptionAccepted($matchId);

        if(!$checkCorruption){

            $homeHoliday=$this->manager_model->checkHoliday($homeTeam);
            $awayHoliday=$this->manager_model->checkHoliday($awayTeam);

            if($homeTeamComplete==TRUE && $awayTeamComplete==TRUE){

                //return an array of teams experience
                $homeTeamExpArr=$this->match_model->load_team_experience($homeTeamInfos,$homeTeamTactic);
                $awayTeamExpArr=$this->match_model->load_team_experience($awayTeamInfos,$awayTeamTactic);

                //return the capacity of the two stadium
                $homeTeamCapacity=$this->match_model->load_stadium_capacity($homeTeamInfos);
                $awayTeamCapacity=$this->match_model->load_stadium_capacity($awayTeamInfos);

                //return points won with capacity for each team
                $stadiumCapacityPoints=match_rules::compare_stadium_capacity($homeTeamCapacity,$awayTeamCapacity);

                //return success points for a team randomly
                $successPoints=match_rules::success_parameter();

                //return points won with each primary sector for each team

                $primaryAttackPoints=match_rules::compare_skills($homeTeamExpArr["primary_experience_att"],$awayTeamExpArr["primary_experience_att"]);

                $primaryMiddlePoints=match_rules::compare_skills($homeTeamExpArr["primary_experience_mil"],$awayTeamExpArr["primary_experience_mil"]);

                $primaryDefensePoints=match_rules::compare_skills($homeTeamExpArr["primary_experience_def"],$awayTeamExpArr["primary_experience_def"]);

                $primaryGoalkeeperPoints=match_rules::compare_skills($homeTeamExpArr["primary_experience_gb"],$awayTeamExpArr["primary_experience_gb"]);

                //return points won with each secondary sector for each team
                $secondaryAttackPoints=match_rules::compare_skills($homeTeamExpArr["secondary_experience_att"],$awayTeamExpArr["secondary_experience_att"]);
                $secondaryMiddlePoints=match_rules::compare_skills($homeTeamExpArr["secondary_experience_mil"],$awayTeamExpArr["secondary_experience_mil"]);
                $secondaryDefensePoints=match_rules::compare_skills($homeTeamExpArr["secondary_experience_def"],$awayTeamExpArr["secondary_experience_def"]);
                $secondaryGoalkeeperPoints=match_rules::compare_skills($homeTeamExpArr["secondary_experience_gb"],$awayTeamExpArr["secondary_experience_gb"]);


                //return points won with Sector vs Sector (ex: def vs att)
                $homeTeamExpOffensive=$homeTeamExpArr["primary_experience_att"]+($homeTeamExpArr["primary_experience_mil"]/2);
                $awayTeamExpOffensive=$awayTeamExpArr["primary_experience_att"]+($awayTeamExpArr["primary_experience_mil"]/2);
                $homeTeamExpDefensive=$homeTeamExpArr["primary_experience_gb"]+$homeTeamExpArr["primary_experience_def"];
                $awayTeamExpDefensive=$awayTeamExpArr["primary_experience_gb"]+$awayTeamExpArr["primary_experience_def"];

                $sectorHomeOffensive=match_rules::compare_skills($homeTeamExpOffensive,$awayTeamExpDefensive);
                $sectorAwayOffensive=match_rules::compare_skills($homeTeamExpDefensive,$awayTeamExpOffensive);
                $sectorMiddle=match_rules::compare_skills($homeTeamExpArr["primary_experience_mil"],$awayTeamExpArr["primary_experience_mil"]);

                //return points won with global team skills
                $globalPoints=match_rules::compare_skills($homeTeamExpArr["experience_team"],$awayTeamExpArr["experience_team"]);

                //return total points
                $totalPoints=match_rules::total_points(

                    $stadiumCapacityPoints,
                    $primaryAttackPoints,
                    $primaryMiddlePoints,
                    $primaryDefensePoints,
                    $primaryGoalkeeperPoints,
                    $secondaryAttackPoints,
                    $secondaryMiddlePoints,
                    $secondaryDefensePoints,
                    $secondaryGoalkeeperPoints,
                    $sectorHomeOffensive,
                    $sectorAwayOffensive,
                    $successPoints,
                    $globalPoints
                );

                //The score between the two team is calculated
                $score=match_rules::calcul_score($totalPoints);
                $result=match_rules::match_winner($homeTeam, $awayTeam, $score);

                //add match comments
                $commentsLevel=match_rules::getLevelComments($result,$score);
                $this->match_model->insertComments($matchId,$result,$commentsLevel,$homeTeam,$awayTeam);

                //update stats and corruptions
                $this->match_model->update_match_result($matchId,$result);
                $this->matchRewards($matchId,$result,$homeTeam,$awayTeam);

                $this->team_model->updateTeamStats($result,$homeTeam,$awayTeam);

                if(!$homeHoliday)
                {
                    $this->playerInjury($homeTeam);
                    //$this->team_model->update_team_not_ready($homeTeam);
                }

                if(!$awayHoliday)
                {
                    $this->playerInjury($awayTeam);
                    //$this->team_model->update_team_not_ready($awayTeam);
                }

                $this->championship_model->update_classement($result,$homeTeam,$awayTeam);

                $this->corruption_model->deleteMethodEndMatch($homeTeam);
                $this->corruption_model->deleteMethodEndMatch($awayTeam);
                $this->corruption_model->corruptionRefused($matchId);
                
                $this->championshipFinished($championshipId,$matchId);

            }else{

                if($homeTeamComplete==FALSE && $awayTeamComplete==FALSE)
                {
                        $withdrawalWinner=array();
                        $withdrawalWinner["winner"]="";
                        $withdrawalWinner["home_team_score"]=0;
                        $withdrawalWinner["looser"]="";
                        $withdrawalWinner["away_team_score"]=0;
                        $withdrawalWinner["draw"]="y";

                        $this->match_model->update_match_result($matchId,$withdrawalWinner);
                        $this->matchRewards($matchId,$withdrawalWinner,$homeTeam,$awayTeam);
                        $this->team_model->updateTeamStats($withdrawalWinner,$homeTeam,$awayTeam);
                        $this->championship_model->update_classement($withdrawalWinner,$homeTeam,$awayTeam);
                        $this->playerInjury($homeTeam);
                        $this->playerInjury($awayTeam);
                        $this->corruption_model->corruptionRefused($matchId);
                        $this->corruption_model->deleteMethodEndMatch($homeTeam);
                        $this->corruption_model->deleteMethodEndMatch($awayTeam);
                        $this->championshipFinished($championshipId,$matchId);
                }
                else
                {
                    
                    if($homeTeamComplete==TRUE)
                    {
                        $withdrawalWinner=array();
                        $withdrawalWinner["winner"]=$homeTeam;
                        $withdrawalWinner["home_team_score"]=3;
                        $withdrawalWinner["looser"]=$awayTeam;
                        $withdrawalWinner["away_team_score"]=0;
                        $withdrawalWinner["draw"]="";

                        $this->match_model->update_match_result($matchId,$withdrawalWinner);
                        $this->matchRewards($matchId,$withdrawalWinner,$homeTeam,$awayTeam);
                        $this->team_model->updateTeamStats($withdrawalWinner,$homeTeam,$awayTeam);
                        $this->championship_model->update_classement($withdrawalWinner,$homeTeam,$awayTeam);
                        $this->corruption_model->corruptionRefused($matchId);
                        $this->corruption_model->deleteMethodEndMatch($homeTeam);
                        $this->corruption_model->deleteMethodEndMatch($awayTeam);

                        if(!$homeHoliday){
                            $this->playerInjury($homeTeam);
                            //$this->team_model->update_team_not_ready($homeTeam);
                        }

                        $this->championshipFinished($championshipId,$matchId);

                    }else{

                        $withdrawalWinner=array();
                        $withdrawalWinner["winner"]=$awayTeam;
                        $withdrawalWinner["away_team_score"]=3;
                        $withdrawalWinner["looser"]=$homeTeam;
                        $withdrawalWinner["home_team_score"]=0;
                        $withdrawalWinner["draw"]="";

                        $this->match_model->update_match_result($matchId,$withdrawalWinner);
                        $this->matchRewards($matchId,$withdrawalWinner,$homeTeam,$awayTeam);
                        $this->team_model->updateTeamStats($withdrawalWinner,$homeTeam,$awayTeam);
                        $this->championship_model->update_classement($withdrawalWinner,$homeTeam,$awayTeam);
                        $this->corruption_model->corruptionRefused($matchId);
                        $this->corruption_model->deleteMethodEndMatch($homeTeam);
                        $this->corruption_model->deleteMethodEndMatch($awayTeam);

                        if(!$awayHoliday){
                            $this->playerInjury($awayTeam);
                            //$this->team_model->update_team_not_ready($awayTeam);
                        }
                        
                        $this->championshipFinished($championshipId,$matchId);


                    }
                }

            }

        }else{

            //load corruption infos
            $corruption=$this->corruption_model->getCorruptionInfos($matchId);
            if($corruption[0]["sender"]==$homeTeam)
            {

                $corruptionWinner=array();
                $corruptionWinner["winner"]=$homeTeam;
                $corruptionWinner["home_team_score"]=1;
                $corruptionWinner["looser"]=$awayTeam;
                $corruptionWinner["away_team_score"]=0;
                $corruptionWinner["draw"]="";

                $this->match_model->update_match_result($matchId,$corruptionWinner);
                $this->matchRewards($matchId,$corruptionWinner,$homeTeam,$awayTeam);
                $this->team_model->updateTeamStats($corruptionWinner,$homeTeam,$awayTeam);
                $this->championship_model->update_classement($corruptionWinner,$homeTeam,$awayTeam);
                $this->corruption_model->corruptionRefused($matchId);
                //$this->team_model->update_team_not_ready($homeTeam);
                //$this->team_model->update_team_not_ready($awayTeam);
                $this->corruption_model->deleteMethodEndMatch($homeTeam);
                $this->corruption_model->deleteMethodEndMatch($awayTeam);
                $this->championshipFinished($championshipId,$matchId);

            }else{

                $corruptionWinner=array();
                $corruptionWinner["winner"]=$awayTeam;
                $corruptionWinner["away_team_score"]=1;
                $corruptionWinner["looser"]=$homeTeam;
                $corruptionWinner["home_team_score"]=0;
                $corruptionWinner["draw"]="";

                $this->match_model->update_match_result($matchId,$corruptionWinner);
                $this->matchRewards($matchId,$corruptionWinner,$homeTeam,$awayTeam);
                $this->team_model->updateTeamStats($corruptionWinner,$homeTeam,$awayTeam);
                $this->championship_model->update_classement($corruptionWinner,$homeTeam,$awayTeam);
                $this->corruption_model->corruptionRefused($matchId);
                //$this->team_model->update_team_not_ready($homeTeam);
                //$this->team_model->update_team_not_ready($awayTeam);
                $this->corruption_model->deleteMethodEndMatch($homeTeam);
                $this->corruption_model->deleteMethodEndMatch($awayTeam);
                $this->championshipFinished($championshipId,$matchId);
            }

        }

    }

/*
|==========================================================
| rewards for team after match
|==========================================================
|
*/
public function matchRewards($matchId,$result,$homeTeam,$awayTeam)
{
    $homeUserId=$this->manager_model->getUserIdByTeamId($homeTeam);
    $awayUserId=$this->manager_model->getUserIdByTeamId($awayTeam);

    if(empty($result["draw"]))
    {
        if($result["winner"]==$homeTeam)
        {
            $this->money_model->updateSellMoney(100000,$homeUserId[0]["user_id"]);
            $this->money_model->updateSellMoney(10000,$awayUserId[0]["user_id"]);
            $this->notification_model->addNotification(notifications_rules::WOLLARS_WIN,$homeTeam,notifications_rules::TYPE_WOLLARS,100000);
            $this->notification_model->addNotification(notifications_rules::WOLLARS_LOOSE,$awayTeam,notifications_rules::TYPE_WOLLARS,10000);
        }else{
            $this->money_model->updateSellMoney(10000,$homeUserId[0]["user_id"]);
            $this->money_model->updateSellMoney(100000,$awayUserId[0]["user_id"]);
            $this->notification_model->addNotification(notifications_rules::WOLLARS_WIN,$awayTeam,notifications_rules::TYPE_WOLLARS,100000);
            $this->notification_model->addNotification(notifications_rules::WOLLARS_LOOSE,$homeTeam,notifications_rules::TYPE_WOLLARS,10000);
        }

    }else{
        $this->money_model->updateSellMoney(50000,$homeUserId[0]["user_id"]);
        $this->money_model->updateSellMoney(50000,$awayUserId[0]["user_id"]);
        $this->notification_model->addNotification(notifications_rules::WOLLARS_DRAW,$homeTeam,notifications_rules::TYPE_WOLLARS,50000);
        $this->notification_model->addNotification(notifications_rules::WOLLARS_DRAW,$awayTeam,notifications_rules::TYPE_WOLLARS,50000);
    }
}


/*
|==========================================================
| Finish player carreer
|==========================================================
|
*/
    public function playerCarreerFinished($playerArr)
    {
        $carreerFinishedArr=array();
        $teamFinishedArr=array();

        //check player age
        foreach($playerArr as $player)
        {
            if($player->age>=32)
            {
                $carreerFinishedArr[]=$player->player_id;

                if(!in_array($player->team_id, $teamFinishedArr))
                    $teamFinishedArr[]=$player->team_id;
            }
        }

        $playerString=implode(',',$carreerFinishedArr);
        $teamString=implode(',',$teamFinishedArr);

        //delete player who are older
        if($playerString!="")
            $this->players_model->deletePlayer($playerString);

        if($teamString!="")
        {
            //reset team and player
            foreach($teamFinishedArr as $team){
                $this->team_model->reset_team($team);
                $this->players_model->reset_players($team);
            }

            //$this->team_model->update_teams_not_ready($teamString);
        }

    }

/*
|==========================================================
| Finish championship
|==========================================================
|
*/
    public function championshipFinished($championshipId,$matchId)
    {
        $lastMatch=$this->championship_model->getLastMatchOfChampionship($championshipId);

        if($lastMatch[0]["match_id"]==$matchId)
        {
            $championshipInfos=$this->championship_model->get_championship($championshipId);
            $awards=$this->championship_model->championshipAwards($championshipInfos[0]->level);
            $classement=$this->championship_model->get_teams_championship($championshipId);

            //give awards to teams
            $i=0;
            $j=0;
            foreach($classement as $row)
            {
                $j=$i+1;

                //load userId by teamId
                $userId=$this->manager_model->getUserIdByTeamId($row->team_id);
                
                //send championship finish mail
                $managerInfos=$this->manager_model->getUserInfos($userId[0]["user_id"]);
                $this->lang->load('match', $managerInfos[0]["langage"]);
                $this->sendChampionshipFinishMail($managerInfos[0]["email"]);
                
                //Update awards
                $this->money_model->updateSellDirtyGold($awards[0]["place".$j],$userId[0]["user_id"]);
                $this->championship_model->addPalmares($row->team_id,$championshipInfos[0]->championship_id,$j,$championshipInfos[0]->title,$championshipInfos[0]->level,$row->point);

                //update age of players
                $allPlayers=$this->players_model->getAllPlayersByTeamId($row->team_id);
                $playersArr=array();
                foreach($allPlayers as $player)
                {
                    $playersArr[]=$player->player_id;
                }

                if(!empty($playersArr))
                    $this->players_model->updatePlayerAge($playersArr);

                //delete players who finished their carreer
                $this->playerCarreerFinished($allPlayers);

                //delete team sponsor
                $this->sponsors_model->deleteSponsorByTeam($row->team_id);
                $this->notification_model->addNotification(notifications_rules::CHAMPIONSHIP_FINISHED,$row->team_id,notifications_rules::TYPE_INFORMATION,$j);
                
                $i++;
            }

            //promotion
            if($championshipInfos[0]->level<3)
            {
                $userInfos=$this->manager_model->getUserIdByTeamId($classement[0]->team_id);
                $this->championship_model->updateTeamLevelChampionship($userInfos,championship_rules::LEVEL_UP);

                $userInfos=$this->manager_model->getUserIdByTeamId($classement[1]->team_id);
                $this->championship_model->updateTeamLevelChampionship($userInfos,championship_rules::LEVEL_UP);

                $userInfos=$this->manager_model->getUserIdByTeamId($classement[2]->team_id);
                $this->championship_model->updateTeamLevelChampionship($userInfos,championship_rules::LEVEL_UP);
            }

            //relegation
            if($championshipInfos[0]->level>1)
            {
                $userInfos=$this->manager_model->getUserIdByTeamId($classement[7]->team_id);
                $this->championship_model->updateTeamLevelChampionship($userInfos,championship_rules::LEVEL_DOWN);

                $userInfos=$this->manager_model->getUserIdByTeamId($classement[8]->team_id);
                $this->championship_model->updateTeamLevelChampionship($userInfos,championship_rules::LEVEL_DOWN);

                $userInfos=$this->manager_model->getUserIdByTeamId($classement[9]->team_id);
                $this->championship_model->updateTeamLevelChampionship($userInfos,championship_rules::LEVEL_DOWN);
            }

            //end season
            $this->match_model->deleteMatchsChampionship($championshipInfos[0]->championship_id);
            $this->championship_model->deleteTeamsChampionship($championshipInfos[0]->championship_id);
            $this->championship_model->deleteChampionship($championshipInfos[0]->championship_id);
            

        }
    }

        /*
|==========================================================
| Send mail start
|==========================================================
|
*/
    public function sendChampionshipFinishMail($email)
    {

        $this->load->library('email');

        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $this->email->from('contact@bigbang-interactive.com', 'Football Manager game');
        $this->email->to($email);

        $this->email->subject($this->lang->line("mail_title_finish"));
        $this->email->message($this->lang->line("mail_message_finish"));

        $this->email->send();
    }

/*
|==========================================================
| Research championship
|==========================================================
|
*/
    public function research_championship()
    {
        $connected = $this->session->userdata('connected_ok');

        if($connected){

            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('match', $langageFile);
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{
                redirect("start/begin_game");

            }

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            $level = $this->session->userdata('level');

            //XAJAX init functions
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'join_championship_process'));
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'create_championship_process'));
            /*$this->xajax->configure('debug', true);*/
            $this->xajax->processRequest();

            if(isset($_POST) && !empty($_POST))
            {
               $data=$this->input->xss_clean($_POST);
               $array_items = array(
                   "championshipName"=>"");

               $this->session->unset_userdata($array_items);

               $session=array(
                   "championshipName"=>$data["championship_name"]
               );
               $this->session->set_userdata($session);
            }

            $config['total_rows'] = $this->championship_model->count_championships_by_measure($this->session->userdata("championshipName"));
            $config['per_page'] = '20';
            $config['base_url'] = base_url().'/index.php/match/research_championship';
            $this->pagination->initialize($config);

            $data["my_infos"]=$this->manager_model->get_my_infos();
            $data["championships"]=$this->championship_model->get_championships_by_measure($config['per_page'],$this->uri->segment(3),
                                                                                    $this->session->userdata("championshipName")
                                                                                    );

            $teamInChampionship=$this->championship_model->is_team_in_championship($teamId);
            $data["teamInChampionship"]=$teamInChampionship;
            $data["matchsChampArr"]=$this->championship_model->get_matchs_championship($teamId);
            $data["classement"]=$this->championship_model->get_classement($teamId);
            $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);
            $data["allAwards"]=$this->championship_model->championshipAwards($level);

            $this->load->view('match/match_view',$data);

        }else{

           redirect('start/begin_game');

        }
    }

/*
|==========================================================
| Player Injury
|==========================================================
|
*/
    public function playerInjury($teamId)
    {
        $injuryChance=rand(0,15);

        if($injuryChance==9)
        {
            $playerInjuriedLimit=$this->players_model->checkNbPlayerInjuriedByTeam($teamId);

            if(!$playerInjuriedLimit)
            {
                $playerList=$this->players_model->getAllPlayersSelected($teamId);
                $randomPlayer=rand(0,10);
                $playerId=$playerList[$randomPlayer]["player_id"];
                $playerName=$playerList[$randomPlayer]["player_name"];
                
                $playerAlreadyInjuried=$this->players_model->checkPlayerInjury($playerId);

                if(!$playerAlreadyInjuried){
                    
                    $dateEndInjury=$this->players_model->playerInjury($playerId,$teamId);
                    $this->players_model->delete_player_team($playerId);
                    $this->players_model->updatePlayerInjury($playerId,1);
                    $this->team_model->update_deleted_players($teamId);
                    $this->notification_model->addNotification(notifications_rules::INJURY,$teamId,notifications_rules::TYPE_INFORMATION,$playerName,$dateEndInjury);
                    
                }
            }
        }
    }


    public function classment(){

        $connected = $this->session->userdata('connected_ok');

        if($connected){

            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('match', $langageFile);
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{

                redirect("start/begin_game");

            }
            
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            //return user infos
            $data["my_infos"]=$this->manager_model->get_my_infos();

            $championshipId=$this->uri->segment(3);

            if(!empty($championshipId)){

                $data["classement"]=$this->championship_model->get_teams_championship($championshipId);

            }else{
                $data["classement"]="";
            }

            $this->load->view('match/classment_view',$data);
        }
        else
        {
            redirect('start/begin_game');
        }
    }

    public function startChampionshipManually()
    {
            $champId=46;
            $champTitle="Tuga\'s League";
            $this->championship_model->start_championship($champId);
            $teamsChampArr=$this->championship_model->get_teams_championship($champId);
            foreach($teamsChampArr as $team){

                  //send mail to start championship
                  $userInfos=$this->manager_model->getUserInfosByTeamId($team->team_id);
                  $this->sendChampionshipStartMail($userInfos[0]["email"]);

                  //send notificaion
                  $this->notification_model->addNotification(notifications_rules::START_CHAMPIONSHIP,$team->team_id,notifications_rules::TYPE_INFORMATION,$champTitle);
            }
    }

    /* update team validation day by day*/
    public function updateTeamValidation()
    {
        $this->team_model->updateTeamStatutValidation();
    }
    
}
?>