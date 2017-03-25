<?php
class laboratory_model extends Model {


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
| Return all laboratories
|==========================================================
|
*/
    public function getLaboratories()
    {
        $this->db->order_by("level", "asc");
        $query = $this->db->get('infrastructure_laboratory');
        return $query->result_array();
    }

/*
|==========================================================
| update laboratory type
|==========================================================
|
*/
    public function updateLaboratoryType($laboratoryId,$teamId)
    {
        $data = array(
            'laboratory_id' => $laboratoryId
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('team_laboratory', $data);

    }

/*
|==========================================================
| Return laboratory id
|==========================================================
|
*/
    public function getLaboratoryId($teamId)
    {
        $this->db->select('laboratory_id');
        $this->db->Where("team_id", $teamId);
        $query = $this->db->get('team_laboratory');
        $result=$query->result_array();
        if(isset($result[0]["laboratory_id"]))
            $laboratoryId=$result[0]["laboratory_id"];
        else
            $laboratoryId=0;

        return $laboratoryId;
    }

/*
|==========================================================
| Return laboratory infos
|==========================================================
|
*/
    public function getLaboratoryInfos($laboratoryId)
    {
        $this->db->Where("laboratory_id", $laboratoryId);
        $query = $this->db->get('infrastructure_laboratory');
        return $query->result_array();
    }


/*
|==========================================================
| Return user laboratory infos
|==========================================================
|
*/
    public function getUserLaboratory($teamId)
    {
        $queryString="SELECT *
                      FROM team_laboratory,infrastructure_laboratory
                      WHERE team_laboratory.laboratory_id=infrastructure_laboratory.laboratory_id
                      AND team_laboratory.team_id=$teamId";
        $query = $this->db->query($queryString);
        return $query->result_array();
    }

/*
|==========================================================
| add laboratory
|==========================================================
|
*/
    public function addLaboratory($laboratoryId,$teamId)
    {
        $data = array(
            'laboratory_id' => $laboratoryId,
            'team_id'=>$teamId
        );

        $this->db->insert('team_laboratory', $data);

    }

/*
|==========================================================
| delete laboratory
|==========================================================
|
*/
    public function deleteLaboratory($teamId)
    {
        $this->db->where('team_id',$teamId);
        $this->db->delete('team_laboratory');
    }

 /*
|==========================================================
| check laboratory already bought
|==========================================================
|
*/
    public function checkLabsAlreadybought($teamId,$labsId)
    {
        $queryString="SELECT *
                      FROM team_laboratory
                      WHERE laboratory_id=$labsId
                      AND team_id=$teamId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        if(empty($result))
            return FALSE;

        return TRUE;
    }
}
?>
