<?php

class cronjob extends Controller {

    public function __construct(){

	//chargement de la page parent
	parent::Controller();
        date_default_timezone_set('Europe/Paris');
        $this->load->database();
        $this->load->helper('url_helper');
    }



    public function insertSponsor(){
        $image=htmlspecialchars('<img src="http://dirtydev.lionwebl.com/images/sponsors/sponsor1.jpg" />');
        $queryString="INSERT INTO sponsors values('','sponsor1','$image',5)";
        $this->db->query($queryString);
        
    }


    public function test(){

        $queryString="update users set dirtyGold=dirtyGold+10 where user_id=1370361530";
        $this->db->query($queryString);

    }

    public function resetTraining()
    {
        $this->training_model->resetTraining();
    }



}
?>