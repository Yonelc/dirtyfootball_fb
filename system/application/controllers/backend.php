<?php

class backend extends Controller {

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
        $email = $this->session->userdata('email');

        if($connected && $email="lionel.clamens@gmail.com"){

            //load backend elements
            $data["allUsers"]=$this->backend_model->countAllUsers();
            $data["allUserNotConnected"]=$this->backend_model->countUsersNotConnected();
            $data["allTeams"]=$this->backend_model->countAllTeams();
            $data["allPayment"]=$this->backend_model->countAllPayment();
            $data["sumPayment"]=$this->backend_model->sumPayment();

            $data["my_infos"]=$this->manager_model->get_my_infos();

            //load view
            $this->load->view('backend/backend_view',$data);

        }else{
            redirect('start/begin_game');
        }
    }

    public function insertNewPlayer(){

        $this->players_model->insertNewPlayers($_POST);
        redirect('backend/index#newplayer');
    }

}
?>