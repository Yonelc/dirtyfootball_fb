<?php
class stadium_model extends Model {

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
| Return all stadiums
|==========================================================
|
*/
    public function getStadiums()
    {
        $this->db->order_by("capacity", "asc");
        $query = $this->db->get('infrastructure_stadium');
        return $query->result_array();
    }

/*
|==========================================================
| Return stadium infos
|==========================================================
|
*/
    public function getStadiumId($teamId)
    {
        $this->db->select('stadium_id');
        $this->db->Where("team_id", $teamId);
        $query = $this->db->get('team_stadium');
        return $query->result_array();
    }

/*
|==========================================================
| Return stadium infos
|==========================================================
|
*/
    public function getStadiumInfos($stadiumId)
    {
        $this->db->Where("stadium_id", $stadiumId);
        $query = $this->db->get('infrastructure_stadium');
        return $query->result_array();
    }

/*
|==========================================================
| Return user stadium infos
|==========================================================
|
*/
    public function getUserStadium($teamId)
    {
        $queryString="SELECT *
                      FROM team_stadium,infrastructure_stadium
                      WHERE team_stadium.stadium_id=infrastructure_stadium.stadium_id
                      AND team_stadium.team_id=$teamId";
        $query = $this->db->query($queryString);
        return $query->result_array();
    }
    
/*
|==========================================================
| update stadium type
|==========================================================
|
*/
    public function updateStadiumType($stadiumId,$teamId)
    {
        $data = array(
            'stadium_id' => $stadiumId
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('team_stadium', $data);

    }

/*
|==========================================================
| sell stadium
|==========================================================
|
*/
    public function sellStadium($teamId)
    {
        $data = array(
            'stadium_id' => 1
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('team_stadium', $data);

    }

/*
|==========================================================
| add first stadium
|==========================================================
|
*/
    public function addFirstStadium($teamId)
    {
        $data = array(
            'stadium_id' => 1,
            'team_id'=>$teamId
        );

        $this->db->insert('team_stadium', $data);

    }
 /*
|==========================================================
| check stadium already bought
|==========================================================
|
*/
    public function checkStadiumAlreadybought($teamId,$stadiumId)
    {
        $queryString="SELECT *
                      FROM team_stadium
                      WHERE stadium_id=$stadiumId
                      AND team_id=$teamId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        if(empty($result))
            return FALSE;

        return TRUE;
    }

}
?>
