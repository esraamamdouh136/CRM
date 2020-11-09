<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 13/10/2018
 * Time: 12:11 ص
 */

class premissions extends CI_Model
{
    public function get_premissions($userid,$objCode)
    {
        $query = $this->db->get_where('crm_users_permissions',["UserID"=>$userid,"Object_Code"=>$objCode])->result();
        if ($query ==NULL){
            return 0;
        }else{
         if (count($query) > 0){
             return $query[0]->IsGranted;
         }   else{
             return 0;
         }
        }


    }
    public function get_premissionsList()
    {
        return $this->db->get("crm_permissions_objects")->result();

    }
    public function get_UserpremissionsList($userID)
    {
        $this->db->select('crm_users_permissions.*');
        $this->db->select('crm_permissions_objects.Name');
        $this->db->where('crm_users_permissions.UserID', $userID);
        $this->db->join('crm_users_permissions', 'crm_permissions_objects.Code = crm_users_permissions.Object_Code','right');
        return $this->db->get("crm_permissions_objects")->result();

    }
}