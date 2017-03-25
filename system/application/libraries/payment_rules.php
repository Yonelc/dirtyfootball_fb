<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class payment_rules {

    public static function getPaymentLogo($type)
    {
        switch($type){

            case "1":
                return "<img src='".base_url()."images/fr/payment/sms.png' alt='SMS+'>";
            break;

            case "2":
                return "<img src='".base_url()."images/fr/payment/audiotel.png' alt='audiotel'>";
            break;

            case "3":
                return "<img src='".base_url()."images/fr/payment/paypal.png' alt='paypal'>";
            break;

            case "4":
                return "<img src='".base_url()."images/fr/payment/cb.gif' alt='cb'>";
            break;

            case "5":
                return "<img src='".base_url()."images/fr/payment/neosurf.gif' alt='neosurf'>";
            break;
        }


    }
}