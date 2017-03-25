<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class championship_rules {

    const LEVEL_DOWN=0;
    const LEVEL_UP=1;
/*
|==========================================================
|Get Goal Average
| @param $bp(int):but pour
| @param $bc (int):but contre
|return (int) summ of goal
|==========================================================
|
*/
    public static function getGoalAverage($bp,$bc)
    {
        
        if($bp>$bc)
        {
            $total=$bp-$bc;
        }

        if($bc>$bp)
        {
            $total="-".($bc-$bp);
        }

        return $total;

    }

}
