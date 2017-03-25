<?php
class transferts_model extends Model {

    public function __construct()
    {
        parent::Model();

    }

    //Return all available transfert
    public function get_available_transferts($teamId,$num,$offset)
    {
        $this->db->where('statut',1);
        $this->db->order_by("value", "desc");
        $query = $this->db->get('players',$num,$offset);
        return $query->result();
    }

    //Return all available transfert
    public function get_available_encheres()
    {
        $this->db->where('statut',2);
        $this->db->order_by("date_end", "ASC");
        $query = $this->db->get('players');
        return $query->result();
    }

        //Return all available transfert
    public function checkPlayerEnchere($playerId)
    {
        $this->db->select('statut');
        $this->db->where('player_id',$playerId);
        $query = $this->db->get('players');

        $result=$query->result_array();

        if($result[0]["statut"]==2)
            return TRUE;

        return FALSE;
    }

    //Return last offer
    public function getLastOffer($playerId)
    {
        $this->db->select('*');
        $this->db->from('transferts');
        $this->db->join('teams','teams.team_id = transferts.team_sender_id');
        $this->db->where('player_id',$playerId);
        $this->db->order_by("offer", "desc");
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->result_array();
    }

        //Return last offer
    public function getPlayersAuction()
    {
        $this->db->select('*');
        $this->db->from('players');
        $this->db->where('date_end <=',date('Y-m-d h:i:s'));
        $this->db->where('statut',2);
        $query = $this->db->get();
        return $query->result_array();
    }


    //count all avaible transferts
    public function count_available_transferts($teamId)
    {
        $this->db->where('statut', 1);
	$query=$this->db->get("players");
        return $query->num_rows();
    }

    //Return all transfert by measure
    public function get_transferts_by_measure($num,$offset,$playerName,$playerAge,$playerPosition,$playerValue)
    {
        
        if($playerName!=''){

            $this->db->where('player_name', $playerName);
        }

        if($playerPosition!='all'){
            $this->db->where('position',$playerPosition);
                  
        }

        if($playerAge!='all'){
            $this->db->where('age',$playerAge);
            
        }

        if($playerValue!='all'){
            $this->db->where('value <=',$playerValue);

        }

        $this->db->where('statut',1);
        $this->db->order_by("value", "desc");
        $query = $this->db->get('players',$num,$offset);
        return $query->result();
    }

    //Count transfert by measure
    public function count_transferts_by_measure($playerName,$playerAge,$playerPosition,$playerValue)
    {

        if($playerName!=''){

            $this->db->where('player_name', $playerName);
        }

        if($playerPosition!='all'){
            $this->db->where('position',$playerPosition);

        }

        if($playerAge!='all'){
            $this->db->where('age',$playerAge);

        }

        if($playerValue!='all'){
            $this->db->where('value <=',$playerValue);

        }

        $this->db->where('statut', 1);
        $this->db->order_by("value", "desc");
        $query = $this->db->get('players');
        return $query->num_rows();
    }

    //Add new offer
    public function add_offer($form_data,$teamSenderId,$teamReceiverId)
    {
        
        $data=array(
          "offer"=>$form_data["offer"],
          "player_id"=>$form_data["playerId"],
          "team_sender_id"=>$teamSenderId,
          "team_receiver_id"=>$teamReceiverId,
        );

       	$query=$this->db->insert('transferts',$data);
        
    }

    //update new offer
    public function update_offer($form_data,$teamSenderId)
    {

        $data=array(
          "offer"=>$form_data["offer"]
        );
        
        $this->db->where('player_id',$form_data["playerId"]);
        $this->db->where('team_sender_id',$teamSenderId);

       	$query=$this->db->update('transferts',$data);

    }

    //update auction statut
    public function updateAuctionStatut($playerId,$teamId,$statut)
    {
        $dateEnd=date('Y-m-d 00:00:00', strtotime('+7 day'));

        $data=array(
          "team_id"=>$teamId,
          "statut"=>$statut,
          "date_end"=>$dateEnd,
        );

        $this->db->where('player_id',$playerId);

       	$query=$this->db->update('players',$data);

    }

    //count auction by playerid
    public function countAuction($playerId)
    {

        $this->db->where('player_id',$playerId);
       	$query=$this->db->get('transferts');
        return $query->num_rows();

    }

    public function getOffer($transfertId)
    {
        $queryString="SELECT *
                      FROM transferts
                      WHERE transfert_id=$transfertId";
        $query=$this->db->query($queryString);
        $result=$query->result_array();

        return $result;

    }

    public function deleteOffer($transfertId)
    {
        $queryString="DELETE
                      FROM transferts
                      WHERE transfert_id=$transfertId";
        $query=$this->db->query($queryString);
 
    }

    public function deleteAllOffers($teamId,$playerId)
    {
        $queryString="DELETE
                      FROM transferts
                      WHERE team_receiver_id=$teamId
                      AND player_id=$playerId";
        $query=$this->db->query($queryString);

    }

    public function deletePlayerOffers($playerId)
    {
        $queryString="DELETE
                      FROM transferts
                      WHERE player_id=$playerId";
        $query=$this->db->query($queryString);

    }

        //count all avaible transferts
    public function check_offer_already_done($form_data,$teamId)
    {
	$this->db->where('player_id', $form_data["playerId"]);
        $this->db->where('team_sender_id', $teamId);
	$query=$this->db->get("transferts");
	$nbOffer=$query->num_rows();

        if($nbOffer>0){
            return TRUE;
        }

        return FALSE;
    }

    public function getOffersByPlayer($playerId)
    {
        $this->db->join('teams', 'teams.team_id = transferts.team_sender_id');
        $this->db->where('player_id', $playerId);
        $this->db->order_by('transferts.offer', 'DESC');
	$query=$this->db->get("transferts");
        return $query->result();
    }

    public function get_offer_sent($teamId)
    {
        $this->db->join('players', 'players.player_id = transferts.player_id');
        $this->db->join('teams', 'teams.team_id = transferts.team_sender_id');
        $this->db->where('teams.team_id', $teamId);
	$query=$this->db->get("transferts");
        return $query->result();
    }

    public function get_offer_received($teamId)
    {
        $this->db->join('players', 'players.player_id = transferts.player_id');
        $this->db->join('teams', 'teams.team_id = players.team_id');
        $this->db->where('teams.team_id', $teamId);
	$query=$this->db->get("transferts");
        return $query->result();
    }

    //update new offer
    public function update_player_name($form_data)
    {

        $data=array(
          "player_name"=>$form_data["playerName"]
        );

        $this->db->where('player_id',$form_data["playerId"]);

       	$query=$this->db->update('players',$data);

    }

}
?>
