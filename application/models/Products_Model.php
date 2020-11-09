<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 9/27/2018
 * Time: 11:32 PM
 */

class Products_Model extends CI_Model
{

    public function GetProducts(){
        $query = $this->db->get('crm_products');
        return $query->result();
    }
    public function GetProductsByType($Type){

        $query = $this->db->get_where('crm_products',array('Product_Type' => $Type));
        return $query->result();
    }
    public function __GetProducts($ID){
        $query = $this->db->get_where('crm_products',array('Product_ID' => $ID));
        return $query->result();
    }

    public function update($ID,$data){
        $this->db->update('crm_products', $data, array('Product_ID' => $ID));
    }
    public function delete($ID){
        $this->db->delete('crm_products', array('Product_ID' => $ID));
    }
    public function add($data){
        $this->db->insert('crm_products', $data);
    }
    public  function ProductInUse($ID){
        $query = $this->db->get_where('client_orders_details',array('Unit_ID' => $ID));
        return count($query->result());
    }

}