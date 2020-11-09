<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 02/02/2019
 * Time: 04:54 م
 */

class ClientOrders extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        session_start();
        $this->load->model('Client_OrderModel');
        $this->load->model('Clients');
        $this->load->model('Employee_Taskes');
        $this->load->model('Model1');
        $this->load->model('Follows');
        $this->load->model('Call_Status');
        $this->load->model('Orders');
        $this->load->model('Transfer_Model');
        $this->load->model('ordersettingsModel');
    }

    function addNewOrder(){
//
//        print_r("<pre>");
//        print_r($_POST);
//        print_r("<pre>");die();

        if (isset($_POST['time'])){
            $time = $_POST['time'];
            $time = strtotime($time) + 7200;
            $time = new DateTime("@$time");
            $time=$time->format('H:i:s');
        }

        $data['url'] = base_url();
        $data["title"]="عميل";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else {
            $this->Model1->updatedata('crm_users_log','UserID='.$_SESSION['userid'],['Status'=>1]);
            $client_id=$_POST['clientid'];
            $status = $this->Call_Status->GetStatusType($_POST['callStatus']);

            $follow = $this->Follows->isFollow($_POST['clientid']);
            $followID = null;
            if ($status[0]->follow ==1){

                // add in Follow Table
                // Get Client Follows
                $FollowData['UserID']=$_SESSION['userid'];
                $FollowData['ClientID']=$_POST['clientid'];
                $FollowData['Follow_Time']=$time;
                $FollowData['Follow_Date']=$_POST['date'];
                if (count($follow) > 0 ){
                    // update
                    $followID = $follow[0]->ID;
                    $this->Follows->updateFollow($follow[0]->ID,$FollowData);
                }else{
                    //insert
                    $followID = $this->Follows->addFollow($FollowData);
                }
            }else{
                //delete follow
                if (count($follow) > 0){
                    $this->Follows->deleteFolow($follow[0]->ID);
                }


            }

            if (isset($_POST) && !is_null($_POST)){
                if (isset($_POST['names']) && !is_null($_POST['names'])){
                    $OrderData['Client_ID'] = $_POST['clientid'];
                    $OrderData['User_ID'] = $_SESSION['userid'];
                    $OrderData['Discount'] = $_POST['DiscountValue'];
                    $OrderData['Transfer_Cost'] = $_POST['TransferCost'];
                    $OrderData['Order_Cost'] = $_POST['productCost'];
                    $OrderData['Net_Cost'] = $_POST['Total'];
                    $Products = $_POST['names'];
                    $Transfer = $_POST['transferType'];
                    $Payment = $_POST['paymentType'];
                    $Quantity = $_POST['quantity'];
                    for ($i=0;$i<count($Products);$i++){
                        $OrderDetails[$i]['Transfer_ID'] = $Transfer[$i];
                        $OrderDetails[$i]['Payment_ID'] = $Payment[$i];
                        $OrderDetails[$i]['Unit_ID'] = $Products[$i];
                        $OrderDetails[$i]['Quantity'] = $Quantity[$i];
                    }
                    $OrderPayment['Client_ID'] = $_POST['clientid'];
                    $OrderPayment['User_ID'] = $_SESSION['userid'];
                    $OrderPayment['Amount '] = $_POST['Total'];
                    $this->Client_OrderModel->addNewOrder($OrderData,$OrderDetails,$OrderPayment);
                    if (isset($_POST['IsCall']) && !is_null($_POST['IsCall'])){
                        if ($_POST['IsCall'] == 1){
                            $this->Model1->updatedata('crm_users_log','UserID='.$_SESSION['userid'],['Status'=>1]);
                            $this->Model1->updatedata('crm_calls','ID='.$_POST['callID'],['endcall'=>date('H:i:s'),'call_Result'=>$_POST['callStatus']]);
                            $this->Employee_Taskes->updateStatus($_POST['clientid'],$_POST['callStatus'],$_SESSION['userid']);
                        }
                    }
                    if (isset($_POST['comment']) && $_POST['comment'] != null) {
                        if (isset($_POST['date']) && $_POST['date'] != null)
                            $row['date'] = $_POST['date'];
                        if (isset($time) && $time != null)
                            $row['time'] = $time;
                        $row['Comment_Text']=htmlspecialchars($_POST['comment']);
                        $row['ClientID']=$_POST['clientid'];
                        $row['UserID']=$_SESSION['userid'];
                        $this->Model1->addtotable('crm_comments',$row);
                    }
                    redirect(site_url("Client/Details/".$_POST['clientid']));
                }else{
                    redirect(site_url("Client/Details/".$_POST['clientid']));
                }
            }else{
                redirect(site_url("Client/Distributors"));
            }
        }
    }

    function OrderDetails($OrderID){
        $data['url'] = base_url();
        $data["title"]="تفاصيل طلب شراء للعميل ";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else {

            // Get order Details
            $data['orderDetails'] = $this->Client_OrderModel->getOrderDetails($OrderID);
            $data['PaymentTypes'] = $this->Model1->selectdata('PaymentTypes');
            $data["trucks"] = $this->Transfer_Model->GetTransfer();
            $data["Order_ID"] = $OrderID;
            $data["Ordersettings"] =  $this->ordersettingsModel->getParentOrderSettings();
            $data['Client_ID'] = $data['orderDetails'][0]->Client_ID;
//            print_r("<pre>");
//            print_r($data);
//            print_r("</pre>");die();
            $this->load->view('Orders/customerOrderDetails', $data);
        }
    }

    function DeleteOrder(){
        if (!is_null($_POST) && isset($_POST)){
            if (!is_null($_POST['ID'])){
                $this->Client_OrderModel->DeleteClientOrder($_POST['ID']);
                echo 1;
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
    }
    function  GetPaymentData(){
        if (!is_null($_POST) && isset($_POST)){
            if (!is_null($_POST['clientid'])){
                $data= $this->Client_OrderModel->GetPaymentData($_POST['clientid']);
                echo json_encode($data);
            }else{
                echo 0;
            }
        }else{
            echo 0;
        }
    }

    function SetPaymentAmount(){
//        print_r("<pre>");
//        print_r($_POST);
//        print_r("</pre>");
        if (isset($_POST['time'])){
            $time = $_POST['time'];
            $time = strtotime($time) + 7200;
            $time = new DateTime("@$time");
            $time=$time->format('H:i:s');
        }
        $data['url'] = base_url();
        $data["title"]="عميل";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else {
            $this->Model1->updatedata('crm_users_log','UserID='.$_SESSION['userid'],['Status'=>1]);
            $client_id=$_POST['clientid'];
            $status = $this->Call_Status->GetStatusType($_POST['callStatus']);

            $follow = $this->Follows->isFollow($_POST['clientid']);
            $followID = null;
            if ($status[0]->follow ==1){

                // add in Follow Table
                // Get Client Follows
                $FollowData['UserID']=$_SESSION['userid'];
                $FollowData['ClientID']=$_POST['clientid'];
                $FollowData['Follow_Time']=$time;
                $FollowData['Follow_Date']=$_POST['date'];
                if (count($follow) > 0 ){
                    // update
                    $followID = $follow[0]->ID;
                    $this->Follows->updateFollow($follow[0]->ID,$FollowData);
                }else{
                    //insert
                    $followID = $this->Follows->addFollow($FollowData);
                }
            }else{
                //delete follow
                if (count($follow) > 0){
                    $this->Follows->deleteFolow($follow[0]->ID);
                }


            }

            if (!is_null($_POST['comment']) & !empty($_POST['comment'])){
                // add comment
                if (isset($_POST['date']) && $_POST['date'] != null)
                    $row['date'] = $_POST['date'];
                if (isset($time) && $time != null)
                    $row['time'] = $time;
                $row['Comment_Text']=htmlspecialchars($_POST['comment']);
                $row['ClientID']=$_POST['clientid'];
                $row['UserID']=$_SESSION['userid'];
                $this->Model1->addtotable('crm_comments',$row);
            }
            $this->Model1->updatedata('crm_users_log','UserID='.$_SESSION['userid'],['Status'=>1]);
            $this->Model1->updatedata('crm_calls','ID='.$_POST['CallID'],['endcall'=>date('H:i:s'),'call_Result'=>$_POST['Contracted_status_id']]);
            $this->Employee_Taskes->updateStatus($_POST['clientid'],$_POST['Contracted_status_id'],$_SESSION['userid']);

            // update payment amount
            if (!is_null($_POST['Amount']) && !empty($_POST['Amount'])){
                $this->Client_OrderModel->UpdatePaymentAmount($_POST['clientid'],$_POST['Amount']);
            }
            redirect(site_url("Client/Details/".$_POST['clientid']));

        }
    }

    function Delete(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);return;
        }else {
            if (isset($_POST['unitID']) && !is_null($_POST['unitID'])){
                // Check If it last item in order
                $this->Orders->deleteItem($_POST['unitID']);

                $orders =   $this->Orders->GetOrderItems($_POST['OrderID']);
                if (isset($orders)){
                    if (count($orders) <= 0){
                        // delete order
                        $this->Orders->DeleteOrder($_POST['OrderID']);
                        echo 2;return;
                    }else{

                        //Update Total cost

                        $TotalPrice = $this->Client_OrderModel->GetTotalOrderCost($_POST['OrderID']);
                        // get New Values
                        $oldOrder = $this->Client_OrderModel->GetOldOrder($_POST['OrderID']);
                        // Save New Values
                        $orderData['Order_Cost']=$TotalPrice;
                        $orderData['Transfer_Cost']=$oldOrder->Transfer_Cost;
                        $orderData['Discount']=$oldOrder->Discount;
                        $Net_Cost = ($orderData['Order_Cost']+$orderData['Transfer_Cost'])- $orderData['Discount'];
                        $orderData['Net_Cost']=$Net_Cost;
                        $this->Client_OrderModel->UpdateOrder($_POST['OrderID'],$orderData);


                        echo 1;return;
                    }
                }else{
                    $this->Orders->DeleteOrder($_POST['OrderID']);
                    echo 2;return;
                }

                echo 1;return;
            }else{
                echo 0;return;
            }
        }
        echo 0;
    }
    function GetOrderData(){
        $result['error'] = 0;
        if (is_null($_POST) || !isset($_POST['unitID'])){
            $result['error'] = 1;
            echo json_encode($result);
            return;
        }
        $result['data'] = $this->Client_OrderModel->GetOrderDetailsItems($_POST['unitID']);
        echo json_encode($result);
    }
    function AddOrderData(){
//        print_r("<pre>");
//        print_r($_POST);
//        print_r("</pre>");die();
        if (isset($_POST['time'])){
            $time = $_POST['time'];
            $time = strtotime($time) + 7200;
            $time = new DateTime("@$time");
            $time=$time->format('H:i:s');
        }

        $data['url'] = base_url();
        $data["title"]="عميل";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else {


            if (isset($_POST) && !is_null($_POST)){
                if (isset($_POST['names']) && !is_null($_POST['names'])){

                    $Products = $_POST['names'];
                    $Transfer = $_POST['transferType'];
                    $Payment = $_POST['paymentType'];
                    $Quantity = $_POST['quantity'];
                    for ($i=0;$i<count($Products);$i++){
                        $OrderDetails[$i]['Transfer_ID'] = $Transfer[$i];
                        $OrderDetails[$i]['Payment_ID'] = $Payment[$i];
                        $OrderDetails[$i]['Unit_ID'] = $Products[$i];
                        $OrderDetails[$i]['Quantity'] = $Quantity[$i];
                    }
                    $this->Client_OrderModel->addNewOrderDetails($_POST['OrderID'],$OrderDetails);
                    // update cost
                    // Get Old Values
                    $TotalPrice = $this->Client_OrderModel->GetTotalOrderCost($_POST['OrderID']);
                    // get New Values
                    $oldOrder = $this->Client_OrderModel->GetOldOrder($_POST['OrderID']);
                    // Save New Values


                    $orderData['Order_Cost']=$TotalPrice;
                    $orderData['Transfer_Cost']=$_POST['TransferCost']+isset($oldOrder->Transfer_Cost)?$oldOrder->Transfer_Cost:0;
                    $orderData['Discount']=$_POST['DiscountValue']+isset($oldOrder->Discount)?$oldOrder->Discount:0;
                    $Net_Cost = ($orderData['Order_Cost']+$orderData['Transfer_Cost'])- $orderData['Discount'];
                    $orderData['Net_Cost']=$Net_Cost;

                    $this->Client_OrderModel->UpdateOrder($_POST['OrderID'],$orderData);

                    $this->Client_OrderModel->setupdatePayment($oldOrder->Client_ID,$Net_Cost);

//                    $OrderPayment['Client_ID'] = $_POST['clientid'];
//                    $OrderPayment['User_ID'] = $_SESSION['userid'];
//                    $OrderPayment['Amount '] = $_POST['Total'];
//                    $this->Client_OrderModel->addNewOrder($OrderData,$OrderDetails,$OrderPayment);


                    if (isset($_POST['comment']) && $_POST['comment'] != null) {
                        if (isset($_POST['date']) && $_POST['date'] != null)
                            $row['date'] = $_POST['date'];
                        if (isset($time) && $time != null)
                            $row['time'] = $time;
                        $row['Comment_Text']=htmlspecialchars($_POST['comment']);
                        $row['ClientID']=$_POST['Client_ID'];
                        $row['UserID']=$_SESSION['userid'];
                        $this->Model1->addtotable('crm_comments',$row);
                    }
                    redirect(site_url("ClientOrders/OrderDetails/".$_POST['OrderID']));
                }else{
                    redirect(site_url("ClientOrders/OrderDetails/".$_POST['OrderID']));
                }
            }else{
                redirect(site_url("Client/Distributors"));
            }
        }
    }

    function UpdateOrderData(){
//        print_r("<pre>");
//        print_r($_POST);
//        print_r("</pre>");die();

        $data['url'] = base_url();
        $data["title"]="تفاصيل طلب شراء للعميل ";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{
            $orderDetails['Quantity'] = $_POST['Quantity'];
            $orderDetails['Transfer_ID'] = $_POST['truckType'];
            $orderDetails['Payment_ID'] = $_POST['PaymentType'];
            // Get Old Transfer Cost
            //__GetTransfer()
            $Details= $this->Client_OrderModel->GetOrderDetailsItems($_POST['DetailsID']);
            $oldtransCost = $this->Transfer_Model->__GetTransfer($Details->Transfer_ID)[0]->Price;
            $newtransCost=$this->Transfer_Model->__GetTransfer($_POST['truckType'])[0]->Price;
            $this->Client_OrderModel->updateOrderDetails($_POST['DetailsID'],$orderDetails);
            // update Order Cost
            $TotalPrice = $this->Client_OrderModel->GetTotalOrderCost($_POST['OrderID']);
            // get New Values
            $oldOrder = $this->Client_OrderModel->GetOldOrder($_POST['OrderID']);
            // Save New Values
            $orderData['Order_Cost']=$TotalPrice;
            $orderData['Transfer_Cost']=($oldOrder->Transfer_Cost-$oldtransCost)+$newtransCost;
            $orderData['Discount']=$oldOrder->Discount;
            $Net_Cost = ($orderData['Order_Cost']+$orderData['Transfer_Cost'])- $orderData['Discount'];
            $orderData['Net_Cost']=$Net_Cost;
            $this->Client_OrderModel->UpdateOrder($_POST['OrderID'],$orderData);
            $this->Client_OrderModel->setupdatePayment($oldOrder->Client_ID,$Net_Cost);


        }
        redirect(site_url("ClientOrders/OrderDetails/".$_POST['OrderID']));



    }
}