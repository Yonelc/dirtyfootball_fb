<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notifications_rules {

//NOTIFICATIONS MESSAGE

    //NOTIFICATIONS TYPE
    const TYPE_TRANSFERT=1;
    const TYPE_WOLLARS=2;
    const TYPE_DIRTYGOLD=3;
    const TYPE_INFORMATION=4;

    //TRANSFERTS
    const WELCOME_GAME="welcome_game";
    const WELCOME_WOLLARS="welcome_wollars";
    const WELCOME_DIRTYGOLD="welcome_dirtygold";

    //CHAMPIONSHIP
    const JOIN_CHAMPIONSHIP="join_championship";
    const CHAMPIONSHIP_FINISHED="championship_finished";
    const START_CHAMPIONSHIP="start_championship";
    //TRANSFERTS
    const TRANSFERT_PURPOSED="transfert_propose";
    const TRANSFERT_MODIFIED="transfert_modifie";
    const TRANSFERT_ACCEPTED="transfert_accepte";
    const TRANSFERT_REFUSED="transfert_refuse";
    const TRANSFERT_CANCELED="transfert_annule";

    //WOLLARS
    const WOLLARS_WIN="wollars_win";
    const WOLLARS_LOOSE="wollars_loose";
    const WOLLARS_DRAW="wollars_draw";

    //WOLLARS
    const INJURY="injury";

    //Corruption
    const CORRUPTION_PROPOSE="corruption_propose";
    const CORRUPTION_ACCEPTE="corruption_accepte";
    const CORRUPTION_REFUSE="corruption_refuse";
    const CORRUPTION_ABORTED="corruption_aborted";

    //Friendly
    const FRIENDLY_PROPOSE="friendly_propose";
    const FRIENDLY_ACCEPTE="friendly_accepte";
    const FRIENDLY_REFUSE="friendly_refuse";

    public static function getLogoMessage($type)
    {
       switch($type){

           case notifications_rules::TYPE_TRANSFERT:
                return "<img src='".base_url()."images/fr/manager/logo_transfert.png' />";
           break;

           case notifications_rules::TYPE_WOLLARS:
                return "<img src='".base_url()."images/fr/manager/logo_wollars.png' />";
           break;

           case notifications_rules::TYPE_DIRTYGOLD:
                return "<img src='".base_url()."images/fr/manager/logo_dirtygold.png' />";
           break;

           case notifications_rules::TYPE_INFORMATION:
                return "<img src='".base_url()."images/fr/manager/logo_infos.png' />";
           break;

           default:
                return "<img src='".base_url()."images/fr/manager/logo_infos.png' />";
           break;
       }
    }
}
