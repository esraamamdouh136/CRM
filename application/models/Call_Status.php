<?php
/**
 * Created by PhpStorm.
 * User: boody
 * Date: 09/08/2018
 * Time: 05:36 م
 */

class Call_Status extends CI_Model
{

    public function GetCallStatus($parentID){
        $query = "select * from call_status where id = " . $parentID." and is_active=1";
        return $this->db->query($query)->result();

    }
    public function GetAnswerStatus(){
        $query = "select * from call_status where type=1 and status!=3 and is_active=1";
        return $this->db->query($query)->result();

    }
    public function GetwrongStatus(){
        $query = "select * from call_status where type=3 and status!=3 and is_active=1";
        return $this->db->query($query)->result();

    }
    public function GetNoAnswerStatus(){
        $query = "select * from call_status where type = 2 and is_active=1";
        return $this->db->query($query)->result();

    }
    public function GetReserveStatus(){
        $query = "select * from call_status where type=1 and status=3 and is_active=1";
        return $this->db->query($query)->result();

    }
    public function GetStatusByType($type){
        $query = "select * from call_status where type = ".$type." and is_active=1";
        return $this->db->query($query)->result();

    }

    public function getDelayedCalls($time,$userID = null,$type = null){
        $this->db->select('*');
        $this->db->from('crm_follows');
        $this->db->join('crm_users', 'crm_users.ID = crm_follows.UserID');
        $where = "crm_follows.Follow_Date = Date(now())";


        if ($type !=null && $type == 1){
            // employee
            $where .= "and now() > DATE_ADD(crm_follows.Follow_Time, INTERVAL ".$time." minute)";

        }else if ($type !=null && $type == 2){
            //supervisor
            $where .= "and now() > DATE_ADD(crm_follows.Follow_Time, INTERVAL ".$time." minute)";
            $where .=" and (crm_users.Super = ".$userID." or crm_users.ID = ".$userID.")";

        }else if ($userID != null){
            //admin

            $where .=" and crm_users.ID = ".$userID;
        }else if ($type ==null &&$userID == null){
            $where .= "and now() > DATE_ADD(crm_follows.Follow_Time, INTERVAL ".$time." minute)";
        }

        $this->db->where($where);
        return $this->db->get()->result();
    }



    function GetStatusType($statusID){
        $this->db->where('id',$statusID);
        return $this->db->get('call_status')->result();
    }
}