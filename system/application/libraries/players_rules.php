<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class players_rules {

    const LVL_1=1;
    const LVL_2=2;
    const LVL_3=3;
    const LVL_4=4;
    const LVL_5=5;

    public static function getNbPlayersToGenerate($level)
    {
        switch($level){

            case "1":
                return players_rules::LVL_1;
            break;

            case "2":
                return players_rules::LVL_2;
            break;

            case "3":
                return players_rules::LVL_3;
            break;

            case "4":
                return players_rules::LVL_4;
            break;

            case "5":
                return players_rules::LVL_5;
            break;
        }


    }

    public static function getInjuryFlag($injuryFlag)
    {
        if($injuryFlag==1)
            return "<img src='".base_url()."images/fr/players/injury.png' alt='injury' />";

        return "<img src='".base_url()."images/fr/players/ok.png' alt='injury' />";
    }

    public static function experiencePlayerWon($playerInfos,$trainingInfos)
    {
            $playerUp=array();
            $playerUp["ATT"]=0;
            $playerUp["MIL"]=0;
            $playerUp["DEF"]=0;
            $playerUp["GB"]=0;

            switch($playerInfos->position){

            case "ATT":

                if($trainingInfos[0]["att"]>=20 && $playerInfos->experience_att<=16){

                    if($playerInfos->age<25){
                        $playerUp["ATT"]=rand(0,3);
                    }else{
                        $playerUp["ATT"]=rand(0,1);
                    }

                    $playerUp["MIL"]=0;
                    $playerUp["DEF"]=0;
                    $playerUp["GB"]=0;

                }
                if(10<=$trainingInfos[0]["att"] && $trainingInfos[0]["att"]<20 && $playerInfos->experience_att<=16){

                    if($playerInfos->age<25){
                        $playerUp["ATT"]=rand(0,2);
                    }else{
                        $playerUp["ATT"]=rand(0,1);
                    }

                    $playerUp["MIL"]=0;
                    $playerUp["DEF"]=0;
                    $playerUp["GB"]=0;

                }
                if(5<=$trainingInfos[0]["att"] && $trainingInfos[0]["att"]<10 && $playerInfos->experience_att<=16){

                    if($playerInfos->age<25){
                        $playerUp["ATT"]=rand(0,1);
                    }else{
                        $playerUp["ATT"]=0;
                    }
                    
                    $playerUp["MIL"]=0;
                    $playerUp["DEF"]=0;
                    $playerUp["GB"]=0;
                    
                }
                if($trainingInfos[0]["att"]<5){
                    $playerUp["ATT"]=0;
                    $playerUp["MIL"]=0;
                    $playerUp["DEF"]=0;
                    $playerUp["GB"]=0;

                }

                return $playerUp;
            break;

            case "MILL":
                if($trainingInfos[0]["mil"]>=20 && $playerInfos->experience_mil<=16){
                    $playerUp["ATT"]=0;

                    if($playerInfos->age<25){
                        $playerUp["MIL"]=rand(0,3);
                    }else{
                        $playerUp["MIL"]=rand(0,1);
                    }
                    
                    $playerUp["DEF"]=0;
                    $playerUp["GB"]=0;
                    
                }
                if(10<=$trainingInfos[0]["mil"] && $trainingInfos[0]["mil"]<20 && $playerInfos->experience_mil<=16){
                    $playerUp["ATT"]=0;
                    if($playerInfos->age<25){
                        $playerUp["MIL"]=rand(0,2);
                    }else{
                        $playerUp["MIL"]=rand(0,1);
                    }
                    $playerUp["DEF"]=0;
                    $playerUp["GB"]=0;
                    
                }
                if(5<=$trainingInfos[0]["mil"] && $trainingInfos[0]["mil"]<10 && $playerInfos->experience_mil<=16){
                    $playerUp["ATT"]=0;
                    if($playerInfos->age<25){
                        $playerUp["MIL"]=rand(0,1);
                    }else{
                        $playerUp["MIL"]=0;
                    }
                    $playerUp["DEF"]=0;
                    $playerUp["GB"]=0;
                    
                }
                if($trainingInfos[0]["mil"]<5 && $playerInfos->experience_mil<=16){
                    $playerUp["ATT"]=0;
                    $playerUp["MIL"]=0;
                    $playerUp["DEF"]=0;
                    $playerUp["GB"]=0;
                    
                }

                return $playerUp;
            break;

            case "DEF":
                if($trainingInfos[0]["def"]>=20 && $playerInfos->experience_def<=16){
                    $playerUp["ATT"]=0;
                    $playerUp["MIL"]=0;
                    if($playerInfos->age<25){
                        $playerUp["DEF"]=rand(0,3);
                    }else{
                        $playerUp["DEF"]=rand(0,1);
                    }
                    $playerUp["GB"]=0;
                    
                }
                if(10<=$trainingInfos[0]["def"] && $playerInfos->experience_def<=16){
                    $playerUp["ATT"]=0;
                    $playerUp["MIL"]=0;
                    if($playerInfos->age<25){
                        $playerUp["DEF"]=rand(0,2);
                    }else{
                        $playerUp["DEF"]=rand(0,1);
                    }
                    $playerUp["GB"]=0;
                    
                }
                if(5<=$trainingInfos[0]["def"] && $trainingInfos[0]["def"]<10 && $playerInfos->experience_def<=16){
                    $playerUp["ATT"]=0;
                    $playerUp["MIL"]=0;
                    if($playerInfos->age<25){
                        $playerUp["DEF"]=rand(0,1);
                    }else{
                        $playerUp["DEF"]=0;
                    }
                    $playerUp["GB"]=0;
                    
                }
                if($trainingInfos[0]["def"]<5){
                    $playerUp["ATT"]=0;
                    $playerUp["MIL"]=0;
                    $playerUp["DEF"]=0;
                    $playerUp["GB"]=0;
                    
                }

                return $playerUp;
            break;

            case "GB":
                if($trainingInfos[0]["gb"]>=20 && $playerInfos->experience_def<=16){
                    $playerUp["ATT"]=0;
                    $playerUp["MIL"]=0;
                    $playerUp["DEF"]=0;
                    if($playerInfos->age<25){
                        $playerUp["GB"]=rand(0,3);
                    }else{
                        $playerUp["GB"]=rand(0,1);
                    }
                    
                }
                if(10<=$trainingInfos[0]["gb"] && $trainingInfos[0]["gb"]<20 && $playerInfos->experience_def<=16){
                    $playerUp["ATT"]=0;
                    $playerUp["MIL"]=0;
                    $playerUp["DEF"]=0;
                    if($playerInfos->age<25){
                        $playerUp["GB"]=rand(0,2);
                    }else{
                        $playerUp["GB"]=rand(0,1);
                    }
                    
                }
                if(5<=$trainingInfos[0]["gb"] && $trainingInfos[0]["gb"]<10 && $playerInfos->experience_def<=16){
                    $playerUp["ATT"]=0;
                    $playerUp["MIL"]=0;
                    $playerUp["DEF"]=0;
                    if($playerInfos->age<25){
                        $playerUp["GB"]=rand(0,1);
                    }else{
                        $playerUp["GB"]=0;
                    }
                    
                }
                if($trainingInfos[0]["gb"]<5){
                    $playerUp["ATT"]=0;
                    $playerUp["MIL"]=0;
                    $playerUp["DEF"]=0;
                    $playerUp["GB"]=0;
                    
                }

                return $playerUp;
            break;

        }
    }
}