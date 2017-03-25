<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class training_rules {

    //TRAINING TYPE
    const ATT_TYPE="att";
    const MIL_TYPE="mil";
    const DEF_TYPE="def";
    const GB_TYPE="gb";
    const TRAINING_VALUE=10000;

    public static function getTube($trainingLevel)
    {
        if($trainingLevel>=20){

            return "<img src='".base_url()."images/fr/global/tube4.jpg' alt='tube4'>";
        }

        if($trainingLevel>=10 && $trainingLevel<20){

            return "<img src='".base_url()."images/fr/global/tube3.jpg' alt='tube3'>";
        }

        if($trainingLevel>=5 && $trainingLevel<10){

            return "<img src='".base_url()."images/fr/global/tube2.jpg' alt='tube2'>";
        }

        if($trainingLevel<5){

            return "<img src='".base_url()."images/fr/global/tube1.jpg' alt='tube1'>";
        }
    }
}
