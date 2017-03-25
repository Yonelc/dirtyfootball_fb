<?php
class sponsors_model extends Model {

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
| Return all sponsors
|==========================================================
|
*/
    public function getSponsors()
    {
        $queryString="SELECT *
                      FROM sponsors";
        $query = $this->db->query($queryString);
        return $query->result_array();
    }

/*
|==========================================================
| Return all sponsors by team
|==========================================================
|
*/
    public function getSponsorsByTeam($teamId)
    {
        $queryString="SELECT *
                      FROM sponsors, team_sponsors
                      WHERE sponsors.sponsor_id=team_sponsors.sponsor_id
                      AND team_id=$teamId";
        $query = $this->db->query($queryString);
        return $query->result_array();
    }

/*
|==========================================================
| Add team sponsors
|==========================================================
|
*/
    public function addSponsorByTeam($sponsorId,$teamId)
    {
        $queryString="INSERT INTO team_sponsors
                     VALUES($sponsorId,$teamId)";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| Delete team sponsors
|==========================================================
|
*/
    public function deleteSponsorByTeam($teamId)
    {
        $queryString="DELETE FROM team_sponsors
                      WHERE team_id=$teamId";
        $query = $this->db->query($queryString);
    }


}
?>
