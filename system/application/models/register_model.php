<?php
class register_model extends Model {

    //max player in a new team
    const nbPlayer=15;
    //max age for player in a new team
    const maxAge=30;
    //min age for player in a new team
    const minAge=20;
    //max player experience in his favorite position
    const primaryMaxExp=10;
    //min player experience in his favorite position
    const primaryMinExp=4;
    //max player experience in others positions
    const secondaryMaxExp=3;
    //min player experience in others position
    const secondaryMinExp=1;

/*
|==========================================================
| Constructor
|==========================================================
|
*/
    public function __construct()
    {
        parent::__construct();
		
    }

/*
|==========================================================
| Add new user
|@$user (array): informations about facebook's user
|==========================================================
|
*/
	public function insert_user($user,$langage)
	{
        
            $data=array(
               "user_id"=>$user["id"],
               "email"=>$user["email"],
               "username"=>$user["first_name"],
               "userfirstname"=>$user["last_name"],
               "money"=>1000000,
               "dirtyGold"=>5,
               "langage"=>$langage,
                "registration_date"=>date('Y-m-d')

            );

            $query=$this->db->insert('users',$data);
            return $query;
	}

/*
|==========================================================
| update user ID
|@$user (array): informations about facebook's user
|==========================================================
|
*/
	public function updateUserId($userId,$email)
	{

            $data=array(
               "user_id"=>$userId,
            );

            $this->db->where('email',$email);
            $query=$this->db->update('users',$data);
            return $query;
	}

/*
|==========================================================
| Add new team
|@$form_data (array): form post array
|@$userId (int): user id
|==========================================================
|
*/
    public function insert_team($form_data,$userId)
    {
        $data=array(
          "team_name"=>$form_data["team_name"],
          "stadium"=>$form_data["stadium"],
          "user_id"=>$userId,
          "tactic_id"=>1
        );

       	$query=$this->db->insert('teams',$data);
        return $this->db->insert_id();
        
    }
/*
|==========================================================
| getLastTeamInserted
|@$userId (int): user id
|==========================================================
|
*/
    public function getLastTeamInserted($userId)
    {
        $queryString="SELECT MAX(team_id) as teamId
                      FROM teams";
        $query = $this->db->query($queryString);

        /*$this->db->select('team_id');
        $this->db->where('user_id',$userId);
        $query=$this->db->get('teams');*/
        $result=$query->result_array();
        //print_r($result);

        return $result[0]["teamId"];

    }

/*
|==========================================================
| Add players in a team
|@$team (array): player array from post
|@$teamId (int): team id
|==========================================================
|
*/
    public function add_player_team($team,$teamId){
        
        for($i=1;$i<=register_model::nbPlayer;$i++)
        {
          $age=rand(register_model::minAge,register_model::maxAge);
          //attribute skills to player
          $skillsArr=$this->add_player_skills($team["position_".$i],$age);
          
          //add player identity in database
          $data=array(
          "player_name"=>$team["player".$i],
          "position"=>$team["position_".$i],
          "age"=>$age,
          "nationality"=>$team["nationality_".$i],
          "experience_att"=>$skillsArr["expAtt"],
          "experience_mil"=>$skillsArr["expMil"],
          "experience_def"=>$skillsArr["expDef"],
          "experience_gb"=>$skillsArr["expGb"],
          "experience_pt"=>$skillsArr["expTotal"],
          "value"=>$skillsArr["value"],
          "team_id"=>$teamId
            );

            $query=$this->db->insert('players',$data);
        }

    }

/*
|==========================================================
| Add players skills
|==========================================================
|
*/
    private function add_player_skills($position,$age){

        //array of experience
        $expArr=array();

        //attribute skills depending on his position
        switch($position){

            case 'ATT':

                $expAtt=rand(register_model::primaryMinExp,register_model::primaryMaxExp);
                $expMil=rand(register_model::secondaryMinExp,register_model::secondaryMaxExp);
                $expDef=rand(register_model::secondaryMinExp,register_model::secondaryMaxExp);
                $expGb=rand(register_model::secondaryMinExp,register_model::secondaryMaxExp);
                $expTotal=($expAtt+$expMil+$expDef+$expGb)/4;

                //attribute price depending on his exp total and his age
                $value=$this->attribute_player_price($expTotal,$age);

                $expArr=array("expAtt"=>$expAtt,"expMil"=>$expMil,"expDef"=>$expDef,"expGb"=>$expGb,"expTotal"=>$expTotal,"value"=>$value);
                break;

            case 'MILL':

                $expAtt=rand(register_model::secondaryMinExp,register_model::secondaryMaxExp);
                $expMil=rand(register_model::primaryMinExp,register_model::primaryMaxExp);
                $expDef=rand(register_model::secondaryMinExp,register_model::secondaryMaxExp);
                $expGb=rand(register_model::secondaryMinExp,register_model::secondaryMaxExp);
                $expTotal=($expAtt+$expMil+$expDef+$expGb)/4;

                //attribute price depending on his exp total and his age
                $value=$this->attribute_player_price($expTotal,$age);

                $expArr=array("expAtt"=>$expAtt,"expMil"=>$expMil,"expDef"=>$expDef,"expGb"=>$expGb,"expTotal"=>$expTotal,"value"=>$value);
                break;

            case 'DEF':

                $expAtt=rand(register_model::secondaryMinExp,register_model::secondaryMaxExp);
                $expMil=rand(register_model::secondaryMinExp,register_model::secondaryMaxExp);
                $expDef=rand(register_model::primaryMinExp,register_model::primaryMaxExp);
                $expGb=rand(register_model::secondaryMinExp,register_model::secondaryMaxExp);
                $expTotal=($expAtt+$expMil+$expDef+$expGb)/4;

                //attribute price depending on his exp total and his age
                $value=$this->attribute_player_price($expTotal,$age);

                $expArr=array("expAtt"=>$expAtt,"expMil"=>$expMil,"expDef"=>$expDef,"expGb"=>$expGb,"expTotal"=>$expTotal,"value"=>$value);
                break;

            case 'GB':

                $expAtt=rand(register_model::secondaryMinExp,register_model::secondaryMaxExp);
                $expMil=rand(register_model::secondaryMinExp,register_model::secondaryMaxExp);
                $expDef=rand(register_model::secondaryMinExp,register_model::secondaryMaxExp);
                $expGb=rand(register_model::primaryMinExp,register_model::primaryMaxExp);
                $expTotal=($expAtt+$expMil+$expDef+$expGb)/4;

                //attribute price depending on his exp total and his age
                $value=$this->attribute_player_price($expTotal,$age);

                $expArr=array("expAtt"=>$expAtt,"expMil"=>$expMil,"expDef"=>$expDef,"expGb"=>$expGb,"expTotal"=>$expTotal,"value"=>$value);
                break;
        }

        return $expArr;
        

	}

/*
|==========================================================
| Attribute player price (value)
|==========================================================
|
*/
   private function attribute_player_price($expTotal,$age){

        $averageExp=6;
        $averageAge=25;

        if($expTotal>=$averageExp){

             if($age<=$averageAge){

                 $value=rand(800000,1500000);

             }else{

                 $value=rand(500000,800000);

             }

        }else{

             if($age<=$averageAge){

                 $value=rand(300000,500000);

             }else{

                 $value=rand(100000,300000);

             }

        }

        return $value;
	}

    public function checkUserAlreadyRegistred($userId)
    {
        $this->db->select('user_id');
        $this->db->where('user_id',$userId);
        $query=$this->db->get('users');
        $result=$query->result_array();
        $nb=count($result);

        if($nb==0)
            return FALSE;

        return TRUE;
    }

    public function checkConnection($userId)
    {
        $this->db->select('connection');
        $this->db->where('user_id',$userId);
        $query = $this->db->get('users');

        $result=$query->result_array();

        if($result[0]["connection"]==1)
            return TRUE;

        return FALSE;
    }

/*
|==========================================================
| Update connection statut
|==========================================================
|
*/
    public function updateConnectionStatut($userId){

        $data = array(
            'connection' => 1
        );

        $this->db->where('user_id',$userId);
        $this->db->update('users', $data);
    }

/*
|==========================================================
| Update langage
|==========================================================
|
*/
    public function updateLanguage($langage,$userId){

        $data = array(
            'langage' => $langage
        );

        $this->db->where('user_id',$userId);
        $this->db->update('users', $data);
    }
}
?>
