<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class team_rules {

    const URL_FLAGS="images/fr/flag_mini";

/*
|==========================================================
|Get color position
|==========================================================
|
*/
    public static function getColorPosition($playerPosition,$attPosition,$millPosition,$defPosition,$gbPosition)
    {
        
        if($playerPosition==$gbPosition)
        {
            $class="player_gb";
        }

        if($gbPosition < $playerPosition && $playerPosition <= $defPosition)
        {
            $class="player_def";
        }

        if($defPosition < $playerPosition && $playerPosition <= $millPosition)
        {
            $class="player_mill";
        }

        if($millPosition < $playerPosition && $playerPosition <= $attPosition)
        {
            $class="player_att";
        }

        return $class;

    }

    public static function getAllFlags()
    {
        
        $flagsArr=array();

        $path = team_rules::URL_FLAGS;
        $dir = opendir($path);

        while ($file = readdir($dir)) {
            
           if(is_file($path.'/'.$file)) {
              
              $flagsArr[]=$file;
           }
        }

        return $flagsArr;
    }

}
