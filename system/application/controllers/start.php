<?php

class start extends Controller {

    private $facebook;
    private $language;

    public function __construct(){

        //chargement de la page parent
        parent::__construct();
        
        $this->load->database();
        $this->load->helper('cookie');

        
        header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

        date_default_timezone_set('Europe/Paris');
        if($this->uri->segment(3)!=FALSE)
        {
             $this->lang->load('createTeam', $this->uri->segment(3));
             $this->language=$this->uri->segment(3);
        }
        else
        {
             $this->lang->load('createTeam', 'fr');
             $this->lang->load('cgu', 'fr');
             $this->language="fr";
        }


 
        //configuration facebook
        $this->load->plugin('facebook');
        $this->facebook = new Facebook(array(
              'appId'  => APP_ID,
              'secret' => SECRET_KEY,
              'cookie' => FALSE,
              'domain'=>FACEBOOK_DOMAIN,
        ));
    }
/*
|==========================================================
| Main page FACEBOOK on connection
|==========================================================
|
*/
   public function index(){

       //erase session already setup

       
       $this->session->sess_destroy();
       $session = $this->facebook->getSession();
       if (!$session) {
            $this->load->view('registration/intro_view');
       }else{
            redirect("start/begin_game");
       }

       //redirect("start/begin_game");

   }

   public function cgu(){
       $this->load->view('registration/cgu_view');
   }


   public function begin_game(){

       $session = $this->facebook->getSession();

        if (!$session) {

            $url = $this->facebook->getLoginUrl(array('canvas' => 1, 'fbconnect' => 0,'req_perms' =>  'email,publish_stream,status_update'));
           echo "<script type='text/javascript'>top.location.href = '$url';</script>";

        } else {

            try {

                //load user infos
                $user = $this->facebook->api('/me');
                //put new session
                $identification = array(
                               'email'  => $user["email"],
                               'userId'     => $user["id"],
                               'username'     => $user["first_name"],
                               'userfirstname' => $user["last_name"],
                               'access_token' => $session["access_token"],
                               'connected_ok' => TRUE
                );

                $this->session->set_userdata($identification);

               if(!$this->register_model->checkUserAlreadyRegistred($user["id"]))
                {
                    $this->register_model->insert_user($user,$this->language);
                    $this->friends_model->insertUserFriends($user);
                    $data["my_infos"]=$this->manager_model->get_my_infos();
                    $this->load->view('registration/create_team_view',$data);
                }
                else
                {

                    if(!$this->register_model->checkConnection($user["id"]))
                    {
                        $this->register_model->updateLanguage($this->language,$user["id"]);
                        $data["my_infos"]=$this->manager_model->get_my_infos();
                        $this->load->view('registration/create_team_view',$data);
                    }
                    else
                    {

                        $teamInfos=$this->team_model->getTeamByUserId($user["id"]);
                        $userInfos=$this->manager_model->get_my_infos();
                        $sponsorInfos=$this->sponsors_model->getSponsorsByTeam($teamInfos[0]["team_id"]);

                        if(empty($sponsorInfos))
                            $sponsorLink="";
                        else
                            $sponsorLink=$sponsorInfos[0]["link"];

                        $identification = array(
                                   'email'  => $user["email"],
                                   'userId'     => $user["id"],
                                   'username'     => $user["first_name"],
                                   'userfirstname' => $user["last_name"],
                                   'teamId'  => $teamInfos[0]["team_id"],
                                   'teamName'=> $teamInfos[0]["team_name"],
                                   'level'=> $userInfos[0]["level"],
                                   'sponsor'=> $sponsorLink,
                                   'langage'=> $userInfos[0]["langage"],
                                    'access_token' => $session["access_token"],
                                   'connected_ok' => TRUE);

                        $this->session->set_userdata($identification);

                        redirect('game/');
                    }
                }


            } catch (FacebookApiException $e) {

                echo "Error:" . print_r($e, true);

            }
        }
   }

/*public function begin_game()
{

    ini_set('allow_url_fopen', 1);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    //Authentification new players Oauth 2.0
    $app_id = APP_ID;
    $app_secret = SECRET_KEY;
    $my_url = APP_URL_CANVAS;


print_r($this->facebook->getSignedRequest());
print_r($_REQUEST);
    //$access_token=$this->facebook->getUserAccessToken();
    //check if check application code is given
    if(isset($_REQUEST["code"])){
        $code = $_REQUEST["code"];
    }else{
        $code="";
    }

    if(empty($code)) {//first time in game



            $dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
                . $app_id . "&redirect_uri=" . urlencode($my_url)."&cancel_url=" . urlencode($my_url)."&scope=publish_stream,email";

            //echo("<script> top.location.href='" . $dialog_url . "'</script>");

    }else {//else go in game directly


                    

    $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
        . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret="
        . $app_secret . "&code=" . $code;

    $access_token = file_get_contents($token_url);


    //load user infos
    $user = $this->facebook->api('me?'.$access_token);

    $identification = array(
                   'email'  => $user["email"],
                   'userId'     => $user["id"],
                   'username'     => $user["first_name"],
                   'userfirstname' => $user["last_name"],
                   'access_token' => $session["access_token"],
                   'connected_ok' => TRUE
    );

                $this->session->set_userdata($identification);

               if(!$this->register_model->checkUserAlreadyRegistred($user["id"]))
                {
                    $this->register_model->insert_user($user,$this->language);
                    $this->friends_model->insertUserFriends($user);
                    $data["my_infos"]=$this->manager_model->get_my_infos();
                    $this->load->view('registration/create_team_view',$data);
                }
                else
                {

                    if(!$this->register_model->checkConnection($user["id"]))
                    {
                        $this->register_model->updateLanguage($this->language,$user["id"]);
                        $data["my_infos"]=$this->manager_model->get_my_infos();
                        $this->load->view('registration/create_team_view',$data);
                    }
                    else
                    {

                        $teamInfos=$this->team_model->getTeamByUserId($user["id"]);
                        $userInfos=$this->manager_model->get_my_infos();
                        $sponsorInfos=$this->sponsors_model->getSponsorsByTeam($teamInfos[0]["team_id"]);

                        if(empty($sponsorInfos))
                            $sponsorLink="";
                        else
                            $sponsorLink=$sponsorInfos[0]["link"];

                        $identification = array(
                                   'email'  => $user["email"],
                                   'userId'     => $user["id"],
                                   'username'     => $user["first_name"],
                                   'userfirstname' => $user["last_name"],
                                   'teamId'  => $teamInfos[0]["team_id"],
                                   'teamName'=> $teamInfos[0]["team_name"],
                                   'level'=> $userInfos[0]["level"],
                                   'sponsor'=> $sponsorLink,
                                   'langage'=> $userInfos[0]["langage"],
                                    'access_token' => $session["access_token"],
                                   'connected_ok' => TRUE);

                        $this->session->set_userdata($identification);

                        redirect('game/');







                }

                }
                }

        }*/
/*
|==========================================================
| Add new players in a team for first time
|==========================================================
|
*/
    public function add_player_team()
    {

        //feeds to facebook wall
/*        $attachment = array('message' => $this->lang->line('create_feed_message'),
        'name' => $this->lang->line('create_feed_name'),
        'caption' => $this->lang->line('create_feed_caption'),
        'description' => $this->lang->line('create_feed_description'),
        'link' => APP_URL_CANVAS,
        'picture' => APP_URL_SERVER.'images/fr/global/logo_dirty.png',
        'actions' => array(array('name' => 'Créer son équipe',
        'link' => FACEBOOK_URL_APP))

        );

        $feed=$this->facebook->api('/me/feed?oauth_token='.$this->session->userdata('access_token'),'post',$attachment);
*/
        //add players and stadium
        $userId = $this->session->userdata('userId');
        $email = $this->session->userdata('email');
        $this->register_model->updateUserId($userId,$email);
        $data = $this->input->xss_clean($_POST);
        $this->register_model->insert_team($data,$userId);
        $teamId=$this->register_model->getLastTeamInserted($userId);
        $teamInfos=$this->team_model->getTeamByUserId($userId);
        $this->register_model->add_player_team($data,$teamId);
        $this->stadium_model->addFirstStadium($teamId);
        $this->training_model->addTeamTraining($teamId);

        $this->register_model->updateConnectionStatut($userId);

        $this->notification_model->addNotification(notifications_rules::WELCOME_GAME,$teamId,notifications_rules::TYPE_INFORMATION);
        $this->notification_model->addNotification(notifications_rules::WELCOME_WOLLARS,$teamId,notifications_rules::TYPE_WOLLARS);
        $this->notification_model->addNotification(notifications_rules::WELCOME_DIRTYGOLD,$teamId,notifications_rules::TYPE_DIRTYGOLD);

        $userInfos=$this->manager_model->get_my_infos();

        //add team id to session
        $identification = array(
             'teamId'  => $teamId,
             'teamName'=> $teamInfos[0]["team_name"],
             'level'=> $userInfos[0]["level"],
             'langage'=> $userInfos[0]["langage"] 
        );

        $this->session->set_userdata($identification);

        redirect("game/");
    }


    public function googleAdsense(){
        echo "Ce billet
        confirme que je suis bien le propriétaire du site et que celui-ci respecte
        le Règlement et les Conditions générales du programme Google AdSense";
    }

    public function info(){

        phpinfo();
    }
}
?>