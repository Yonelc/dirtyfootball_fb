<?php
class training_model extends Model {

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
| Return team training infos
|==========================================================
|
*/
    public function getTeamTraining($teamId)
    {
        $queryString="SELECT *
                      FROM training
                      WHERE team_id=$teamId";
        $query = $this->db->query($queryString);
        return $query->result_array();
    }

/*
|==========================================================
| add team training
|==========================================================
|
*/
    public function addTeamTraining($teamId)
    {
        $queryString="INSERT INTO training
                      VALUES('',$teamId,0,0,0,0,0,0,0,0,0,'".date('Y-m-d')."')";
        $query = $this->db->query($queryString);

    }

/*
|==========================================================
| update team training
|==========================================================
|
*/
    public function updateTeamTraining($teamId,$type)
    {
        $queryString="UPDATE training";

        switch($type){

            case "att":
                $queryString.=" SET att=att+1,att_estate=1,date_training='".date('Y-m-d')."' ";
            break;

            case "mil";
                $queryString.=" SET mil=mil+1,mil_estate=1,date_training='".date('Y-m-d')."' ";
            break;

            case "def":
                $queryString.=" SET def=def+1,def_estate=1,date_training='".date('Y-m-d')."' ";
            break;

            case "gb":
                $queryString.=" SET gb=gb+1,gb_estate=1,date_training='".date('Y-m-d')."' ";
            break;
        }

        $queryString.="WHERE team_id=$teamId";
        $query = $this->db->query($queryString);

    }

/*
|==========================================================
| update training value
|==========================================================
|
*/
    public function updateTrainingValue($teamId,$value)
    {
        $queryString="UPDATE training SET value=value+$value WHERE team_id=$teamId";
        $query = $this->db->query($queryString);

    }

/*
|==========================================================
| reset training estate
|==========================================================
|
*/
    public function resetTraining($teamId)
    {
        $queryString="UPDATE training
                      SET gb_estate=0,def_estate=0,mil_estate=0,att_estate=0
                      WHERE CURDATE()>date_training
                      AND team_id=$teamId";
        $query = $this->db->query($queryString);

    }

/*
|==========================================================
| New training season
|==========================================================
|
*/
    public function newTrainingSeason($teamId)
    {
        $queryString="UPDATE training
                      SET gb_estate=0,def_estate=0,mil_estate=0,att_estate=0,
                      gb=0,def=0,mil=0,att=0 
                      WHERE team_id=$teamId";
        $query = $this->db->query($queryString);

    }



}
?>
