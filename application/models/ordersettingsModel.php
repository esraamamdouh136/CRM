<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 30/01/2019
 * Time: 12:32 م
 */

class ordersettingsModel extends CI_Model
{
    function getParentOrderSettings(){
        $this->db->where('parent', null);
        $this->db->where('Is_Active',true);
        return $this->db->get('crm_ordersettings')->result();
    }

    function getChieldOrderSettings($parentID){
        $this->db->where('parent',$parentID);
        $this->db->where('Is_Active',true);
        return $this->db->get('crm_ordersettings')->result();
    }

    function UpdateSettings($id,$data){
        $this->db->where('ID',$id);
        $this->db->update('crm_ordersettings',$data);
        return $this->db->affected_rows();
    }

    function UpdateSettingsStatus($id,$status){
        $this->db->where('ID',$id);
        $data['Is_Active'] = ($status==1);
        $this->db->update('crm_ordersettings',$data);
        return $this->db->affected_rows();
    }

    function GetAllOrderSettings(){
        $this->db->where('parent', null);
        return $this->db->get('crm_ordersettings')->result();
    }

    function getAllChieldOrderSettings($parentID){
        $this->db->where('parent',$parentID);

        return $this->db->get('crm_ordersettings')->result();
    }
}