<?php
class match_model extends Model {

const teamPlayers=11;

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
| Load team infos
| @param $teamId :team id
|==========================================================
|
*/
    public function load_team_info($teamId)
    {
        $this->db->select('*');
        $this->db->from('teams');
	$this->db->where('team_id',$teamId);
        $query=$this->db->get();

        return $query->result();

    }

/*
|==========================================================
| Check if teams are complete (11 players per team)
| @param $teamInfos :Array of team infos
|==========================================================
|
*/
    public function load_nb_players($teamInfos)
    {

        foreach( $teamInfos as $value )
        {
            $nbPlayers=$value->selected_players;
            $validation=$value->validation;
        }

        if($nbPlayers==match_model::teamPlayers && $validation=="y"){

            return TRUE;

        }

        return FALSE;

    }

/*
|==========================================================
| Check if teams are complete (11 players per team)
| @param $teamInfos :Array of team infos
|==========================================================
|
*/
    public function checkTeamValidate($teamInfos)
    {

        foreach( $teamInfos as $value )
        {

            $validation=$value->validation;
        }

        if($validation=="y"){

            return TRUE;

        }

        return FALSE;

    }

 /*
|==========================================================
| Load team experience
| @param $teamInfos :Array of team infos
|==========================================================
|
*/
    public function load_team_experience($teamInfos,$teamTactic)
    {

        $expArr=array();

        $nbAttPlayers=$teamTactic[0]["att"];
        $nbMilPlayers=$teamTactic[0]["mil"];
        $nbDefPlayers=$teamTactic[0]["def"];
        $nbGbPlayers=$teamTactic[0]["gb"];

        foreach( $teamInfos as $value )
        {
            $expArr["primary_experience_att"]=$value->experience_att/*/($nbAttPlayers-$nbMilPlayers)*/;
            $expArr["primary_experience_mil"]=$value->experience_mil/*/($nbMilPlayers-$nbDefPlayers)*/;
            $expArr["primary_experience_def"]=$value->experience_def/*/($nbDefPlayers-$nbGbPlayers)*/;
            $expArr["primary_experience_gb"]=$value->experience_gb;
            
            $expArr["secondary_experience_att"]=$value->secondary_experience_att/*/($nbAttPlayers-$nbMilPlayers)*/;
            $expArr["secondary_experience_mil"]=$value->secondary_experience_mil/*/($nbMilPlayers-$nbDefPlayers)*/;
            $expArr["secondary_experience_def"]=$value->secondary_experience_def/*/($nbDefPlayers-$nbGbPlayers)*/;
            $expArr["secondary_experience_gb"]=$value->secondary_experience_gb;

            $expArr["experience_team"]=$value->experience_team;
        }

        return $expArr;

    }

 /*
|==========================================================
| Load team experience
| @param  $teamInfos :Array of team infos
|==========================================================
|
*/
    public function load_stadium_capacity($teamInfos)
    {

        foreach( $teamInfos as $value )
        {
            //$stadiumId=$value->stadium;
            $teamId=$value->team_id;
        }

        $this->db->select('capacity');
        $this->db->from('infrastructure_stadium');
        $this->db->where('team_stadium.team_id',$teamId);
        $this->db->join('team_stadium', 'infrastructure_stadium.stadium_id = team_stadium.stadium_id');
        
        $query=$this->db->get();

        foreach($query->result() as $row){

            $stadiumCapacity=$row->capacity;

        }
        
        return $stadiumCapacity;

    }

 /*
|==========================================================
| Load all match
|==========================================================
|
*/
    public function load_all_matchs()
    {

        $queryString="SELECT *
                      FROM matchs
                      WHERE date<=NOW()
                      AND played=0
                      ORDER BY date ASC,match_id ASC
                      LIMIT 0,200";

        $query=$this->db->query($queryString);
        $result=$query->result();

        return $result;

    }

 /*
|==========================================================
| Load match by championship
|==========================================================
|
*/
    public function loadMatchsByChampionship($championshipId/*,$date*/)
    {

        /*$queryString="SELECT *
                      FROM matchs
                      WHERE championship_id=$championshipId
                      AND date='$date'";*/
        $queryString="SELECT *
                      FROM matchs
                      WHERE championship_id=$championshipId
                      ";
        $query=$this->db->query($queryString);
        $result=$query->result_array();

        return $result;

    }


  /*
|==========================================================
| return infos of a match
| @param $matchId: match id
|==========================================================
|
*/
    public function load_match($matchId)
    {

        $this->db->select('*');
        $this->db->from('matchs');
        $this->db->where('matchs.match_id',$matchId);
        $query=$this->db->get();
        $result=$query->result_array();

        return $result;

    }

/*
|==========================================================
| Update match result
| @param $match_id:id of the match
| @param $result:score of the match
|==========================================================
|
*/
    public function Update_match_result($matchId,$result)
    {

        $data = array(
                'home_team_score' => $result["home_team_score"],
                'away_team_score' => $result["away_team_score"],
                'winner' => $result["winner"],
                'looser' => $result["looser"],
                'draw' => $result["draw"],
                'played' => 1,


        );

        $this->db->where('match_id', $matchId);
        $this->db->update('matchs', $data);

        return $result;

    }


    /*
|==========================================================
| Update match display
| @param $match_id:id of the match
| @param $result:score of the match
|==========================================================
|
*/
    public function Update_match_display($matchId,$result)
    {

        $data = array(
                'played' => 2,


        );

        $this->db->where('match_id', $matchId);
        $this->db->update('matchs', $data);

        return $result;

    }

    /*
|==========================================================
| Update match result
| @param $match_id:id of the match
| @param $result:score of the match
|==========================================================
|
*/
    public function Update_match_finish($matchId,$result)
    {

        $data = array(
                'played' => 3,


        );

        $this->db->where('match_id', $matchId);
        $this->db->update('matchs', $data);

        return $result;

    }
     /*
|==========================================================
| get ATT comments
|==========================================================
|
*/
    public function getAttCommentsByTeam($matchId,$teamId)
    {

        $queryString="SELECT *
                      FROM live_comments,matchs_comments
                      WHERE live_comments.live_comments_id=matchs_comments.comments_id
                      AND live_comments.type='ATT'
                      AND matchs_comments.team_id=$teamId
                      AND matchs_comments.match_id=$matchId";
        $query = $this->db->query($queryString);
        return $query->result_array();

    }

/*
|==========================================================
| get MIL comments
|==========================================================
|
*/
    public function getMilCommentsByTeam($matchId,$teamId)
    {

        $queryString="SELECT *
                      FROM live_comments,matchs_comments
                      WHERE live_comments.live_comments_id=matchs_comments.comments_id
                      AND live_comments.type='MIL'
                      AND matchs_comments.team_id=$teamId
                      AND matchs_comments.match_id=$matchId";
        $query = $this->db->query($queryString);
        return $query->result_array();

    }

/*
|==========================================================
| get DEF comments by team
|==========================================================
|
*/
    public function getDefCommentsByTeam($matchId,$teamId)
    {

        $queryString="SELECT *
                      FROM live_comments,matchs_comments
                      WHERE live_comments.live_comments_id=matchs_comments.comments_id
                      AND live_comments.type='DEF'
                      AND matchs_comments.team_id=$teamId
                      AND matchs_comments.match_id=$matchId";
        $query = $this->db->query($queryString);
        return $query->result_array();

    }

 

/*
|==========================================================
| get GB comments
|==========================================================
|
*/
    public function getGbCommentsByTeam($matchId,$teamId)
    {

        $queryString="SELECT *
                      FROM live_comments,matchs_comments
                      WHERE live_comments.live_comments_id=matchs_comments.comments_id
                      AND live_comments.type='GB'
                      AND matchs_comments.team_id=$teamId
                      AND matchs_comments.match_id=$matchId";
        $query = $this->db->query($queryString);
        return $query->result_array();

    }


/*
|==========================================================
| get DEF comments
|==========================================================
|
*/
    public function getDefComments($level,$statut)
    {

        $queryString="SELECT *
                      FROM live_comments
                      WHERE type='DEF'
                      AND level=$level
                      AND statut=$statut";
        $query = $this->db->query($queryString);
        return $query->result_array();

    }
   /*
|==========================================================
| get DEF comments
|==========================================================
|
*/
    public function getMilComments($level,$statut)
    {

        $queryString="SELECT *
                      FROM live_comments
                      WHERE type='MIL'
                      AND level=$level
                      AND statut=$statut";
        $query = $this->db->query($queryString);
        return $query->result_array();

    }

   /*
|==========================================================
| get DEF comments
|==========================================================
|
*/
    public function getAttComments($level,$statut)
    {

        $queryString="SELECT *
                      FROM live_comments
                      WHERE type='ATT'
                      AND level=$level
                      AND statut=$statut";
        $query = $this->db->query($queryString);
        return $query->result_array();

    }

   /*
|==========================================================
| get DEF comments
|==========================================================
|
*/
    public function getGbComments($level,$statut)
    {

        $queryString="SELECT *
                      FROM live_comments
                      WHERE type='GB'
                      AND level=$level
                      AND statut=$statut";
        $query = $this->db->query($queryString);
        return $query->result_array();

    }

/*
|==========================================================
| return the comments of a match
| @param $match_id:id of the match
|==========================================================
|
*/
    public function get_live_comments_undisplayed($matchId)
    {
        $this->db->select('*');
        $this->db->from('matchs_comments');
        $this->db->where('matchs_comments.match_id',$matchId);
        $this->db->where('matchs_comments.displayed',0);
        $this->db->join('live_comments', 'matchs_comments.comments_id = live_comments.live_comments_id');
        $this->db->limit(1);
        $query=$this->db->get();
        $result=$query->result();

        return $result;
    }
/*
|==========================================================
| return the comments of a match
| @param $match_id:id of the match
|==========================================================
|
*/
    public function get_live_comments_displayed($matchId)
    {
        $this->db->select('*');
        $this->db->from('matchs_comments');
        $this->db->where('matchs_comments.match_id',$matchId);
        $this->db->where('matchs_comments.displayed',1);
        
        $this->db->join('live_comments', 'matchs_comments.comments_id = live_comments.live_comments_id');
        $this->db->order_by('matchs_comments.matchs_comments_id', "desc");
        $query=$this->db->get();
        $result=$query->result();

        return $result;
    }

    /*
|==========================================================
| Update comment status
| @param $comment_id:id of the comment
|==========================================================
|
*/
    public function update_comment_statut($commentId)
    {
        $data = array('displayed' => 1);

        $this->db->where('matchs_comments_id', $commentId);
        $this->db->update('matchs_comments', $data);
    }

/*
|==========================================================
| return the next match
| @param $match_id:id of the match
|==========================================================
|
*/
    public function getNextCompetitionMatch($teamId)
    {
        $queryString="SELECT * FROM matchs
                      WHERE played=0
                      AND (home_team_id=$teamId
                      OR away_team_id=$teamId)
                      ORDER BY date ASC
                      LIMIT 0,1";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| return the next match
| @param $match_id:id of the match
|==========================================================
|
*/
    public function getNextFriendlyMatch($teamId)
    {
        $queryString="SELECT * FROM friendly 
                      WHERE played=0
                      AND (home_team_id=$teamId
                      OR away_team_id=$teamId)
                      ORDER BY date ASC
                      LIMIT 0,1";
        $query = $this->db->query($queryString);
        $result=$query->result_array();

        return $result;
    }

/*
|==========================================================
| buy the next match
| @param $matchId:id of the match
| @param $value:value to buy match
| @param $sender:team wich does the offer
| @param $receiver: team wich receive the offer
|==========================================================
|
*/
    public function buyNextMatch($matchId,$value,$sender,$receiver)
    {
        $queryString="INSERT INTO corruption_match (match_id,value,sender,receiver) VALUES(".$matchId.",".$value.",".$sender.",".$receiver.")";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| return the next match
| @param $match_id:id of the match
|==========================================================
|
*/
    public function checkMatchAlreadybought($matchId)
    {
        $queryString="SELECT COUNT(corruption_match_id) AS nb
                      FROM corruption_match
                      WHERE match_id=$matchId";
        $query = $this->db->query($queryString);
        $result=$query->result_array();
        
        if($result[0]["nb"]==0)
            return FALSE;
        
        return TRUE;
    }



/*
|==========================================================
| insert match comments
|==========================================================
|
*/
    public function insertComments($matchId,$result,$commentsLevel,$homeTeam,$awayTeam)
    {
        if(!empty($result["winner"])&&!empty($result["looser"])){

            $attWinArr=$this->getAttComments($commentsLevel,2);
            $nbWinAttComment=count($attWinArr);
            shuffle($attWinArr);
            $milWinArr=$this->getMilComments($commentsLevel,2);
            $nbWinMilComment=count($milWinArr);
            shuffle($milWinArr);
            $defWinArr=$this->getDefComments($commentsLevel,2);
            $nbWinDefComment=count($defWinArr);
            shuffle($defWinArr);
            $winnerTeam=$result["winner"];

            $attLooseArr=$this->getAttComments($commentsLevel,1);
            $nbLooseAttComment=count($attLooseArr);
            shuffle($attLooseArr);
            $milLooseArr=$this->getMilComments($commentsLevel,1);
            $nbLooseMilComment=count($milLooseArr);
            shuffle($milLooseArr);
            $defLooseArr=$this->getDefComments($commentsLevel,1);
            $nbLooseDefComment=count($defLooseArr);
            shuffle($defLooseArr);
            $looserTeam=$result["looser"];

            $queryString="INSERT INTO matchs_comments VALUES('',".$matchId.",".$winnerTeam.",".$attWinArr[0]['live_comments_id'].")";
            $query = $this->db->query($queryString);

            $queryString="INSERT INTO matchs_comments VALUES('',".$matchId.",".$winnerTeam.",".$milWinArr[0]['live_comments_id'].")";
            $query = $this->db->query($queryString);

            $queryString="INSERT INTO matchs_comments VALUES('',".$matchId.",".$winnerTeam.",".$defWinArr[0]['live_comments_id'].")";
            $query = $this->db->query($queryString);

            $queryString="INSERT INTO matchs_comments VALUES('',".$matchId.",".$looserTeam.",".$attLooseArr[0]['live_comments_id'].")";
            $query = $this->db->query($queryString);

            $queryString="INSERT INTO matchs_comments VALUES('',".$matchId.",".$looserTeam.",".$milLooseArr[0]['live_comments_id'].")";
            $query = $this->db->query($queryString);

            $queryString="INSERT INTO matchs_comments VALUES('',".$matchId.",".$looserTeam.",".$defLooseArr[0]['live_comments_id'].")";
            $query = $this->db->query($queryString);

        }else{
            $attTieArr=$this->getAttComments($commentsLevel,0);
            $nbTieAttComment=count($attTieArr);
            shuffle($attTieArr);
            $milTieArr=$this->getMilComments($commentsLevel,0);
            $nbTieMilComment=count($milTieArr);
            shuffle($milTieArr);
            $defTieArr=$this->getDefComments($commentsLevel,0);
            $nbTieDefComment=count($defTieArr);
            shuffle($defTieArr);

            $winnerTeam=$homeTeam;
            $looserTeam=$awayTeam;

            $queryString="INSERT INTO matchs_comments VALUES('',".$matchId.",".$winnerTeam.",".$attTieArr[0]['live_comments_id'].")";
            $query = $this->db->query($queryString);

            $queryString="INSERT INTO matchs_comments VALUES('',".$matchId.",".$winnerTeam.",".$milTieArr[0]['live_comments_id'].")";
            $query = $this->db->query($queryString);

            $queryString="INSERT INTO matchs_comments VALUES('',".$matchId.",".$winnerTeam.",".$defTieArr[0]['live_comments_id'].")";
            $query = $this->db->query($queryString);

            $queryString="INSERT INTO matchs_comments VALUES('',".$matchId.",".$looserTeam.",".$attTieArr[0]['live_comments_id'].")";
            $query = $this->db->query($queryString);

            $queryString="INSERT INTO matchs_comments VALUES('',".$matchId.",".$looserTeam.",".$milTieArr[0]['live_comments_id'].")";
            $query = $this->db->query($queryString);

            $queryString="INSERT INTO matchs_comments VALUES('',".$matchId.",".$looserTeam.",".$defTieArr[0]['live_comments_id'].")";
            $query = $this->db->query($queryString);
        }


    }

    /*
|==========================================================
| delete championship match
| @param $championship_id:id of the championship
|==========================================================
|
*/
    public function deleteMatchsChampionship($championshipId)
    {
        $queryString="DELETE
                      FROM matchs
                      WHERE championship_id=$championshipId";
        $query = $this->db->query($queryString);

    }

/*
|==========================================================
| return last matchs result
| @param $championship_id:id of the championship
|==========================================================
|
*/
    public function get_last_matchs_results($championshipId)
    {
        $queryString="SELECT *
                      FROM matchs
                      WHERE championship_id=$championshipId
                      AND played=1
                      ORDER BY date DESC
                      LIMIT 0,5";
        $query = $this->db->query($queryString);
        $result=$query->result_array();
        return $result;
    }

/*
|==========================================================
| return next matchs
| @param $championship_id:id of the championship
|==========================================================
|
*/
    public function get_next_matchs($championshipId)
    {
        $queryString="SELECT *
                      FROM matchs
                      WHERE championship_id=$championshipId
                      AND played=0
                      ORDER BY date ASC
                      LIMIT 0,5";
        $query = $this->db->query($queryString);
        $result=$query->result_array();
        return $result;
    }

}
?>
