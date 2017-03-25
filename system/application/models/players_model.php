<?php
class players_model extends Model {


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
| Return all players by team
|==========================================================
|
*/

    public function get_player_details($playerId)
    {
        $this->db->where('player_id',$playerId);
        $query = $this->db->get('players');
        return $query->result_array();
    }

/*
|==========================================================
| Return all players by team
|==========================================================
|
*/

    public function get_all_players()
    {
        $teamId = $this->session->userdata('teamId');
        $this->db->where('team_id',$teamId);
        $this->db->order_by("position", "ASC");
        $query = $this->db->get('players');
        return $query->result();
    }

/*
|==========================================================
| Return all players by team
|==========================================================
|
*/

    public function getAllPlayersByTeamId($teamId)
    {
        $this->db->where('team_id',$teamId);
        $this->db->order_by("position", "ASC");
        $query = $this->db->get('players');
        return $query->result();
    }

/*
|==========================================================
| Return all players selected
|==========================================================
|
*/

    public function getAllPlayersSelected($teamId)
    {
        $this->db->where('team_id',$teamId);
        $this->db->where('team_sheet','y');
        $query = $this->db->get('players');
        return $query->result_array();
    }

 /*
|==========================================================
| Return the team sheet
|==========================================================
|
*/

    public function get_team_sheet()
    {
        $teamId = $this->session->userdata('teamId');
        $this->db->where('team_id',$teamId);
        $this->db->where('team_sheet','y');
        $this->db->order_by("shirt_number", "desc");
        $query = $this->db->get('players');
        return $query->result();
    }

 /*
|==========================================================
| Return the players who are not in team sheet yet
|==========================================================
|
*/

    public function get_players_free()
    {
        $teamId = $this->session->userdata('teamId');
        $this->db->where('team_id',$teamId);
        $this->db->where('team_sheet','n');
        $this->db->where('injury',0);
        $query = $this->db->get('players');
        return $query->result();
    }

 /*
|==========================================================
| Return the selected shirt numbers in a team
|==========================================================
|
*/

    public function get_selected_shirt_numbers()
    {
        $teamId = $this->session->userdata('teamId');
        $this->db->where('team_id',$teamId);
        $this->db->where('shirt_number !=','0');
        $this->db->where('team_sheet','y');
        $query = $this->db->get('players');
        return $query->result();
    }


 /*
|==========================================================
| Update shirt number
|==========================================================
|
*/

    public function update_shirt_number($form_data)
    {
        $teamId = $this->session->userdata('teamId');
        $data = array(
            'shirt_number' => $form_data["shirt_number"],
            'team_sheet' => 'y'
        );

        $this->db->trans_start();
        $this->db->where('team_id',$teamId);
        $this->db->where('player_id',$form_data["playerId"]);
        $this->db->update('players', $data);
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
| Delete a player of the team sheet
|==========================================================
|
*/

    public function delete_player_team($playerId)
    {
        $teamId = $this->session->userdata('teamId');
        $data = array(
            'shirt_number' => 0,
            'team_sheet' => 'n'
        );

        $this->db->trans_start();
        /*$this->db->where('team_id',$teamId);*/
        $this->db->where('player_id',$playerId);
        $this->db->update('players', $data);
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
| Get player skills
|==========================================================
|
*/
    public function get_player_skills($formData)
    {
        $playerSkillsArr=array();

        $this->db->select('experience_gb,
                           experience_def,
                           experience_mil,
                           experience_att,
                           shirt_number,
                           position');
        $this->db->where('player_id',$formData["playerId"]);
        $query = $this->db->get('players');

        foreach($query->result() as $row)
        {
            $playerSkillsArr["experience_att"]=$row->experience_att;
            $playerSkillsArr["experience_mil"]=$row->experience_mil;
            $playerSkillsArr["experience_def"]=$row->experience_def;
            $playerSkillsArr["experience_gb"]=$row->experience_gb;
            $playerSkillsArr["shirt_number"]=$row->shirt_number;
            $playerSkillsArr["position"]=$row->position;
        }

        return $playerSkillsArr;
    }

 /*
|==========================================================
| Get All selected players skills
|==========================================================
|
*/
    public function get_all_selected_players_skills($teamId)
    {
        $playerSkillsArr=array();

        $this->db->select('experience_gb,
                           experience_def,
                           experience_mil,
                           experience_att,
                           shirt_number,
                           position');
        $this->db->where('team_id',$teamId);
        $this->db->where('team_sheet','y');
        $query = $this->db->get('players');

        foreach($query->result() as $row)
        {
            $playerSkillsArr["experience_att"]=$row->experience_att;
            $playerSkillsArr["experience_mil"]=$row->experience_mil;
            $playerSkillsArr["experience_def"]=$row->experience_def;
            $playerSkillsArr["experience_gb"]=$row->experience_gb;
            $playerSkillsArr["shirt_number"]=$row->shirt_number;
            $playerSkillsArr["position"]=$row->position;
        }

        return $query->result();
    }

/*
|==========================================================
| Update player age
|==========================================================
|
*/
    public function updatePlayerAge($playerArr)
    {
        $playerString=implode(',',$playerArr);

        $queryString="UPDATE players
                     SET age=age+1
                     WHERE player_id IN($playerString)";
        $this->db->query($queryString);
    }

/*
|==========================================================
| Update player age
|==========================================================
|
*/
    public function updatePlayerPrice($playerPrice,$playerId)
    {
        $queryString="UPDATE players
                     SET value=$playerPrice
                     WHERE player_id=$playerId";
        $this->db->query($queryString);
    }
/*
|==========================================================
| Check own player
|==========================================================
|
*/
    public function checkOwnPlayer($teamId,$playerId)
    {
        $queryString="Select *
                     FROM players
                     WHERE player_id=$playerId
                     AND team_id=$teamId";
        $query=$this->db->query($queryString);
        $result=$query->result_array();

        if(!empty($result))
            return TRUE;

        return FALSE;
    }

/*
|==========================================================
| Check own player
|==========================================================
|
*/
    public function getPlayerTeam($playerId)
    {
        $queryString="Select *
                     FROM players,teams
                     WHERE teams.team_id=players.team_id
                     AND player_id=$playerId";
        $query=$this->db->query($queryString);
        $result=$query->result_array();
        return $result;
    }
/*
|==========================================================
| Update team player
|==========================================================
|
*/
    public function updateTeamPlayer($teamId,$playerId)
    {
        $queryString="UPDATE players
                     SET team_id=$teamId
                     WHERE player_id=$playerId";
        $this->db->query($queryString);
    }

/*
|==========================================================
| Update player age
|==========================================================
|
*/
    public function deletePlayer($playerString)
    {
        $queryString="DELETE FROM players
                      WHERE player_id IN($playerString)";
        $this->db->query($queryString);
    }

/*
|==========================================================
| update player value
|==========================================================
|
*/
    public function updatePlayerExperience($playerId,$playerUp)
    {
        $queryString="UPDATE players
        SET experience_att=experience_att+".$playerUp['ATT'].",
            experience_mil=experience_mil+".$playerUp['MIL'].",
            experience_def=experience_def+".$playerUp['DEF'].",
            experience_gb=experience_gb+".$playerUp['GB']."
            WHERE player_id=$playerId";
        $query = $this->db->query($queryString);

    }


/*
|==========================================================
| Check player in team
|==========================================================
|
*/
    public function checkPlayerInTeam($playerId,$teamId)
    {
        $queryString="SELECT *
                     FROM players
                     WHERE player_id=$playerId
                     AND team_id=$teamId 
                     AND team_sheet='y'";
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
| Reset players
|==========================================================
|
*/
    public function reset_players($teamId)
    {
        $this->db->trans_start();

        $data = array(
            'shirt_number' => 0,
            'team_sheet' => 'n'
        );

        $this->db->where('team_id',$teamId);
        $this->db->update('players', $data);
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
| check player injury
|==========================================================
|
*/
    public function checkPlayerInjury($playerId)
    {
        $queryString="SELECT *
                     FROM injuries
                     WHERE player_id=$playerId";
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
| check nb injuries by team
|==========================================================
|
*/
    public function checkNbPlayerInjuriedByTeam($teamId)
    {
        $queryString="SELECT *
                     FROM injuries
                     WHERE team_id=$teamId";
        $query=$this->db->query($queryString);
        $result=$query->result();
        $nb=count($result);

        if($nb>=3)
            return TRUE;
        
        return FALSE;
        
    }


/*
|==========================================================
| player injury
|==========================================================
|
*/
    public function playerInjury($playerId,$teamId)
    {
        $date=date('Y-m-d', strtotime('+'.rand(0,8).' days'));
        $data = array(
               'player_id' => $playerId ,
               'team_id' => $teamId ,
               'date_injury_end' => $date
            );

        $this->db->insert('injuries', $data);

        return $date;
    }

/*
|==========================================================
| update player injury
|==========================================================
|
*/
    public function updatePlayerInjury($playerId,$state)
    {
        $data = array(
               'injury' => $state
            );
        $this->db->where('player_id', $playerId);
        $this->db->update('players', $data);
    }

/*
|==========================================================
| update team injury
|==========================================================
|
*/
    public function updateTeamInjury($playerId,$teamId)
    {
        $data = array(
               'team_id' => $teamId
            );
        $this->db->where('player_id', $playerId);
        $this->db->update('players', $data);
    }

/*
|==========================================================
| delete player injury
|==========================================================
|
*/
    public function deletePlayerInjury($playerId)
    {
        $queryString="DELETE
                     FROM injuries
                     WHERE player_id=$playerId";
        $query=$this->db->query($queryString);

    }

/*
|==========================================================
| Select player end injury
|==========================================================
|
*/
    public function playerInjuryEnd($teamId)
    {
        $queryString="SELECT *
                     FROM injuries
                     WHERE team_id=$teamId
                     AND date_injury_end<='".date('Y-m-d')."'";

        $query=$this->db->query($queryString);
        $result=$query->result_array();

        foreach($result as $row)
        {
            $this->updatePlayerInjury($row["player_id"],0);
            $this->deletePlayerInjury($row["player_id"]);
        }


    }

/*
|==========================================================
| update player statut
|==========================================================
|
*/
    public function updatePlayerStatut($playerId,$statut)
    {
        $data = array(
               'statut' => $statut
            );
        $this->db->where('player_id', $playerId);
        $this->db->update('players', $data);
    }

/*
|==========================================================
| Insert new players
|==========================================================
|
*/
    public function insertNewPlayers($data)
    {

        $data = array(
                'team_id' => 0,
                'player_name' => $data["player_name"],
                'age' => $data["age"],
                'position' => $data["position"] ,
                'nationality'=>$data["nationality"],
                'experience_pt' => round(($data["experience_att"]+$data["experience_mil"]+$data["experience_def"]+$data["experience_gb"])/4) ,
                'value' => $data["value"] ,
                'experience_att' => $data["experience_att"] ,
                'experience_mil' => $data["experience_mil"] ,
                'experience_def' => $data["experience_def"] ,
                'experience_gb' => $data["experience_gb"] ,
                'statut' => 2 ,
                'date_end' => $data["date_end"]
            );

        $this->db->insert('players', $data);

        return $date;
    }
}
?>
