<?php

class team_model extends Model {


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
| Return all infos about team
|==========================================================
|
*/
    public function get_team_infos($teamId){
        $this->db->where('team_id',$teamId);
        $query = $this->db->get('teams');
        return $query->result();
    }

/*
|==========================================================
| Return all infos about team
|==========================================================
|
*/
    public function get_team_name($teamId){
        $this->db->where('team_id',$teamId);
        $query = $this->db->get('teams');
        $result=$query->result_array();
        return $result[0]["team_name"];
    }

/*
|==========================================================
| Return all infos about team by userID
|==========================================================
|
*/
    public function getTeamByUserId($userId){
        $this->db->where('user_id',$userId);
        $query = $this->db->get('teams');
        return $result=$query->result_array();
    }

/*
|==========================================================
| Return if a team is validated
|==========================================================
|
*/
    public function is_team_ready($teamId){

        $this->db->select('validation');
        $this->db->where('team_id',$teamId);
        $query = $this->db->get('teams');

        foreach($query->result() as $row)
        {
            $ready=$row->validation;
        }

        if($ready=='y')
        {
           return true;
        }

        return false;
    }

/*
|==========================================================
| Update validation team ready
|==========================================================
|
*/
    public function update_team_ready($teamId){

        $data = array(
            'validation' => 'y'
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('teams', $data);
    }

/*
|==========================================================
| Update validation team not ready
|==========================================================
|
*/
    public function update_team_not_ready($teamId){

        $data = array(
            'validation' => 'n'
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('teams', $data);
    }

/*
|==========================================================
| Update validation team not ready
|==========================================================
|
*/
    public function updateTeamStatutValidation(){

        $data = array(
            'validation' => 'n'
        );

        $this->db->where('holiday',0);
        $this->db->update('teams', $data);
    }

/*
|==========================================================
| Update teams not ready
|==========================================================
|
*/
    public function update_teams_not_ready($teamsArr){

        $queryString="UPDATE teams SET validation='n' WHERE team_id IN($teamsArr)";
        $this->db->query($queryString);
    }

/*
|==========================================================
| Update the number of selected players in team sheet
|==========================================================
|
*/
    public function update_selected_players($teamId)
    {
        $this->db->trans_start();
        $this->db->select('selected_players');
        $this->db->where('team_id',$teamId);
        $query = $this->db->get('teams');
        
        foreach($query->result() as $row)
        {
            $totalSelectedPlayers=$row->selected_players;
        }

        $totalSelectedPlayers=$totalSelectedPlayers+1;

        $data = array(
            'selected_players' => $totalSelectedPlayers
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('teams', $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

/*
|==========================================================
| udapte the player who are fired of team sheet
|==========================================================
|
*/
    public function update_deleted_players($teamId)
    {

        $this->db->trans_start();
        $this->db->select('selected_players');
        $this->db->where('team_id',$teamId);
        $query = $this->db->get('teams');

        foreach($query->result() as $row)
        {
            $totalSelectedPlayers=$row->selected_players;
        }

        $totalSelectedPlayers=$totalSelectedPlayers-1;

        $data = array(
            'selected_players' => $totalSelectedPlayers
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('teams', $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

/*
|==========================================================
| return all tactics
|==========================================================
|
*/
    public function get_all_tactics()
    {
        $query = $this->db->get('tactics');
        return $query->result();
    }

/*
|==========================================================
| return one tactic
|==========================================================
|
*/
    public function get_one_tactic($tacticId)
    {
        $this->db->where('tactic_id',$tacticId);
        $query = $this->db->get('tactics');
        return $query->result();
    }

/*
|==========================================================
| return the tactic of the team
|==========================================================
|
*/
    public function get_one_tactic_by_team()
    {
        $teamId = $this->session->userdata('teamId');
        $this->db->where('team_id',$teamId);
        $query = $this->db->get('teams');
        return $query->result();
    }

    /*
|==========================================================
| return the tactic of the team
|==========================================================
|
*/
    public function get_team_tactic_infos($teamId)
    {

        $this->db->select('*');
        $this->db->from('teams AS t');
        $this->db->join('tactics AS tc', 't.tactic_id = tc.tactic_id');
	$this->db->where('t.team_id',$teamId);
        $query = $this->db->get();
        return $query->result_array();
    }
/*
|==========================================================
| Update the tactic choosen by the user
|==========================================================
|
*/
    public function update_tactic_team($tacticId)
    {
        $this->db->trans_start();
        $teamId = $this->session->userdata('teamId');
        $data = array(
            'tactic_id' => $tacticId
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('teams', $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

/*
|==========================================================
| Get secondary skills
|==========================================================
|
*/
    public function get_secondary_skills()
    {
        $teamId = $this->session->userdata('teamId');
        $this->db->select('secondary_experience_gb,
                           secondary_experience_def,
                           secondary_experience_mil,
                           secondary_experience_att');
        $this->db->where('team_id',$teamId);
        $query = $this->db->get('teams');
        return $query->result();
    }

/*
|==========================================================
| Get primary skills
|==========================================================
|
*/
    public function get_primary_skills()
    {
        $teamId = $this->session->userdata('teamId');
        $this->db->select('experience_gb,
                           experience_def,
                           experience_mil,
                           experience_att');
        $this->db->where('team_id',$teamId);
        $query = $this->db->get('teams');
        return $query->result();
    }

/*
|==========================================================
| Estimate team experiences(skills)
|==========================================================
|
*/
    public function estimate_team_experiences($playersSkills)
    {

        $teamId = $this->session->userdata('teamId');

        $teamExperiencesArr=array();

        $teamExperiencesArr["experience_att"]=0;
        $teamExperiencesArr["experience_mil"]=0;
        $teamExperiencesArr["experience_def"]=0;
        $teamExperiencesArr["experience_gb"]=0;
        $teamExperiencesArr["experience_team"]=0;

        $teamExperiencesArr["secondary_experience_att"]=0;
        $teamExperiencesArr["secondary_experience_mil"]=0;
        $teamExperiencesArr["secondary_experience_def"]=0;
        $teamExperiencesArr["secondary_experience_gb"]=0;

        //load team tactic
        $tacticInfoArr=array();

        $this->db->select('tactic_id');
        $this->db->where('team_id',$teamId);
        $query = $this->db->get('teams');
        $tacticResult=$query->result();

        $tacticId=$tacticResult[0]->tactic_id;

        //Return the tactic of the team
        $tacticInfo=$this->get_one_tactic($tacticId);

        //return max position player by sector(ex: pour ATT en 4-4-2 les deux positions sont 10 et 11, on prend 11)
        $tacticInfoArr["att"]=$tacticInfo[0]->att;
        $tacticInfoArr["mill"]=$tacticInfo[0]->mil;
        $tacticInfoArr["def"]=$tacticInfo[0]->def;
        $tacticInfoArr["gb"]=$tacticInfo[0]->gb;
   
        foreach($playersSkills as $row){

           
            if($tacticInfoArr["mill"]<$row->shirt_number && $row->shirt_number<=$tacticInfoArr["att"]){

                $teamExperiencesArr["experience_att"]=($teamExperiencesArr["experience_att"]+$row->experience_att)/*/($tacticInfoArr["att"]-$tacticInfoArr["mill"])*/;
                $teamExperiencesArr["secondary_experience_mil"]=($teamExperiencesArr["secondary_experience_mil"]+$row->experience_mil)/*/($tacticInfoArr["mill"]-$tacticInfoArr["def"])*/;
                $teamExperiencesArr["secondary_experience_def"]=($teamExperiencesArr["secondary_experience_def"]+$row->experience_def)/*/($tacticInfoArr["def"]-$tacticInfoArr["gb"])*/;
                $teamExperiencesArr["secondary_experience_gb"]=$teamExperiencesArr["secondary_experience_gb"]+$row->experience_gb;
            }

            if($tacticInfoArr["def"]<$row->shirt_number && $row->shirt_number<=$tacticInfoArr["mill"]){

                $teamExperiencesArr["experience_mil"]=($teamExperiencesArr["experience_mil"]+$row->experience_mil)/*/($tacticInfoArr["mill"]-$tacticInfoArr["def"])*/;
                $teamExperiencesArr["secondary_experience_att"]=($teamExperiencesArr["secondary_experience_att"]+$row->experience_att)/*/($tacticInfoArr["att"]-$tacticInfoArr["mill"])*/;
                $teamExperiencesArr["secondary_experience_def"]=($teamExperiencesArr["secondary_experience_def"]+$row->experience_def)/*/($tacticInfoArr["def"]-$tacticInfoArr["gb"])*/;
                $teamExperiencesArr["secondary_experience_gb"]=$teamExperiencesArr["secondary_experience_gb"]+$row->experience_gb;
            }

            if($tacticInfoArr["gb"]<$row->shirt_number && $row->shirt_number<=$tacticInfoArr["def"]){

                $teamExperiencesArr["experience_def"]=($teamExperiencesArr["experience_def"]+$row->experience_def)/*/($tacticInfoArr["def"]-$tacticInfoArr["gb"])*/;
                $teamExperiencesArr["secondary_experience_att"]=($teamExperiencesArr["secondary_experience_att"]+$row->experience_att)/*/($tacticInfoArr["att"]-$tacticInfoArr["mill"])*/;
                $teamExperiencesArr["secondary_experience_mil"]=($teamExperiencesArr["secondary_experience_mil"]+$row->experience_mil)/*/($tacticInfoArr["mill"]-$tacticInfoArr["def"])*/;
                $teamExperiencesArr["secondary_experience_gb"]=$teamExperiencesArr["secondary_experience_gb"]+$row->experience_gb;
            }

            if($row->shirt_number==$tacticInfoArr["gb"]){

                $teamExperiencesArr["experience_gb"]=$teamExperiencesArr["experience_gb"]+$row->experience_gb;
                $teamExperiencesArr["secondary_experience_att"]=($teamExperiencesArr["secondary_experience_att"]+$row->experience_att)/*/($tacticInfoArr["att"]-$tacticInfoArr["mill"])*/;
                $teamExperiencesArr["secondary_experience_def"]=($teamExperiencesArr["secondary_experience_def"]+$row->experience_def)/*/($tacticInfoArr["def"]-$tacticInfoArr["gb"])*/;
                $teamExperiencesArr["secondary_experience_mil"]=($teamExperiencesArr["secondary_experience_mil"]+$row->experience_mil)/*/($tacticInfoArr["mill"]-$tacticInfoArr["def"])*/;
            }

        }

        //load team bonus

        $teamExperiencesArr["experience_att"]=ceil($teamExperiencesArr["experience_att"]/($tacticInfoArr["att"]-$tacticInfoArr["mill"]));
        $teamExperiencesArr["experience_mil"]=ceil($teamExperiencesArr["experience_mil"]/($tacticInfoArr["mill"]-$tacticInfoArr["def"]));
        $teamExperiencesArr["experience_def"]=ceil($teamExperiencesArr["experience_def"]/($tacticInfoArr["def"]-$tacticInfoArr["gb"]));

        $teamExperiencesArr["secondary_experience_mil"]=ceil($teamExperiencesArr["secondary_experience_mil"]/(11-($tacticInfoArr["mill"]-$tacticInfoArr["def"])));
        $teamExperiencesArr["secondary_experience_def"]=ceil($teamExperiencesArr["secondary_experience_def"]/(11-($tacticInfoArr["def"]-$tacticInfoArr["gb"])));
        $teamExperiencesArr["secondary_experience_att"]=ceil($teamExperiencesArr["secondary_experience_att"]/(11-($tacticInfoArr["att"]-$tacticInfoArr["mill"])));
        $teamExperiencesArr["secondary_experience_gb"]=ceil($teamExperiencesArr["secondary_experience_gb"]/10);

        $teamExperiencesArr["experience_team"]=($teamExperiencesArr["experience_gb"]+
                                            $teamExperiencesArr["experience_def"]+
                                            $teamExperiencesArr["experience_mil"]+
                                            $teamExperiencesArr["experience_att"]+
                                            $teamExperiencesArr["secondary_experience_att"]+
                                            $teamExperiencesArr["secondary_experience_def"]+
                                            $teamExperiencesArr["secondary_experience_mil"]+
                                            $teamExperiencesArr["secondary_experience_gb"])/8;

        $data = array(
            'experience_gb' => $teamExperiencesArr["experience_gb"],
            'experience_def' => $teamExperiencesArr["experience_def"],
            'experience_mil' => $teamExperiencesArr["experience_mil"],
            'experience_att' => $teamExperiencesArr["experience_att"],
            'secondary_experience_gb' => $teamExperiencesArr["secondary_experience_gb"],
            'secondary_experience_def' => $teamExperiencesArr["secondary_experience_def"],
            'secondary_experience_mil' => $teamExperiencesArr["secondary_experience_mil"],
            'secondary_experience_att' => $teamExperiencesArr["secondary_experience_att"],
            'experience_team' => $teamExperiencesArr["experience_team"]
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('teams', $data);

        return $teamExperiencesArr;
        
    }


/*
|==========================================================
| Update team stats
|==========================================================
|
*/
    public function updateTeamStats($result,$homeTeam,$awayTeam)
    {
        $winnerId=$result["winner"];
        $looserId=$result["looser"];

        if($winnerId!=0 && $looserId!=0)
        {
            $queryString1="UPDATE teams SET nb_victory=nb_victory+1 WHERE team_id=$winnerId";
            $queryString2="UPDATE teams SET nb_lost=nb_lost+1 WHERE team_id=$looserId";
            $this->db->query($queryString1);
            $this->db->query($queryString2);
        }else{
            $queryString1="UPDATE teams SET nb_tie=nb_tie+1 WHERE team_id=$homeTeam";
            $queryString2="UPDATE teams SET nb_tie=nb_tie+1 WHERE team_id=$awayTeam";
            $this->db->query($queryString1);
            $this->db->query($queryString2);
        }
    }

/*
|==========================================================
| check shirt number already used
|==========================================================
|
*/
    public function checkShirtNumberAlreadyUsed($shirtNumber,$teamId)
    {
 
            $queryString="SELECT *
                          FROM players
                          WHERE team_id=$teamId
                          AND shirt_number=$shirtNumber";

            $query=$this->db->query($queryString);
            $result=$query->result_array();

            if(!empty($result)){
                return TRUE;
            }else{
                return FALSE;
            }
    }
/*
|==========================================================
| Reset team
|==========================================================
|
*/
    public function reset_team($teamId)
    {
        $this->db->trans_start();

        $data = array(
            'selected_players' => 0,
            'validation' => 'n'
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('teams', $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

/*
|==========================================================
| get all teams
|==========================================================
|
*/
    public function getAllTeams($num,$offset)
    {
        $this->db->select('*')
                //->order_by('(nb_victory*100)/(nb_victory+nb_lost+nb_tie)','DESC')
                ->order_by('(nb_victory)','DESC')
                ->limit(20);

        $query = $this->db->get('teams',$num,$offset);

        $result=$query->result_array($query);

        return $result;

    }

/*
|==========================================================
| get all teams
|==========================================================
|
*/
    public function getTeamByName($name)
    {
        $this->db->select('*')
                ->like('team_name', $name);

        $query = $this->db->get('teams');

        $result=$query->result_array($query);

        return $result;

    }

 /*
|==========================================================
| count all teams
|==========================================================
|
*/
    public function countAllTeams()
    {
	$query=$this->db->get("teams");
        return $query->num_rows();
    }
}
?>
