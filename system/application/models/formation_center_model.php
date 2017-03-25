<?php
class formation_center_model extends Model {

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
| Return all formation center
|==========================================================
|
*/
    public function getFormationCenters()
    {
        $this->db->order_by("level", "asc");
        $query = $this->db->get('infrastructure_formation_center');
        return $query->result_array();
    }

/*
|==========================================================
| Return formation center id
|==========================================================
|
*/
    public function getFormationCenterId($teamId)
    {
        $this->db->select('formation_center_id');
        $this->db->Where("team_id", $teamId);
        $query = $this->db->get('team_formation_center');
        $result=$query->result_array();
        if(isset($result[0]["formation_center_id"]))
            $formationCenterId=$result[0]["formation_center_id"];
        else
            $formationCenterId=0;

        return $formationCenterId;
    }

/*
|==========================================================
| Return stadium infos
|==========================================================
|
*/
    public function getFormationCenterInfos($formationCenterId)
    {
        $this->db->Where("formation_center_id", $formationCenterId);
        $query = $this->db->get('infrastructure_formation_center');
        return $query->result_array();
    }

/*
|==========================================================
| Return user formation_center infos
|==========================================================
|
*/
    public function getUserFormationCenter($teamId)
    {
        $queryString="SELECT *
                      FROM team_formation_center,infrastructure_formation_center
                      WHERE team_formation_center.formation_center_id=infrastructure_formation_center.formation_center_id
                      AND team_formation_center.formation_center_id=$teamId";
        $query = $this->db->query($queryString);
        return $query->result_array();
    }


/*
|==========================================================
| update formation center type
|==========================================================
|
*/
    public function updateFormationCenterType($formationCenterId,$teamId)
    {
        $data = array(
            'formation_center_id' => $formationCenterId
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('team_formation_center', $data);

    }

/*
|==========================================================
| add formation center type
|==========================================================
|
*/
    public function addFormationCenter($formationCenterId,$teamId)
    {
        $data = array(
            'formation_center_id' => $formationCenterId,
            'team_id'=>$teamId
        );

        $this->db->insert('team_formation_center', $data);

    }

/*
|==========================================================
| delete formation center
|==========================================================
|
*/
    public function deleteFormationCenter($teamId)
    {
        $this->db->where('team_id',$teamId);
        $this->db->delete('team_formation_center');
    }
}
?>
