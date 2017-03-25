<?php
class friendly_model extends Model {

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
| Insert a new friendly ask
| @param $sender :sender fb id
| @param $receiver :receiver fb id
|==========================================================
|
*/
    public function addFriendlyRequest($sender,$receiver)
    {
        $data = array(
                       'sender' => $sender ,
                       'receiver' => $receiver,
                       'ask_date' => date('Y-m-d')
                    );

        $this->db->insert('friendly_ask', $data);

    }

/*
|==========================================================
| Check if friendly ask already exist
| @param $userId :user fb id
| @param $friendId :friend fb id
|==========================================================
|
*/
    public function checkFriendAlreadySent($userId,$friendId)
    {
        $this->db->select('*')
                ->from('friendly_ask')
                ->where('sender', $userId)
                ->where('receiver', $friendId);

        $query = $this->db->get();

        $result=$query->result_array($query);

        if(empty($result))
            return FALSE;

        return TRUE;

    }
/*
|==========================================================
| load asked friendly match
| @param $userId :user fb id
|==========================================================
|
*/
    public function getFriendAlreadySent($userId)
    {
        $this->db->select('*')
                ->from('friendly_ask')
                ->where('sender', $userId);

        $query = $this->db->get();

        $result=$query->result_array($query);

        $friendsArr=array();

        foreach($result as $row){
            $friendsArr[]=$row["receiver"];
        }

        return $friendsArr;

    }

/*
|==========================================================
| load requests by user
| @param $userId :user fb id
|==========================================================
|
*/
    public function getRequestsByUser($userId)
    {
        $this->db->select('*')
                ->from('friendly_ask')
                ->join('teams', 'teams.user_id = friendly_ask.sender')
                ->join('users', 'users.user_id = teams.user_id')
                ->where('receiver', $userId);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

/*
|==========================================================
| Insert a new friendly match
| @param $ownTeam :own team infos
| @param $awayTeam :opponent team infos
|==========================================================
|
*/
    public function addFriendlyMatch($ownTeam,$awayTeam,$date)
    {
        $data = array(
                       'home_team_id' => $awayTeam[0]["team_id"] ,
                       'away_team_id' => $ownTeam[0]["team_id"],
                       'home_team_name' => $awayTeam[0]["team_name"],
                       'away_team_name' => $ownTeam[0]["team_name"],
                       'date' => $date
                    );

        $this->db->insert('friendly', $data);

    }

/*
|==========================================================
| Delete friendly request
| @param $userId : receiver id
| @param $senderId :opponent sender id
|==========================================================
|
*/
    public function deleteFriendlyRequest($userId,$senderId)
    {
        $this->db->where('receiver', $userId);
        $this->db->where('sender', $senderId);
        $this->db->delete('friendly_ask');
    }

 /*
|==========================================================
| make friendly fixture
| @param $userId : receiver id
| @param $senderId :opponent sender id
|==========================================================
|
*/
    public function friendlyFixtureMatch($ownTeamId,$awayTeamId)
    {
        //make date
        $hour=rand(12,23);
        $min=rand(0,59);

        if($min<10)
            $min='0'.$min;

        $friendlyDate=date('Y-m-d '.$hour.':'.$min.':00', strtotime('+1 day'));
        $date=date('Y-m-d ', strtotime('+1 day'));

        //load competitions date
        $ownCompetitionDate=$this->getCompetitionsDate($ownTeamId, $date);
        $awayCompetitionDate=$this->getCompetitionsDate($awayTeamId, $date);
        $ownCompetitionDate=(empty($ownCompetitionDate)) ? '' : $ownCompetitionDate[0]["date"];
        $awayCompetitionDate=(empty($awayCompetitionDate)) ? '' : $awayCompetitionDate[0]["date"];

        //load friendly date
        $ownFriendlyDate=$this->getFriendlyDate($ownTeamId, $date);
        $awayFriendlyDate=$this->getFriendlyDate($awayTeamId, $date);
        $ownFriendlyDate=(empty($ownFriendlyDate)) ? '' : $ownFriendlyDate[0]["date"];
        $awayFriendlyDate=(empty($awayFriendlyDate)) ? '' : $awayFriendlyDate[0]["date"];

        //Search free date
        $searchDate=TRUE;
        while($searchDate){

            if($ownFriendlyDate!=$friendlyDate && $awayFriendlyDate!=$friendlyDate){

                if($ownCompetitionDate!=$friendlyDate && $awayCompetitionDate!=$friendlyDate){
                    $searchDate=FALSE;
                }else{
                    $friendlyDate=date('Y-m-d '.$hour.':'.$min.':00', strtotime('+1 day 1 hours'));
                }
                
            }else{
                $friendlyDate=date('Y-m-d '.$hour.':'.$min.':00', strtotime('+1 day'));
            }
        }

        return $friendlyDate;

    }

/*
|==========================================================
| load competiton date
| @param $teamId :team id
| @param $date :date day
|==========================================================
|
*/
    public function getCompetitionsDate($teamId,$date)
    {
        $dateMax=$date.' 23:59:00';
        $dateMin=$date.' 00:00:00';

        $this->db->select('*')
                ->from('matchs')
                ->where('home_team_id', $teamId)
                ->where('date <=', $dateMax)
                ->where('date >=', $dateMin)
                ->or_where('away_team_id', $teamId)
                ->where('date <=', $dateMax)
                ->where('date >=', $dateMin);
        
        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }
/*
|==========================================================
| load friendly date
| @param $teamId :team id
| @param $date :date day
|==========================================================
|
*/
    public function getFriendlyDate($teamId,$date)
    {
        $dateMax=$date.' 23:59:00';
        $dateMin=$date.' 00:00:00';

        $this->db->select('*')
                ->from('friendly')
                ->where('home_team_id', $teamId)
                ->where('date <=', $dateMax)
                ->where('date >=', $dateMin)
                ->or_where('away_team_id', $teamId)
                ->where('date <=', $dateMax)
                ->where('date >=', $dateMin);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

/*
|==========================================================
| load friendly date
| @param $teamId :team id
| @param $date :date day
|==========================================================
|
*/
    public function getFriendlyMatchByTeam($teamId)
    {
        $this->db->select('*')
                ->from('friendly')
                ->where('home_team_id', $teamId)
                ->or_where('away_team_id', $teamId)
                ->order_by('date','ASC');

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

/*
|==========================================================
| get last 20 freindly matchs
| @param $teamId :team id
| @param $date :date day
|==========================================================
|
*/
    public function getFriendlyAllMatchs()
    {
        $this->db->select('*')
                ->from('friendly')
                ->where('played', 1)
                ->order_by('date','DESC')
                ->limit(20);

        $query = $this->db->get();

        $result=$query->result_array($query);

        return $result;

    }

 /*
|==========================================================
| Load all freindly match
|==========================================================
|
*/
    public function load_all_matchs()
    {

        $queryString="SELECT *
                      FROM friendly
                      WHERE date<=NOW()
                      AND played=0
                      ORDER BY date ASC,friendly_id ASC
                      LIMIT 0,200";

        $query=$this->db->query($queryString);
        $result=$query->result();

        return $result;

    }

/*
|==========================================================
| Update friendly match result
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

        $this->db->where('friendly_id', $matchId);
        $this->db->update('friendly', $data);

        return $result;

    }
}
?>
