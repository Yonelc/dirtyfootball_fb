<?php

class game extends Controller {

    public function __construct(){

	//chargement de la page parent
	parent::Controller();
        date_default_timezone_set('Europe/Paris');

        $this->load->database();
        $this->load->helper('url_helper');
        $this->load->helper('cookie');
        $this->load->library('validation');

        //langage loading
        $langageFile=$this->session->userdata('langage');

        if(!empty($langageFile)){
            $this->lang->load('menu', $langageFile);
            $this->lang->load('manager', $langageFile);
            $this->lang->load('infos', $langageFile);
            $this->lang->load('faq', $langageFile);
            $this->lang->load('cgu', $langageFile);
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

        //third party id in session for applifier
        $info = $this->facebook->api('/me?fields=third_party_id&oauth_token='.$this->session->userdata("access_token"));

        //put third party in session
        $identification = array(
                       'third'  => $info['third_party_id']
        );

        $this->session->set_userdata($identification);
    }


/*******************************************************************************
 *
 * MANAGER FUNCTIONS
 *
 *******************************************************************************/
    //Main page in game boarding
    public function index(){

        $connected = $this->session->userdata('connected_ok');
        if($connected){
            //Init XAJAX
            $this->xajax->register(XAJAX_FUNCTION ,array($this, 'holiday_process'));

            /*$this->xajax->configure('debug', true);*/
            $this->xajax->processRequest();

            $teamId = $this->session->userdata('teamId');
            $teamName = $this->session->userdata('teamName');
            $userId = $this->session->userdata('userId');

            $data["my_infos"]=$this->manager_model->get_my_infos();
            $data["stats"]=$this->team_model->get_team_infos($teamId);
            $data["notifications"]=$this->notification_model->getNotifications($teamId,$userId);

            $data["ownStadium"]=$this->stadium_model->getUserStadium($teamId);
            $data["ownMerchandising"]=$this->merchandising_model->getUserMerchandising($teamId);
            $data["ownLaboratory"]=$this->laboratory_model->getUserLaboratory($teamId);
            $data["ownFormationCenter"]=$this->formation_center_model->getUserFormationCenter($teamId);
            $data["palmares"]=$this->championship_model->get_palmares($teamId);

            $checkChamp=$this->championship_model->is_team_in_championship($teamId);
            $checkTeam=$this->team_model->is_team_ready($teamId);
            $MatchArr=$this->match_model->getNextCompetitionMatch($teamId);
            $friendlyMatch=$this->match_model->getNextFriendlyMatch($teamId);
            $checkMatch=count($MatchArr);
            $checkFriendly=count($friendlyMatch);

            $friends=$this->facebook->api('/me/friends?oauth_token='.$this->session->userdata('access_token'));
            $friendsArr=array();
            $friendsArr[]=$this->session->userdata('userId');

            $friendString="";
            foreach($friends["data"] as $row){
               $friendsArr[]= $row["id"];

               //$friendString.="'".$row["id"]."'".",";

               
            }

            /*$friendString=rtrim($friendString, ',');

            $fql = "SELECT pic_square,uid FROM user WHERE uid IN($friendString)";

            $data["response"] = $this->facebook->api(array('method' => 'fql.query','query' =>$fql));*/

           
            $data["friends"]=$this->friends_model->getPantheonFriends($friendsArr);
            $data["top"]=$this->friends_model->getTop();

            if($checkFriendly!=0)
            {
                if($friendlyMatch[0]["home_team_name"]==$teamName)
                {
                    $opponentName=$friendlyMatch[0]["away_team_name"];
                    $opponentId=$friendlyMatch[0]["away_team_id"];
                }else{
                    $opponentName=$friendlyMatch[0]["home_team_name"];
                    $opponentId=$friendlyMatch[0]["home_team_id"];
                }
                $data["friendlyMatch"]=str_replace("%data1",$friendlyMatch[0]["date"],$this->lang->line('next_friendly_match'))." ".anchor('team/team_profil/'.$opponentId, $opponentName);

            }else{

                $data["friendlyMatch"]=$this->lang->line('no_friendly_match');

            }

            if($checkMatch==0)
            {
                if($checkChamp==FALSE){
                    $data["contentMatch"]=$this->lang->line('match_program');
                }else{
                    $data["contentMatch"]=$this->lang->line('match_program');
                }
                
            }
            else
            {
                if($MatchArr[0]["home_team_name"]==$teamName)
                {
                    $opponentName=$MatchArr[0]["away_team_name"];
                    $opponentId=$MatchArr[0]["away_team_id"];
                }else{
                    $opponentName=$MatchArr[0]["home_team_name"];
                    $opponentId=$MatchArr[0]["home_team_id"];
                }
                $data["contentMatch"]=str_replace("%data1",$MatchArr[0]["date"],$this->lang->line('next_match'))." ".anchor('team/team_profil/'.$opponentId, $opponentName);
            }

            if($checkChamp==FALSE)
            {
                $data["contentChamp"]=$this->lang->line('not_in_champ')." ".anchor('match', $this->lang->line('integration_championship'));
            }
            else
            {
                $result=$this->championship_model->getOwnChampionship($teamId);
                $data["contentChamp"]=$this->lang->line('in_champ')." ".$result[0]["title"];
            }

            if($checkTeam==FALSE)
            {
                $data["contentTeam"]=$this->lang->line('not_valide_team')." ".anchor('team#tactic', $this->lang->line('confirm_team'));
            }
            else
            {
                $data["contentTeam"]=$this->lang->line('valide_team');
            }

            //reset injury players
            $this->players_model->playerInjuryEnd($teamId);

            $data["holiday"]=$this->manager_model->checkHoliday($teamId);

            $data["data_url"]=site_url('ofc2/get_data_pie');
            $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

            $this->load->view('manager/game_view',$data);



        }else{

            redirect('start/begin_game');
        }
        
    }


    //palmares details page
    public function palmares_details(){

        $connected = $this->session->userdata('connected_ok');
        if($connected){

            $teamId = $this->session->userdata('teamId');
            $data["my_infos"]=$this->manager_model->get_my_infos();
            $championshipId=$this->uri->segment(3);
            $data["palmares"]=$this->championship_model->get_palmares_details($championshipId);
            $this->load->view('manager/palmares_details_view',$data);

        }else{

            redirect('start/begin_game');
        }
    }

    //bug tracker page
    public function bug_tracker(){

        $connected = $this->session->userdata('connected_ok');
        if($connected){

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');

            if(isset($_POST["validation_bug"]))
            {
                $addition=$_POST["nb1"]+$_POST["nb2"];

                if($addition==$_POST["nbControle"]){
                    $this->validation->set_rules('bug', 'bug tracker','required');

                    if ($this->validation->run() == FALSE || empty($_POST["bug"]))
                    {
                        $data["messageInfos"]=$this->lang->line('bug_nok');
                    }
                    else
                    {
                        $bug = $this->input->xss_clean($_POST["bug"]);
                        $this->manager_model->addBug($_POST["userId"],$_POST["username"],$_POST["userfirstname"],$_POST["email"],$bug);
                        $data["messageInfos"]=$this->lang->line('bug_ok');
                    }
                }else{
                    $data["messageInfos"]=$this->lang->line('bug_captcha');
                }
            }

            $data["my_infos"]=$this->manager_model->get_my_infos();
            $this->load->view('manager/bug_tracker_view',$data);

        }else{

            redirect('start/begin_game');
        }
    }

    //cgu page
    public function cgu(){

        $connected = $this->session->userdata('connected_ok');
        if($connected){

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            $data["my_infos"]=$this->manager_model->get_my_infos();
            $this->load->view('manager/cgu_view',$data);

        }else{

            redirect('start/begin_game');
        }
    }

    //faq page
    public function faq(){

        $connected = $this->session->userdata('connected_ok');
        if($connected){

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            $data["my_infos"]=$this->manager_model->get_my_infos();
            $this->load->view('manager/faq_view',$data);

        }else{

            redirect('start/begin_game');
        }
    }

 
    public function holiday_process($form_data)
    {
        $objResponse = new xajaxResponse();
        $teamId = $this->session->userdata('teamId');
        $userId = $this->session->userdata('userId');

        if($form_data["holiday"]==1){

            $teamReady=$this->team_model->is_team_ready($teamId);
            if($teamReady){
                $methodInUse=$this->corruption_model->checkMethodInUse($teamId);

                if(!$methodInUse){

                    $enoughDirtyGold=$this->money_model->checkEnoughDirtyGold(1,$userId);

                    if($enoughDirtyGold){
                        $this->money_model->updateDirtyGold(1,$userId);
                        $this->manager_model->updateHoliday($userId,$form_data["holiday"]);
                        $data["messageInfos"]=$this->lang->line('validation_ok');
                    }else{

                        $data["messageInfos"]=$this->lang->line('validation_dirtygold');
                    }

                }else{
                    $data["messageInfos"]=$this->lang->line('validation_bonus');
                }
            }else{
                $data["messageInfos"]=$this->lang->line('validation_team_not_ready');
            }
        }else{
            
            $this->manager_model->updateHoliday($userId,$form_data["holiday"]);
            $data["messageInfos"]=$this->lang->line('validation_back');
        }

        $data["my_infos"]=$this->manager_model->get_my_infos();
        $data["holiday"]=$this->manager_model->checkHoliday($teamId);

        $result = $this->load->view('manager/includes/options_view',$data,true);
        $objResponse->assign("options","innerHTML",$result);

        $result = $this->load->view('includes/infos_view',$data,true);
        $objResponse->assign("infos_options","innerHTML",$result);

        return $objResponse;
    }

    public function changeLangage()
    {
        $langage=$_POST["lang"];
        $userId = $this->session->userdata('userId');
        $this->manager_model->updateLangage($userId,$langage);
        redirect("start/begin_game");
    }

}
?>