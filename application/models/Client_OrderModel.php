<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 02/02/2019
 * Time: 05:07 م
 */

class Client_OrderModel extends CI_Model
{

    //Products_Model

    function addNewOrder($OrderData,$OrderDetails,$OrderPayment){

//        print_r("<pre>");
//        print_r($OrderData);
//        print_r($OrderDetails);
//        print_r($OrderPayment);
//        print_r("</pre>");die();
        $this->db->insert('client_orders', $OrderData);
        $OrderID = $this->db->insert_id();
        $this->addNewOrderDetails($OrderID,$OrderDetails);
        $this->addOrderPayment($OrderID,$OrderPayment);

    }
    function getOrderDetails($id){
        $this->db->select('*,client_orders_details.id as DetailsID');
        $this->db->from('client_orders');
        $this->db->join('client_orders_details', 'client_orders.ID = client_orders_details.Order_ID');
        $this->db->join('client_payments', 'client_orders.ID = client_payments.Order_ID');
        $this->db->where('client_orders.ID',$id);
        return $this->db->get()->result();
    }

    function DeleteClientOrder($id){
        $this->db->where('ID', $id);
        $this->db->delete('client_orders');
    }

    function GetPaymentData($ClientID){
        $this->db->select_sum('Amount');
        $this->db->select_sum('paid ');
        $this->db->where('Client_ID',$ClientID);
        //client_payments
        $query = $this->db->get('client_payments');
        return $query->result();
    }

    function UpdatePaymentAmount($ClientID,$amount){

        //get client payments
        $this->db->where('Client_ID',$ClientID);
        $query = $this->db->get('client_payments')->result();
        foreach ($query as $row){

            if ($amount > 0){
                if ( $amount >= ($row->Amount - $row->paid)){
                    $amount = $amount - ($row->Amount - $row->paid);
                    $this->UpdateAmount($row->ID,$row->Amount);
                }else{
                    if (($row->paid + $amount) <= $row->Amount){
                        $this->UpdateAmount($row->ID,($row->paid + $amount));
                        $amount = 0;
                    }else{
                        $this->UpdateAmount($row->ID,($row->Amount));
                        $amount = $amount - ($row->Amount - $row->paid);
                    }


                }
            }}

    }

    private function UpdateAmount($id,$amount){

        $this->db->set('paid', $amount);
        $this->db->where('ID',$id);
        $this->db->update('client_payments');
    }

    function setupdatePayment($ClientID,$amount){
        $this->db->where('Client_ID',$ClientID);
        $this->db->set('Amount', $amount);
        $this->db->update('client_payments');

    }
    function addNewOrderDetails($id,$OrderDetails){

        foreach ($OrderDetails as $item){
//            print_r("<pre>");
//            print_r($item);
//            print_r("</pre>");die();
            $item['Order_ID'] = $id;
            // Get Item price using ItemID
            $ItemPrice = $this->GetProducts($item['Unit_ID'])[0]->Price;
            $item['Price'] = $ItemPrice;
            $this->db->insert('client_orders_details', $item);
        }
    }

    private function addOrderPayment($id,$OrderPayment){
        $OrderPayment['Order_ID'] = $id;
        $this->db->insert('client_payments', $OrderPayment);
    }

    private function GetProducts($ID){
        $query = $this->db->get_where('crm_products',array('Product_ID' => $ID));
        return $query->result();
    }


    function GetTotalOrderCost($ID){
        $this->db->select('SUM(`Price` * `Quantity`) as TotalPrice');
        $this->db->where('Order_ID',$ID);
        return $this->db->get('client_orders_details')->result()[0]->TotalPrice;
    }

    function GetOldOrder($ID){
        $this->db->where('ID',$ID);
        return $this->db->get('client_orders')->result()[0];
    }
    function UpdateOrder($ID,$data){
        $this->db->where('ID',$ID);
        $this->db->update('client_orders',$data);
    }


    function GetOrderDetailsItems($id){
        $this->db->select('client_orders_details.*,crm_products.Product_Name');
        $this->db->from('client_orders_details');
        $this->db->join('crm_products', 'client_orders_details.Unit_ID = crm_products.Product_ID');
        $this->db->where('client_orders_details.ID', $id);
        return $this->db->get()->result()[0];
    }


    function updateOrderDetails($id,$data){
        $this->db->where('ID',$id);
        $this->db->update('client_orders_details',$data);

    }


}