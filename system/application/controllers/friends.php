<?php

class friends extends Controller {

    private $facebook;

    public function __construct(){

	//chargement de la page parent
	parent::Controller();
        date_default_timezone_set('Europe/Paris');
        $this->load->database();
        $this->load->helper('url_helper');

        //langage loading
        $langageFile=$this->session->userdata('langage');

        if(!empty($langageFile)){
            $this->lang->load('friends', $langageFile);
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



    public function index(){

        $connected = $this->session->userdata('connected_ok');
        if($connected){

            $teamId = $this->session->userdata('teamId');
            $userId = $this->session->userdata('userId');
            $data["userId"]=$userId;
            $data["my_infos"]=$this->manager_model->get_my_infos();
            $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

            $this->load->view('friends/friends_view',$data);

        }else{

            redirect('start/begin_game');
        }
        
    }


    public function invite(){

        $connected = $this->session->userdata('connected_ok');
        if($connected){
            
            if (isset($_REQUEST['ids'])){
                $teamId = $this->session->userdata('teamId');
                $userId = $this->session->userdata('userId');
                $nbFriends = count($_REQUEST['ids']);
                $this->friends_model->updateUserFriends($userId,$nbFriends);

            }
            redirect('game');

        }else{

           redirect('start/begin_game');
        }

    }

}
?>