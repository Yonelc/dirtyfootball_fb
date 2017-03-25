<?php

/**
 * OFC2 Chart Controller
 * 
 * @package CodeIgniter
 * @author  thomas (at) kbox . ch
 */
class Ofc2 extends Controller {
  
    /**
     * Constructor
     * 
     * @return void
     */
	function __construct()
	{
            parent::__construct();
            date_default_timezone_set('Europe/Paris');
            $this->load->helper('url_helper');
            
            //langage loading
            $langageFile=$this->session->userdata('langage');

            if(!empty($langageFile)){
                $this->lang->load('menu', $langageFile);
                $this->lang->load('manager', $langageFile);
                $this->lang->load('footer', $langageFile);
            }else{
                redirect("start/begin_game");
            }
	}

    /**
     * Generates data for OFC2 pie chart in json format
     *
     * @return void
     */
    public function get_data_pie()
    {
        $this->load->plugin('ofc2');

        $teamId = $this->session->userdata('teamId');
        $pie_stats=$this->team_model->get_team_infos($teamId);
        $title=new title("<div style='color:#093134;font-size:16px;font-weight:bold;'>Matchs joués</div>");
        $flag=false;

        foreach($pie_stats as $row)
        {
            $victory=$row->nb_victory;
            $lost=$row->nb_lost;
            $tie=$row->nb_tie;
        }

        $nbVictory=(int)$victory;
        $nbLost=(int)$lost;
        $nbTie=(int)$tie;

        if($nbVictory!=0 || $nbLost!=0 || $nbTie!=0)
        {
            $statsArr=array(new pie_value($nbVictory, $nbVictory.$this->lang->line('victory')),new pie_value($nbLost, $nbLost.$this->lang->line('defeat')),new pie_value($nbTie, $nbTie.$this->lang->line('tie')));
        }
        else
        {
            $statsArr=array(new pie_value(1, "0".$this->lang->line('victory')),new pie_value(1, "0".$this->lang->line('defeat')),new pie_value(1, "0".$this->lang->line('tie')));
            $flag=true;
        }
        
        $pie = new pie();
        $pie->set_alpha(1.0);
        $pie->add_animation( new pie_bounce(5) );
        $pie->set_start_angle( 35 );
        $pie->add_animation( new pie_fade() );
        if($flag!=true)
        {
            $pie->set_tooltip( '#val# / #total#<br>#percent#' );
        }
        else
        {
            $pie->set_tooltip( '#val# / #total#' );
        }

        $pie->set_colours( array('#1aa102','#d90202','#031be5') );
        $pie->set_values( $statsArr );
        
        $chart = new open_flash_chart();
        //$chart->set_title( $title );
        $chart->set_bg_colour('#e4eaed');
        $chart->add_element( $pie );
        $chart->x_axis = null;

        echo $chart->toPrettyString();
    }

  
}
