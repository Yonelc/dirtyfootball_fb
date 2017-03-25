<?php
class notification_model extends Model {

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
| Return all notifications
|==========================================================
|
*/
    public function getNotifications($teamId,$userId)
    {
        $queryString="SELECT *
                      FROM notifications
                      WHERE team_id=$teamId
                      OR user_id=$userId
                      ORDER BY notification_date DESC
                      LIMIT 0,10";
        $query = $this->db->query($queryString);
        return $query->result_array();
    }

/*
|==========================================================
| Add notifications
|==========================================================
|
*/
    public function addNotification($message,$teamId,$type,$data1=NULL,$data2=NULL,$data3=NULL,$data4=NULL,$data5=NULL)
    {
        $queryString="INSERT INTO notifications
                      VALUES('','$message',$teamId,NULL,$type,'$data1','$data2','$data3','$data4','$data5',NOW())";
        $query = $this->db->query($queryString);
    }

/*
|==========================================================
| Add notifications
|==========================================================
|
*/
    public function addFriendlyNotification($message,$userId,$type,$data1=NULL,$data2=NULL,$data3=NULL,$data4=NULL,$data5=NULL)
    {
        $queryString="INSERT INTO notifications
                      VALUES('','$message',NULL,$userId,$type,'$data1','$data2','$data3','$data4','$data5',NOW())";
        $query = $this->db->query($queryString);
    }
}
?>
