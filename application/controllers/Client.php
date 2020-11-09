<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 13/10/2018
 * Time: 03:35 ص
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Client extends CI_Controller
{
    function __construct()
    {
        parent::__construct();


        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        session_start();
        $this->load->model('Model1');
        $this->load->model('Customers_Model');
        $this->load->model('Comments');
        $this->load->model('Call_Status');
        $this->load->model('Orders');
        $this->load->model('Transfer_Model');
        $this->load->model('Products_Model');
        $this->load->model('Users_Model');
        $this->load->model('Employee_Taskes');
        $this->load->model('ordersettingsModel');
        $this->load->model('SMSModel');
        $this->load->model('premissions');

    }

    public function index($CustomerID)
    {
        $data['url'] = base_url();
        $data["title"]="عميل";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{

            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            // get Customer Data
            $data["customer"]=$this->Customers_Model->GetCustomerByID($CustomerID);
            $data["customer_id"]=$CustomerID;
            // Comments
            $data["Comments"] = $this->Comments->GetClientComments($CustomerID);
            // Orders
            $data["answer"] = $this->Call_Status->GetAnswerStatus();
            $data["noanswer"] = $this->Call_Status->GetNoAnswerStatus();
            $data["reserve"] = $this->Call_Status->GetReserveStatus();
            $data["time"] = $this->Customers_Model->get_setting();
            $data["trucks"] = $this->Transfer_Model->GetTransfer();
            $this->load->view('Clients/index', $data);



        }
    }
    public function edit($CustomerID){
        $data['url'] = base_url();
        $data["title"]="عميل";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }

            // get Customer Data
            $data["customer"]=$this->Customers_Model->GetCustomerByID($CustomerID);
            $data["customer_id"]=$CustomerID;
            // Comments
            $data["Comments"] = $this->Comments->GetClientComments($CustomerID);
            // Orders
            $data["answer"] = $this->Call_Status->GetAnswerStatus();
            $data["noanswer"] = $this->Call_Status->GetNoAnswerStatus();
            $data["reserve"] = $this->Call_Status->GetReserveStatus();
            $data["time"] = $this->Customers_Model->get_setting();
            $data["trucks"] = $this->Transfer_Model->GetTransfer();
            // print_r($data);die;

            $this->load->view('Clients/edit', $data);



        }
    }
    public function update(){
        $data['url'] = base_url();
        $data["title"]="عميل";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $CustomerID=$_POST['customerCrmId'];

//

            $updatedData['customerCrmName']=$_POST['customerCrmName'];
            $updatedData['customerCrmAge']=$_POST['customerCrmAge'];
            $updatedData['customerCrmQualification']=$_POST['customerCrmQualification'];

            $updatedData['customerCrmGender']=($_POST['customerCrmGender']==1);

            $updatedData['customerCrmCountry']=$_POST['customerCrmCountry'];
            $updatedData['customerCrmGov']=$_POST['customerCrmGov'];
            $updatedData['customerCrmAddress']=$_POST['customerCrmAddress'];
            $updatedData['customerCrmEmail']=$_POST['customerCrmEmail'];
            $updatedData['customerCrmPhone']=$_POST['customerCrmPhone'];
            $updatedData['customerCrmSecondPhone']=$_POST['customerCrmSecondPhone'];
            $updatedData['customerCrmCompany']=$_POST['customerCrmCompany'];
            $updatedData['customerCrmJob']=$_POST['customerCrmJob'];
            $updatedData['customerCrmActivity']=$_POST['customerCrmActivity'];
//            print_r("<pre>");
//            print_r($updatedData);
//            print_r("</pre>");die();
            $this->Model1->updatedata('customercrm','customerCrmId='.$CustomerID,$updatedData);

            $data["customer"]=$this->Customers_Model->GetCustomerByID($CustomerID);
            $data["customer_id"]=$CustomerID;
            if (isset($_SESSION['CurrentURL']) && !empty($_SESSION['CurrentURL'])&& $_SESSION['CurrentURL']!=null){
                $CurrentURL = base_url().$_SESSION['CurrentURL'];
                $_SESSION['CurrentURL'] = null;
                // print_r($CurrentURL);die();
                redirect($CurrentURL);
                // $this->load->view($_SESSION['CurrentURL'],$data);
            }else{
                $this->index($CustomerID);
            }


        }

    }
    public function start_call(){
        $client_id=$_GET['client_id'];
        $this->Model1->updatedata('crm_users_log','UserID='.$_SESSION['userid'],['Status'=>3]);
        $arr=[
            'UserID'=>$_SESSION['userid'],
            'ClientID'=>$client_id,
            'startcall'=>date('H:i:s'),
            'date'=>date("Y-m-d")
        ];
        $callID=$this->Model1->addtotable('crm_calls',$arr);
        echo $callID;
    }
    public function end_call(){
        $client_id=$_GET['CallID'];
        $this->Model1->updatedata('crm_users_log','UserID='.$_SESSION['userid'],['Status'=>1]);
        $this->Model1->updatedata('crm_calls','ID='.$client_id,['endcall'=>date('H:i:s')]);
        echo 'done';
    }
    public function get_proudct_service(){
        $type=$_GET['type'];
        // $type => 1  Product ,,, $type  => 2  Service
        $item=$this->Products_Model->GetProductsByType($type);
        // print_r((array)$item);die;
        foreach($item as $value){
            echo '<option value="'.$value->Product_ID.'" cost="'.$value->Price.'">
                '.$value->Product_Name.'
            </option>';
        }
    }
    public function Clients($empID,$dateRange = null){
        $data['url'] = base_url();
        $data["title"]="عملاء الموظف : ";

        if(!isset($_SESSION['userid'])){
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            // Get employee Name
            $data['empID'] = $empID;
            $data["title"].= $this->Users_Model->GetUserByID($empID)[0]->Name;
            // get All Employee Clients

            $data['empClients'] = $this->Customers_Model->GetEmployeeCalls($empID,$dateRange);




            if ($_SESSION['usertype']==1){
                $data["employee"]=$this->Users_Model->GetEmployee($_SESSION['userid'],$_SESSION['usertype']);
            }else if ($_SESSION['usertype']==2){
                $data["employee"]=$this->Users_Model->GetSuperVisorEmployee($_SESSION['userid']);
            }
//            print_r("<pre>");
//            print_r($data);
//            print_r("</pre>");die();
            $this->load->view('Clients/ClientsList', $data);
        }
    }
    public function Details($ClientID){
        $data['url'] = base_url();
        $data["title"]="العملاء";
        if(!isset($_SESSION['userid'])){
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $data["customer"]=$this->Customers_Model->GetCustomerByID($ClientID);
            $data["customer_id"]=$ClientID;
            // Comments
            $data["Comments"] = $this->Comments->GetClientComments($ClientID);
            $data["Orders"] = $this->Orders->GetClientOrders($ClientID);
            $data["answer"] = $this->Call_Status->GetAnswerStatus();
            $data["noanswer"] = $this->Call_Status->GetNoAnswerStatus();
            $data["wrong"] = $this->Call_Status->GetwrongStatus();
            $data["reserve"] = $this->Call_Status->GetReserveStatus();
            $data["time"] = $this->Customers_Model->get_setting();
            $data["trucks"] = $this->Transfer_Model->GetTransfer();
            $clientStatus= $this->Employee_Taskes->getClientCallStatus($ClientID);
            $data['callStatus'] = $clientStatus[0]->status;
            $data['clientcallStatus'] = $clientStatus[0]->id;
            if ($_SESSION['usertype']==1){
                $data["users"]=$this->Users_Model->GetEmployee($_SESSION['userid'],$_SESSION['usertype']);
            }else if ($_SESSION['usertype']==2){
                $data["users"]=$this->Users_Model->GetSuperVisorEmployee($_SESSION['userid']);
            }
            $data['Ordersettings'] = $this->ordersettingsModel->getParentOrderSettings();
            $data['ContractedStatus'] = $this->Call_Status->GetStatusByType(4);
            $data['DeContractedStatus'] = $this->Call_Status->GetStatusByType(5);
            $data['PaymentTypes'] = $this->Model1->selectdata('PaymentTypes');
            $_SESSION['CurrentURL'] = 'Client/Details/'.$ClientID;
//            print_r("<pre>");
//            print_r($data);
//            print_r("</pre>");die();
            $this->load->view('Clients/Details', $data);
        }
    }
    public function Distributors($dateRange = null){
        $data['url'] = base_url();
        $data["title"]="عملاء تم توزيعهم";
        if (isset($_SESSION['usertype'] )){
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
        }

        if (isset($_SESSION["filter"]) && !is_null($_SESSION["filter"])){
            $data["selectedIndex"] = $_SESSION["filter"];
            $_SESSION["filter"] = null;
        }

        if(!isset($_SESSION['userid'])){
            $this->load->view('login', $data);
        }else{
            if ($dateRange ==null){
                $date1 =  date("Y-m-d") ;
                $date2 =  date("Y-m-d");
                $dateRange = $date1.'@'.$date2;
                $_SESSION['date1'] = $date1;
                $_SESSION['date2'] = $date2;
            }else{
                if ($dateRange !=null){
                    $dateArray = explode("@",$dateRange);
                    $date1 =    $dateArray[0] ;
                    $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                    $_SESSION['date1'] = $date1 ;
                    $_SESSION['date2'] = $date2 ;}
                else{
                    $_SESSION['date1'] = date("Y-m-d") ;
                    $_SESSION['date2'] = date("Y-m-d") ;
                }
            }
            $_SESSION['dateRange'] = $dateRange;
            $status=$this->Customers_Model->call_status();
            $per = $this->premissions->get_premissions($_SESSION['userid'],"09");
            foreach($status As $row){
                if ($per == 1){
                    $data["status"][$row['id']]=$this->Customers_Model->GetCalCount($row['id'],$_SESSION['userid'],$_SESSION['usertype'],$dateRange,1);
                }else{
                    $data["status"][$row['id']]=$this->Customers_Model->GetCalCount($row['id'],$_SESSION['userid'],$_SESSION['usertype'],$dateRange);
                }
            }
            $data["statusCrm"] = $this->Customers_Model->GetCallStatus();
            $_SESSION["PAGE"] = "Distributors";
            // get user permission

            if  ($_SESSION['usertype'] == 1 || $per == 1){
                //Admin
                $data["Distributors"] = $this->Customers_Model->Distributors($_SESSION['usertype'],null,$dateRange,1);
                $data["Clients"] = $this->Customers_Model->DistributorsClients($_SESSION['usertype'],null,$dateRange,null,1);
                $data["employee"]=$this->Users_Model->GetEmployee($_SESSION['userid']);
                // get clients
//                print_r("<pre>");
//                print_r($data);
//                print_r("</pre>");die();
                $this->load->view('Clients/DistributorsClients', $data);
                return;
            }else if($_SESSION['usertype'] ==2){
                //Super
                $data["Distributors"] = $this->Customers_Model->Distributors($_SESSION['usertype'],$_SESSION['userid'],$dateRange);
                $data["Clients"] = $this->Customers_Model->DistributorsClients($_SESSION['usertype'],$_SESSION['userid'],$dateRange);
                $data["employee"]=$this->Users_Model->GetSuperVisorEmployee($_SESSION['userid']);
                // get clients
                $this->load->view('Clients/DistributorsClients', $data); return;
                return;
            }else{
                // Employee
                $data["Distributors"] = $this->Customers_Model->Distributors($_SESSION['usertype'],$_SESSION['userid'],$dateRange);
                $data["Clients"] = $this->Customers_Model->DistributorsClients($_SESSION['usertype'],$_SESSION['userid'],$dateRange);
                // get clients
                $this->load->view('Clients/DistributorsClients', $data);
                return;
            }


//print_r("<pre>");
//print_r($data);
//print_r("</pre>");die();






        }



    }
    function deleteOrder(){
        if(!isset($_SESSION['userid'])){
            redirect(site_url("CRM_Users"));
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $orderID= $_POST['OrderID'];
            $result= $this->Orders->DeleteOrder($orderID);
            if ($result > 0){
                echo 1;
            }else{
                echo 0;
            }
        }
    }
    function updateOrder(){
        if(!isset($_SESSION['userid'])){
            redirect(site_url("CRM_Users"));
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $orderID= $_POST['OrderID'];
            $quantity= $_POST['newquantity'];
            $result= $this->Orders->UpdateOrder($orderID,$quantity);
            if ($result > 0){
                echo 1;
            }else{
                echo 0;
            }
        }
    }
    function create(){
        if(!isset($_SESSION['userid'])){
            redirect(site_url("CRM_Users"));
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $data['url'] = base_url();
            $data["title"]="إضافة عميل جديد";
            $_SESSION["PAGE"] = "Distributors";
            $this->load->view('Clients/Create', $data);
        }
    }
    function Add(){
//        print_r("<pre>");
//        print_r($_POST);
//        print_r("</pre>");die();
        if(!isset($_SESSION['userid'])){
            redirect(site_url("CRM_Users"));
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $data['url'] = base_url();
            $data["title"]="إضافة عميل جديد";
            $_SESSION["PAGE"] = "Distributors";

            if (!isset($_POST['customerCrmName']) || is_null($_POST['customerCrmName'])){
                redirect(site_url("Client/create/"));
            }
            if (!isset($_POST['customerCrmPhone']) || is_null($_POST['customerCrmPhone'])){
                redirect(site_url("Client/create/"));
            }
            $updatedData['customerCrmName']=$_POST['customerCrmName'];
            $updatedData['customerCrmAge']=$_POST['customerCrmAge'];
            $updatedData['customerCrmQualification']=$_POST['customerCrmQualification'];
            $updatedData['customerCrmGender']=($_POST['customerCrmGender']==1);
            $updatedData['customerCrmCountry']=$_POST['customerCrmCountry'];
            $updatedData['customerCrmGov']=$_POST['customerCrmGov'];
            $updatedData['customerCrmAddress']=$_POST['customerCrmAddress'];
            $updatedData['customerCrmEmail']=$_POST['customerCrmEmail'];
            $updatedData['customerCrmPhone']=$_POST['customerCrmPhone'];
            $updatedData['customerCrmSecondPhone']=$_POST['customerCrmSecondPhone'];
            $updatedData['customerCrmCompany']=$_POST['customerCrmCompany'];
            $updatedData['customerCrmJob']=$_POST['customerCrmJob'];
            $updatedData['customerCrmActivity']=$_POST['customerCrmActivity'];
            $updatedData['customerCrmOther']=$_POST['customerCrmOther'];

            $updatedData['addedby']=$_SESSION['userid'];
            $clientID=$this->Model1->addtotable('customercrm',$updatedData);

            redirect(site_url("Client/Distributors/"));
        }


    }
    function addOrder(){
        $data['url'] = base_url();
        $data["title"]="عميل";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else {
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
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
                }

                // Update call status
                //callStatus
                //callID

                $this->Model1->updatedata('crm_users_log','UserID='.$_SESSION['userid'],['Status'=>1]);
                //$this->Model1->updatedata('crm_calls','ID='.$_POST['callID'],['endcall'=>date('H:i:s'),'call_Result'=>$_POST['callStatus']]);
                $this->Employee_Taskes->updateStatus($_POST['clientid'],$_POST['callStatus'],$_SESSION['userid']);
// add comment
                if (isset($_POST['comment']) && $_POST['comment'] != null) {
                    if (isset($_POST['date']) && $_POST['date'] != null)
                        $row['date'] = $_POST['date'];
                    if (isset($_POST['time']) && $_POST['time'] != null)
                        $row['time'] = $_POST['time'];
                    $row['Comment_Text']=$_POST['comment'];
                    $row['ClientID']=$_POST['clientid'];
                    $row['UserID']=$_SESSION['userid'];
                    $this->Model1->addtotable('crm_comments',$row);
                }


                redirect(site_url("Client/Details/".$_POST['clientid']));
            }else{
                redirect(site_url("Client/Distributors"));
            }
        }

    }
    function SendSMS(){
        $data['url'] = base_url();
        $data["title"]="العملاء";
        if(!isset($_SESSION['userid'])){
            $result['errorCode'] = 1;
            $result['message']='Pleas Login First';
            echo json_encode($result);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $userID = $_SESSION['userid'];

            if ($this->Users_Model->IsMaximumSMS($userID)){
                $result['errorCode'] = 1;
                $result['message']='تم الوصول إلى الحد المسموح به لارسال الرسائل النصية اليومى';
                echo json_encode($result);
            }else{
                // Send SMS
                $clientID = $_POST['clientID'];
                $Content = $_POST['message'];
                if ($this->SMSModel->send($clientID,$Content,$userID)){
                    $result['errorCode'] = 0;
                    $result['message']='تم إرسال الرسالة بنجاح';
                    echo json_encode($result);
                }else{
                    $result['errorCode'] = 1;
                    $result['message']='حدث خطأ أثناء إرسال الرسالة';
                    echo json_encode($result);
                }

            }

        }
    }
    function SendBulkSMS(){
        $data['url'] = base_url();
        $data["title"]="العملاء";
        if(!isset($_SESSION['userid'])){
            $result['errorCode'] = 1;
            $result['message']='Pleas Login First';
            echo json_encode($result);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'09');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $userID = $_SESSION['userid'];
            $customerid = explode(",", $_POST["customerid"] );
            $ClientCount = 0;
            foreach ($customerid as $ID ){
                if ($ID !='') {
                    $ClientCount += 1;
                }
            }



            if ($this->Users_Model->IsMaximumSMS($userID,$ClientCount)){
                $result['errorCode'] = 1;
                $result['message']='تم الوصول إلى الحد المسموح به لارسال الرسائل النصية اليومى';
                echo json_encode($result);
            }else{
                // Send SMS
                $Content = $_POST['message'];
                foreach ($customerid as $ID ){
                    if ($ID !=''){
                        if (!$this->SMSModel->send($ID,$Content,$userID)){
                            $result['errorCode'] = 1;
                            $result['message']='حدث خطأ أثناء إرسال الرسالة';
                            echo json_encode($result);
                            return;
                        }
                    }

                }
                $result['errorCode'] = 0;
                $result['message']='تم إرسال الرسالة بنجاح';
                echo json_encode($result);

            }

        }
    }
    function DeContracted(){
//        print_r("<pre>");
//        print_r($_POST);
//        print_r("</pre>");die();
        // update status
        // add comment

        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('home',$data);return;
        }else {
            $client_id = $_POST['clientid'];
            $CallID = $_POST['CallID'];
            if (isset($_POST['comment']) && $_POST['comment'] != null) {
                $row['date'] = date("Y-m-d");
                $row['time'] = date("H:i:s");
                $row['Comment_Text'] = htmlspecialchars($_POST['comment']);
                $row['ClientID'] = $client_id;
                $row['UserID'] = $_SESSION['userid'];
                $row["IsFollowComment"] = false;
                $commentID = $this->Model1->addtotable('crm_comments', $row);
                $this->Model1->updatedata('crm_calls', 'ID=' . $CallID, ['endcall' => date('H:i:s'), 'call_Result' => $_POST['call_status_id'], 'CommentID' => $commentID]);
            } else {
                $this->Model1->updatedata('crm_calls', 'ID=' . $CallID, ['endcall' => date('H:i:s'), 'call_Result' => $_POST['call_status_id']]);
            }
            //Delete order
            $this->Orders->DeleteClientOrders($client_id);
            $this->Employee_Taskes->updateStatus($client_id,$_POST['call_status_id'],$_SESSION['userid']);
        }
        if (isset($_SESSION['date1'])){
            redirect('Client/Distributors/'.$_SESSION['date1'].'@'.$_SESSION['date2']);
        }else{
            redirect('Client/Distributors');
        }
    }

}
