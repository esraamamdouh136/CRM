<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 30/01/2019
 * Time: 03:04 م
 */

class PaymentModel extends CI_Model
{
    function Create($data){
        $this->db->insert('paymenttypes', $data);
        return $this->db->insert_id();
    }
    function Update($id,$data){
        $this->db->where('ID', $id);
        $this->db->update('paymenttypes', $data);
        return $this->db->affected_rows();
    }
    function Delete($id){
        $this->db->where('ID', $id);
        $this->db->delete('paymenttypes');
    }

    function GetPaymentType($id){
        $this->db->where('ID', $id);
        $query = $this->db->get('paymenttypes');
        return $query->result();
    }

    public  function PaymentInUse($ID){
        $query = $this->db->get_where('client_orders_details',array('Payment_ID' => $ID));
        return count($query->result());
    }

}