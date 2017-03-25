<?php
class friends_model extends Model {

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
| Add new user friend row
|@$user (array): informations about facebook's user
|==========================================================
|
*/
	public function insertUserFriends($user)
	{

            $data=array(
               "user_id"=>$user["id"],
            );

            $query=$this->db->insert('user_friends',$data);
            return $query;
	}

/*
|==========================================================
| Add new user friend row
|@$user (array): informations about facebook's user
|@$nbFriends: nb friends invited
|==========================================================
|
*/
	public function updateUserFriends($userId,$nbFriends)
	{
            $queryString="UPDATE user_friends
                          SET friends=friends+$nbFriends
                          WHERE user_id=$userId";
            $query = $this->db->query($queryString);

            return $query;
	}

/*
|==========================================================
| Add new user friend row
|@$userId: user Id
|@$nbFriends: nb friends invited
|==========================================================
|
*/
	public function getNbUserFriends($userId)
	{
            $queryString="SELECT friends
                          FROM user_friends
                          WHERE user_id=$userId";
            $query = $this->db->query($queryString);
            $result=$query->result_array();

            return $result[0]["friends"];
	}


/*
|==========================================================
| get freinds
|@$friendsArray: nb friends invited
|==========================================================
|
*/
	public function getPantheonFriends($friendsArr)
	{
            $friendsString=implode(",",$friendsArr);
            $queryString="SELECT teams.team_name,teams.team_id,users.dirtyGold,users.user_id,users.username,users.userfirstname,users.level
                          FROM users,teams
                          WHERE users.user_id=teams.user_id
                          AND users.user_id IN($friendsString)
                          ORDER BY users.level DESC,users.dirtyGold DESC
                          LIMIT 0,20";
            $query = $this->db->query($queryString);
            $result=$query->result_array();

            return $result;
	}

/*
|==========================================================
| get top
|@$friendsArray: nb friends invited
|==========================================================
|
*/
	public function getTop()
	{
            $queryString="SELECT teams.team_name,teams.team_id,users.dirtyGold,users.user_id,users.username,users.userfirstname,users.level
                          FROM users,teams
                          WHERE users.user_id=teams.user_id
                          ORDER BY users.level DESC,users.dirtyGold DESC
                          LIMIT 0,30";
            $query = $this->db->query($queryString);
            $result=$query->result_array();

            return $result;
	}
}

?>
