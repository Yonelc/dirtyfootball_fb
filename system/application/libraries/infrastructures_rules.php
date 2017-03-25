<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class infrastructures_rules {

//type of currency
const MONEY_TYPE=1;
const DIRTYGOLD_TYPE=2;
const FRIEND_TYPE=3;

//type of button
const BUY_BUTTON=1;
const SELL_BUTTON=2;
const NONE_BUTTON=3;
const GET_DIRTYGOLD_BUTTON=4;
const LOCKED_BUTTON=5;

/*
|==========================================================
| get action button
| @params $ownValue: your money or dirty gold or friend quantity
| @params $price:price of the item
| @params $itemId:item of the product
| @params $ownItem:id of the own product
|==========================================================
|
*/
    public static function getAction($ownValue,$price,$itemId,$ownItem,$ownLevel,$level)
    {
        if($ownLevel>=$level){

            if($ownValue>=$price)
            {
                if($price==0)
                {
                   return infrastructures_rules::NONE_BUTTON;
                }

                if(isset($itemId))
                {
                    if($ownItem==$itemId)
                    {
                        return infrastructures_rules::SELL_BUTTON;
                    }
                    else
                    {
                        return infrastructures_rules::BUY_BUTTON;
                    }

                }else {
                    return infrastructures_rules::NONE_BUTTON;
                }
            }

            if($ownItem==$itemId)
            {
                return infrastructures_rules::SELL_BUTTON;
            }
            else
            {
                return infrastructures_rules::GET_DIRTYGOLD_BUTTON;
            }
        }else{

            if($ownItem==$itemId)
            {
                return infrastructures_rules::SELL_BUTTON;
            }
            else
            {
                return infrastructures_rules::LOCKED_BUTTON;
            }
            
        }
        
    }

/*
|==========================================================
| get currency type
| @params $type:type of currency
|==========================================================
|
*/
    public static function getCurrencyType($type)
    {
        switch($type)
        {
            case infrastructures_rules::MONEY_TYPE:
                return $type="money";

            break;

            case infrastructures_rules::DIRTYGOLD_TYPE:
                return $type="dirtyGold";

            break;

            case infrastructures_rules::FRIEND_TYPE:
                return $type="friends";

            break;
        }
    }

    public static function checkStadium($infrastructure)
    {
        if(empty($infrastructure)){
            return anchor("building", "<img src='".base_url()."images/fr/manager/construction.png' border='none' alt='build' />");
        }else{
            return anchor("building", "<img src='".base_url()."images/fr/building/stadiums/".$infrastructure[0]["image"]."' border='none' alt='build' />");
        }
    }

    public static function checkMerchandising1($infrastructure)
    {
        if(!isset($infrastructure[0]["image"])){
            return anchor("building", "<img src='".base_url()."images/fr/manager/construction.png' border='none' alt='build' />");
        }else{
            return anchor("building", "<img src='".base_url()."images/fr/building/merchandisings/".$infrastructure[0]["image"]."' border='none' alt='build' />");
        }
    }

    public static function checkMerchandising2($infrastructure)
    {
        if(!isset($infrastructure[1]["image"])){
            return anchor("building", "<img src='".base_url()."images/fr/manager/construction.png' border='none' alt='build' />");
        }else{
            return anchor("building", "<img src='".base_url()."images/fr/building/merchandisings/".$infrastructure[1]["image"]."' border='none' alt='build' />");
        }
    }

    public static function checkMerchandising3($infrastructure)
    {
        if(!isset($infrastructure[2]["image"])){
            return anchor("building", "<img src='".base_url()."images/fr/manager/construction.png' border='none' alt='build' />");
        }else{
            return anchor("building", "<img src='".base_url()."images/fr/building/merchandisings/".$infrastructure[2]["image"]."' border='none' alt='build' />");
        }
    }

    public static function checkMerchandising4($infrastructure)
    {
        if(!isset($infrastructure[3]["image"])){
            return anchor("building", "<img src='".base_url()."images/fr/manager/construction.png' border='none' alt='build' />");
        }else{
            return anchor("building", "<img src='".base_url()."images/fr/building/merchandisings/".$infrastructure[3]["image"]."' border='none' alt='build' />");
        }
    }

    public static function checkMerchandising5($infrastructure)
    {
        if(!isset($infrastructure[4]["image"])){
            return anchor("building", "<img src='".base_url()."images/fr/manager/construction.png' border='none' alt='build' />");
        }else{
            return anchor("building", "<img src='".base_url()."images/fr/building/merchandisings/".$infrastructure[4]["image"]."' border='none' alt='build' />");
        }
    }

    public static function checkLaboratory($infrastructure)
    {
        if(empty($infrastructure)){
            return anchor("building", "<img src='".base_url()."images/fr/manager/construction.png' border='none' alt='build' />");
        }else{
            return anchor("building", "<img src='".base_url()."images/fr/building/laboratories/".$infrastructure[0]["image"]."' border='none' alt='build' />");
        }
    }

    public static function checkFormationCenter($infrastructure)
    {
        if(empty($infrastructure)){
            return anchor("building", "<img src='".base_url()."images/fr/manager/construction.png' border='none' alt='build' />");
        }else{
            return anchor("building", "<img src='".base_url()."images/fr/building/formation_centers/".$infrastructure[0]["image"]."' border='none' alt='build' />");
        }
    }

}
