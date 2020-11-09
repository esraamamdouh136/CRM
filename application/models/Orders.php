<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 13/10/2018
 * Time: 03:17 ص
 */

class Orders extends CI_Model
{
    public function GetClientOrders($ClientID){
//        $this->db->select('*');
//        $this->db->from('crm_orders');
//        $this->db->join('crm_products', 'crm_orders.ProductID = crm_products.Product_ID');
//        $this->db->where('crm_orders.ClientID',$ClientID);
//        $query = $this->db->get();

        $this->db->select('client_orders.*');
        $this->db->select('crm_users.Name');
        $this->db->select('customercrm.customerCrmName');
        $this->db->from('client_orders');
        $this->db->join('customercrm', 'client_orders.Client_ID = customercrm.customerCrmId');
        $this->db->join('crm_users', 'client_orders.User_ID = crm_users.ID');
        $this->db->where('client_orders.Client_ID',$ClientID);
        $this->db->where('isDeleted',false);
        $query = $this->db->get();

        return $query->result();
    }
    public function AddClientOrders($UserID,$ClientID,$Orders){

    }

    function DeleteOrder($OrderID){
        $this->db->where('ID', $OrderID);
        $this->db->delete('client_orders');
        return $this->db->affected_rows();
    }
    function UpdateOrder($OrderID,$quantity){
        $this->db->where('ID', $OrderID);
        $this->db->set(array('Quantity'=>$quantity));
        $this->db->update('crm_orders');
        return $this->db->affected_rows();
    }

    function deleteItem($id){
        $this->db->where('ID', $id);
        $this->db->delete('client_orders_details');
    }
    function GetOrderItems($id){
        $this->db->where('Order_ID', $id);
       return $this->db->get('client_orders_details')->result();
    }


    function DeleteClientOrders($ClientID){
        $this->db->where('Client_ID', $ClientID);
        $this->db->delete('client_orders');
        return $this->db->affected_rows();
    }
}