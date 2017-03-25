<?php

class research extends Controller {

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
                /*$this->xajax->register(XAJAX_FUNCTION ,array($this, 'join_friendly_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'accept_request_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'refuse_request_process'));
                $this->xajax->configure('debug', true);
                $this->xajax->processRequest();*/

                $config['total_rows'] = $this->team_model->countAllTeams();
                $config['per_page'] = '20';
                $config['base_url'] = base_url().'/index.php/research/index';
                $this->pagination->initialize($config);
                $data["allTeams"]=$this->team_model->getAllTeams($config['per_page'],$this->uri->segment(3));

                //return user infos
                $data["my_infos"]=$this->manager_model->get_my_infos();
                $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

                $this->load->view('research/research_view',$data);
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
	public function researchTeam(){

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

                //XAJAX init functions
                /*$this->xajax->register(XAJAX_FUNCTION ,array($this, 'join_friendly_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'accept_request_process'));
                $this->xajax->register(XAJAX_FUNCTION ,array($this, 'refuse_request_process'));
                $this->xajax->configure('debug', true);
                $this->xajax->processRequest();*/

                
                if(isset($_POST) && !empty($_POST))
                {
                   $data=$this->input->xss_clean($_POST);
                   $data["research"]="ok";
                }else{
                    $data="";
                    $data["research"]="ok";
                }

                $data["allTeams"]=$this->team_model->getTeamByName($data["team_name"]);

                //return user infos
                $data["my_infos"]=$this->manager_model->get_my_infos();
                $data["sponsorTeam"]=$this->sponsors_model->getSponsorsByTeam($teamId);

                $this->load->view('research/research_view',$data);
            }
            else
            {
                redirect('start/begin_game');
            }

	}


}
?>