<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 10/10/2018
 * Time: 1:05 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class CRM_Users extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->model('Users_Model');
        $this->load->model('Employee_Taskes');
        $this->load->model('User_Log');
        $this->load->model('InternalMessages');
        $this->load->model('CRM_User_Log');
        $this->load->model('Model1');
        $this->load->model('Customers_Model');
        $this->load->model('Call_Status');
        $this->load->model('CRM_FollowsModel');
        $this->load->model('ReportModel');
        $this->load->model('NotificationModel');
        $this->load->model('premissions');
        session_start();

    }
    private function GetPermissinsArray($Permissions){
        $result='';
        foreach ($Permissions as $p) {

            $result["$p->Object_Code"] = $p->IsGranted;
        }

        return $result;
    }
    public function logout()
    {
        try
        {
            $this->Users_Model->LogOut($_SESSION["userid"]);
            session_destroy();
            redirect("CRM_Users/index");
        } catch (Exception $e) {
            header("Refresh:0");
        }
    }
    public function index($dateRange=null)
    {
        $data['url'] = base_url();

        $_SESSION["PAGE"] = "index";
        if(isset($_SESSION['userid'])){
            if ($_SESSION['usertype'] == 1){
                $data["UnreadComplaints"]=  $this->InternalMessages->GetUnReadComplaint();
            }else{
                $data["UnreadComplaints"]=0;
            }
            $this->SetLastSeen();
            $this->CheckOfflineUser();


            // get User type And Check if = 4 redirect to first Page in his permissions
            if ($_SESSION['usertype'] == 4){
                $Userpremissions= $this->premissions->get_UserpremissionsList($_SESSION['userid']);
                for ($i=0;$i<count($Userpremissions);$i++){
                    if ($Userpremissions[$i]->IsGranted == 1){
                        switch ($Userpremissions[$i]->Object_Code){
                            case '01':
                                redirect(site_url("Mission/Assign"));return;
                                break;
                            case '02':
                                redirect(site_url("reports/employee/3"));return;
                                break;
                            case '04':
                                redirect(site_url("Transfer"));return;
                                break;
                            case '05':
                                redirect(site_url("CRM_Follows/DelayedCalls"));return;
                                break;
                            case '06':
                                redirect(site_url("CRM_Users"));return;
                                break;
                            case '07':
                                redirect(site_url("users/emails_view"));return;
                                break;
                            case '08':
                                redirect(site_url("Employees"));return;
                                break;
                            case '09':
                                redirect(site_url("Client/Distributors"));return;
                                break;
                            case '10':
                                redirect(site_url("CRM_Messages"));return;
                                break;
                            case '11':
                                redirect(site_url("Mission/Assign"));return;
                                break;
                        }
                    }
                }
                $data["error"]="تعذر تسجيل الدخول لعدم تحديد صلاحياتك كإدارى";

                $this->load->view('login',$data);return;
              //  print_r("<script>alert('لا تملك اى صلاحيات لاستخدام هذا الموقع');</script>");

              //  redirect(site_url("CRM_Users/logout"));return;
            }



            $data["charts"]=1;
            $data["title"]="الصفحة الرئيسية";
            if ($_SESSION['usertype'] != 1 && $dateRange ==null){
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
                    $dateRange = date("Y-m-d")."@".date("Y-m-d");
                }
            }

            $_SESSION['TotalDelayedCalls'] = count($this->CRM_FollowsModel->getUpcoming($_SESSION['userid'],2,$_SESSION['usertype']));
            $totalcolls = $this->CRM_FollowsModel->getCalls($_SESSION['userid']);
//            print_r("<pre>");
//            print_r($totalcolls);
//            print_r("</pre>");die();
            //[0]->UpcommingCalls
            if (isset($totalcolls) && !is_null($totalcolls) && count($totalcolls) > 0){
                $_SESSION['TotalUpcommingCalls'] =  $totalcolls[0]->UpcommingCalls;
            }else{
                $_SESSION['TotalUpcommingCalls'] = 0;
            }

            $status=$this->Customers_Model->call_status(true);
            foreach($status As $row){
                $data["status"][$row['id']]=$this->Customers_Model->GetCalCount($row['id'],$_SESSION['userid'],$_SESSION['usertype'],$dateRange);
            }
            $data['ChartData'] = $this->ReportModel->GetHomeCallsReport($_SESSION['usertype'],$_SESSION['userid'],$dateRange);


            $data['DataChart'] = $this->ReportModel->GetHomeDataReportAdmin($_SESSION['usertype'],$_SESSION['userid']);




            $UserType = $_SESSION['usertype'];
            $UserID = $_SESSION['userid'];
            $stat[0] =intval($this->User_Log->GetUserStatus(2,1,$UserType,$UserID)); // مشرف مفعال
            $stat[1] =intval($this->User_Log->GetUserStatus(2,2,$UserType,$UserID)); // مشرف غير فعال
            $stat[2] =intval($this->User_Log->GetUserStatus(2,3,$UserType,$UserID)); // مشرف فى مكالمة
            $stat[3] =intval($this->User_Log->GetUserStatus(3,1,$UserType,$UserID)); // موظف فعال
            $stat[4] =intval($this->User_Log->GetUserStatus(3,2,$UserType,$UserID)); // موظف غير فعال
            $stat[5] =intval($this->User_Log->GetUserStatus(3,3,$UserType,$UserID)); // موظف فى مكالمة
            $data["stat"]= json_encode($stat);
//            print_r($stat);die();
            if($_SESSION['usertype']==1)
            {
                // Admin
                $data["PotentialCustomers"] = $this->Customers_Model->GetPotentialCustomers($_SESSION['usertype'],null,$dateRange);
                $data["NonDistributors"] = $this->Customers_Model->NonDistributors($_SESSION['usertype'],null,$dateRange);
                $data["Distributors"] = $this->Customers_Model->Distributors($_SESSION['usertype'],null,$dateRange);
                $data["delayedData"] = $this->Customers_Model->delayedData(null,null);
//                 print_r("<pre>");
//                 print_r($data);
//                 print_r("</pre>");die();

                $this->load->view('Admin/home',$data);

            }
            else if($_SESSION['usertype']==2)
            {
                // supervisor
                $data["PotentialCustomers"] = $this->Customers_Model->GetPotentialCustomers($_SESSION['usertype'],$_SESSION['userid'],$dateRange);
                $data["NonDistributors"] = $this->Customers_Model->NonDistributors($_SESSION['usertype'],$_SESSION['userid'],$dateRange);
                $data["Distributors"] = $this->Customers_Model->Distributors($_SESSION['usertype'],$_SESSION['userid'],$dateRange);
                $data["delayedData"] = $this->Customers_Model->delayedData($_SESSION['userid'],$dateRange);
//                print_r("<pre>");
//                print_r($data);
//                print_r("<pre>");die();
// Get Call Chart Data

                $this->load->view('Admin/home',$data);
            }
            else if($_SESSION['usertype']==3)
            {
                // Employee
                $data["PotentialCustomers"] = $this->Customers_Model->GetPotentialCustomers($_SESSION['usertype'],$_SESSION['userid'],$dateRange);
                $data["NonDistributors"] = $this->Customers_Model->NonDistributors($_SESSION['usertype'],$_SESSION['userid'],$dateRange);
                $data["delayedData"] = $this->Customers_Model->delayedData($_SESSION['userid'],$dateRange);
                $data["Distributors"] = $this->Customers_Model->Distributors($_SESSION['usertype'],$_SESSION['userid'],$dateRange);
                $data["missionsCount"] = $this->Customers_Model->missionsCount($_SESSION['userid'],$dateRange);
                $data["missionsDone"] =$this->Customers_Model->missionsDone($_SESSION['userid'],$dateRange);
                $data["missions"] = $this->Customers_Model->missions($_SESSION['userid'],$dateRange);
                // Get Call Chart Data

                $this->load->view('Admin/home',$data);
            }
        }else{
            if (!(isset($_POST['username'])) || !(isset($_POST['password']))){
                $this->load->view('login',$data);
            }else{

                $UserData = $this->Users_Model->CheckData($_POST['username'],md5($_POST['password']));

                if (count($UserData) > 0){
                    if( $UserData != null || count($UserData) ==0){
                        if  ($UserData[0]->active == 0){
                            $data["error"]="Account Disabled";
                            $this->load->view('login',$data);
                            return;
                        }
                        $_SESSION['email'] = $UserData[0]->Email;
                        $_SESSION['userid'] = $UserData[0]->ID;
                        $_SESSION['usertype'] = $UserData[0]->Type;
                        $_SESSION['username']=$UserData[0]->Name;
                        $_SESSION['UserPermissions'] = $this->Users_Model->GetUserPermissions($UserData[0]->ID);
                        $this->Users_Model->Login($_SESSION["userid"]);
                        redirect(site_url("CRM_Users"));
                    }else{
                        $data["error"]="Wrong Username or password";
                        $this->load->view('login',$data);
                    }
                }else{
                    $data["error"]="Wrong Username or password";
                    $this->load->view('login',$data);
                }
            }
        }
    }
    public function SetLastSeen(){
        if (isset($_SESSION["userid"])){
            $this->CRM_User_Log->UpdateLastSeen($_SESSION["userid"]);
        }
    }
    public function CheckOfflineUser(){
        $this->CRM_User_Log->SetOfflineUsers();

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
            $Mcount = count($this->InternalMessages->GetMSGCount($UserID,1));
            $Acount = count($this->InternalMessages->GetMSGCount($UserID,3));
            if (isset($_SESSION['MessageCount'])){
                if ($_SESSION['MessageCount'] < $Mcount){
                    $_SESSION['MessageCount'] =$Mcount;
                    $newrow['messages_count']=$Mcount;
                    $where['userID']=$UserID;
                    $this->Model1->updatedata("user_messages",$where,$newrow );
                    $resultData['Message']= $Mcount;
                }else{
                    $newrow['messages_count']=$Mcount;
                    $where['userID']=$UserID;
                    $this->Model1->updatedata("user_messages",$where,$newrow );
                }
            }else{
                $_SESSION['MessageCount'] = $Mcount;
                $resultData['Message']= $Mcount[0];
            }
            if (isset($_SESSION['AlertCount'])){
                if ($_SESSION['AlertCount'] < $Acount[0]){
                    $_SESSION['AlertCount'] = $Acount[0];
                    $newrow['alerts_count'] = $Acount[0];
                    $where['userID']=$UserID;
                    $this->Model1->updatedata("user_messages",$where,$newrow );
                    $resultData['Alert']= $Acount[0];
                }else{
                    $newrow['alerts_count']=$Acount[0];
                    $where['userID']=$UserID;
                    $this->Model1->updatedata("user_messages",$where,$newrow );
                }
            }else{
                $_SESSION['AlertCount'] = $Acount[0];
                $resultData['Alert']= $Acount[0];
            }
        }
        echo json_encode($resultData);
    }
    public function get_noti_tasks(){
        $today_date=date('Y-m-d');
        $now_time=date('H:i:s');
        $sql='select * from crm_follows where Follow_Date=? and';
        $arr=[$today_date];
        $today_date=date('Y-m-d');
        $now_time=date('H:i:s');
        if($_SESSION['usertype']==1){
            $sql .=' Follow_Time >= now() + INTERVAL 5 minute';
        }else if($_SESSION['usertype']==2){
            $sql .=' Follow_Time >= now() - INTERVAL 15 minute';
        }else if($_SESSION['usertype']==3){
            $sql .=' Follow_Time >= now() - INTERVAL 30 minute';
        }
        $noti=$this->Data_model->Select($sql,$arr,'A');
        if($noti !='0'){
            return 1;
        }else{
            return 0;
        }

    }
    public function getDelayedCalls(){


        $userID = $_SESSION['userid'];
        $userType = $_SESSION['usertype'];

        switch ($userType){
            case 1:
                // for admin
                // 30
                $time = 30;
                $resultData['DelayedCalls'] = count($this->Call_Status->getDelayedCalls($time));
                break;
            case 2:
                // for Supervisor
                // 15
                $time = 15;
                $resultData['DelayedCalls'] = count($this->Call_Status->getDelayedCalls($time,$userID,$userType));
                break;
            case 3:
                // for Employee
                //-5
                $time = -5;
                $resultData['DelayedCalls'] = count($this->Call_Status->getDelayedCalls($time,$userID,$userType));
                break;
        }

        echo json_encode($resultData);
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



    private function UpdateDelayedCalls($UserID){
        $count = $this->db->query("select count(*) as count from employees_tasks where userID = $UserID and (Follow_Date <= now()  or (Follow_Date = now() and Follow_Time < date('".date("h:i:s")."') ))")->result();
        $this->db->query("update user_messages set Delayed_Calls = ".$count[0]->count." where userID = $UserID");
    }


    function SendNotification(){

        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
            return;
        }else{
            if (!isset($_SESSION['notifyTime']) || is_null($_SESSION['notifyTime'])){
                $_SESSION['notifyTime']= $this->Users_Model->GetNotifyTime();
            }

            $Upcoming = 0;
            $Delayed = 0;
            $userType = $_SESSION['usertype'];
            $userID = $_SESSION['userid'];
            $notification = $this->NotificationModel->GetUserNotification($userID,$userType);

            if (!is_null($notification) && count($notification)>0){
                for ($i=0;$i < count($notification) ; $i++){


                    $time = strtotime($notification[$i]->Follow_Time);
                    if (($time+300) <= time() && ($time+600)> time()){
                        if ($notification[$i]->After5M == 0){
                            $Delayed++;
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,1);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,2);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,3);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,4);
                        }
                    }else  if (($time+600) <= time() && ($time+900) > time()){
                        if ($notification[$i]->After10M == 0){
                            $Delayed++;
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,1);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,2);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,3);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,4);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,5);
                        }
                    } if (($time+900) <= time() && ($time+1200) > time()){
                        if ($notification[$i]->After15M == 0){
                            $Delayed++;
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,1);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,2);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,3);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,4);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,5);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,6);
                        }
                    }
                    if (($time - 900 ) <= time() && ($time - 600) > time()){
                        if ($notification[$i]->Befor15M == 0){
                            $Upcoming++;
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,1);
                        }
                    }else  if (($time - 600) <= time() && ($time - 300) > time()){
                        if ($notification[$i]->Befor10M == 0){
                            $Upcoming++;
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,1);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,2);
                        }
                    }else if (($time - 300) <= time() && $time > time()){
                        if ($notification[$i]->Befor5M == 0){
                            $Upcoming++;
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,1);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,2);
                            $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,3);
                        }
                    }
                    if ($userType == 2 ){
                        if (($time+1200) <= time() && ($time+1800) > time()){
                            //  echo "asdsa";
                            if ($notification[$i]->ForSupervisor == 0){
                                $Delayed++;
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,1);
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,2);
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,3);
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,4);
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,5);
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,6);
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,7);
                            }
                        }
                    }
                    $today_dt = new DateTime(date("Y-m-d"));
                    $expire_dt = new DateTime($notification[$i]->Follow_Date);
                    // get time from database or checked for sesstion



                    if ($userType == 1){
                        if ($_SESSION['notifyTime'] > 0){
                            if (($time+($_SESSION['notifyTime']*60)) < time() || $expire_dt < $today_dt){
                                if ($notification[$i]->ForAdmin  !=1)
                                    $Delayed++;

                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,1);
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,2);
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,3);
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,4);
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,5);
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,6);
                                $this->NotificationModel->UpdateNotificationStatus($notification[$i]->ID,8);
                            }
                        }
                    }
                }
            }
            $resultData['Upcoming'] = $Upcoming;
            $resultData['Delayed'] = $Delayed;
            echo json_encode($resultData);

        }



    }

    function SaveNotify(){
        $newTime = $_POST['newTime'];
        if (isset($newTime) && !is_null($newTime)){
            $this->Users_Model->SetNotifyTime($newTime);
            echo 1;
        }else{
            echo 0;
        }


        //SetNotifyTime
    }

}