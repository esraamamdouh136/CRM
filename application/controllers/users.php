<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class users extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        session_start();
        $this->load->model('Model1');
        $this->load->model('Employee_Taskes');
        $this->load->model('Call_Status');
        $this->load->model('Data_model');
        $this->load->model('Clients');
        $this->load->model('User_Log');
        $this->load->model('Users_Model');
        $this->load->model('Follows');
        $this->load->model('InternalMessages');
        $this->load->model('premissions');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');
    }
    public function logout()
    {
        try
        {
            $data['url'] = base_url();
            $row["usercrmStatus"]=3;
            $result=$this->Model1->updatedata("usercrm",["userCrmId"=>$_SESSION["userid"]],$row );
            $this->User_Log->LogOut($_SESSION["userid"]);
            session_destroy();
        } catch (Exception $e) {}

        redirect("users/index");
    }
    public function index($dateRange=null)
    {

        $data['url'] = base_url();
        $_SESSION["PAGE"] = "index";
        if(isset($_SESSION['userid'])){
            //   $this->sendEmail1();
            // $data["UnreadMessages"]=  $this->InternalMessages->GetUnReadMessages($_SESSION['userid'],0);
            // $data["UnreadInstructions"]=  $this->InternalMessages->GetUnReadMessages($_SESSION['userid'],1);
            if ($_SESSION['usertype'] == 1){
                //  $data["UnreadComplaints"]=  $this->InternalMessages->GetUnReadComplaint();
            }else{
                //   $data["UnreadComplaints"]=0;
            }
            $this->SetLastSeen();
            $this->CheckOfflineUser();
            $data["charts"]=1;
            $data["title"]="الصفحة الرئسية";
            if ($dateRange == null){

                $date1 =  date("Y-m-d") ;
                $date2 =  date("Y-m-d");
            }else{
                $dateArray = explode("@",$dateRange);
                $date1 =    $dateArray[0] ;
                $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
            }
            $data["date1"] = $date1 ;
            $data["date2"] = ($date2 == $date1) ? "" : $date2;
            $_SESSION['date1'] = $date1;
            $_SESSION['date2'] = $date2;

            if($_SESSION['usertype']==1)
            {
                // Admin

                $data["allData"] = $this->Employee_Taskes->GetTasksCount($date1, $date2, 0, 0);
                $data["AllNewData"] = $this->Employee_Taskes->GetTasksCount($date1, $date2, 1, 0);
                $data["buyData"] = $this->Employee_Taskes->GetTasksCount($date1, $date2, 2, 0);
                $data["hagzData"] = $this->Employee_Taskes->GetTasksCount($date1, $date2, 3, 0);
                $data["followData"] = $this->Employee_Taskes->GetTasksCount($date1, $date2, 4, 0);
                $data["UnfollowData"] = $this->Employee_Taskes->GetTasksCount($date1, $date2, 5, 0);
                $data["delayedData"] = $this->Employee_Taskes->GetTasksCount(null, null, 1, 0);
                $data["allData"]+= $data["delayedData"];
                $this->load->view('Admin/home',$data);
            }
            else if($_SESSION['usertype']==2)
            {
                // supervisor
                $data["allData"] = $this->Employee_Taskes->GetTasksCount($date1,$date2,0,$_SESSION["userid"],true);
                $data["AllNewData"]= $this->Employee_Taskes->GetTasksCount($date1,$date2,1,$_SESSION["userid"],true);
                $data["buyData"]= $this->Employee_Taskes->GetTasksCount($date1,$date2,2,$_SESSION["userid"],true);
                $data["hagzData"]= $this->Employee_Taskes->GetTasksCount($date1,$date2,3,$_SESSION["userid"],true);
                $data["followData"]= $this->Employee_Taskes->GetTasksCount($date1,$date2,4,$_SESSION["userid"],true);
                $data["UnfollowData"]= $this->Employee_Taskes->GetTasksCount($date1,$date2,5,$_SESSION["userid"],true);
                $data["delayedData"] = $this->Employee_Taskes->GetTasksCount(null, null, 1, $_SESSION["userid"],true);
                $data["allData"]+= $data["delayedData"];
                $this->load->view('Admin/home',$data);
            }
            else if($_SESSION['usertype']==3)
            {
                // Employee
                $data["allData"] = $this->Employee_Taskes->GetTasksCount($date1,$date2,0,$_SESSION["userid"]);
                $data["AllNewData"]= $this->Employee_Taskes->GetTasksCount($date1,$date2,1,$_SESSION["userid"]);
                $data["buyData"]= $this->Employee_Taskes->GetTasksCount($date1,$date2,2,$_SESSION["userid"]);
                $data["hagzData"]= $this->Employee_Taskes->GetTasksCount($date1,$date2,3,$_SESSION["userid"]);
                $data["followData"]= $this->Employee_Taskes->GetTasksCount($date1,$date2,4,$_SESSION["userid"]);
                $data["UnfollowData"]= $this->Employee_Taskes->GetTasksCount($date1,$date2,5,$_SESSION["userid"]);
                $data["delayedData"] = $this->Employee_Taskes->GetTasksCount(null, null, 1, $_SESSION["userid"]);
                $data["allData"]+= $data["delayedData"];
                $this->load->view('Admin/home',$data);
            }
        }else{
            if (!(isset($_POST['username']))){
                $this->load->view('login',$data);
            }else{
                $ed = $this->Model1->selectdata("usercrm", ["active"=>1,"userCrmUserName"=>$_POST['username'],
                    "userCrmPass"=>md5($_POST['password'])] );

                if( $ed != null ){
                    $_SESSION['email'] = $ed[0]->userCrmEmail;
                    $_SESSION['userid'] = $ed[0]->userCrmId;
                    $_SESSION['group'] = $ed[0]->usercrmGroup;
                    $_SESSION['usertype'] = $ed[0]->userCrmType;
                    $_SESSION['username']=$_POST['username'];
                    $row1["usercrmStatus"]=1;
                    $resl = $this->Model1->updatedata("usercrm",["userCrmId"=> $_SESSION['userid']],$row1 );
                    //$data["title"]="الصفحه الرئسيه";
                    $this->User_Log->Login($_SESSION["userid"]);

                    redirect(site_url("users"));
                }else{
                    $data["error"]="Wrong Username or password";
                    $this->load->view('login',$data);
                }
            }
        }
    }
    public function message()
    {
        //admin see all messages else see message he send it or recived it only

        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            $data["clients"] = $this->Model1->selectdata("customercrm", null );
            //$data["subject"] = $this->Model1->selectdata("subject", null );

            if($_SESSION['usertype']==1)
            {


                $data["sent"] = $this->Model1->getjoin("messagecrm","usercrm","messagecrm.CrmMessagesFrom=usercrm.userCrmId",
                    "Date(messagecrm.CrmMessagesCreateDate)='".date("Y-m-d")."'" );
                $data["recieved"] = NULL;

            }
            if($_SESSION['usertype']==2)
            {

                $data["sent"] = $this->Model1->getjoin("messagecrm","usercrm","messagecrm.CrmMessagesFrom=usercrm.userCrmId",
                    "Date(messagecrm.CrmMessagesCreateDate)='".date("Y-m-d")."' and usercrm.userCrmSuper=".$_SESSION["userid"] );
                $data["recieved"] = $this->Model1->getjoin("messagecrm","usercrm","messagecrm.CrmMessagesTo=usercrm.userCrmId",
                    "Date(messagecrm.CrmMessagesCreateDate)='".date("Y-m-d")."' and usercrm.userCrmSuper=".$_SESSION["userid"] );

            }
            if($_SESSION['usertype']==3)
            {

                $data["sent"] = $this->Model1->getjoin("messagecrm","usercrm","messagecrm.CrmMessagesFrom=usercrm.userCrmId",
                    "Date(messagecrm.CrmMessagesCreateDate)='".date("Y-m-d")."' and usercrm.userCrmSuper=".$_SESSION["userid"] );
                $data["recieved"] = $this->Model1->getjoin("messagecrm","usercrm","messagecrm.CrmMessagesTo=usercrm.userCrmId",
                    "Date(messagecrm.CrmMessagesCreateDate)='".date("Y-m-d")."' ");

            }
            $data["title"]="الرسائل";
            $this->load->view('messages',$data);

        }
    }
    public function client($i,$dateRange)
    {

        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{

            if($i==1 || $i == 2 || $i == 3 || $i == 4 )
            {
                if($i == 1){
                    $_SESSION["PAGE"] = "follow";
                }

                if ($dateRange == null){
                    $date1 =  date("Y-m-d") ;
                    $date2 =  date("Y-m-d");
                }else{
                    $dateArray = explode("@",$dateRange);
                    //print_r($dateArray);die();
                    $date1 =    $dateArray[0] ;
                    $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                }
                $data["date1"] = $date1 ;
                $data["date2"] = $date2;

                $data["statusData"] = $i;
//                print_r($data["statusData"]);die();
                $data["chartsData"]=2;
                $data["dateRange"]=$dateRange;
                $data["statusCrm"] = $this->Model1->selectdata("statuscrm" , ["statusCrmfilter"=>$i] );
                $selectType = 0;
                switch ($i){
                    case 1:
                        $selectType = 4;
                        break;
                    case 2:
                        $selectType = 3;
                        break;
                    case 3:
                        $selectType = 5;
                        break;
                    case 4:
                        $selectType = 2;
                        break;
                }

                if($_SESSION["usertype"]==1)
                {
                    // Login as admin
                    $data["clients"] = $this->Employee_Taskes->GetUserFollows($date1,$date2,$selectType,$_SESSION['userid'],0);
                    $data["ClientCount"] = isset($data["clients"]) ? count($data["clients"]) : 0;
                    $data['statusCrm'] = $this->Call_Status->GetCallStatus($selectType);
                    for ($i=0;$i < count($data['statusCrm']);$i++){
                        $count = $this->Employee_Taskes->GetTasksCountForclient($date1,$date2,$data['statusCrm'][$i]->id,0);
                        $data["statusCount"][] = isset($count) ? $count : 0;
                    }
                }
                elseif($_SESSION["usertype"]==2)
                {
                    $data["clients"] = $this->Employee_Taskes->GetUserFollows($date1,$date2,$selectType,$_SESSION['userid'],1);
                    $data["ClientCount"] = isset($data["clients"]) ? count($data["clients"]) : 0;

                    $data['statusCrm'] = $this->Call_Status->GetCallStatus($selectType);

                    for ($i=0;$i < count($data['statusCrm']);$i++){
                        $count = $this->Employee_Taskes->GetTasksCountForclient($date1,$date2,$data['statusCrm'][$i]->id,$_SESSION['userid'],true);
                        $data["statusCount"][] = isset($count) ? $count : 0;
                    }

                }
                else
                {

                    $data["clients"] = $this->Employee_Taskes->GetUserFollows($date1,$date2,$selectType,$_SESSION['userid'],2);
                    $data["ClientCount"] = isset($data["clients"]) ? count($data["clients"]) : 0;

                    $data['statusCrm'] = $this->Call_Status->GetCallStatus($selectType);

                    for ($i=0;$i < count($data['statusCrm']);$i++){
                        $count = $this->Employee_Taskes->GetTasksCountForclient($date1,$date2,$data['statusCrm'][$i]->id,$_SESSION['userid']);
                        $data["statusCount"][] = isset($count) ? $count : 0;
                    }


                }
            }
            if($_SESSION["usertype"]==1 )
            {
                $data["emps"]= $this->Model1->selectdata("usercrm", "active=1 and userCrmType!=1",null);
            }elseif ($_SESSION["usertype"]==2){
                $data["emps"]= $this->Model1->selectdata("usercrm", "active=1 and userCrmType=3 and userCrmSuper=".$_SESSION["userid"],null);
            }

//            print_r("<pre>");
//            print_r($data);
//            print_r("</pre>");die();

            $data["title"]="العملاء";
            $this->load->view('Admin/clients',$data);
        }
    }
    public function clientviewBydate($dateRange){
        $data['url'] = base_url();
        $_SESSION["PAGE"] = "index";
        $data["title"]="الصفحة الرئسية";
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            if ($dateRange == null){
                $date1 =  date("Y-m-d") ;
                $date2 =  date("Y-m-d");
            }else{
                $dateArray = explode("@",$dateRange);
                //print_r($dateArray);die();
                $date1 =    $dateArray[0] ;
                $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
            }
            $data["date1"] = $date1 ;
            $data["date2"] = $date2;

            if(emails_view==1)
            {
                // admin
                $data["clients"] = $this->Employee_Taskes->GetUserClients($date1,$date2,1,$_SESSION['userid'],0);
            }
            elseif($_SESSION["usertype"]==2)
            {
                //supervisor
                $data["clients"] = $this->Employee_Taskes->GetUserClients($date1,$date2,1,$_SESSION['userid'],1);
            }
            else
            {
                // employee
                $data["clients"] = $this->Employee_Taskes->GetUserClients($date1,$date2,1,$_SESSION['userid'],2);
            }
            $this->load->view("Admin/clients_view_date",$data);
        }
    }
    public function clients_view($dateRange = null)
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            if ($dateRange == null){
                $date1 =  date("Y-m-d") ;
                $date2 =  date("Y-m-d");
            }else{
                $dateArray = explode("@",$dateRange);
                $date1 =    $dateArray[0] ;
                $date2 = (is_null($dateArray[1]) || !isset($dateArray[1]) ||$dateArray[1] =="" ) ?  date("Y-m-d") : $dateArray[1] ;
            }
            $data["date1"] = $date1 ;
            $data["date2"] = ($date2 == $date1) ? "" : $date2;


            // get User Clients

            $UserID = $_SESSION["userid"];

            $UserType = $_SESSION["usertype"];
            $data["clients"] = $this->Clients->GetCurrentClients($UserID,$UserType);
//print_r("<pre>");
//print_r($data);
//print_r("</pre>");die();
            $_SESSION["PAGE"] = "clients_view";
            $data["title"]="العملاء";

            $this->load->view('Admin/clients_view',$data);
        }
    }
    public function message_view()
    {
        $data['url'] = base_url();
        $_SESSION["PAGE"] = "message_view";
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            $data["clients"] = $this->Model1->selectdata("usercrm", "userCrmType=2");
            $data["users"] = $this->Model1->selectdata("usercrm", "userCrmId!=".$_SESSION['userid'] );
            $data["recieved"] =  $this->InternalMessages->GetUserMessage($_SESSION['userid'],1,0);
            $data["sent"] =  $this->InternalMessages->GetUserMessage($_SESSION['userid'],0,0);
            $this->InternalMessages->UpdateMessageStatus($_SESSION['userid'],0);
            $data["title"]="الرسائل";
            $this->load->view('messages',$data);
        }
    }
    public function groups_view()
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            $data["title"]="المجموعات";
            $this->load->view('groups',$data);
        }
    }
    public function emails_view()
    {
        $data['url'] = base_url();
        $_SESSION["PAGE"] = "emails_view";
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'07');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $per = $this->premissions->get_premissions($_SESSION['userid'],"07");

            if($_SESSION["usertype"]==2)
            {
                $data["sent"] = $this->Model1->selectdata("crm_mails","DeleteForSupervisor =0 and (UserID=".$_SESSION["userid"]." or UserID in (select ID from crm_users where Super=".$_SESSION["userid"]."))");
            }else if ($_SESSION["usertype"]==3){
                if ($per == 1){
                    $data["sent"] = $this->Model1->selectdata("crm_mails","DeleteForAdmin = 0");
                }else{
                    $data["sent"] = $this->Model1->selectdata("crm_mails","DeleteForEmployee = 0");
                }
            }else if ($_SESSION["usertype"]==4){
                if ($per == 1){
                    $data["sent"] = $this->Model1->selectdata("crm_mails","DeleteForAdmin = 0");
                }
            }else if($_SESSION["usertype"]==1 )
            {
                $data["sent"] = $this->Model1->selectdata("crm_mails","DeleteForAdmin = 0");
            }

            $data["title"]="الايميلات";
            $this->load->view('emails',$data);
        }
    }
    public function instr_view()
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            $_SESSION["PAGE"] = "instr_view";
            $data["users"] = $this->Model1->selectdata("crm_users", "Type!=1" );

            if($_SESSION["usertype"]==1)
            {
                $data["sent"] = $this->InternalMessages->GetUserMessage($_SESSION['userid'],5,true);
                $data["recieved"]=NULL;
                $data["users"] = $this->Model1->selectdata("crm_users", "Type!=1" );
            }
            if($_SESSION["usertype"]!=1)
            {
                $data["recieved"] =  $this->InternalMessages->GetUserMessage($_SESSION['userid'],5,false);
                $data["sent"] =  $this->InternalMessages->GetUserMessage($_SESSION['userid'],5,true);
//print_r("<pre>");
//print_r($data);
//print_r("</pre>");die();
                if ($_SESSION["usertype"] == 2){
                    $data["users"] = $this->Model1->selectdata("crm_users", "Type!=1 and Super=".$_SESSION['userid'] );
                }
            }
            $this->InternalMessages->UpdateMessageStatus($_SESSION['userid'],1);
            $data["title"]="التعليمات";
            $this->load->view('instructions',$data);
        }
    }
    public function send_instr()
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            $data["clients"] = $this->Model1->selectdata("customercrm", null );
            $data["title"]="ارسال تعليمات";
            $data["multi"]=1;
            $this->load->view('Admin/send_instr',$data);
        }
    }
    public function edit_instr()
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{

            $data["clients"] = $this->Model1->selectdata("customercrm", null );
            $data["title"]="تعديل تعليمات";
            $data["multi"]=1;
            $this->load->view('Admin/edit_instr',$data);

            // }
        }
    }

    private function get_premissions($userid,$objCode)
    {
        $CI = &get_instance();
        $CI->load->model("Model1");
        $result= $CI->Model1->selectdata("crm_users_permissions",["UserID"=>$userid,"Object_Code"=>$objCode],null);
        if($result==NULL)
        {
            return 0;
        }else{
            return $result[0]->IsGranted;
        }

    }

    public function change_view()
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($this->get_premissions($_SESSION['userid'],'10') ==1 || $_SESSION['usertype'] == 1){
                $_SESSION["PAGE"] = "change_view";
                $data["clients"] = $this->Model1->selectdata("customercrm", null );
                $data["changes"]=$this->Model1->selectdata("changecrm", null );
                $data["settings"]=$this->Model1->selectdata("settingcrm", null );
                $data["noanswer"]=$this->Model1->selectdata("call_status", ["type"=>2] );
                $data["answer"]=$this->Model1->selectdata("call_status", "type=1 and status!=3" );
                $data["reserve"]=$this->Model1->selectdata("call_status", "type=1 and status=3");

                $data["wrongData"]=$this->Model1->selectdata("call_status", ["type"=>3] );
                $data["showContracted"]=$this->Model1->selectdata("call_status", ["type"=>4] );
                $data["showDeContracted"]=$this->Model1->selectdata("call_status", ["type"=>5] );

                $data["title"]="تغير المحتوي";
                $data["calltable"]=1;
                $data["notifyTime"]=$this->Users_Model->GetNotifyTime();

                $this->load->view('Admin/change_content',$data);
            }else{
                redirect(site_url("CRM_Users"));
            }


        }
    }
    public function update_company()
    {

        if ($_SESSION['usertype'] ==  4){
            $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
            if  ($Reports !=1){
                redirect(site_url("CRM_Users"));return;
            }
        }
        $data['url'] = base_url();
        if (isset($_FILES['fileToUpload']) && !empty($_FILES['fileToUpload'])){
            $uploadPath = 'design/assets/images/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] ='settingcrmLogo';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('fileToUpload')) {
                // Uploaded file data
                $fileData = $this->upload->data();
                $row["settingcrmLogo"]= $fileData['file_name'];
            }
        }
        if (isset($_FILES['fileToUpload2']) && !empty($_FILES['fileToUpload2'])){
            $uploadPath = 'design/assets/images/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] ='loginbg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('fileToUpload2')) {
                // Uploaded file data
                $fileData = $this->upload->data();
                $row["loginbg"]= $fileData['file_name'];
            }
        }
        $data['msg'] = "تم التعديل بنجاح";
        $data['error'] = false;
        if (isset($row)){
            $res = $this->Model1->updatedata("settingcrm",["1"=>1],$row );
        }
        redirect(site_url("users/company_data"));
    }
    public function company_data()
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }

            $_SESSION["PAGE"] = "company_data";
            $data["company"] = $this->Model1->selectdata("settingcrm", null );
            $data["title"]=" معلومات عن الشركة";
            $data["calltable"]=1;
            $data["select"]=1;
            $this->load->view('Admin/company_data',$data);
        }
    }
    public function reservations_view()
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            $_SESSION["PAGE"] = "reservations_view";
            $data["products"] = $this->Model1->selectdata("productcrm", ["ProductCrmType"=>1] );
            $data["services"] = $this->Model1->selectdata("productcrm", ["ProductCrmType"=>2] );
            $data["trucks"] = $this->Model1->selectdata("productcrm", ["ProductCrmType"=>3] );

            $data["title"]=" الحجوزات";
            $data["calltable"]=1;
            $this->load->view('reservations',$data);

            // }
        }
    }
    public function complains_view()
    {

        $data['url'] = base_url();
        $_SESSION["PAGE"] = "complains_view";
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            $data["clients"] = $this->Model1->selectdata("customercrm", null );
            //$data["subject"] = $this->Model1->selectdata("subject", null );
            $data["subject"] = $this->Model1->selectdata("subject", null );
            $per=get_pre($_SESSION["userid"],7);

            if($_SESSION["usertype"]==1 || $per==1)
            {
                // get all data
//                $data["sent"] = $this->Model1->selectdata("messagecrm",
//                    "complain=1 and CrmMessagesType=4" );
//                $data["recieved"]=$this->Model1->selectdata("messagecrm",
//                    "complain=2 and CrmMessagesType=4" );
// send => client
// received => employee
                $data["sent"] = $this->InternalMessages->GetUserComplaint(1);
                $data["recieved"]=$this->InternalMessages->GetUserComplaint(0);


            }
            else if($_SESSION["usertype"]!=1)
            {
//                $data["sent"] = $this->Model1->selectdata("messagecrm",
//                    "complain=1 and CrmMessagesFrom=".$_SESSION["userid"]." and CrmMessagesType=4" );
//                $data["recieved"] = $this->Model1->selectdata("messagecrm",
//                    "complain=2 and CrmMessagesFrom=".$_SESSION["userid"]." and CrmMessagesType=4" );
                // get user data only
                $data["sent"] = $this->InternalMessages->GetUserComplaint(1,$_SESSION["userid"]);
                $data["recieved"]=$this->InternalMessages->GetUserComplaint(0,$_SESSION["userid"]);
            }

            $data["calltable"]=1;
            $data["users"] = $this->Model1->selectdata("usercrm", "userCrmType!=1" );
            $this->InternalMessages->UpdateComplaintStatus();
            $data["title"]="الشكاوي";
            $this->load->view('complains',$data);

            // }
        }

    }
    public function adduser()//to retrive adduser view
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            $data["supers"] = $this->Model1->selectdata("usercrm", ["userCrmType"=>2] );
            $data["title"]="اضافه موظف";
            $this->load->view('emp_data',$data);
        }
    }
    public function addsuper()//to retrive adduser view
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['email'])){
            $this->load->view('login',$data);
        }else{
            $data["title"]="اضافه مشرف";
            $data["super"]=1;
            $this->load->view('emp_data',$data);
        }
    }
    public function updateUser()
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('home',$data);
        }else{
            $data['url'] = base_url();


            if (!(empty($_POST['name'])) && !(empty($_POST['phone'])) && !(empty($_POST['email']))
                && !(empty($_POST['birthdate'])) && !(empty($_POST['job']))
                && !(empty($_POST['joinDate'])) && !(empty($_POST['salary']))
                && !(empty($_POST['username']))){

                $user = $this->Model1->selectdata("usercrm","(userCrmEmail='".$_POST['email']."' and userCrmId!=".$_POST["userid"].")
                                                     or (userCrmUserName='".$_POST['username']."' and userCrmId!=".$_POST["userid"].")");
                if($user==NULL)
                {
                    $row["userCrmName"]=$_POST['name'];
                    $row["userCrmPhone"]=$_POST['phone'];
                    $row["userCrmEmail"]=$_POST['email'];
                    $row["userCrmBirthDate"]=$_POST['birthdate'];
                    $row["userCrmType"]=$_POST['job'];
                    $row["userCrmJoinDate"]=$_POST['joinDate'];
                    $row["userCrmSalary"]=$_POST['salary'];
                    $row["userCrmAnnInc"]=$_POST['annualInc'];
                    $row["userCrmSuper"]=$_POST['supervisor'];
                    $row["userCrmSellInc"]=$_POST['target'];
                    $row["userCrmUserName"]=$_POST['username'];

                    if (str_replace(' ', '',$_POST['password']) != "" ){
                        $row["userCrmPass"]=md5($_POST['password']);
                    }

                    $row["userCrmAddress"]=$_POST['address'];
                    $cond["userCrmId"]=$_POST["userid"];
                    $result=$this->Model1->updatedata("usercrm",$cond,$row );
                    $row=NULL;

                    $row["permissionuser"]=$_POST["userid"];
                    $result=$this->Model1->removefromtable("permissioncrm",$row );

                    if(isset($_POST['alerts']))
                    {
                        $row["permissionid"]=1;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }
                    if(isset($_POST['acceptmess']))
                    {
                        $row["permissionid"]=2;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }
                    if(isset($_POST['uploadfile']))
                    {
                        $row["permissionid"]=3;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }
                    if(isset($_POST['assigntask']))
                    {
                        $row["permissionid"]=4;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }
                    if(isset($_POST['pemp']))
                    {
                        $row["permissionid"]=5;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }
                    if(isset($_POST['psuper']))
                    {
                        $row["permissionid"]=6;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }
                    if(isset($_POST['complains']))
                    {
                        $row["permissionid"]=7;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }
                    if(isset($_POST['instr']))
                    {
                        $row["permissionid"]=8;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }
                    if(isset($_POST['services']))
                    {
                        $row["permissionid"]=9;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }
                    if(isset($_POST['databas']))
                    {
                        $row["permissionid"]=10;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }
                    if(isset($_POST['reports']))
                    {
                        $row["permissionid"]=11;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }
                    if(isset($_POST['panel']))
                    {
                        $row["permissionid"]=12;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }
                    if(isset($_POST['company']))
                    {
                        $row["permissionid"]=13;
                        $res=$this->Model1->addtotable("permissioncrm",$row );

                    }

                    echo 1;
                }
                else
                {
                    echo 2;
                }
            }else{

                echo 3;


            }

        }
    }
    //function to insert user into crmUser Not implemented
    public function add_user()
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('home',$data);
        }else{
            $data['url'] = base_url();
            if (1==1){


                if (!(empty($_POST['name'])) && !(empty($_POST['phone'])) && !(empty($_POST['email']))
                    && !(empty($_POST['job'])) && !(empty($_POST['username'])) && !(empty($_POST['password'])) )
                {
                    $user = $this->Model1->selectdata("usercrm","userCrmEmail='".$_POST['email']."' 
                                                        or userCrmUserName='".$_POST['username']."'");
                    if($user==NULL)
                    {
                        $row["userCrmName"]=$_POST['name'];
                        $row["userCrmPhone"]=$_POST['phone'];
                        $row["userCrmEmail"]=$_POST['email'];
                        if(!empty($_POST['birthdate']))
                        {
                            $row["userCrmBirthDate"]=$_POST['birthdate'];
                        }
                        if(!empty($_POST['job']))
                        {
                            $row["userCrmType"]=$_POST['job'];
                        }
                        if(!empty($_POST['joinDate']))
                        {
                            $row["userCrmJoinDate"]=$_POST['joinDate'];
                        }
                        if(!empty($_POST['salary']))
                        {
                            $row["userCrmSalary"]=$_POST['salary'];
                        }
                        if(!empty($_POST['annualInc']))
                        {
                            $row["userCrmAnnInc"]=$_POST['annualInc'];
                        }

                        $row["userCrmSuper"]=$_POST['supervisor'];
                        if(!empty($_POST['target']))
                        {
                            $row["userCrmSellInc"]=$_POST['target'];
                        }

                        $row["userCrmUserName"]=$_POST['username'];
                        $row["userCrmPass"]=md5($_POST['password']);
                        if(!empty($_POST['address']))
                        {
                            $row["userCrmAddress"]=$_POST['address'];
                        }
                        if(!empty($_POST['nmess']))
                        {
                            $row["num_message"]=$_POST['nmess'];

                        }

                        $result=$this->Model1->addtotable("usercrm",$row );
                        $row=NULL;
                        $row["permissionuser"]=$result;

                        if(isset($_POST['alerts']))
                        {
                            $row["permissionid"]=1;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }
                        if(isset($_POST['acceptmess']))
                        {
                            $row["permissionid"]=2;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }
                        if(isset($_POST['uploadfile']))
                        {
                            $row["permissionid"]=3;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }
                        if(isset($_POST['assigntask']))
                        {
                            $row["permissionid"]=4;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }
                        if(isset($_POST['pemp']))
                        {
                            $row["permissionid"]=5;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }
                        if(isset($_POST['psuper']))
                        {
                            $row["permissionid"]=6;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }
                        if(isset($_POST['complains']))
                        {
                            $row["permissionid"]=7;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }
                        if(isset($_POST['instr']))
                        {
                            $row["permissionid"]=8;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }
                        if(isset($_POST['services']))
                        {
                            $row["permissionid"]=9;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }
                        if(isset($_POST['databas']))
                        {
                            $row["permissionid"]=10;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }
                        if(isset($_POST['reports']))
                        {
                            $row["permissionid"]=11;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }
                        if(isset($_POST['panel']))
                        {
                            $row["permissionid"]=12;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }
                        if(isset($_POST['company']))
                        {
                            $row["permissionid"]=13;
                            $res=$this->Model1->addtotable("permissioncrm",$row );

                        }

                        $data["success"]="تم اضافه المستخدم بنجاح";
                    }
                    else
                    {
                        $data["error"]= "عذرا هذا البريد الالكتروني او اسم المستخدم موجود من قبل";
                    }
                }else{

                    $data["error"]= "يجب ادخال  كل البيانات";


                }
                $data["supers"] = $this->Model1->selectdata("usercrm", "userCrmType=2" );
                $data["title"]="اضافه مستخدم";
                $this->load->view('emp_data',$data);
            }

        }
    }
    public function edit_user($userid)
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){

            $this->load->view('login',$data);
        }
        else
        {
            $data["title"]="تعديل المستخدم";
            $data["user"]=$this->Model1->selectdata("usercrm",["userCrmId"=>$userid]);
            $data['userid'] = $userid ;
            $data["supers"]=$this->Model1->selectdata("usercrm",["userCrmType"=>2]);
            if($data["user"][0]->userCrmType==2)
            {
                $data["super"]=1;
            }

//            print_r("<pre>");
//            print_r($data);
//            print_r("<pre>");die();
            $this->load->view('edit_emp',$data);

        }
    }
    public function delete()
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){

            $this->load->view('login',$data);
        }
        else
        {

            if( !empty($_POST["userid"]) ){
                $cond["userCrmId"]=$_POST["userid"];
                $row["active"]=0;
                if($_POST["status"]==0)
                {
                    $row["active"]=1;
                }

                $result=$this->Model1->updatedata("usercrm",$cond, $row);
                echo $result;


            }
            else
            {
                echo 0;
            }
        }
    }
    //function to update user
    public function update_user()
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            $data['url'] = base_url();
            $user = $this->Model1->selectdata("crm_users", ["ID"=>$_SESSION['userid']]);
//            print_r("<pre>");
//            print_r($user);
//            print_r("</pre>");
//            die();
            if ( !(empty($_POST['uname'])) && !(empty($_POST['pass']))){

                if($user!=NULL)
                {
                    $row["UserName"]=$_POST['uname'];
                    $row["Pass"]=md5($_POST['pass']);
                    $cond["ID"]=$_SESSION["userid"];
                    $_SESSION["username"]=$_POST['uname'];
                    $this->load->helper("file");
                    $config['upload_path']          = 'ProfielsImages/';
                    $config['allowed_types']        = 'jpg|png';
                    $config['file_name']             = $_POST['uname'];
                    $this->load->library('upload', $config);
                    $this->upload->overwrite = true;
                    if ($this->upload->do_upload('imgInp') )
                    {
                        $error = array('error' => $this->upload->display_errors());
                        $data['error'] = true;
                        $data['msg'] = $error;
                        $data['data'] = array('upload_data' => $this->upload->data());
                        $row["Image"]=$data['data']['upload_data']["orig_name"];
                        //echo $error;die();
                    }
                    $result=$this->Model1->updatedata("crm_users",$cond,$row );
                    // print_r($result);die();
                    $data["updated"]="تم التعديل بنجاح";
                }
                else
                {
                    $data["error"]="هذا المستخدم موجود من قبل";
                }
            }else{
                $data["error"]="يجب عليك ادخال اسم المستخدم وكلمه السر";
            }
            $data["title"]="تعديل البيانات";
            $data["user"] = $user;
            redirect(site_url("users/edituser"));return;

        }
    }
    //function to delete user
    public function delete_user()
    {
        if(isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('home',$data);
        }else{
            $data['url'] = base_url();
            if ( !(empty($_POST['userid']))){

                $cond["userCrmId"]=$_POST["userid"];
                $result=$this->load->removefromtable("usercrm",$cond);
                echo "employee deleted Successfully";
            }else{

                echo "some thing is wrong";


            }
        }
    }
    public function get_empsuper()
    {

        if($_POST["type"]!=1)
        {
            $emps = $this->Model1->selectdata("usercrm", "userCrmType=".$_POST["type"] );
        }
        else
        {
            //$emps = $this->Model1->selectdata("customercrm", null );
        }
        echo json_encode($emps);
    }
    public function userinfo()
    {
        $data['url'] = base_url();
        $data["title"]="عرض البيانات";
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            $data["user"] = $this->Model1->selectdata("crm_users", ["ID"=>$_SESSION['userid']]);

//            print_r("<pre>");
//            print_r($data);
//            print_r("</pre>");
//            die();
            $this->load->view('profile',$data);


        }
    }
    public function edituser()
    {
        $data['url'] = base_url();
        $data["title"]="تعديل البيانات";
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            $data["user"] = $this->Model1->selectdata("crm_users", ["ID"=>$_SESSION['userid']]);

//            print_r("<pre>");
//            print_r($data);
//            print_r("</pre>");
//            die();
            $this->load->view('edit_profile',$data);


        }
    }
    public function getClientData($dateRange = null) //type for emp or super
    {
        if(isset($_SESSION['userid'])){
            if ($dateRange == null){

                $date1 =  date("Y-m-d") ;
                $date2 =  date("Y-m-d");
            }else{
                $dateArray = explode("@",$dateRange);
                //print_r($dateArray);die();
                $date1 =    $dateArray[0] ;
                $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
            }

            if($_SESSION['usertype']==1)
            {
                $this->db->group_by("fage");
                $this->db->select("COUNT( fage ) as CountData ,fage as title  ");
                $data["CountAge"] = $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    ["statuscrm.statusCrmfilter" => 4 ,"date(customercrm.customerCrmCreateDate) >= "=>$date1 ,"date(customercrm.customerCrmCreateDate) <= "=> $date2  ] );

                $this->db->group_by("ftype");
                $this->db->select("COUNT( ftype ) as CountData ,ftype as title ");
                $data["CountType"] = $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    ["statuscrm.statusCrmfilter" => 4 ,"date(customercrm.customerCrmCreateDate) >= "=>$date1 ,"date(customercrm.customerCrmCreateDate) <= "=> $date2  ] );

                $this->db->group_by("customerCrmGov");
                $this->db->select("COUNT( customerCrmGov ) as CountData ,customerCrmGov as title ");
                $data["CountPlace"] = $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    ["statuscrm.statusCrmfilter" => 4 ,"date(customercrm.customerCrmCreateDate) >= "=>$date1 ,"date(customercrm.customerCrmCreateDate) <= "=> $date2  ] );

                $this->db->group_by("fqualify");
                $this->db->select("COUNT( fqualify ) as CountData ,fqualify as title ");
                $data["CountQualify"] = $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    ["statuscrm.statusCrmfilter" => 4 ,"date(customercrm.customerCrmCreateDate) >= "=>$date1 ,"date(customercrm.customerCrmCreateDate) <= "=> $date2  ] );

            }
            else if($_SESSION['usertype']==2)
            {
                $this->db->group_by("fage");
                $this->db->select("COUNT( fage ) as CountData ,fage  as title");
                $data["CountAge"] = $this->Model1->getjoin3table("customercrm" , "statuscrm" , "usercrm", "customercrm.Callstatus=statuscrm.statusCrmId", "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    "(customercrm.customerCrmEmp = ".$_SESSION["userid"]." OR customercrm.customerCrmSuper = ".$_SESSION["userid"]." OR usercrm.userCrmSuper =
                    ".$_SESSION["userid"]." ) AND statuscrm.statusCrmfilter=4 AND date(customerCrmCreateDate) >= '".$date1."'  AND date(customerCrmCreateDate) <='".$date2."'"   ) ;

                $this->db->group_by("ftype");
                $this->db->select("COUNT( ftype ) as CountData ,ftype  as title");
                $data["CountType"] = $this->Model1->getjoin3table("customercrm" , "statuscrm" , "usercrm", "customercrm.Callstatus=statuscrm.statusCrmId", "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    "(customercrm.customerCrmEmp = ".$_SESSION["userid"]." OR customercrm.customerCrmSuper = ".$_SESSION["userid"]." OR usercrm.userCrmSuper =
                    ".$_SESSION["userid"]." ) AND statuscrm.statusCrmfilter=4 AND date(customerCrmCreateDate) >= '".$date1."'  AND date(customerCrmCreateDate) <='".$date2."'"   ) ;

                $this->db->group_by("customerCrmGov");
                $this->db->select("COUNT( customerCrmGov ) as CountData ,customerCrmGov  as title");
                $data["CountPlace"] = $this->Model1->getjoin3table("customercrm" , "statuscrm" , "usercrm", "customercrm.Callstatus=statuscrm.statusCrmId", "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    "(customercrm.customerCrmEmp = ".$_SESSION["userid"]." OR customercrm.customerCrmSuper = ".$_SESSION["userid"]." OR usercrm.userCrmSuper =
                    ".$_SESSION["userid"]." ) AND statuscrm.statusCrmfilter=4 AND date(customerCrmCreateDate) >= '".$date1."'  AND date(customerCrmCreateDate) <='".$date2."'"   ) ;


                $this->db->group_by("fqualify");
                $this->db->select("COUNT( fqualify ) as CountData ,fqualify as title ");
                $data["CountQualify"] = $this->Model1->getjoin3table("customercrm" , "statuscrm" , "usercrm", "customercrm.Callstatus=statuscrm.statusCrmId", "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    "(customercrm.customerCrmEmp = ".$_SESSION["userid"]." OR customercrm.customerCrmSuper = ".$_SESSION["userid"]." OR usercrm.userCrmSuper =
                    ".$_SESSION["userid"]." ) AND statuscrm.statusCrmfilter=4 AND date(customerCrmCreateDate) >= '".$date1."'  AND date(customerCrmCreateDate) <='".$date2."'"   ) ;

            }
            else if($_SESSION['usertype']==3)
            {
                $this->db->group_by("fage");
                $this->db->select("COUNT( fage ) as CountData ,fage  as title");
                $data["CountAge"] = $this->Model1->selectdata("customercrm" ,
                    ["customercrm.customerCrmEmp"=>$_SESSION["userid"],"date(customerCrmCreateDate) >= "=>$date1
                        ,"date(customerCrmCreateDate) <= "=> $date2 ] ) ;

                $this->db->group_by("ftype");
                $this->db->select("COUNT( ftype ) as CountData ,ftype as title ");
                $data["CountType"] = $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    ["customercrm.customerCrmEmp"=>$_SESSION["userid"],"statuscrm.statusCrmfilter" => 4 ,"date(customercrm.customerCrmCreateDate) >= "=>$date1 ,"date(customercrm.customerCrmCreateDate) <= "=> $date2  ] ) ;

                $this->db->group_by("customerCrmGov");
                $this->db->select("COUNT( customerCrmGov ) as CountData ,customerCrmGov as title ");
                $data["CountPlace"] = $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    ["customercrm.customerCrmEmp"=>$_SESSION["userid"],"statuscrm.statusCrmfilter" => 4 ,"date(customercrm.customerCrmCreateDate) >= "=>$date1 ,"date(customercrm.customerCrmCreateDate) <= "=> $date2  ] ) ;

                $this->db->group_by("fqualify");
                $this->db->select("COUNT( fqualify ) as CountData ,fqualify as title ");
                $data["CountQualify"] = $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    ["customercrm.customerCrmEmp"=>$_SESSION["userid"],"statuscrm.statusCrmfilter" => 4 ,"date(customercrm.customerCrmCreateDate) >= "=>$date1 ,"date(customercrm.customerCrmCreateDate) <= "=> $date2  ] ) ;

            }
            echo json_encode($data);
        }else{
            $data["error"] = true;
            echo json_encode($data);
        }
    }
    public function getstatus()
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            $UserType = $_SESSION['usertype'];
            $UserID = $_SESSION['userid'];
            $stat[0] =intval($this->User_Log->GetUserStatus(2,1,$UserType,$UserID)); // مشرف مفعال
            $stat[1] =intval($this->User_Log->GetUserStatus(2,2,$UserType,$UserID)); // مشرف غير فعال
            $stat[2] =intval($this->User_Log->GetUserStatus(2,3,$UserType,$UserID)); // مشرف فى مكالمة
            $stat[3] =intval($this->User_Log->GetUserStatus(3,1,$UserType,$UserID)); // موظف فعال
            $stat[4] =intval($this->User_Log->GetUserStatus(3,2,$UserType,$UserID)); // موظف غير فعال
            $stat[5] =intval($this->User_Log->GetUserStatus(3,3,$UserType,$UserID)); // موظف فى مكالمة
        }
        echo json_encode($stat);
    }
    //get all overdues calls
    public function dueCall()//to retrive adduser view
    {
        if(isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            //first you must check if user has premission to add user or not
            //   [0:notall,1:add,2:edit,3:delete,4:add and edit ,5:edit and delete,6:add and delete,7:all]
            // userpage=1

            $stop_date = date('Y-m-d H:i:s');
            $stat=$this->load->get_three_join("usercrm","customercrm","callcrm","usercrm.userCrmId=customercrm.customerCrmEmp",
                "customercrm.customerCrmId=callcrm.callCrmCutomer",
                "usercrm.usercrmStatus=1 and callCrmStatusId=3 and callcrm.callCrmDate<'".$stop_date."'");



        }
    }
    public function delmess()
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            $data['url'] = base_url();
            if ( !(empty($_POST['messid']))){
                $cond["CrmMessagesId"]=$_POST["messid"];
                // print_r($cond);die();
                $result=$this->Model1->removefromtable("messagecrm",$cond);
                echo 1;
            }else{

                echo 0;


            }
        }
    }
    public function delproduct()
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            $data['url'] = base_url();
            if ( !(empty($_POST['messid']))){

                $cond["ProductCrmId"]=$_POST["messid"];
                $result=$this->Model1->removefromtable("productcrm",$cond);
                echo 1;
            }else{

                echo 0;


            }
        }
    }
    public function delstatus()
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            $data['url'] = base_url();
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ( !(empty($_POST['messid']))){
                $cond["id"]=$_POST["messid"];
                $StatCond["Status"]=$_POST["messid"];
                $status = $this->Model1->selectdata('employees_tasks',$StatCond);

                if (isset($status) && $status !=null){
                    if (count($status) >0){
                        echo 0;
                    }else{
                        $result=$this->Model1->removefromtable("call_status",$cond);
                        if ($result == "ERROR")
                            echo 0;
                        else
                            echo 1;
                    }
                }else{

                    $result=$this->Model1->removefromtable("call_status",$cond);

                    if ($result == "ERROR")
                        echo 0;
                    else
                        echo 1;
                }
            }else{
                echo 0;
            }
        }
    }
    public function updatestatus()
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            $data['url'] = base_url();
            if ( !(empty($_POST["id"])) &&!(empty($_POST["StatusName"]) )){

                $where['id'] = $_POST["id"];
                $valuse['title'] = $_POST["StatusName"];
                $status = $this->Model1->updatedata('call_status',$where,$valuse);
                if ($status == "ERROR")
                    echo 0;
                else
                    echo 1;

            }else{
                echo 0;

            }
        }
    }
    //send allert to employee
    public function sendAllert($callid)//to retrive adduser view
    {
        if(isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            //first you must check if user has premission to add user or not
            //   [0:notall,1:add,2:edit,3:delete,4:add and edit ,5:edit and delete,6:add and delete,7:all]
            // userpage=1

            $stop_date = date('Y-m-d H:i:s');
            $stat=$this->load->updatedata("callcrm", ["callCrmId"=>$callid],["callcrmAllert"=>1]);


        }
    }
    //delegte call new  employee
    public function delgete($cutomerid,$supervisor=null,$emp=null,$note=null,$date=null)//to retrive adduser view
    {
        if(isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            if($supervisor!=NULL)
            {
                $data["customerCrmSuper"]=$supervisor;
            }
            if($emp!=NULL)
            {
                $data["customerCrmEmp"]=$emp;
            }
            if($note!=NULL)
            {
                $data["note"]=$note;
            }
            if($date!=NULL)
            {
                $data["customerCrmDate"]=$date;
            }

            $stat=$this->load->updatedata("callcrm", ["customerCrmId"=>$cutomerid],$data);


        }
    }
    public function get_emps()
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            $_SESSION["PAGE"] = "get_emps";
            $data["calltable"]=1;

            $data["emps"] = $this->Model1->selectdata("usercrm", "userCrmType=3" );
            $data["supers"] = $this->Model1->selectdata("usercrm", "userCrmType=2" );

            $data["title"]="الموظفين";
            $this->load->view('Admin/employees',$data);
        }
    }
    public function list_users($userid)
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            $data["calltable"]=1;

            $data["emps"] = $this->Model1->selectdata("usercrm", "userCrmSuper=".$userid );

            $data["title"]="الموظفين";
            $this->load->view('emps_super',$data);

        }

    }
    public function mess_details($id)
    {
        $data['url'] = base_url();
        $data["title"]="تفاصيل الرساله";
        $data["message"] = $this->Model1->selectdata("messagecrm",
            "CrmMessagesId=".$id );
        $data["type"]=5;
        $this->load->view('message_details',$data);
    }
    public function customer_details($id)
    {
        $data['url'] = base_url();
        //$data["calltable"]=1;
        $data["client"] = $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
            "customerCrmId=".$id);

        $data["title"]="تفاصيل العميل";

        $this->load->view('customer_details',$data);
    }
    public function mission()
    {
        $data['url'] = base_url();
        $_SESSION["PAGE"] = "mission" ;
        $data["calltable"]=1;
        $UserID = $_SESSION["userid"];
        $UserType = 0;
        switch ($_SESSION["usertype"]){
            case 1:
                $UserType = 0;
                break;
            case 2:
                $UserType = 1;
                break;
            case 3:
                $UserType = 2;
                break;
        }



        // get client
        $data["clients"] = $this->Employee_Taskes->GetUserClients(date("Y-m-d"),date("Y-m-d"),1,$UserID,$UserType);
        // get Total Tasks
        $data["total"] = $this->Employee_Taskes->GetTasksCount(date("Y-m-d"),date("Y-m-d"),0,$UserID);
        // Get Total remainder Tasks
        $data["remainder"] = $this->Employee_Taskes->GetTasksCount(date("Y-m-d"),date("Y-m-d"),1,$UserID); //done
        // Get Total Completed Tasks
        $data["Completed"] =$data["total"] -$data["remainder"];


//
//
////        $data["clients"] = $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
////            "(customercrm.Callstatus=0 and customercrm.customerCrmEmp=".$_SESSION["userid"]." ) or (customercrm.callstatusreturn = 1) or
////         (customercrm.customerCrmEmp=".$_SESSION["userid"]." and statuscrm.statusCrmfilter=1 and Date(customercrm.follow)='".date("Y:m:d")."')");
////
//
//        $result = $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
//            "(customercrm.Callstatus=0 and customercrm.customerCrmEmp=".$_SESSION["userid"]." ) or (callstatusreturn = 1) or
//        (customercrm.customerCrmEmp=".$_SESSION["userid"]." and  Date(customercrm.customerCrmUpdateDate)='".date("Y:m:d")."' )
//        or (customercrm.customerCrmEmp=".$_SESSION["userid"]." and  statuscrm.statusCrmfilter=1 and Date(customercrm.follow)='".date("Y:m:d")."' )");
//        if(isset($result)){
//            $data["total"]= count($result);
//        }else
//            $data["total"]= 0;
//        print_r("<pre>");
//        print_r($data["clients"]);
//
//        print_r("</pre>");die();
        $data["title"]="مهامي";
        $this->load->view('mission',$data);
    }
    public function customer($customerid)
    {

        $data['url'] = base_url();
        $data["calltable"]=1;
        $data["subject"] = $this->Model1->selectdata("subject", null );
        $data["product"]=$this->Model1->selectdata("productcrm", "ProductCrmType!=3");
        $data["trucks"]=$this->Model1->selectdata("productcrm", "ProductCrmType=3");
        $data["time"]=$this->Model1->selectdata("settingcrm", null);
        $data["customer"] = $this->Model1->selectdata("customercrm","customerCrmId=".$customerid);
        $data["answer"] = $this->Call_Status->GetAnswerStatus();
        if ($_SESSION["usertype"] == 1){
            $data["users"] = $this->Model1->selectdata("usercrm", "userCrmId!=".$_SESSION['userid']." and userCrmType !=1");
        }else{
            $data["users"] = $this->Model1->selectdata("usercrm", "userCrmId!=".$_SESSION['userid']." and userCrmType !=1 and userCrmSuper = ".$_SESSION['userid'] );
        }

        $data["noanswer"] = $this->Call_Status->GetNoAnswerStatus();
        $data["reserve"] = $this->Call_Status->GetReserveStatus();
        $data["title"]="عميل";
//        print_r("<pre>");
//        print_r($_SESSION);
//        print_r("</pre>");die();
        $this->load->view('customer',$data);
    }
    public function alerts()
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            //$data["messages"] =NULL;
            $_SESSION["PAGE"] = "alerts";
            $per=get_pre($_SESSION["userid"],2);
            if($_SESSION["usertype"]==1 || $per==1)
            {
                $data["messages"] = $this->Model1->selectdata("messagecrm", "active=0 and CrmMessagesType=1" );
            }
            else
            {
                $data["messages"]=NULL;
            }
            $data["calltable"]=1;
            $per=get_pre($_SESSION["userid"],1);
            if($_SESSION["usertype"]==1 || $per==1)
            {
                $startTime=date("Y-m-d H:i:s");
                $plus='-60 minutes';
                $cenvertedTime = date('Y-m-d H:i:s',strtotime($plus,strtotime($startTime)));
                $data["calls"] = $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    "statuscrm.statusCrmfilter=1 and customercrm.follow<'".$cenvertedTime."'");
                $data["emps"] = $this->Model1->selectdata("usercrm", "userCrmType!=1" );
                $data["time"]=$this->Model1->selectdata("settingcrm", NULL);
            }
            else if($_SESSION["usertype"]==2)
            {
                $startTime=date("Y-m-d H:i:s");
                $plus='-30 minutes';
                $cenvertedTime = date('Y-m-d H:i:s',strtotime($plus,strtotime($startTime)));
                $data["calls"] = $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
                    "customercrm.customerCrmSuper=".$_SESSION["userid"]." and statuscrm.statusCrmfilter=1 and customercrm.follow<'".$cenvertedTime."'");
                $data["emps"] = $this->Model1->selectdata("usercrm", "userCrmType=3 and userCrmSuper=".$_SESSION["userid"] );
            }
            else
            {
                $data["calls"]=NULL;
                $data["emps"]=NULL;
            }
            $data["title"]="التنبيهات";
            $this->load->view('Admin/alerts',$data);

        }

    }
    public function user_customer($user=NULL,$super=NULL)
    {
        if(isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('home',$data);
        }else{
            $cond["1"]=1;
            if($user!=NULL)
            {
                $cond["userCrmId"]=$user;
            }
            if($super!=NULL)
            {
                $cond["customerCrmSuper"]=$super;
            }

            $ed = $this->Model1->getjoin("usercrm", "customercrm" , "usercrm.userCrmId=customercrm.customerCrmEmp" ,
                $cond);

            return $ed;
        }
    }
    public function status($type,$status,$dateRange=null) //type for emp or super
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{

        }
        if ($dateRange == null){

            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$dateRange);
            //print_r($dateArray);die();
            $date1 =    $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $data["date1"] = $date1 ;
        $data["date2"] = ($date2 == $date1) ? "" : $date2;
        $_SESSION['date1'] = $date1;
        $_SESSION['date2'] = $date2;


        if($type==2){
            $data["title"]="حاله المشرفين";
        }
        else
        {
            $data["title"]="حاله الموظفين";

        }
        $stat = $this->User_Log->GetUserByStatus($type,$status);

        if (isset($stat)){
            if (count($stat) ){
                for ($i=0;$i<count($stat);$i++){
                    $isSuper = ($stat[$i]->Type == 2);
                    $callsCount[$i] = $this->Employee_Taskes->GetTasksCount($date1,$date2,0,$stat[$i]->UserID,$isSuper);
                    $empcallsCount[$i] = 0;
                    if ($type == 2){
                        $emps = $this->Users_Model->GetSuperVisorEmployee($stat[$i]->UserID);

                        if (isset($emps) && !is_null($emps)){
                            for ($j=0;$j<count($emps);$j++){
                                $empcallsCount[$j] += $this->Employee_Taskes->GetTasksCount($date1,$date2,0,$emps[$j]->ID,false);
                            }
                        }
                        $callsCount[$i] =$callsCount[$i] - $empcallsCount[$i];
                    }

                    $NewcallsCount[$i] = $this->Employee_Taskes->GetTasksCount($date1,$date2,1,$stat[$i]->UserID,$isSuper);
                    $NewcallsCount[$i] = $NewcallsCount[$i] - $empcallsCount[$i];
                    $CallsDone[$i] = $callsCount[$i] - $NewcallsCount[$i];
                    $Last_Seen[$i] = date("Y-m-d h:i A ", strtotime($this->User_Log->GetUserLastSeen($stat[$i]->UserID)));

                }


                $data["type"]= $type;
                $data["status"]= $status;
                $data["users"]= $stat;
                $data["calls"]= $callsCount;
                $data["newCalls"]= $NewcallsCount;

                $data["CallsDone"]= $CallsDone;
                $data["Last_Seen"]= $Last_Seen;
                if ($type ==2){
                    $data["empCalls"]= $empcallsCount;

                }
            }
        }

        $this->load->view('status',$data);

    }
    public function reasign($userid)
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            $data["calltable"]=1;
            $data["userid"]= $userid;
            $data["title"]="اعادة تعين المهام";
            $data["supers"]= $this->Model1->selectdata("usercrm", "userCrmType=2 and userCrmId!=".$userid);
            $data["emps"]= $this->Model1->selectdata("usercrm", "userCrmType=3 and userCrmId!=".$userid);
            $data["reset"]= $this->Model1->getjoin("customercrm", "statuscrm" , "customercrm.Callstatus=statuscrm.statusCrmId" ,
                "(customercrm.Callstatus=0 and customerCrmEmp=".$userid.")  or (statuscrm.statusCrmfilter=1 and Date(customercrm.follow)='".date("Y:m:d")."' and customerCrmEmp=".$userid.")");

            $this->load->view('reasign',$data);
        }
    }
    public function add_alert()
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            echo 0;
        }
        else
        {
            $customerid=$_POST["customer"];
            $empID = $_POST["UserID"];
            $result=$this->Model1->addtotable("alerts",["customercrm"=>$customerid,"UserID"=>$empID] );
            echo 1;
        }
    }
    public function reasgin_user()
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        $olduser=$_POST["olduser"];
        $row["customerCrmEmp"]=$_POST["newuser"];
        $row["note"]=$_POST["comment"];
        $customerid=$_POST["customerid"];



        //Notes

//        $this->Employee_Taskes->TasksReset($_POST["olduser"],$_POST["newuser"],$_POST["customerid"],$_POST["comment"]);

        $result=$this->Model1->updatedata("customercrm","customerCrmId=".$customerid,$row);

        echo 0;

    }
    public function deleteData(){

        if (isset($_SESSION['userid'])) {
            $customerid=$_POST["customer"];
            //print_r( $customerid); die();
            $this->db->where_in('customerCrmId', $customerid);
            $res = $this->db->delete('customercrm');
            if ($res) {
                echo "1";
            }else{
                echo "0";
            }
        }else{
            $this->load->view('login');
        }

    }
    public function reasgin()
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        $customerid=$_POST["customer"];


        if(!empty($_POST["rcomment"]))
        {
            $row["note"]=$_POST["comment"];
        }
        if(!empty($_POST["date"]))
        {
            $date=$_POST["date"];
            $time=$_POST["time"];
            $datetime= date('Y-m-d H:i:s', strtotime("$date $time"));
            $row["follow"]=$datetime;

        }
        $row["customerCrmEmp"]=$_POST["empid"];
        $element= $this->Model1->selectdata("usercrm", "userCrmId=".$_POST["empid"]);
        $row["customerCrmSuper"]=$element[0]->userCrmSuper;
        $result=$this->Model1->updatedata("customercrm","customerCrmId=".$customerid,$row);



        echo 1;

    }
    public function task_view()
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            $_SESSION["PAGE"] = "task_view";
            $data["title"]=" تعين المهام";
            $per=get_pre($_SESSION["userid"],4);

            if($_SESSION["usertype"]==1 || $per==1)
            {
                $data["admin"]=1;
                $data["supers"]= $this->Model1->selectdata("usercrm", "active=1 and userCrmType=2",null);
                $data["emps"]= $this->Model1->selectdata("usercrm", "active=1 and userCrmType=3",null);
                $data["reset"]= $this->Model1->selectdata("customercrm","customerCrmEmp=0 and customerCrmSuper=0",null);
            }
            else if($_SESSION["usertype"]==2)
            {
                $data["supers"]= $this->Model1->selectdata("usercrm", "active=1 and userCrmType=2",null);
                $data["emps"]= $this->Model1->selectdata("usercrm", "active=1 and userCrmType=3 and userCrmSuper=".$_SESSION["userid"],null);
                $data["reset"]= $this->Model1->selectdata("customercrm","(customerCrmEmp=0 or customerCrmEmp=".$_SESSION["userid"]." ) and customerCrmSuper=".$_SESSION["userid"],null);
            }
            $this->load->view('asign_task',$data);

        }
    }
    public function asgin_user()
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {

            $date=date("Y:m:d");
            $row["customerCrmEmp"]=$_GET["emp"];
            $row["customerCrmSuper"]=$_GET["super"];
            $row["customerCrmDate"]=$date;



            // In New Updates By Abdalraheem Kamel
            $customerid = explode(",", $_GET["customerid"]);
            // Get Supervisor ID Using Employee ID
            $SuperID = $this->db->query("SELECT `userCrmSuper` FROM `usercrm` where `userCrmId` =".$_GET["emp"])->result();
            $inputData['userID']=$_GET["emp"];
            $inputData['Date']=date("Y:m:d");
            $inputData['Time']=date("h:i:sa");
            $inputData['Status']=1;
            if (isset($SuperID[0]->userCrmSuper) && $SuperID[0]->userCrmSuper >0){
                $inputData['supervisor_ID']=$SuperID[0]->userCrmSuper;
            }
            foreach ($customerid as $ID){
                if ($ID !=''){
                    $inputData['clientID']=$ID;
                    $result=$this->Model1->updatedata("customercrm","customerCrmId=".$ID,$row);
                    $this->Model1->addtotable("employees_tasks",$inputData);
                }
            }
            $data["title"]=" تعين المهام";
            $data["supers"]= $this->Model1->selectdata("usercrm", "userCrmType=2",null);
            $data["emps"]= $this->Model1->selectdata("usercrm", "userCrmType!=1",null);
            $data["reset"]= $this->Model1->selectdata("customercrm",["customerCrmEmp"=>0],null);

            echo 0;
        }

    }
    public function sendMessage(){

        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {

            if(!empty($_POST["mfrom"]))
            {
                $row["CrmMessagesFrom"]=$_POST["mfrom"];
                $ufrom=$this->Model1->selectdata("usercrm", ["userCrmId"=>$_POST["mfrom"]] );
            }

            if(!empty($_POST["title"]))
            {
                $row["CrmMessagesTitle"]=$_POST["title"];
            }
            if(!empty($_POST["content"]))
            {
                $row["CrmMessagesContent"]=$_POST["content"];
            }

            if(!empty($_POST["mtype"]))
            {
                $row["CrmMessagesType"]=$_POST["mtype"];
            }

            if(!empty($_POST["mto"]))
            {
                $movie = $_POST['mto'];

                $count=0;
                foreach($movie AS $title) {
                    $SendTo=$title;
                    if($_POST["type"]==1)
                    {
                        $row["CrmMessagesTo"]=$title;

                        $res=$this->Model1->selectdata("customercrm", ["customerCrmId"=>$title] );
                        if($_POST["mtype"]==1)
                        {
                            // $phone=$res[0]->customerCrmPhone;
                            if($count<$ufrom[0]->num_message )
                            {
                                $row["active"]=1;
                                //send here message for this phone
                                $count++;
                            }
                        }

                    }
                    else
                    {
                        $row["CrmMessagesTo"]=$title;
                        $res=$this->Model1->selectdata("usercrm", ["userCrmId"=>$title] );

                    }
                    $result=$this->Model1->addtotable("messagecrm",$row );
                    $from= $_SESSION['userid'];
                    $Messagetitle = $_POST["title"];
                    $content = $_POST["content"];
                    if ($_POST["mtype"]==1 && ($_POST["type"]==2 || $_POST["type"]==1)){
                        $this->InternalMessages->NewMessage($from,$SendTo,$Messagetitle,$content);
                    }elseif ($_POST["mtype"]==3 && $_POST["type"]==2){
                        $this->InternalMessages->NewInstructions($from,$SendTo,$Messagetitle,$content);
                    }elseif ($_POST["mtype"]==4 && $_POST["type"]==2){
                        $this->InternalMessages->NewComplaint($from,0,$Messagetitle,$content,$SendTo);
                    }
                }

            }
            $data["clients"] = $this->Model1->selectdata("customercrm", null );

            if($_POST["mtype"]==1)
            {
                $data["title"]="الرسائل";

                redirect("users/message_view");

            }
            else if($_POST["mtype"]==2)
            {
                $data["title"]="الايميلات";
                $this->load->view("emails",$data);
            }
            else if($_POST["mtype"]==3)
            {

                redirect("users/instr_view");
            }
            else if($_POST["mtype"]==4)
            {

                redirect("users/complains_view");
            }

        }
    }
    public function copy()
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            $this->load->dbutil();
            $this->load->helper('file');

            $query = $this->db->query("SELECT * FROM customercrm");
            $filename="backup/file".time().".CSV";
            $res= $this->dbutil->csv_from_result($query);
            $done= write_file($filename, $res);
            echo 1;

        }
    }
    public function updateMessage(){
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            if(!empty($_POST["mfrom"]))
            {
                $row["CrmMessagesFrom"]=$_POST["mfrom"];
            }
            if(!empty($_POST["mto"]))
            {
                $row["CrmMessagesTo"]=$_POST["mto"];
            }
            if(!empty($_POST["mto"]))
            {
                $row["CrmMessagesCustomer"]=$_POST["customer"];
            }
            if(!empty($_POST["title"]))
            {
                $row["CrmMessagesTitle"]=$_POST["title"];
            }
            if(!empty($_POST["content"]))
            {
                $row["CrmMessagesContent"]=$_POST["content"];
            }
            if(!empty($_POST["status"]))
            {
                $row["CrmMessagesStatus"]=$_POST["status"];
            }
            if(!empty($_POST["type"]))
            {
                $row["CrmMessagesType"]=$_type=$_POST["type"];
            }
            $cond["CrmMessagesId"]=$_POST["messageid"];
            $result=$this->load->updatedata("messagecrm",$cond,$row );
            $this->load->view("messages");
        }
    }
    public function change()
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('home',$data);
        }else{
            $data['url'] = base_url();

            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if (!(empty($_POST['changeid'])) && !(empty($_POST['content'])))
            {

                $cond["changecrmID"]=$_POST['changeid'];
                $row["Content"]=$_POST["content"];
                $result=$this->Model1->updatedata("changecrm",$cond,$row );
                echo 1;
            }
            else
            {
                echo 2;
            }
        }


    }
    public function message_details($type,$id)
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('home',$data);
        }else{
            $data['url'] = base_url();
            $data["message"] = $this->Model1->selectdata("messagecrm", "CrmMessagesId=".$id );
            if($type==1){
                $data["title"]="تفاصيل الرساله";

            }
            else if($type==2)
            {
                $data["title"]="تفاصيل البريد الالكتروني";

            }
            else if($type==3)
            {
                $data["title"]="تفاصيل التعليمه";

            }
            else if($type==4)
            {
                $data["title"]="تفاصيل الشكوي+";

            }
            $data["type"]=$type;
            $this->load->view('message_details',$data);

        }


    }
    public function add_product()
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            echo 0;
        }
        else
        {
            if ($_POST["name"] == "" && $_POST["price"] == "" && $_POST["desc"] == "" && $_POST["type"] == ""){
//                  echo   $row["ProductCrmName"]=$_POST["name"];
//                  echo "<br>";
//                  echo   $row["ProductCrmDesc"]=$_POST["name"];
//                  echo "<br>";
//                  echo   $row["ProductCrmPrice"]=$_POST["name"];
//                  echo "<br>";
//                  echo   $row["ProductCrmType"]=$_POST["name"];
//                  echo "<br>";
                echo "يجب ادخال جميع البيانات المطلوبه." ;
            }
            else{
                $row["ProductCrmName"]=$_POST["name"];
                $row["ProductCrmDesc"]=$_POST["desc"];
                $row["ProductCrmPrice"]=$_POST["price"];
                $row["ProductCrmCancelDate"]=( isset($_POST["cancel"]) ) ? $_POST["cancel"] : "" ;
                $row["ProductCrmType"]=$_POST["type"];

                $result=$this->Model1->addtotable("productcrm",$row );
                echo $result;
            }

        }
    }
    public function edit_product()
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            echo 0;
        }
        else
        {
            if ($_POST["name"] == "" && $_POST["price"] == "" && $_POST["desc"] == "" && $_POST["type"] == ""){
                echo "يجب ادخال جميع البيانات المطلوبه." ;
            }
            else{
                $cond["ProductCrmId"]=$_POST["prodid"];
                $row["ProductCrmName"]=$_POST["name"];
                $row["ProductCrmDesc"]=$_POST["desc"];
                $row["ProductCrmPrice"]=$_POST["price"];
                $row["ProductCrmCancelDate"]=$_POST["cancel"];
                $row["ProductCrmType"]=$_POST["type"];

                $result=$this->Model1->updatedata("productcrm",$cond,$row );
                echo 1;
            }
        }
    }
    public function update_time()
    {
        $data['url'] = base_url();
        $row["settingcrmTimeMinute"]=$_POST["time"];
        //echo "here";
        $res = $this->Model1->updatedata("settingcrm",NULL,$row );
        //echo "after here";
        echo 1;
    }
    public function addstatus()
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            echo 0;
        }else{

            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }

            // print_r($_POST);die;
            // $row["statusCrmContent"]=$_POST["statusCrmContent"];
            // $row["statusCrmfilter"]=$_POST["statusCrmfilter"];
            // $row["statusCrmType"]=$_POST["statusCrmType"];

            $row['title']=$_POST['title'];

            // 1=>عادى
            // 2=> تعاقد
            // 3=> حجز
            $row['status']=$_POST['status'];
            // 2=>لم يتم الرد
            // 1=> تم الرد
            $row['type']=$_POST['type'];
            $row['at_home']=$_POST['athome'];
            $row['follow']=$_POST['follow'];
            // $result=$this->Model1->addtotable("statuscrm",$row );
            $result=$this->Model1->addtotable("call_status",$row );
            echo $result;
        }

    }
    public function sendsms(){
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {

            $row["CrmMessagesFrom"]=$_SESSION["userid"];


            $row["CrmMessagesTitle"]=$_POST["subject"];

            $row["CrmMessagesContent"]=$_POST["content"];



            $row["CrmMessagesType"]=1;
            $row["CrmMessagesCustomer"]=$_POST["clientid"];
            $row["active"]=1;
            $res=$this->Model1->selectdata("customercrm", ["customerCrmId"=>$_POST["clientid"]] );
            $phone=$res[0]->customerCrmPhone;
            // send message to this phone
            $result=$this->Model1->addtotable("messagecrm",$row );
            echo 1;


        }
    }
    public function sendcomplain(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            $row["CrmMessagesFrom"]=$_SESSION["userid"];
            $row["CrmMessagesTitle"]=$_POST["subject"];
            $row["CrmMessagesContent"]=$_POST["content"];
            $row["complain"]=$_POST["complain"];
            $row["CrmMessagesType"]=4;
            $row["CrmMessagesCustomer"]=$_POST["clientid"];
            $row["active"]=1;
            $from= $_SESSION["userid"];
            $type=1;
            $title=$_POST["subject"];
            $message=$_POST["content"];
            $ClientID=$_POST["clientid"];

            $this->InternalMessages->NewComplaint($from,$type,$title,$message,$ClientID);

            $result=$this->Model1->addtotable("messagecrm",$row );
            echo 1;


        }
    }
    public function sendemail(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            $result = 1;
            $communicationData = $this->Users_Model->GetMailServerConfig($_SESSION['userid']);
            $email_Address = '';

            if (count($communicationData) <= 0  || is_null($communicationData) ){
                $communicationData = $this->Model1->selectdata("communication_settings");
            }


//            print_r("<pre>");
//            print_r($communicationData);
//            print_r("</pre>");die();

            if (count($communicationData) <= 0  || strlen($communicationData[0]->Mail_Address) <=0){
                $communicationData = $this->Model1->selectdata("communication_settings");
                if (is_null($communicationData) || count($communicationData) <= 0){
                    $result= 2;
                    echo $result;
                    return;
                }else{
                    $email_Address = $communicationData[0]->Mail_Address;
                    $config = array(
                        'protocol' => 'smtp',
                        'smtp_host' => $communicationData[0]->Mail_Server,
                        'smtp_port' => $communicationData[0]->Port,
                        'smtp_user' => $communicationData[0]->Mail_Address,
                        'smtp_pass' => $communicationData[0]->Mail_Password,
                        'smtp_crypto' => 'tls',
                        'mailtype'  => 'text'
                    );
                }
            }else if (count($communicationData) > 0 && strlen($communicationData[0]->Mail_Address) >0){
                // Emp SMTP configrations
                $email_Address = $communicationData[0]->Mail_Address;
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => $communicationData[0]->Mail_Server,
                    'smtp_port' => $communicationData[0]->Port,
                    'smtp_user' => $communicationData[0]->Mail_Address,
                    'smtp_pass' => $communicationData[0]->Mail_Password ,
                    'smtp_crypto' => 'tls',
                    'mailtype'  => 'text'
                );
            }else{
                echo 2;
                return;
            }





//            print_r("<pre>");
//            print_r($_POST);
//            print_r("</pre>");

            $row["CrmMessagesFrom"]=$_SESSION["userid"];
            $row["CrmMessagesTitle"]=$_POST["subject"];
            $row["CrmMessagesContent"]=$_POST["content"];
            $row["CrmMessagesType"]=2;
            $clinetsIDs = explode(",", $_POST["to"]);
            $row["active"]=1;
            $this->load->library('email', $config);
//            print_r("<pre>");
//            print_r($_POST);
//            print_r("</pre>");die();
            foreach ($clinetsIDs as $clientID){

                if (!empty($clientID)){
                    $row["CrmMessagesCustomer"] = $clientID;
                    $res=$this->Model1->selectdata("customercrm", ["customerCrmId"=>$clientID] );
                    $email=$res[0]->customerCrmEmail;
                    $this->email->set_newline("\r\n");
                    $this->email->from($email_Address, 'CRM');
                    $this->email->subject($_POST["subject"]);
                    $this->email->message($_POST["content"] );
                    $this->email->to($email);
                    if (!$this->email->send())
                    {
                        $result = 0;
                    }
                    else {
                        $result = 1;
                    }
                    $this->Model1->addtotable("messagecrm",$row );
                }
            }
            echo $result;

        }
    }
    public function startcall()
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('home',$data);
        }else {
            $data['url'] = base_url();

            $cond["customerCrmId"] = $_POST['clientid'];
            $row["startcall"] = date("Y:m:d H:i:s");
            $result = $this->Model1->updatedata("customercrm", $cond, $row);

            // update New Table
            $cid["clientID"] = $_POST['clientid'];
            $this->Model1->updatedata("employees_tasks", $cid, $row);

            $res = $this->Model1->selectdata("customercrm", $cond);
            $result = $this->Model1->updatedata("usercrm", ["userCrmId" => $res[0]->customerCrmEmp], ["usercrmStatus" => 2]);
            $this->User_Log->StartCall($_SESSION["userid"]);

            echo 1;

        }
    }

    public function update_status(){


//        print_r("<pre>");
//        print_r($_POST);
//        print_r("</pre>"); die();

        if (isset($_POST['time'])){
            $time = $_POST['time'];
            $time = strtotime($time) + 7200;
            $time = new DateTime("@$time");
            $time=$time->format('H:i:s');
        }



        $this->Model1->updatedata('crm_users_log','UserID='.$_SESSION['userid'],['Status'=>1]);
        $client_id=$_POST['CallID'];

        /*
         * status = 1 => Answer
         * status = 2 => NoAnswer
         * status = 3 => Order
         * status = 4 => Wrong Data
         *
         */





        $status = $this->Call_Status->GetStatusType($_POST['call_status_id']);

        $follow = $this->Follows->isFollow($_POST['clientid']);
        $followID = null;



        if ($status[0]->follow ==1){

            // add in Follow Table
            // Get Client Follows
            $FollowData['UserID']=$_SESSION['userid'];
            $FollowData['ClientID']=$_POST['clientid'];
            //time
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
        $commentID = 0;
        if (isset($_POST['comment']) && $_POST['comment'] != null) {
            $row['date'] = date("Y-m-d");
            $row['time'] = date("H:i:s");
            $row['Comment_Text']=htmlspecialchars($_POST['comment']);
            $row['ClientID']=$_POST['clientid'];
            $row['UserID']=$_SESSION['userid'];
            $row["IsFollowComment"] = ($status[0]->follow == 1);
            $row["FollowID"] = $followID;
            $commentID= $this->Model1->addtotable('crm_comments',$row);
            $this->Model1->updatedata('crm_calls','ID='.$client_id,['endcall'=>date('H:i:s'),'call_Result'=>$_POST['call_status_id'],'CommentID'=>$commentID]);
        }else{
            $this->Model1->updatedata('crm_calls','ID='.$client_id,['endcall'=>date('H:i:s'),'call_Result'=>$_POST['call_status_id']]);
        }
        if ($status[0]->status == 3){
            //Order
            if (isset($_POST['product']) && !is_null($_POST['product'])){
                $order['ProductID']=$_POST['product'];
                $order['Quantity']=$_POST['qyt'];
                $order['transfer_id']=$_POST['truck'];
                $order['date']=$_POST['date'];
                //time

                $order['time']=$time;
                $order['notes']=htmlspecialchars($_POST['comment']);
                $order['ClientID']=$_POST['clientid'];
                $order['UserID']=$_SESSION['userid'];
                $this->Model1->addtotable('crm_orders',$order);
            }
        }
        // Update Status
        $this->Employee_Taskes->updateStatus($_POST['clientid'],$status[0]->id,$_SESSION['userid']);
        if (isset($_SESSION['date1'])){
            redirect('Client/Distributors/'.$_SESSION['date1'].'@'.$_SESSION['date2']);
        }else{
            redirect('Client/Distributors');
        }

    }




    public function active_status(){
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            $data['url'] = base_url();
            if ( !(empty($_POST['messid']))){
                $cond["id"]=$_POST["messid"];
                $res = $this->Model1->selectdata("call_status", $cond);
                if($res[0]->is_active==0){
                    $is_active=1;
                }else{
                    $is_active=0;
                }
                $result = $this->Model1->updatedata("call_status", ["id" => $cond["id"]], ["is_active" => $is_active]);
                echo 1;
            }else{
                echo 0;
            }
        }
    }


    public function setFollowStatus(){
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $data['url'] = base_url();
            if ( !(empty($_POST['messid']))){
                $cond["id"]=$_POST["messid"];
                $res = $this->Model1->selectdata("call_status", $cond);
                if($res[0]->follow==0){
                    $is_follow=1;
                }else{
                    $is_follow=0;
                }
                $result = $this->Model1->updatedata("call_status", ["id" => $cond["id"]], ["follow" => $is_follow]);
                echo 1;
            }else{
                echo 0;
            }
        }
    }



    // public function update_status()
    // {
    //     $data['url'] = base_url();

    //     if(!isset($_SESSION['userid']))
    //     {
    //         $this->load->view('login',$data);
    //     }
    //     else
    //     {
    //         $statusid=$_POST["status"];
    //         $row["CallStatus"]=$statusid;
    //         $row["callstatusreturn"]=0;
    //         $clientid=$_POST["clientid"];
    //         $cond["customerCrmId"]=$clientid;
    //         if(!empty($_POST["comment"]))
    //         {
    //             $row["note"]=$_POST["comment"];
    //             $newData['Notes']=$_POST["comment"];
    //             $this->Clients->AddClientNote((int)$_SESSION["userid"],$clientid,$_POST["comment"]);
    //         }
    //         if(!empty($_POST["date"]))
    //         {
    //             $date=$_POST["date"];
    //             $time=$_POST["time"];
    //             $datetime= date('Y-m-d H:i:s', strtotime("$date $time"));
    //         }
    //         if(!empty($_POST["truck"]))
    //         {
    //             $row["truckway"]=$_POST["truck"];
    //             $row["truckdate"]=$datetime;
    //         }
    //         else
    //         {
    //             if (!empty($datetime))
    //                 $row["follow"]=$datetime;
    //         }
    //         $row["endcall"]=date("Y-m-d H:i:s");
    //         $newData['Status']=$statusid;
    //         $newData['endcall']=date("Y-m-d H:i:s");
    //         $callStatus = $this->Call_Status->GetCallStatus(4);
    //         $IsFollow = false;
    //         foreach ($callStatus as $Status){
    //             if ($Status->id == $statusid);
    //             $IsFollow = true;
    //             break;
    //         }
    //         if (isset($_POST["date"]) && isset($_POST["time"])){
    //             if ($IsFollow){
    //                 $newData['Follow_Date'] = $_POST["date"];
    //                 $newData['Follow_Time'] = $_POST["time"];
    //             }
    //         }
    //         $CID['clientID'] =$clientid;
    //         $this->Model1->updatedata("employees_tasks",$CID,$newData );
    //         $this->User_Log->EndCall($_SESSION["userid"]);
    //         $user=$this->Model1->selectdata("customercrm", ["customerCrmId"=>$clientid] );

    //         $res = $this->Model1->updatedata("customercrm",$cond,$row );
    //         $resl = $this->Model1->updatedata("usercrm",["userCrmId"=>$user[0]->customerCrmEmp],["usercrmStatus"=>1] );

    //         if(!empty($_POST["product"]))
    //         {

    //             $movie = $_POST['product'];
    //             $row1["customerId"]=$clientid;

    //             foreach($movie AS $title) {
    //                 $row1["prouductCrmId"]=$title;
    //                 $result=$this->Model1->addtotable("customerproductcrm",$row1 );
    //             }
    //         }
    //         if (isset($_SESSION['FromPage']) && !is_null($_SESSION['FromPage'])){
    //             $redierictTo =$_SESSION['FromPage'] ;
    //             $_SESSION['FromPage'] = null;
    //             $this->$redierictTo();
    //         }else{
    //             $this->mission();
    //         }

    //     }
    // }


    public function SetAtHome(){
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $data['url'] = base_url();
            if ( !(empty($_POST['messid']))){
                $cond["id"]=$_POST["messid"];
                $res = $this->Model1->selectdata("call_status", $cond);
                if($res[0]->at_home==0){
                    $is_active=1;
                }else{
                    $is_active=0;
                }
                $result = $this->Model1->updatedata("call_status", ["id" => $cond["id"]], ["at_home" => $is_active]);
                echo 1;
            }else{
                echo 0;
            }
        }
    }



    public function missionBack()
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('home',$data);
        }else{
            //print_r($_POST['id']); die();
            $result=$this->Model1->updatedata("customercrm", ["customerCrmId"=>$_POST['id']] ,["callstatusreturn"=>1]  );
            if ($result) {
                echo 1;
            }else{
                echo 0;
            }
        }
    }
    public function update_client()
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('home',$data);
        }else{
            $data['url'] = base_url();

            $cond["customerCrmId"]=$_POST['clientid'];
            if(!empty($_POST["name"]))
            {
                $row["customerCrmName"]=$_POST["name"];
            }
            if(!empty($_POST["phone"]))
            {
                $row["customerCrmPhone"]=$_POST["phone"];
            }
            if(!empty($_POST["phone2"]))
            {
                $row["fphone"]=$_POST["phone2"];
            }
            if(!empty($_POST["email"]))
            {
                $row["customerCrmEmail"]=$_POST["email"];
            }
            if(!empty($_POST["address"]))
            {
                $row["customerCrmAddress"]=$_POST["address"];
            }
            if(!empty($_POST["company"]))
            {
                $row["customerCrmCompany"]=$_POST["company"];
            }
            if(!empty($_POST["job"]))
            {
                $row["customerCrmJob"]=$_POST["job"];
            }
            if(!empty($_POST["gov"]))
            {
                $row["customerCrmGov"]=$_POST["gov"];
            }
            if(!empty($_POST["age"]))
            {
                $row["fage"]=$_POST["age"];
            }
            if(!empty($_POST["type"]))
            {
                $row["ftype"]=$_POST["type"];
            }
            $result=$this->Model1->updatedata("customercrm",$cond,$row );
            echo 1;

        }
    }
    public function active()
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            $cond["CrmMessagesId"]=$_POST["messid"];
            $res=$this->Model1->selectdata("messagecrm", $cond );
            if($res[0]->CrmMessagesTo==0){
                $res=$this->Model1->selectdata("customercrm", ["customerCrmId"=>$res[0]->CrmMessagesCustomer] );
                if($res!=NULL)
                {
                    $phone=$res[0]->customerCrmPhone;
                    $check=0;
                }
                else
                {
                    $check=1;
                }
            }
            else
            {
                $res=$this->Model1->selectdata("usercrm", ["userCrmId"=>$res[0]->CrmMessagesTo] );
                if($res!=NULL)
                {
                    $phone=$res[0]->userCrmPhone;
                    $check=0;
                }
                else
                {
                    $check=1;
                }

            }
            // send message to this phone
            if($check==1)
            {
                echo 0;
            }
            else
            {
                $row["active"]=1;
                $result=$this->Model1->updatedata("messagecrm",$cond,$row );
                echo 1;

            }

        }
    }
    public function setEmail(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else {
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $_SESSION["PAGE"] = "edit_mail";
            $data["communication_settings"] = $this->Model1->selectdata("communication_settings", null );
            $data["title"]=" إعدادات البريد الإلكترونى";
            $this->load->view('Admin/communication_settings',$data);
        }
    }
    public function update_mail_settings(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            redirect("users");
        }
        else {
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($_POST["IsUpdate"] == 0){
                $row["Mail_Address"]=$_POST["uName"];
                $row["Mail_Server"]=$_POST["mailServer"];
                $row["Port"]=$_POST["portNo"];
                $row["Mail_Password"]=$_POST["uPass"];
                $res = $this->Model1->addtotable("communication_settings",$row );
                $data['msg'] = "تم الإضافة بنجاح";
                $data['error'] = false;
                echo json_encode($data);
            }else{
                $row["Mail_Address"]=$_POST["uName"];
                $row["Mail_Server"]=$_POST["mailServer"];
                $row["Port"]=$_POST["portNo"];
                $row["Mail_Password"]=$_POST["uPass"];
                $res = $this->Model1->updatedata("communication_settings",["id"=>$_POST["IsUpdate"]],$row );
                $data['msg'] = "تم التعديل بنجاح";
                $data['error'] = false;
                echo json_encode($data);
            }

        }
    }
    public function notification(){
        $data['url'] = base_url();
        $resultData['Message'] =0;
        $resultData['Alert'] =0;
        if(isset($_SESSION['userid'])){
            $UserID = $_SESSION['userid'];
            $messages =$this->db->query("SELECT count(*) as count,messages_count as Ucount,alerts_count as Acount FROM user_messages where userID=".$UserID)->result();
            if ($messages[0]->count <= 0){

                $row['userID']=$UserID;
                $row['messages_count']=0;
                $row['alerts_count']=0;
                $this->Model1->addtotable("user_messages",$row );
                $_SESSION['MessageCount'] = $messages[0]->Ucount;
                $_SESSION['AlertCount'] = $messages[0]->Acount;

            }else {
                $_SESSION['MessageCount'] = $messages[0]->Ucount;
                $_SESSION['AlertCount'] = $messages[0]->Acount;
            }
            $Mcount = $this->db->query("SELECT COUNT(*) as count FROM messagecrm where CrmMessagesTo=".$UserID)->result();
            $Acount = $this->db->query("SELECT COUNT(*) as count FROM alerts where UserID=".$UserID)->result();
            if (isset($_SESSION['MessageCount'])){
                if ($_SESSION['MessageCount'] < $Mcount[0]->count){
                    $_SESSION['MessageCount'] =$Mcount[0]->count;
                    $newrow['messages_count']=$Mcount[0]->count;
                    $where['userID']=$UserID;
                    $this->Model1->updatedata("user_messages",$where,$newrow );
                    $resultData['Message']= $Mcount[0]->count;
                }else{
                    $newrow['messages_count']=$Mcount[0]->count;
                    $where['userID']=$UserID;
                    $this->Model1->updatedata("user_messages",$where,$newrow );
                }
            }else{
                $_SESSION['MessageCount'] = $Mcount[0]->count;
                $resultData['Message']= $Mcount[0]->count;
            }
            if (isset($_SESSION['AlertCount'])){
                if ($_SESSION['AlertCount'] < $Acount[0]->count){
                    $_SESSION['AlertCount'] = $Acount[0]->count;
                    $newrow['alerts_count'] = $Acount[0]->count;
                    $where['userID']=$UserID;
                    $this->Model1->updatedata("user_messages",$where,$newrow );
                    $resultData['Alert']= $Acount[0]->count;
                }else{
                    $newrow['alerts_count']=$Acount[0]->count;
                    $where['userID']=$UserID;
                    $this->Model1->updatedata("user_messages",$where,$newrow );
                }
            }else{
                $_SESSION['AlertCount'] = $Acount[0]->count;
                $resultData['Alert']= $Acount[0]->count;
            }
            //$resultData['follows']= $this->Employee_Taskes->GetUserFollow($UserID);
            // update delayed calss
            $this->UpdateDelayedCalls($UserID);
            $Delayed_Calls = $this->db->get_where("user_messages",["userID"=>$UserID])->result();
            if (count($Delayed_Calls) > 0){
                // Get Current Delayed Calls Count
                $_SESSION['DelayedCalls'] = $Delayed_Calls[0]->Delayed_Calls;
            }else{
                // add new
                $_SESSION['DelayedCalls'] =0;
            }
            $resultData['DelayedCalls'] =$_SESSION['DelayedCalls'];
        }
        echo json_encode($resultData);
    }
    public function UserAlerts(){
        $data['url'] = base_url();

        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }else{
            //$data["messages"] =NULL;
            $_SESSION["PAGE"] = "UserAlerts";



            $data["title"]="التنبيهات";

            $this->load->view('UserAlerts',$data);
        }
    }
    public function Followedcustomer($customerid)
    {
        $data['url'] = base_url();
        $data["calltable"]=1;
        $data["subject"] = $this->Model1->selectdata("subject", null );
        $data["product"]=$this->Model1->selectdata("productcrm", "ProductCrmType!=3");
        $data["trucks"]=$this->Model1->selectdata("productcrm", "ProductCrmType=3");
        $data["time"]=$this->Model1->selectdata("settingcrm", null);
        $data["customer"] = $this->Model1->selectdata("customercrm","customerCrmId=".$customerid);
        $data["answer"] = $this->Call_Status->GetAnswerStatus();
        $data["noanswer"] = $this->Call_Status->GetNoAnswerStatus();
        $data["reserve"] = $this->Call_Status->GetReserveStatus();
        if ($_SESSION["usertype"] == 1){
            $data["users"] = $this->Model1->selectdata("usercrm", "userCrmId!=".$_SESSION['userid']." and userCrmType !=1");
        }else{
            $data["users"] = $this->Model1->selectdata("usercrm", "userCrmId!=".$_SESSION['userid']." and userCrmType !=1 and userCrmSuper = ".$_SESSION['userid'] );
        }

        $data["title"]="عميل";
        $this->load->view('Followedcustomer',$data);
    }
    public function Follow_update_status()
    {
        $data['url'] = base_url();

        if(!isset($_SESSION['userid']))
        {
            $this->load->view('login',$data);
        }
        else
        {

            $statusid=$_POST["status"];



            $row["CallStatus"]=$statusid;
            $row["callstatusreturn"]=0;
            $clientid=$_POST["clientid"];
            $cond["customerCrmId"]=$clientid;




            if(!empty($_POST["comment"]))
            {
                $row["note"]=$_POST["comment"];
                $newData['Notes']=$_POST["comment"];
            }
            if(!empty($_POST["date"]))
            {
                $date=$_POST["date"];
                $time=$_POST["time"];
                $datetime= date('Y-m-d H:i:s', strtotime("$date $time"));
            }
            if(!empty($_POST["truck"]))
            {
                $row["truckway"]=$_POST["truck"];
                $row["truckdate"]=$datetime;
            }
            else
            {
                if (empty($datetime)){

                }else
                    $row["follow"]=$datetime;
            }
            $row["endcall"]=date("Y-m-d H:i:s");

            $newData['Status']=$statusid;
            $newData['endcall']=date("Y-m-d H:i:s");
            $callStatus = $this->Call_Status->GetCallStatus(4);
            $IsFollow = false;
            foreach ($callStatus as $Status){
                if ($Status->id == $statusid);
                $IsFollow = true;
                break;
            }

            if ($IsFollow){
                $newData['Date'] = $_POST["date"];
                $newData['Time'] = $_POST["time"];
            }
            $CID['clientID'] =$clientid;

            $this->Model1->updatedata("employees_tasks",$CID,$newData );

            $user=$this->Model1->selectdata("customercrm", ["customerCrmId"=>$clientid] );

            $res = $this->Model1->updatedata("customercrm",$cond,$row );
            $resl = $this->Model1->updatedata("usercrm",["userCrmId"=>$user[0]->customerCrmEmp],["usercrmStatus"=>1] );

            if(!empty($_POST["product"]))
            {

                $movie = $_POST['product'];
                $row1["customerId"]=$clientid;

                foreach($movie AS $title) {
                    $row1["prouductCrmId"]=$title;
                    $result=$this->Model1->addtotable("customerproductcrm",$row1);
                }
            }

            $this->client(1,"");
        }
    }
    public function SetLastSeen(){
        if (isset($_SESSION["userid"])){
            $this->User_Log->UpdateLastSeen($_SESSION["userid"]);
        }
    }
    public function CheckOfflineUser(){
        $this->User_Log->SetOfflineUsers();

    }
    public function GetUserFollows(){
        $UserID = $_SESSION['userid'];
        $Data['follows']= $this->Employee_Taskes->GetUserFollow($UserID);
        echo json_encode($Data);
    }
    private function sendEmail1()
    {
        $communicationData = $this->Model1->selectdata("communication_settings");
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => $communicationData[0]->mail_Server,
            'smtp_port' => $communicationData[0]->port,
            'smtp_user' => $communicationData[0]->email_Address,
            'smtp_pass' => $communicationData[0]->mail_Password,
            'smtp_crypto' => 'tls',
            'mailtype'  => 'text'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");

        // $to array of clints ids
        $this->email->to("abdob2623@gmail.com");
        $this->email->from($communicationData[0]->email_Address, 'CRM');
        $this->email->subject("test");
        $this->email->message("test message");

        if (!$this->email->send())
        {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    public function DBBackUp(){
        if ($_SESSION['usertype'] ==  4){
            $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
            if  ($Reports !=1){
                redirect(site_url("CRM_Users"));return;
            }
        }
        $this->load->dbutil();
        $db_format=array('format'=>'zip','filename'=>'my_db_backup.sql');
        $backup=& $this->dbutil->backup($db_format);
        $dbname='backup-on-'.date('Y-m-d').'.zip';
        $save='assets/db_backup/'.$dbname;
        write_file($save,$backup);
        force_download($dbname,$backup);
    }
    public function SMS(){

        $data['url'] = base_url();

        if(!isset($_SESSION['email'])){
            $this->load->view('login',$data);
        }else {
            $data["clients"] = $this->Model1->selectdata("customercrm", null);
            //$data["subject"] = $this->Model1->selectdata("subject", null );

            if ($_SESSION['usertype'] == 1) {
                $data["sent"] = $this->Model1->getjoin("messagecrm", "usercrm", "messagecrm.CrmMessagesFrom=usercrm.userCrmId",
                    "Date(messagecrm.CrmMessagesCreateDate)='" . date("Y-m-d") . "'");
                $data["recieved"] = NULL;

            }
            if ($_SESSION['usertype'] == 2) {

                $data["sent"] = $this->Model1->getjoin("messagecrm", "usercrm", "messagecrm.CrmMessagesFrom=usercrm.userCrmId",
                    "Date(messagecrm.CrmMessagesCreateDate)='" . date("Y-m-d") . "' and usercrm.userCrmSuper=" . $_SESSION["userid"]);
                $data["recieved"] = $this->Model1->getjoin("messagecrm", "usercrm", "messagecrm.CrmMessagesTo=usercrm.userCrmId",
                    "Date(messagecrm.CrmMessagesCreateDate)='" . date("Y-m-d") . "' and usercrm.userCrmSuper=" . $_SESSION["userid"]);

            }
            if ($_SESSION['usertype'] == 3) {

                $data["sent"] = $this->Model1->getjoin("messagecrm", "usercrm", "messagecrm.CrmMessagesFrom=usercrm.userCrmId",
                    "Date(messagecrm.CrmMessagesCreateDate)='" . date("Y-m-d") . "' and usercrm.userCrmSuper=" . $_SESSION["userid"]);
                $data["recieved"] = $this->Model1->getjoin("messagecrm", "usercrm", "messagecrm.CrmMessagesTo=usercrm.userCrmId",
                    "Date(messagecrm.CrmMessagesCreateDate)='" . date("Y-m-d") . "' ");

            }
            $data["title"] = "الرسائل";
            $this->load->view('Admin/testSendMail',$data);
        }
//
//            $data['url'] = base_url();
//        $_SESSION["PAGE"] = "index";
//        $this->load->view('testSendMail',$data);
    }
    public function ClientDetails(){

        if ($_POST['clientid'] !=null){
            $Result = $this->Clients->GetClientByID($_POST['clientid']);
            echo  @json_encode($Result[0]);
        }else{
            echo "Error";
        }

    }
    public function ViewDelayedMission(){
        $data['url'] = base_url();
        $_SESSION["PAGE"] = "ViewDelayedData";
        if(isset($_SESSION['userid'])) {
            $data["calltable"]=1;
            $UserID = $_SESSION["userid"];
            $UserType = 0;
            switch ($_SESSION["usertype"]){
                case 1:

                    $data["emps"]= $this->Model1->selectdata("usercrm", "active=1 and userCrmType!=1",null);
                    $UserType = 0;
                    break;
                case 2:

                    $data["emps"]= $this->Model1->selectdata("usercrm", "active=1 and userCrmType=3 and userCrmSuper=".$_SESSION["userid"],null);
                    $UserType = 1;
                    break;
                case 3:
                    $UserType = 2;
                    break;
            }

            // get client
            $data["clients"] = $this->Employee_Taskes->GetUserClients(null,null,1,$UserID,$UserType);
            $data["title"]="مهام متاخر";
//            print_r("<pre>");
//            print_r($data);
//            print_r("<pre>");die();
            $_SESSION['FromPage'] = 'ViewDelayedMission';
            $this->load->view('Delayedmission',$data);

        }else{
            $this->load->view('login',$data);
        }
    }
    public function ReAssign(){
        if ($_POST['clientid'] !=null && $_POST['EmpID'] !=null ){
            $client = $_POST['clientid'] ;
            $employee = $_POST['EmpID'] ;
            if (isset($_POST["status"]))
                $this->Employee_Taskes->ReAssign($employee,$client,$_POST["status"]);
            else
                $this->Employee_Taskes->ReAssign($employee,$client);
            echo "1";
        }else{
            echo "0";
        }
    }
    public function ReAssignTasks(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else {


            // In New Updates By Abdalraheem Kamel
            $customerid = explode(",", $_POST["customerid"]);
            // Get Supervisor ID Using Employee ID
            $UserID = $_POST['emp'];
            foreach ($customerid as $ID) {
                if ($ID != '') {
                    $this->Employee_Taskes->ReAssign($UserID,$ID);

                }
            }
            $data["title"] = "مهام متاخر";

            $data["supers"] = $this->Model1->selectdata("usercrm", "userCrmType=2", null);
            $data["emps"] = $this->Model1->selectdata("usercrm", "userCrmType!=1", null);
            $data["reset"] = $this->Model1->selectdata("customercrm", ["customerCrmEmp" => 0], null);

            echo 0;
        }
    }
    public function import_dump($folder_name = null , $file_name = "my_db_backup.sql") {
        $folder_name = 'dumps';
        $path = 'assets/db_backup/'; // Codeigniter application /assets
        $file_restore = $this->load->file($path  . '/' . $file_name, true);
        $file_array = explode(';', $file_restore);
        foreach ($file_array as $query)
        {
            $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
            $this->db->query($query);
            $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
        }
    }
    public function getDelayedCalls(){
        if (isset($_SESSION['DelayedCalls']))
            $resultData['DelayedCalls'] =$_SESSION['DelayedCalls'];
        else
            $resultData['DelayedCalls']=0;
        echo json_encode($resultData);
    }
    private function UpdateDelayedCalls($UserID){
        $count = $this->db->query("select count(*) as count from employees_tasks where userID = $UserID and (Follow_Date <= now()  or (Follow_Date = now() and Follow_Time < date('".date("h:i:s")."') ))")->result();
        $this->db->query("update user_messages set Delayed_Calls = ".$count[0]->count." where userID = $UserID");
    }


    public function CustomerOrder(){
        $data['url'] = base_url();

        if(!isset($_SESSION['userid']))
        {
            $this->load->view('login',$data);
        }
        else
        {
            $statusid=$_POST["status"];
            $row["CallStatus"]=$statusid;
            $row["callstatusreturn"]=0;
            $clientid=$_POST["clientid"];
            $cond["customerCrmId"]=$clientid;
            if(!empty($_POST["comment"]))
            {
                $row["note"]=$_POST["comment"];
                $newData['Notes']=$_POST["comment"];
                $this->Clients->AddClientNote($_SESSION["userid"],$clientid,$_POST["comment"]);
            }
            if(!empty($_POST["date"]))
            {
                $date=$_POST["date"];
                $time=$_POST["time"];
                $datetime= date('Y-m-d H:i:s', strtotime("$date $time"));
            }
            if(!empty($_POST["truck"]))
            {
                $row["truckway"]=$_POST["truck"];
                $row["truckdate"]=$datetime;
            }
            else
            {
                if (!empty($datetime))
                    $row["follow"]=$datetime;
            }
            $row["endcall"]=date("Y-m-d H:i:s");
            $newData['Status']=$statusid;
            $newData['endcall']=date("Y-m-d H:i:s");
            $callStatus = $this->Call_Status->GetCallStatus(4);
            $IsFollow = false;
            foreach ($callStatus as $Status){
                if ($Status->id == $statusid);
                $IsFollow = true;
                break;
            }
            if (isset($_POST["date"]) && isset($_POST["time"])){
                if ($IsFollow){
                    $newData['Follow_Date'] = $_POST["date"];
                    $newData['Follow_Time'] = $_POST["time"];
                }
            }
            $CID['clientID'] =$clientid;
            $this->Model1->updatedata("employees_tasks",$CID,$newData );
            $this->User_Log->EndCall($_SESSION["userid"]);
            $user=$this->Model1->selectdata("customercrm", ["customerCrmId"=>$clientid] );
            $res = $this->Model1->updatedata("customercrm",$cond,$row );
            $resl = $this->Model1->updatedata("usercrm",["userCrmId"=>$user[0]->customerCrmEmp],["usercrmStatus"=>1] );
            if(!empty($_POST["product"]))
            {
                $movie = $_POST['product'];
                $row1["customerId"]=$clientid;
                foreach($movie AS $title) {
                    $row1["prouductCrmId"]=$title;
                    $result=$this->Model1->addtotable("customerproductcrm",$row1 );
                }
            }
            if (isset($_SESSION['FromPage']) && !is_null($_SESSION['FromPage'])){
                $redierictTo =$_SESSION['FromPage'] ;
                $_SESSION['FromPage'] = null;
                $this->$redierictTo();
            }else{
                $this->mission();
            }

        }
    }
}