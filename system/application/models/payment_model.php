<?php
class payment_model extends Model {

/*
|==========================================================
| Constructor
|==========================================================
|
*/
    public function __construct()
    {
        parent::Model();

    }

/*
|==========================================================
| Return payment countries
|==========================================================
|
*/
    public function getPaymentCountries()
    {
        $queryString="SELECT *
                      FROM countries
                      WHERE available=1
                      ORDER BY country_name DESC";
        $query = $this->db->query($queryString);
        return $query->result_array();
    }

/*
|==========================================================
| Return prices by country
|==========================================================
|
*/
    public function getPriceCountries($country)
    {
        $queryString="SELECT *
                      FROM countries,products
                      WHERE countries.country_id=products.pays
                      AND countries.country_id='$country'
                      ORDER BY prix ASC";
        $query = $this->db->query($queryString);
        return $query->result_array();
    }

/*
|==========================================================
| Return product
|==========================================================
|
*/
    public function getProduct($code)
    {
        $queryString="SELECT *
                      FROM products
                      WHERE code='$code'";
        $query = $this->db->query($queryString);
        return $query->result_array();
    }

/*
|==========================================================
| add payment
|==========================================================
|
*/
    public function addPayment($userId,$code,$productInfos,$pass)
    {
        $queryString="INSERT INTO payment
                      VALUES('',
                      ".$productInfos[0]["product_id"].",
                      '',
                      '$code',
                      ".$productInfos[0]["gold"].",
                      ".$productInfos[0]["type"].",
                      ".$productInfos[0]["prix"].",
                      NOW(),
                      $userId,'$pass')";
        
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| check payment
|==========================================================
|
*/
    public function checkPaymentAlreadyExist($pass)
    {
        $queryString="SELECT pass
                      FROM payment
                      WHERE pass='$pass'";

        $query = $this->db->query($queryString);
        $result=$query->result_array();

        $nb=count($result);

        if($nb>0)
            return TRUE;

        return FALSE;
    }


/*
|==========================================================
| add payment
|==========================================================
|
*/
    public function addPaymentSponsorPay($uid,$amount,$transactionId)
    {
        $queryString="INSERT INTO payment
                      VALUES('',
                      '',
                      '".$transactionId."',
                      '',
                      ".$amount.",
                      '',
                      '',
                      NOW(),
                      $uid,'')";

        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| check sponsorpay payment
|==========================================================
|
*/
    public function checkSponsorPayAlreadyExist($transactionId,$userId)
    {
        $queryString="SELECT transaction_id
                      FROM payment
                      WHERE transaction_id='$transactionId'
                      AND user_id=$userId";

        $query = $this->db->query($queryString);
        $result=$query->result_array();

        if(!empty($result))
        {
            return TRUE;
        }
        
        return FALSE;
    }

/*
|==========================================================
| add payment
|==========================================================
|
*/
    public function addPaymentSuperRewards($uid,$amount,$transactionId)
    {
        $queryString="INSERT INTO payment
                      VALUES('',
                      '',
                      '".$transactionId."',
                      ".$amount.",
                      '',
                      '',
                      NOW(),
                      $uid,'')";

        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| check sponsorpay payment
|==========================================================
|
*/
    public function checkSuperRewardsAlreadyExist($transactionId)
    {
        $queryString="SELECT oid
                      FROM payment
                      WHERE oid=$transactionId";

        $query = $this->db->query($queryString);
        $result=$query->result_array();

        $nb=count($result);

        if($nb>0)
            return TRUE;

        return FALSE;
    }
}
?>
