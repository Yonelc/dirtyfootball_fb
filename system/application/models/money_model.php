<?php
class money_model extends Model {

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
| Check Money
|==========================================================
|
*/
    public function checkEnoughMoney($money,$userId)
    {

        $this->db->select('money');
        $this->db->where('user_id',$userId);
        $query=$this->db->get('users');
        $result=$query->result_array();

        if($result[0]["money"]>=$money)
            return TRUE;

        return FALSE;
    }



/*
|==========================================================
| Check dirtygold
|==========================================================
|
*/
    public function checkEnoughDirtyGold($dirtyGold,$userId)
    {
        $this->db->select('dirtyGold');
        $this->db->where('user_id',$userId);
        $query=$this->db->get('users');
        $result=$query->result_array();

        if($result[0]["dirtyGold"]>=$dirtyGold)
            return TRUE;

        return FALSE;
    }

/*
|==========================================================
| Update Money
|==========================================================
|
*/
    public function updateMoney($money,$userId)
    {
        $queryString="UPDATE users SET money=money-$money WHERE user_id=$userId";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| Update DirtyGold lost
|==========================================================
|
*/
    public function updateDirtyGold($dirtyGold,$userId)
    {
        $queryString="UPDATE users SET dirtyGold=dirtyGold-$dirtyGold WHERE user_id=$userId";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| Update Money
|==========================================================
|
*/
    public function updateSellMoney($money,$userId)
    {
        $queryString="UPDATE users SET money=money+$money WHERE user_id=$userId";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| Update DirtyGold
|==========================================================
|
*/
    public function updateSellDirtyGold($dirtyGold,$userId)
    {
        $queryString="UPDATE users SET dirtyGold=dirtyGold+$dirtyGold WHERE user_id=$userId";
        $query = $this->db->query($queryString);
    }

}
?>
