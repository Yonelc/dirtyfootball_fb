<?php

class money extends Controller {

	public function __construct(){

                //chargement de la page parent
		parent::Controller();
                date_default_timezone_set('Europe/Paris');
                $this->load->database();
	}

    //Main page in game boarding
	public function index(){

	}

}
?>