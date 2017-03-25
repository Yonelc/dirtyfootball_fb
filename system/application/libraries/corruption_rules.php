<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class corruption_rules {

    //type of currency
    const MONEY_TYPE=1;
    const DIRTYGOLD_TYPE=2;
    const FRIEND_TYPE=3;

    //type of button
    const BUY_BUTTON=1;
    const GET_DIRTYGOLD_BUTTON=2;
    const LOCKED_ITEM=3;
    const FRIENDS_BUTTON=4;

    //action
    const ADD_ACTION=1;
    const USE_ACTION=2;
    
    //type method
    const DEFENSIVE_METHOD=1;
    const OFFENSIVE_METHOD=2;
    const MIDFIELD_METHOD=3;
    const GOALKEEPER_METHOD=4;


/*
|==========================================================
| get opponent id
| @params $ownTeamId:team id of the player
|==========================================================
|
*/
    public static function getOpponentId($ownTeamId,$homeTeamId,$awayTeamId)
    {
        if($ownTeamId==$homeTeamId)
            $opponentId=$awayTeamId;
        else
            $opponentId=$homeTeamId;

        return $opponentId;
    }

/*
|==========================================================
| get action
| @params $ownValue:own money
| @params $price:price of the item
| @params $ownLaboratoryLevel:own laboratory level
| @params $laboratoryLevel:laboratory level
|==========================================================
|
*/
    public static function getAction($ownValue,$price,$ownLaboratoryLevel,$laboratoryLevel,$ownFriends,$friendsNeeded)
    {

        if($ownLaboratoryLevel>=$laboratoryLevel)
        {
            if($ownFriends>=$friendsNeeded)
            {
                if($ownValue>=$price)
                {
                    return corruption_rules::BUY_BUTTON;
                }
                else
                {
                    return corruption_rules::GET_DIRTYGOLD_BUTTON;
                }

            }else{
                return corruption_rules::FRIENDS_BUTTON;
            }
        }
        else
        {
            return corruption_rules::LOCKED_ITEM;
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

    public static function getBonusArr($bonus)
    {
        $bonusArr=array();
        $bonusArr["bonusAtt"]=0;
        $bonusArr["bonusMill"]=0;
        $bonusArr["bonusDef"]=0;
        $bonusArr["bonusGb"]=0;

        if(count($bonus)!=0)
        {
            foreach($bonus as $row)
            {
                switch($row["sector"])
                {
                    case "ATT":
                        $bonusArr["bonusAtt"]=$bonusArr["bonusAtt"]+$row["capacity"];
                    break;

                    case "MILL":
                        $bonusArr["bonusMill"]=$bonusArr["bonusMill"]+$row["capacity"];
                    break;

                    case "DEF":
                        $bonusArr["bonusDef"]=$bonusArr["bonusDef"]+$row["capacity"];
                    break;

                    case "GB":
                        $bonusArr["bonusGb"]=$bonusArr["bonusGb"]+$row["capacity"];
                    break;
                }
            }
        }
        return $bonusArr;
    }
}
