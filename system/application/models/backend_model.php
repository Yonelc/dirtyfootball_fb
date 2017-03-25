<?php
class backend_model extends Model {

    public function __construct()
    {
        parent::Model();

    }

/*
|==========================================================
| count all users
|==========================================================
|
*/
    public function countAllUsers()
    {
        $queryString="SELECT COUNT(user_id) as nb
                      FROM users";
        $query = $this->db->query($queryString);
        $result=$query->result_array();
        
        return $result;
    }

/*
|==========================================================
| count  users not connected
|==========================================================
|
*/
    public function countUsersNotConnected()
    {
        $queryString="SELECT COUNT(user_id) as nb
                      FROM users
                      WHERE connection=0";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| count all teams
|==========================================================
|
*/
    public function countAllTeams()
    {
        $queryString="SELECT COUNT(team_id) as nb
                      FROM teams";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| count all payments
|==========================================================
|
*/
    public function countAllPayment()
    {
        $queryString="SELECT COUNT(payment_id) as nb
                      FROM payment";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| Sum price money
|==========================================================
|
*/
    public function sumPayment()
    {
        $queryString="SELECT SUM(prix) as nb
                      FROM payment";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }


}
?>
