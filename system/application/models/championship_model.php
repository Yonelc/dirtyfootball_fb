<?php
class championship_model extends Model {

const CHAMPIONSHIP_FULL=10;
/*
|==========================================================
| Constructor
|==========================================================
|
*/
    public function __construct()
    {
        parent::Model();
        $this->load->dbutil();
    }

/*
|==========================================================
| Return all championship
|==========================================================
|
*/
    public function get_all_championships()
    {
        //$this->db->select('*');
        $this->db->from('championships');
        $query=$this->db->get();

        return $query->result();

    }

/*
|==========================================================
| Return all championship
|==========================================================
|
*/
    public function getTenChampionships()
    {
        $queryString="SELECT *
                     FROM championships
                     WHERE nb_teams=10
                     LIMIT 0,10";
        $query=$this->db->query($queryString);
        return $query->result_array();

    }

/*
|==========================================================
| Return all championship
|==========================================================
|
*/
    public function getOwnChampionship($teamId)
    {
        $queryString="SELECT *
                      FROM championships,teams_championship
                      WHERE championships.championship_id=teams_championship.championship_id
                      AND teams_championship.team_id=$teamId";
        $query=$this->db->query($queryString);

        return $query->result_array();

    }

/*
|==========================================================
| Return all championship
|==========================================================
|
*/
    public function getAllChampionshipsByLevel($level,$num,$offset)
    {
        
        /*$this->db->where('level',$level);*/
        $this->db->order_by('level','DESC');
        $this->db->order_by('nb_teams','ASC');
        
        $query=$this->db->get('championships',$num,$offset);

        return $query->result();

    }



 /*
|==========================================================
| count championship by level
|==========================================================
|
*/
    public function countAvailableChampionshipsByLevel()
    {
	$query=$this->db->get("championships");
        return $query->num_rows();
    }


/*
|==========================================================
| Return  championship by measure
|==========================================================
|
*/
    public function get_championships_by_measure($num,$offset,$championshipName)
    {

        $this->db->like('title', $championshipName);
        $this->db->order_by('nb_teams','ASC');
        $query=$this->db->get('championships',$num,$offset);

        return $query->result();

    }

 /*
|==========================================================
| count championship by measure
|==========================================================
|
*/
    public function count_championships_by_measure($championshipName)
    {
        $this->db->like('title', $championshipName);
	$query=$this->db->get("championships");
        return $query->num_rows();
    }

/*
|==========================================================
| Load Championship
| @param $championshipId: id of the championship
|==========================================================
|
*/
    public function get_championship($championshipId)
    {
        //$this->db->select('*');
        $this->db->from('championships');
	$this->db->where('championship_id',$championshipId);
        $query=$this->db->get();

        return $query->result();

    }

/*
|==========================================================
| Load Classement
| @param $teamId: id of classement
|==========================================================
|
*/
    public function get_classement($teamId)
    {
        $this->db->select('championship_id');
        $this->db->from('teams_championship');
	$this->db->where('team_id',$teamId);
        $query=$this->db->get();
        $result=$query->result_array();

        if(isset($result[0]["championship_id"]))
            $teams=$this->get_teams_championship($result[0]["championship_id"]);
        else
            $teams="";

        return $teams;
    }

/*
|==========================================================
| Update match result
| @param $match_id:id of the match
| @param $result:score of the match
|==========================================================
|
*/
    public function update_classement($result,$homeTeam,$awayTeam)
    {
        $winnerId=$result["winner"];
        $looserId=$result["looser"];

        $winnerInfos=$this->get_team_championship($winnerId);
        $looserInfos=$this->get_team_championship($looserId);
        
        if($result["away_team_score"]<$result["home_team_score"])
        {
            $winnerScore=$result["home_team_score"];
            $looserScore=$result["away_team_score"];
        }  
        else
        {
            $looserScore=$result["home_team_score"];
            $winnerScore=$result["away_team_score"];            
        }
        

        if($winnerId!=0 && $looserId!=0)
        {

            $dataWinner = array(
                    'point' => 3+$winnerInfos[0]["point"],
                    'nb_match' => 1+$winnerInfos[0]["nb_match"],
                    'win' => 1+$winnerInfos[0]["win"],
                    'goal_p' => $winnerScore+$winnerInfos[0]["goal_p"],
                    'goal_c' => $looserScore+$winnerInfos[0]["goal_c"],
                    'goal_average' => ($winnerScore+$winnerInfos[0]["goal_p"])-($looserScore+$winnerInfos[0]["goal_c"])
            );

            $dataLooser = array(
                    'point' => 0+$looserInfos[0]["point"],
                    'nb_match' => 1+$looserInfos[0]["nb_match"],
                    'lose' => 1+$looserInfos[0]["lose"],
                    'goal_p' => $looserScore+$looserInfos[0]["goal_p"],
                    'goal_c' => $winnerScore+$looserInfos[0]["goal_c"],
                    'goal_average' => ($looserScore+$looserInfos[0]["goal_p"])-($winnerScore+$looserInfos[0]["goal_c"])
            );

            $this->db->where('team_id', $winnerId);
            $this->db->update('teams_championship', $dataWinner);

            $this->db->where('team_id', $looserId);
            $this->db->update('teams_championship', $dataLooser);

        }
        else
        {
            $homeTeamInfos=$this->get_team_championship($homeTeam);
            $awayTeamInfos=$this->get_team_championship($awayTeam);

            $dataWinner = array(
                    'point' => 1+$homeTeamInfos[0]["point"],
                    'nb_match' => 1+$homeTeamInfos[0]["nb_match"],
                    'draw' => 1+$homeTeamInfos[0]["draw"],
                    'goal_p' => $looserScore+$homeTeamInfos[0]["goal_p"],
                    'goal_c' => $winnerScore+$homeTeamInfos[0]["goal_c"],
                    //'goal_average' =>championship_rules::getGoalAverage(($looserScore+$homeTeamInfos[0]["goal_p"]),($winnerScore+$homeTeamInfos[0]["goal_c"]))
                    'goal_average' =>($looserScore+$homeTeamInfos[0]["goal_p"])-($winnerScore+$homeTeamInfos[0]["goal_c"])
                    );

            $dataLooser = array(
                    'point' => 1+$awayTeamInfos[0]["point"],
                    'nb_match' => 1+$awayTeamInfos[0]["nb_match"],
                    'draw' => 1+$awayTeamInfos[0]["draw"],
                    'goal_p' => $looserScore+$awayTeamInfos[0]["goal_p"],
                    'goal_c' => $winnerScore+$awayTeamInfos[0]["goal_c"],
                    //'goal_average' =>championship_rules::getGoalAverage(($looserScore+$awayTeamInfos[0]["goal_p"]),($winnerScore+$awayTeamInfos[0]["goal_c"]))
                    'goal_average' =>($looserScore+$awayTeamInfos[0]["goal_p"])-($winnerScore+$awayTeamInfos[0]["goal_c"])
                );

            $this->db->where('team_id', $homeTeam);
            $this->db->update('teams_championship', $dataWinner);

            $this->db->where('team_id', $awayTeam);
            $this->db->update('teams_championship', $dataLooser);
        }

    }

    public function update_goal_average()
    {
        $dataLooser = array(
                    'goal_average' => 1+$awayTeamInfos[0]["point"]
            );
        $this->db->where('team_id', $awayTeam);
        $this->db->update('teams_championship', $dataLooser);
    }

    public function updateNbTeamInChampionship($championshipId)
    {
        $queryString="UPDATE championships
                      SET nb_teams=nb_teams+1
                      WHERE championship_id=$championshipId";
        $this->db->query($queryString);
    }

/*
|==========================================================
| Return team estate
| @param $championshipId: id of the championship
| @param $teamId: id of the team
|==========================================================
|
*/
    public function get_team_championship($teamId)
    {
        $this->db->select('*');
        $this->db->from('teams_championship');
        $this->db->where('team_id',$teamId);

        $query=$this->db->get();
        return $query->result_array();

    }

/*
|==========================================================
| Check if championship is full(y==full n==not full)
| @param $championshipId: id of the championship
|==========================================================
|
*/
    public function is_championship_full($championshipId)
    {
        $this->db->select('*');
        $this->db->from('championships');
	$this->db->where('championship_id',$championshipId);
        $query=$this->db->get();
        $result=$query->result_array();

        if($result[0]["nb_teams"]==championship_model::CHAMPIONSHIP_FULL)
        {
            return true;
        }

        return false;

    }
/*
|==========================================================
| Check if a team is in championship
| @param $teamId: id of the team
|==========================================================
|
*/
    public function is_team_in_championship($teamId)
    {
        
        $this->db->from('teams_championship');
	$this->db->where('team_id',$teamId);
        $nb=$this->db->count_all_results();

        if($nb!=0)
        {
            return true;
        }

        return false;

    }
/*
|==========================================================
| add  championship
| @param $championshipName: name of the championship
| @param $creator: id of user
|==========================================================
|
*/
    public function createChampionship($championshipName,$creator,$level,$teamId)
    {
        $data = array(
               'title' => $championshipName ,
               'nb_teams' => '1',
               'level' => $level,
               'creator' => $creator
            );

        $this->db->insert('championships', $data);

        $lastId=$this->db->insert_id();

        $data2 = array(
               'championship_id' => $lastId ,
               'team_id' => $teamId,

            );

        $this->db->insert('teams_championship', $data2);
    }


    /*
|==========================================================
| add team to a championship
| @param $championshipId: id of the championship
| @param $teamId: id of the team
|==========================================================
|
*/
    public function join_championship($championshipId,$teamId)
    {
        $data = array(
               'team_id' => $teamId ,
               'championship_id' => $championshipId
            );

        $this->db->insert('teams_championship', $data);
    }

/*
|==========================================================
| Return teams of a championship
| @param $championshipId: id of the championship
| @param $teamId: id of the team
|==========================================================
|
*/
    public function get_teams_championship($championshipId)
    {
        $this->db->select('*');
        $this->db->from('teams_championship AS tc');
        $this->db->join('teams AS t', 't.team_id = tc.team_id');
	$this->db->where('tc.championship_id',$championshipId);
        $this->db->order_by('tc.point DESC,tc.goal_average DESC');
        $query=$this->db->get();
        //return $query->result_array();
        return $query->result();
    }
/*
|==========================================================
| Return matchs of a championship by team
| @param $teamId: id of the team
|==========================================================
|
*/
    public function get_matchs_championship($teamId)
    {
        $this->db->select('*');
        $this->db->from('matchs as m');
        //$this->db->join('teams_championship AS tc', 'tc.team_id = m.team_id');
	$this->db->where('m.championship_id !=','');
        $this->db->where('m.home_team_id',$teamId);
        $this->db->or_where('m.away_team_id',$teamId);
        $this->db->order_by('date','ASC');
        $query=$this->db->get();
        return $query->result();
    }

/*
|==========================================================
| Return matchs of a championship
| @param $championshipId: id of the championship
|==========================================================
|
*/
    public function get_all_matchs_championship($championshipId)
    {
        $this->db->select('*');
        $this->db->from('matchs');
	$this->db->where('championship_id',$championshipId);
        //$this->db->where('home_team_id',$championshipId);
        //$this->db->order_by('match_id');
        $query=$this->db->get();
        return $query->result();
    }

/*
|==========================================================
| Return matchs of a championship
| @param $championshipId: id of the championship
|==========================================================
|
*/
    public function start_championship($championshipId)
    {
        $teamsChampArr=$this->get_teams_championship($championshipId);
        shuffle($teamsChampArr);
        $dateArr=array();
        $matchsArr=array();
        for($i=1;$i<31;$i++)
        {

            $hour=rand(14,23);
            $minutes=rand(0,59);

            $dateArr[]=date('Y-m-d '.$hour.':'.$minutes.':00', strtotime('+'.$i.' day'));
        }

        foreach($teamsChampArr as $team1)
        {
            
            foreach($teamsChampArr as $team2)
            {
                if($team1->team_id != $team2->team_id && !in_array($team1->team_id."-".$team2->team_id, $matchsArr))
                {

                            $matchsArr[]=array("match"=>$team1->team_id."-".$team2->team_id,
                                                                      "home_team_id"=>$team1->team_id,
                                                                      "away_team_id"=>$team2->team_id,
                                                                      "championship_id"=>$championshipId,
                                                                      "home_team_name"=>$team1->team_name,
                                                                      "away_team_name"=>$team2->team_name,
                                                                      );
                }
                
            }
        }

        $nbMatch=count($matchsArr);
        $matchAlreadyDated=array();
        shuffle($matchsArr);

        foreach($dateArr as $date)
        {
            $teamsArr=array();

            for($i=0;$i<$nbMatch;$i++)
            {
                    $matchInfo=$matchsArr[$i];
               if(!in_array($i,$matchAlreadyDated))
               {
                   if(!in_array($matchInfo["home_team_id"],$teamsArr) && !in_array($matchInfo["away_team_id"],$teamsArr))
                    {

                        $data = array('match_id' => '' ,'home_team_id' => $matchInfo["home_team_id"] ,'away_team_id' => $matchInfo["away_team_id"],'date'=>$date,
                                       'championship_id' => $championshipId ,'home_team_name' => $matchInfo["home_team_name"] ,'away_team_name' => $matchInfo["away_team_name"]);
                        $this->db->insert('matchs', $data);

                        $matchAlreadyDated[]=$i;
                        $teamsArr[$matchInfo["away_team_id"]]=$matchInfo["away_team_id"];
                        $teamsArr[$matchInfo["home_team_id"]]=$matchInfo["home_team_id"];
                    }

                    $i++;
            
               }
            }
        }

    }
    
/*
|==========================================================
| Return last match of the championship
| @param $championshipId: id of the championship
|==========================================================
|
*/
    public function getLastMatchOfChampionship($championshipId)
    {
        /*$queryString="SELECT *
                      FROM matchs
                      WHERE championship_id=$championshipId
                      ORDER BY date DESC
                      LIMIT 0,1";*/
        $queryString="SELECT *
                      FROM matchs
                      WHERE championship_id=$championshipId
                      ORDER BY match_id DESC
                      LIMIT 0,1";
        $query=$this->db->query($queryString);
        return $query->result_array();
    }

/*
|==========================================================
| getAwards
| @param $championshipLevel: id of the championship
|==========================================================
|
*/
    public function championshipAwards($championshipLevel)
    {
        $queryString="SELECT *
                      FROM awards
                      WHERE level=$championshipLevel";
        $query=$this->db->query($queryString);
        return $query->result_array();
    }

/*
|==========================================================
| Update team level championship
| @param $championshipId: id of the championship
|==========================================================
|
*/
    public function updateTeamLevelChampionship($userInfos,$action)
    {
        $level=$userInfos[0]["user_id"];
        if($action==championship_rules::LEVEL_UP){
            $queryString="UPDATE users
                          SET level=level+1
                          WHERE user_id=$level";
        }else{
            $queryString="UPDATE users
                          SET level=level-1
                          WHERE user_id=$level";
        }

        $query=$this->db->query($queryString);

    }

/*
|==========================================================
| add  palmares
| @param $teamId: teamId
| @param $position: position
| @param $champName: name of the championship
| @param $level: level
|==========================================================
|
*/
    public function addPalmares($teamId,$championshipId,$position,$champName,$level,$points)
    {
        $data = array(
               'team_id' => $teamId,
               'championship_id' => $championshipId,
               'position' => $position,
               'champ_name' => "$champName",
               'level' => $level,
               'pts'=>$points,
               'champ_date' => date("Y-m-d")
            );

        $this->db->insert('palmares', $data);

    }

/*
|==========================================================
| Delete championship
| @param $championship_id: id of the championship
|==========================================================
|
*/
    public function deleteChampionship($championshipId)
    {
        $queryString="DELETE
                      FROM championships
                      WHERE championship_id=$championshipId";
        $query=$this->db->query($queryString);
    }

/*
|==========================================================
| Delete teams championship
| @param $championship_id: id of the championship
|==========================================================
|
*/
    public function deleteTeamsChampionship($championshipId)
    {
        $queryString="DELETE
                      FROM teams_championship
                      WHERE championship_id=$championshipId";
        $query=$this->db->query($queryString);
    }

/*
|==========================================================
| get palmares of a team
| @param $teamId: id of the team
|==========================================================
|
*/
    public function get_palmares($teamId)
    {
        $queryString="SELECT *
                      FROM palmares
                      WHERE team_id=$teamId
                      ORDER BY champ_date DESC";
        $query=$this->db->query($queryString);
        return $query->result_array();
    }

 /*
|==========================================================
| get palmares of a team
| @param $teamId: id of the team
|==========================================================
|
*/
    public function get_palmares_details($championshipId)
    {
        $queryString="SELECT *
                      FROM palmares
                      WHERE championship_id=$championshipId
                      ORDER BY position ASC";
        $query=$this->db->query($queryString);
        return $query->result_array();
    }



}
?>
