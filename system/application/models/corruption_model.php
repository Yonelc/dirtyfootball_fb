<?php
class corruption_model extends Model {

    public function __construct()
    {
        parent::Model();

    }

/*
|==========================================================
| get corrupted match proposal
| @param $matchId:id of the match
| @param $teamId:id of the team
|==========================================================
|
*/
    public function getCorruptedMatchProposal($matchId,$teamId)
    {
        $queryString="SELECT *
                      FROM corruption_match
                      WHERE match_id=$matchId
                      AND receiver=$teamId
                      AND response=0";
        $query = $this->db->query($queryString);
        $result=$query->result_array();
        
        return $result;
    }

/*
|==========================================================
| get corruption infos
| @param $matchId:id of the match
|==========================================================
|
*/
    public function getCorruptionInfos($matchId)
    {
        $queryString="SELECT *
                      FROM corruption_match
                      WHERE match_id=$matchId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| accept corruption update statut
| @param $matchId:id of the match
|==========================================================
|
*/
    public function corruptionAccepted($matchId)
    {
        /*$queryString="SELECT *
                      FROM corruption_match
                      WHERE match_id=$matchId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;*/
        $queryString="UPDATE corruption_match
                      SET response=1
                      WHERE match_id=$matchId";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| check if Corruption is Accepted
| @param $matchId:id of the match
|==========================================================
|
*/
    public function checkCorruptionAccepted($matchId)
    {
        $queryString="SELECT COUNT(corruption_match_id) as nb
                      FROM corruption_match
                      WHERE match_id=$matchId
                      AND response=1";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        if($result[0]["nb"]!=0)
            return TRUE;
        else
            return FALSE;
    }

/*
|==========================================================
| Return offensive methods
|==========================================================
|
*/
    public function getOffensiveMethods()
    {
        $queryString="SELECT *
                      FROM corruption_offensive_methods
                      ORDER BY value ASC";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| Return defensive methods
|==========================================================
|
*/
    public function getdefensiveMethods()
    {
        $queryString="SELECT *
                      FROM corruption_defensive_methods
                      ORDER BY value ASC";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| refuse corruption
| @param $matchId:id of the match
|==========================================================
|
*/
    public function corruptionRefused($matchId)
    {
        $queryString="DELETE FROM corruption_match
                      WHERE match_id=$matchId";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| Return laboratory level
| @param $teamId:id of the team
|==========================================================
|
*/
    public function getOwnLaboratoryLevel($teamId)
    {
        $queryString="SELECT *
                      FROM team_laboratory,infrastructure_laboratory
                      WHERE team_laboratory.laboratory_id=infrastructure_laboratory.laboratory_id
                      AND team_id=$teamId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| Get defensive method infos
| @param $defensiveMethodId:id of defensive method
|==========================================================
|
*/
    public function getDefensiveMethodInfos($defensiveMethodId)
    {
        $queryString="SELECT *
                      FROM corruption_defensive_methods
                      WHERE corruption_defensive_id=$defensiveMethodId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| Get offensive method infos
| @param $offensiveMethodId:id of offensive method
|==========================================================
|
*/
    public function getOffensiveMethodInfos($offensiveMethodId)
    {
        $queryString="SELECT *
                      FROM corruption_offensive_methods
                      WHERE corruption_offensive_id=$offensiveMethodId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| check defensive method
| @param $defensiveMethodId:id of defensive method
|==========================================================
|
*/
    public function checkDefensiveMethod($defensiveMethodId,$teamId)
    {
        $queryString="SELECT *
                      FROM team_defensive_methods
                      WHERE defensive_method_id=$defensiveMethodId
                      AND team_id=$teamId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();
        
        if(empty($result))
        {
            return FALSE;
        }else{
            return TRUE;
        }

    }
/*
|==========================================================
| count defensive method
| @param $defensiveMethodId:id of defensive method
|==========================================================
|
*/
    public function checkCountDefensiveMethod($defensiveMethodId,$teamId)
    {
        $queryString="SELECT *
                      FROM team_defensive_methods
                      WHERE defensive_method_id=$defensiveMethodId
                      AND team_id=$teamId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        if($result[0]["qt"]==0)
        {
            return FALSE;
        }else{
            return TRUE;
        }

    }
/*
|==========================================================
| check offensive method
| @param $offensiveMethodId:id of offensive method
|==========================================================
|
*/
    public function checkOffensiveMethod($offensiveMethodId,$teamId)
    {
        $queryString="SELECT *
                      FROM team_offensive_methods
                      WHERE offensive_method_id=$offensiveMethodId
                      AND team_id=$teamId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        if(empty($result))
        {
            return FALSE;
        }else{
            return TRUE;
        }
    }
/*
|==========================================================
| count offensive method
| @param $offensiveMethodId:id of offensive method
|==========================================================
|
*/
    public function checkCountOffensiveMethod($offensiveMethodId,$teamId)
    {
        $queryString="SELECT *
                      FROM team_offensive_methods
                      WHERE offensive_method_id=$offensiveMethodId
                      AND team_id=$teamId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        if($result[0]["qt"]==0)
        {
            return FALSE;
        }else{
            return TRUE;
        }
    }

/*
|==========================================================
| insert offensive method
| @param $teamId:id of the team
| @param $offensiveMethodId:id of the method
|==========================================================
|
*/
    public function addOffensiveMethod($offensiveMethodId,$teamId)
    {
        $queryString="INSERT INTO team_offensive_methods (team_id,offensive_method_id,qt)
                      VALUES($teamId,$offensiveMethodId,1)";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| update offensive method
| @param $teamId:id of the team
| @param $offensiveMethodId:id of the method
| @param $action:type of action
|==========================================================
|
*/
    public function updateOffensiveMethod($offensiveMethodId,$teamId,$action)
    {
        if($action==corruption_rules::ADD_ACTION)
        {
           $queryString="UPDATE team_offensive_methods
              SET qt=qt+1
              WHERE team_id=$teamId
              AND offensive_method_id=$offensiveMethodId";
        }else{
          $queryString="UPDATE team_offensive_methods
              SET qt=qt-1
              WHERE team_id=$teamId
              AND offensive_method_id=$offensiveMethodId";
        }

        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| insert defensive method
| @param $teamId:id of the team
| @param $defensiveMethodId:id of the method
|==========================================================
|
*/
    public function addDefensiveMethod($defensiveMethodId,$teamId)
    {
        $queryString="INSERT INTO team_defensive_methods (team_id,defensive_method_id,qt)
                      VALUES($teamId,$defensiveMethodId,1)";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| update defensive method
| @param $teamId:id of the team
| @param $offensiveMethodId:id of the method
| @param $action:type of action
|==========================================================
|
*/
    public function updateDefensiveMethod($defensiveMethodId,$teamId,$action)
    {
        if($action==corruption_rules::ADD_ACTION)
        {
           $queryString="UPDATE team_defensive_methods
              SET qt=qt+1
              WHERE team_id=$teamId
              AND defensive_method_id=$defensiveMethodId";
        }else{
          $queryString="UPDATE team_defensive_methods
              SET qt=qt-1
              WHERE team_id=$teamId
              AND defensive_method_id=$defensiveMethodId";
        }

        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| Get own offensive methods
| @param $teamId:id of team
|==========================================================
|
*/
    public function getOwnOffensiveMethods($teamId)
    {
        $queryString="SELECT *
                      FROM team_offensive_methods,corruption_offensive_methods
                      WHERE team_offensive_methods.offensive_method_id=corruption_offensive_methods.corruption_offensive_id
                      AND team_offensive_methods.team_id=$teamId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| Get own defensive methods
| @param $teamId:id of team
|==========================================================
|
*/
    public function getOwnDefensiveMethods($teamId)
    {
        $queryString="SELECT *
                      FROM team_defensive_methods,corruption_defensive_methods
                      WHERE team_defensive_methods.defensive_method_id=corruption_defensive_methods.corruption_defensive_id
                      AND team_defensive_methods.team_id=$teamId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }


/*
|==========================================================
| Get used Defensive methods
| @param $teamId:id of team
| @param $matchId:id of match
|==========================================================
|
*/
    public function getUsedDefensiveMethods($teamId/*,$matchId*/)
    {
        /*$queryString="SELECT *
                      FROM team_used_corruption,corruption_defensive_methods
                      WHERE team_used_corruption.corruption_id=corruption_defensive_methods.corruption_defensive_id
                      AND team_used_corruption.team_id=$teamId
                      AND team_used_corruption.match_id=$matchId
                      AND team_used_corruption.method_type=1";*/
        $queryString="SELECT *
                      FROM team_used_corruption,corruption_defensive_methods
                      WHERE team_used_corruption.corruption_id=corruption_defensive_methods.corruption_defensive_id
                      AND team_used_corruption.team_id=$teamId
                      AND team_used_corruption.method_type=1";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| Get used offensive methods
| @param $teamId:id of team
| @param $matchId:id of match
|==========================================================
|
*/
    public function getUsedOffensiveMethods($teamId/*,$matchId*/)
    {
        /*$queryString="SELECT *
                      FROM team_used_corruption,corruption_offensive_methods
                      WHERE team_used_corruption.corruption_id=corruption_offensive_methods.corruption_offensive_id
                      AND team_used_corruption.team_id=$teamId
                      AND team_used_corruption.match_id=$matchId
                      AND team_used_corruption.method_type=2";*/
        $queryString="SELECT *
                      FROM team_used_corruption,corruption_offensive_methods
                      WHERE team_used_corruption.corruption_id=corruption_offensive_methods.corruption_offensive_id
                      AND team_used_corruption.team_id=$teamId
                      AND team_used_corruption.method_type=2";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| insert defensive method
| @param $teamId:id of the team
| @param $defensiveMethodId:id of the method
| @param $methodId:id of the method
|==========================================================
|
*/
    public function insertUsedMethod($methodId,$teamId,$matchId,$methodType)
    {
        $queryString="INSERT INTO team_used_corruption (team_id,corruption_id,match_id,method_type)
                      VALUES($teamId,$methodId,$matchId,$methodType)";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| delete used method
| @param $teamId:id of the team
|==========================================================
|
*/
    public function deleteUsedMethod($usedId)
    {
        $queryString="DELETE FROM team_used_corruption
                      WHERE used_id=$usedId";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| delete used method
| @param $teamId:id of the team
|==========================================================
|
*/
    public function deleteMethodEndMatch($teamId)
    {
        $queryString="DELETE FROM team_used_corruption
                      WHERE team_id=$teamId";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| check used method
| @param $MethodId:id of method
| @param $teamId:id of team
| @param $type:type of method
|==========================================================
|
*/
    public function checkUsedMethod($teamId,$usedId,$type)
    {
        $queryString="SELECT *
                      FROM team_used_corruption
                      WHERE used_id=$usedId
                      AND team_id=$teamId
                      AND method_type=$type";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        if(empty($result))
        {
            return FALSE;
        }else{
            return TRUE;
        }
    }

/*
|==========================================================
| get offensive bonus used
| @param $teamId:id of team
|==========================================================
|
*/
    public function getOffensiveBonusUsed($teamId)
    {
        $queryString="SELECT *
                      FROM team_used_corruption,corruption_offensive_methods
                      WHERE team_used_corruption.corruption_id=corruption_offensive_methods.corruption_offensive_id
                      AND team_id=$teamId
                      AND method_type=2";
        $query = $this->db->query($queryString);
        $result=$query->result_array();
        return $result;

    }

/*
|==========================================================
| get offensive bonus used
| @param $teamId:id of team
|==========================================================
|
*/
    public function getDefensiveBonusUsed($teamId)
    {
        $queryString="SELECT *
                      FROM team_used_corruption,corruption_defensive_methods
                      WHERE team_used_corruption.corruption_id=corruption_defensive_methods.corruption_defensive_id
                      AND team_id=$teamId
                      AND method_type=1";
        $query = $this->db->query($queryString);
        $result=$query->result_array();
        return $result;
    }

/*
|==========================================================
| update team primary potential
|==========================================================
|
*/
    public function increaseTeamPrimaryPotential($potential,$teamId,$action)
    {
        switch($action){

          case "ATT";
              $queryString="UPDATE teams
              SET experience_att=experience_att+$potential
              WHERE team_id=$teamId";
          break;

          case "MIL";
              $queryString="UPDATE teams
              SET experience_mil=experience_mil+$potential
              WHERE team_id=$teamId";
          break;

          case "DEF";
              $queryString="UPDATE teams
              SET experience_def=experience_def+$potential
              WHERE team_id=$teamId";
          break;

          case "GB";
              $queryString="UPDATE teams
              SET experience_gb=experience_gb+$potential
              WHERE team_id=$teamId";
          break;

        }

        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| update team secondary potential
|==========================================================
|
*/
    public function increaseTeamSecondaryPotential($potential,$teamId,$action)
    {
      switch($action){

          case "ATT";
              $queryString="UPDATE teams
              SET secondary_experience_att=secondary_experience_att+$potential
              WHERE team_id=$teamId";
          break;

          case "MIL";
              $queryString="UPDATE teams
              SET secondary_experience_mil=secondary_experience_mil+$potential
              WHERE team_id=$teamId";
          break;

          case "DEF";
              $queryString="UPDATE teams
              SET secondary_experience_def=secondary_experience_def+$potential
              WHERE team_id=$teamId";
          break;

          case "GB";
              $queryString="UPDATE teams
              SET secondary_experience_gb=secondary_experience_gb+$potential
              WHERE team_id=$teamId";
          break;

        }

        $query = $this->db->query($queryString);
    }

    /*
|==========================================================
| update team primary potential
|==========================================================
|
*/
    public function decreaseTeamPrimaryPotential($potential,$teamId,$action)
    {
        switch($action){

          case "ATT";
              $queryString="UPDATE teams
              SET experience_att=experience_att-$potential
              WHERE team_id=$teamId";
          break;

          case "MIL";
              $queryString="UPDATE teams
              SET experience_mil=experience_mil-$potential
              WHERE team_id=$teamId";
          break;

          case "DEF";
              $queryString="UPDATE teams
              SET experience_def=experience_def-$potential
              WHERE team_id=$teamId";
          break;

          case "GB";
              $queryString="UPDATE teams
              SET experience_gb=experience_gb-$potential
              WHERE team_id=$teamId";
          break;

        }

        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| update team secondary potential
|==========================================================
|
*/
    public function decreaseTeamSecondaryPotential($potential,$teamId,$action)
    {
      switch($action){

          case "ATT";
              $queryString="UPDATE teams
              SET secondary_experience_att=secondary_experience_att-$potential
              WHERE team_id=$teamId";
          break;

          case "MIL";
              $queryString="UPDATE teams
              SET secondary_experience_mil=secondary_experience_mil-$potential
              WHERE team_id=$teamId";
          break;

          case "DEF";
              $queryString="UPDATE teams
              SET secondary_experience_def=secondary_experience_def-$potential
              WHERE team_id=$teamId";
          break;

          case "GB";
              $queryString="UPDATE teams
              SET secondary_experience_gb=secondary_experience_gb-$potential
              WHERE team_id=$teamId";
          break;

        }

        $query = $this->db->query($queryString);
    }

    /*
|==========================================================
| check method in use
| @param $teamId:id of team
|==========================================================
|
*/
    public function checkMethodInUse($teamId)
    {
        $queryString="SELECT *
                      FROM team_used_corruption
                      WHERE team_id=$teamId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        if(empty($result))
        {
            return FALSE;
        }else{
            return TRUE;
        }
    }

}
?>
