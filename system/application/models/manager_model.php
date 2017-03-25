<?php
class manager_model extends Model {

    public function __construct()
    {
        parent::__construct();

    }

    //Return all manager's information
    public function get_my_infos()
    {
        $userId = $this->session->userdata('userId');
        $this->db->where('user_id',$userId);
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function getUserInfos($userId)
    {
        $this->db->where('user_id',$userId);
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function getUserIdByTeamId($teamId)
    {
        $queryString="SELECT user_id
                      FROM teams
                      WHERE team_id=$teamId";
        $query=$this->db->query($queryString);
        return $query->result_array();
    }

    public function getUserInfosByTeamId($teamId)
    {
        $queryString="SELECT *
                      FROM teams,users
                      WHERE users.user_id=teams.user_id
                      AND teams.team_id=$teamId";
        $query=$this->db->query($queryString);
        return $query->result_array();
    }

    public function addBug($userId,$firstName,$lastName,$email,$bug)
    {
        $queryString="INSERT INTO
                      bugs
                      VALUES('',$userId,'$firstName','$lastName','$email','$bug',NOW())";
        $query=$this->db->query($queryString);
    }

    public function updateLangage($userId,$langage)
    {
        $queryString="UPDATE
                      users
                      SET langage='$langage'
                      WHERE user_id=$userId";
        $query=$this->db->query($queryString);
    }

    public function checkHoliday($teamId)
    {
        $queryString="SELECT *
                      FROM teams
                      WHERE team_id=$teamId";
        $query=$this->db->query($queryString);
        $result=$query->result_array();

        if($result[0]["holiday"]==1)
            return TRUE;

        return FALSE;
    }

    public function updateHoliday($userId,$choice)
    {
        $queryString="UPDATE
                      teams ";
        
        if($choice==0){
        $queryString.="SET holiday=0 ";
        }

        if($choice==1){
        $queryString.="SET holiday=1 ";
        }

        $queryString.="WHERE user_id=$userId";
        $query=$this->db->query($queryString);
    }

}
?>
