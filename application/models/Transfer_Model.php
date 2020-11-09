<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 9/27/2018
 * Time: 11:32 PM
 */

class Transfer_Model extends CI_Model
{
    public function GetTransfer(){
        $query = $this->db->get('crm_transfer_type');
        return $query->result();
    }
    public function __GetTransfer($ID){
        $query = $this->db->get_where('crm_transfer_type',array('transfer_ID' => $ID));
        return $query->result();
    }
    public function update($ID,$data){
        $this->db->update('crm_transfer_type', $data, array('transfer_ID' => $ID));
    }
    public function delete($ID){
        $this->db->delete('crm_transfer_type', array('transfer_ID' => $ID));
    }
    public function add($data){
        $this->db->insert('crm_transfer_type', $data);
    }


    public  function TransferInUse($ID){
        $query = $this->db->get_where('client_orders_details',array('Transfer_ID' => $ID));
        return count($query->result());
    }
}