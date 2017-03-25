<?php
class merchandising_model extends Model {

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
| Return all merchandising
|==========================================================
|
*/
    public function getMerchandisings()
    {
        $this->db->order_by("level", "asc");
        $query = $this->db->get('infrastructure_merchandising');
        return $query->result_array();
    }

/*
|==========================================================
| update mechandising type
|==========================================================
|
*/
    public function updateMechandisingType($merchandisingId,$teamId)
    {
        $data = array(
            'merchandising_id' => $merchandisingId
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('team_merchandising', $data);

    }

/*
|==========================================================
| Return merchandising id
|==========================================================
|
*/
    public function getMerchandisingId($teamId)
    {
        $this->db->select('merchandising_id');
        $this->db->Where("team_id", $teamId);
        $query = $this->db->get('team_merchandising');
        $result=$query->result_array();
        if(isset($result[0]["merchandising_id"]))
            $merchandisingId=$result[0]["merchandising_id"];
        else
            $merchandisingId=0;

        return $merchandisingId;
    }

/*
|==========================================================
| Return merchandising infos
|==========================================================
|
*/
    public function getMerchandisingInfos($merchandisingId)
    {
        $this->db->Where("merchandising_id", $merchandisingId);
        $query = $this->db->get('infrastructure_merchandising');
        return $query->result_array();
    }

/*
|==========================================================
| Return user merchandising infos
|==========================================================
|
*/
    public function getUserMerchandising($teamId)
    {
        $queryString="SELECT *
                      FROM team_merchandising,infrastructure_merchandising
                      WHERE team_merchandising.merchandising_id=infrastructure_merchandising.merchandising_id
                      AND team_merchandising.team_id=$teamId";
        $query = $this->db->query($queryString);
        return $query->result_array();
    }

/*
|==========================================================
| add merchandising
|==========================================================
|
*/
    public function addMerchandising($merchandisingId,$teamId)
    {
        $data = array(
            'merchandising_id' => $merchandisingId,
            'team_id'=>$teamId
        );

        $this->db->insert('team_merchandising', $data);

    }

/*
|==========================================================
| delete merchandising
|==========================================================
|
*/
    public function deleteMerchandising($teamId)
    {
        $this->db->where('team_id',$teamId);
        $this->db->delete('team_merchandising');
    }
}
?>
