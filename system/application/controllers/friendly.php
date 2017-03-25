<?php

class friendly extends Controller {

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
| Main page friendly
|==========================================================
|
*/
	public function index(){

            $connected = $this->session->userdata('connected_ok');

            if($connected){

                //langage loading
                $langageFile=$this->session->userdata('langage');

                if(!empty($langageFile)){
                    $this->lang->load('friendly', $langageFile);
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
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'join_friendly_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'accept_request_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'refuse_request_process'));
                /*$this->xajax->configure('debug', true);*/
                $this->xajax->processRequest();

                $friendsList=$this->facebook->api('me/friends?oauth_token='.$this->session->userdata("access_token"));

                $friendsArr=array();
                $friendsInArr=$this->friendly_model->getFriendAlreadySent($userId);
                $friendString="";
                foreach($friendsList as $friend){

                    foreach($friend as $row){

                        if(!in_array($row["id"],$friendsInArr)){
                            //$friendsArr[]=$row["name"]."_".$row["id"];
                            $friendString.="'".$row["id"]."'".",";
                        }
                    }
                }

                //sort user name array
                /*sort($friendsArr);
                $data["friendsList"]=$friendsArr;*/


                $friendString=rtrim($friendString, ',');

                $fql = "SELECT pic_square,uid,first_name,last_name FROM user WHERE uid IN($friendString)";

                $data["friendsList"] = $this->facebook->api(array('method' => 'fql.query','query' =>$fql));

                //load requests of user
                $data["requests"]=$this->friendly_model->getRequestsByUser($userId);

                //load calendar and result
                $data["friendlyMatchs"]=$this->friendly_model->getFriendlyMatchByTeam($teamId);

                //load others matchs results
                $data["othersResults"]=$this->friendly_model->getFriendlyAllMatchs();

                $config['total_rows'] = $this->team_model->countAllTeams();
                $config['per_page'] = '20';
                $config['base_url'] = base_url().'/index.php/friendly/index#find_team';
                $this->pagination->initialize($config);
                $data["allTeams"]=$this->team_model->getAllTeams($config['per_page'],$this->uri->segment(3));


                //return user infos
                $data["my_infos"]=$this->manager_model->get_my_infos();
                $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

                if($this->uri->segment(3)!=FALSE){
                    $data["messageInfos"]=$this->lang->line('infos_defier_ok');
                }else{
                    $data["messageInfos"]=$this->lang->line('infos_friends');
                }

                $this->load->view('friendly/friendly_view',$data);
            }
            else
            {
                redirect('start/begin_game');
            }

	}

/*
|==========================================================
| research friendly team
|==========================================================
|
*/
	public function research_friendly_team(){

            $connected = $this->session->userdata('connected_ok');

            if($connected){

                //langage loading
                $langageFile=$this->session->userdata('langage');

                if(!empty($langageFile)){
                    $this->lang->load('friendly', $langageFile);
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
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'join_friendly_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'accept_request_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'refuse_request_process'));
                /*$this->xajax->configure('debug', true);*/
                $this->xajax->processRequest();

                $friendsList=$this->facebook->api('me/friends?oauth_token='.$this->session->userdata("access_token"));

                $friendsArr=array();
                $friendsInArr=$this->friendly_model->getFriendAlreadySent($userId);

                foreach($friendsList as $friend){

                    foreach($friend as $row){

                        if(!in_array($row["id"],$friendsInArr))
                            $friendsArr[]=$row["name"]."_".$row["id"];
                    }
                }

                //sort user name array
                sort($friendsArr);
                $data["friendsList"]=$friendsArr;

                //load requests of user
                $data["requests"]=$this->friendly_model->getRequestsByUser($userId);

                //load calendar and result
                $data["friendlyMatchs"]=$this->friendly_model->getFriendlyMatchByTeam($teamId);

                //load others matchs results
                $data["othersResults"]=$this->friendly_model->getFriendlyAllMatchs();

                $config['total_rows'] = $this->team_model->countAllTeams();
                $config['per_page'] = '20';
                $config['base_url'] = base_url().'/index.php/friendly/index#find_team';
                $this->pagination->initialize($config);
                $data["allTeams"]=$this->team_model->getAllTeams($config['per_page'],$this->uri->segment(3));


                //return user infos
                $data["my_infos"]=$this->manager_model->get_my_infos();
                $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

                if($this->uri->segment(3)!=FALSE){
                    $data["messageInfos"]=$this->lang->line('infos_defier_ok');
                }else{
                    $data["messageInfos"]=$this->lang->line('infos_friends');
                }

                $this->load->view('friendly/friendly_view',$data);
            }
            else
            {
                redirect('start/begin_game');
            }

	}

/*
|==========================================================
| AJAX join friendly process
|==========================================================
|
*/
    public function join_friendly_process($form_data)
    {
        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){

            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('friendly', $langageFile);
                $this->lang->load('menu', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{
                redirect("start/begin_game");

            }

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            $level = $this->session->userdata('level');

            //add friendly and send notificaion
            $this->friendly_model->addFriendlyRequest($userId,$form_data["receiver"]);
            $this->notification_model->addFriendlyNotification(notifications_rules::FRIENDLY_PROPOSE,$form_data["receiver"],notifications_rules::TYPE_INFORMATION);

            $objResponse->redirect(base_url().'index.php/friendly/index/1');
        }

        return $objResponse;
    }


/*
|==========================================================
| AJAX accept request process
|==========================================================
|
*/
    public function accept_request_process($form_data)
    {
        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){
            
            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            $level = $this->session->userdata('level');

            $ownTeam=$this->team_model->getTeamByUserId($userId);
            $awayTeam=$this->team_model->getTeamByUserId($form_data["sender"]);

            $date=$this->friendly_model->friendlyFixtureMatch($ownTeam[0]["team_id"],$awayTeam[0]["team_id"]);
            $this->friendly_model->addFriendlyMatch($ownTeam,$awayTeam,$date);
            $this->friendly_model->deleteFriendlyRequest($userId,$form_data["sender"]);
            $awayTeamName=$this->team_model->get_team_name($ownTeam[0]["team_id"]);
            $this->notification_model->addNotification(notifications_rules::FRIENDLY_ACCEPTE,$awayTeam[0]["team_id"],notifications_rules::TYPE_INFORMATION,$awayTeamName);

            //load requests of user
            $data["requests"]=$this->friendly_model->getRequestsByUser($userId);
            
            //load calendar and result
            $data["friendlyMatchs"]=$this->friendly_model->getFriendlyMatchByTeam($teamId);

            $data["messageInfos"]=$this->lang->line('accept_friendly');

            $result =$this->load->view('includes/infos_view',$data,true);
            $objResponse->assign("friendly_request_infos","innerHTML",$result);

            $result =$this->load->view('friendly/includes/fixtures_view',$data,true);
            $objResponse->assign("result","innerHTML",$result);

            $result =$this->load->view('friendly/includes/requests_list_view',$data,true);
            $objResponse->assign("requests_list","innerHTML",$result);
            
        }

        return $objResponse;
    }

/*
|==========================================================
| AJAX refuse request process
|==========================================================
|
*/
    public function refuse_request_process($form_data)
    {
        $objResponse = new xajaxResponse();
        $connected = $this->session->userdata('connected_ok');

        if($connected){

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            $level = $this->session->userdata('level');

            $this->friendly_model->deleteFriendlyRequest($userId,$form_data["sender"]);

            $ownTeam=$this->team_model->getTeamByUserId($userId);
            $awayTeam=$this->team_model->getTeamByUserId($form_data["sender"]);

            //load requests of user
            $data["requests"]=$this->friendly_model->getRequestsByUser($userId);
            $awayTeamName=$this->team_model->get_team_name($ownTeam[0]["team_id"]);
            $this->notification_model->addNotification(notifications_rules::FRIENDLY_REFUSE,$awayTeam[0]["team_id"],notifications_rules::TYPE_INFORMATION,$awayTeamName);

            $data["messageInfos"]=$this->lang->line('refuse_friendly');

            $result =$this->load->view('includes/infos_view',$data,true);
            $objResponse->assign("friendly_request_infos","innerHTML",$result);

            $result =$this->load->view('friendly/includes/requests_list_view',$data,true);
            $objResponse->assign("requests_list","innerHTML",$result);
        }

        return $objResponse;
    }


/*
|==========================================================
| Execute match
|==========================================================
|
*/
    public function start_match()
    {
        
         $allMatchs=$this->friendly_model->load_all_matchs();

         if(!empty($allMatchs)){

            foreach($allMatchs as $match)
            {
                $this->db->trans_start();
                $this->execute_match($match->home_team_id,$match->away_team_id,$match->friendly_id);
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

        //load the informations of the two teams
        $homeTeamInfos=$this->match_model->load_team_info($homeTeam);
        $awayTeamInfos=$this->match_model->load_team_info($awayTeam);
        $homeTeamTactic=$this->team_model->get_team_tactic_infos($homeTeam);
        $awayTeamTactic=$this->team_model->get_team_tactic_infos($awayTeam);

        //check if teams are complete
        $homeTeamComplete=$this->match_model->checkTeamValidate($homeTeamInfos);
        $awayTeamComplete=$this->match_model->checkTeamValidate($awayTeamInfos);


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
                /*$commentsLevel=match_rules::getLevelComments($result,$score);
                $this->match_model->insertComments($matchId,$result,$commentsLevel,$homeTeam,$awayTeam);*/

                //update stats and corruptions
                $this->friendly_model->update_match_result($matchId,$result);
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

                //$this->championship_model->update_classement($result,$homeTeam,$awayTeam);

                $this->corruption_model->deleteMethodEndMatch($homeTeam);
                $this->corruption_model->deleteMethodEndMatch($awayTeam);
                
                //$this->championshipFinished($championshipId,$matchId);

            }else{

                if($homeTeamComplete==FALSE && $awayTeamComplete==FALSE)
                {
                        $withdrawalWinner=array();
                        $withdrawalWinner["winner"]="";
                        $withdrawalWinner["home_team_score"]=0;
                        $withdrawalWinner["looser"]="";
                        $withdrawalWinner["away_team_score"]=0;
                        $withdrawalWinner["draw"]="y";

                        $this->friendly_model->update_match_result($matchId,$withdrawalWinner);
                        $this->matchRewards($matchId,$withdrawalWinner,$homeTeam,$awayTeam);
                        $this->team_model->updateTeamStats($withdrawalWinner,$homeTeam,$awayTeam);
                        //$this->championship_model->update_classement($withdrawalWinner,$homeTeam,$awayTeam);
                        $this->playerInjury($homeTeam);
                        $this->playerInjury($awayTeam);
                        $this->corruption_model->deleteMethodEndMatch($homeTeam);
                        $this->corruption_model->deleteMethodEndMatch($awayTeam);
                        //$this->championshipFinished($championshipId,$matchId);
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

                        $this->friendly_model->update_match_result($matchId,$withdrawalWinner);
                        $this->matchRewards($matchId,$withdrawalWinner,$homeTeam,$awayTeam);
                        $this->team_model->updateTeamStats($withdrawalWinner,$homeTeam,$awayTeam);
                        //$this->championship_model->update_classement($withdrawalWinner,$homeTeam,$awayTeam);
                        $this->corruption_model->deleteMethodEndMatch($homeTeam);
                        $this->corruption_model->deleteMethodEndMatch($awayTeam);

                        if(!$homeHoliday){
                            $this->playerInjury($homeTeam);
                            //$this->team_model->update_team_not_ready($homeTeam);
                        }

                        //$this->championshipFinished($championshipId,$matchId);

                    }else{

                        $withdrawalWinner=array();
                        $withdrawalWinner["winner"]=$awayTeam;
                        $withdrawalWinner["away_team_score"]=3;
                        $withdrawalWinner["looser"]=$homeTeam;
                        $withdrawalWinner["home_team_score"]=0;
                        $withdrawalWinner["draw"]="";

                        $this->friendly_model->update_match_result($matchId,$withdrawalWinner);
                        $this->matchRewards($matchId,$withdrawalWinner,$homeTeam,$awayTeam);
                        $this->team_model->updateTeamStats($withdrawalWinner,$homeTeam,$awayTeam);
                        //$this->championship_model->update_classement($withdrawalWinner,$homeTeam,$awayTeam);
                        $this->corruption_model->deleteMethodEndMatch($homeTeam);
                        $this->corruption_model->deleteMethodEndMatch($awayTeam);

                        if(!$awayHoliday){
                            $this->playerInjury($awayTeam);
                            //$this->team_model->update_team_not_ready($awayTeam);
                        }
                        
                        //$this->championshipFinished($championshipId,$matchId);


                    }
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
| Player Injury
|==========================================================
|
*/
    public function playerInjury($teamId)
    {
        $injuryChance=rand(0,20);

        if($injuryChance==11)
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
    
}
?>