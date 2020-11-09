<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 13/10/2018
 * Time: 12:06 ص
 */

class Mission extends CI_Controller {

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
        $this->load->model('premissions');
        $this->load->model('Customers_Model');
        $this->load->model('Follows');
        session_start();

    }
    public function index(){

        $data['url'] = base_url();
        $data["title"]="مهامي";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] >1){
                $UserID = $_SESSION['userid'];
                // get user Missions
                $data["clients"]=$this->Employee_Taskes->GetUserTaskes($UserID);
                $data["total"] = $this->Employee_Taskes->GetTasksCount(date("Y-m-d"),date("Y-m-d"),0,$UserID);
                // Get Total remainder Tasks
                $data["remainder"] = $this->Employee_Taskes->GetTasksCount(date("Y-m-d"),date("Y-m-d"),1,$UserID); //done
                // Get Total Completed Tasks
                $data["Completed"] =$data["total"] -$data["remainder"];


                redirect(site_url("CRM_Users"));
            }else{
                redirect(site_url("CRM_Users"));
            }


        }
    }
    public function Assign($dateRange=null){
        $data['url'] = base_url();
        $data["title"]="تعيين مهام";
        $_SESSION["PAGE"] = "task_view";






        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{

            if ($_SESSION['usertype'] ==  4){
                $UploadFile =$this->premissions->get_premissions($_SESSION["userid"],'01');
                $AssignMissions =$this->premissions->get_premissions($_SESSION["userid"],'11');
                if  ($UploadFile !=1 && $AssignMissions !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($dateRange == null){
                $date1 =  date("Y-m-d") ;
                $date2 =  date("Y-m-d");
            }else{
                $dateArray = explode("@",$dateRange);
                $date1 =    $dateArray[0] ;
                $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
            }
            $data["date1"] =$date1;
            $data["date2"] =$date2;
            $per=$this->premissions->get_premissions($_SESSION['userid'],'11');
            $per2=$this->premissions->get_premissions($_SESSION['userid'],'01');

            if ($_SESSION['usertype'] ==  1 || $per == 1 || ($_SESSION['usertype'] ==  4 && $per2 == 1) ){
                // Get all employees

                $data["employee"]=$this->Users_Model->GetEmployee($_SESSION['userid']);
                $data["clients"]=$this->Customers_Model->GetCustomers($_SESSION['usertype'],$_SESSION['userid'],$dateRange,$per);
                $data["AllData"] = $this->Customers_Model->GetPotentialCustomers(1,null,$dateRange);
                $this->load->view('Mission/Assign', $data);
                print_r("<pre>");
                print_r($data);
                print_r("</pre>");die();
            }
            else if ($_SESSION['usertype'] == 2 && $per != 1 ){
                // get User Employees
                $data["employee"]=$this->Users_Model->GetSuperVisorEmployee($_SESSION['userid']);
                $data["clients"]=$this->Customers_Model->GetCustomers($_SESSION['usertype'],$_SESSION['userid'],$dateRange);
                $data["AllData"] =$this->Customers_Model->GetPotentialCustomers($_SESSION['usertype'],$_SESSION['userid'],$dateRange);
                print_r("<pre>");
                print_r($data);
                print_r("</pre>");die();
                $this->load->view('Mission/Assign', $data);
            }
            else{
                redirect(site_url("CRM_Users"));
            }
        }
    }
    public function asgin_user()
    {
        $data['url'] = base_url();
        $data["title"]="تعيين مهام";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            redirect(site_url("CRM_Users"));
        }
        else
        {
            if ($_SESSION['usertype'] < 3||
                $this->premissions->get_premissions($_SESSION['userid'],'11') == 1 ){
               $customerid = explode(",", $_POST["customerid"] );
                // Get Supervisor ID Using Employee ID
                $SuperID = $this->Users_Model->GetEmployeeSuper($_POST["emp"]);
                //Add notification
                $this->Employee_Taskes->addNotification($_POST["emp"]);
                $inputData['userID']=$_POST["emp"];
                $inputData['supervisor_ID']=$SuperID;
                $inputData['Date']=date("Y:m:d");
                $inputData['Time']=date("h:i:sa");
                $inputData['Distributor_By']=$_SESSION['userid'];
                $inputData['Status']=1;
               // print_r($_POST["customerid"]);die();
                foreach ($customerid as $ID){
                    if ($ID !=''){
                        // if Existed Update It
                        $ClientData = $this->Employee_Taskes->IsExisted($ID);
                        if (count($ClientData) > 0 ){
                            if (count($this->Follows->isFollow($ID)) > 0){
                                $inputData['redirect']=true;
                                $where['ClientID'] = $ID;
                                $follow['UserID'] = $_POST["emp"];

                                $time = strtotime(date("h:i:sa")) +8100;
                                $time = new DateTime("@$time");
                                $time=$time->format('H:i:s');
//                                $time=$time->format('H:i:s');
                                $follow['Follow_Time'] = $time;
                                // print_r($time);die();
                                $follow['Follow_Date'] = date("Y:m:d");

                                $this->Follows->resetFollow($where,$follow);
                                $this->Employee_Taskes->ReAssignExisted($ClientData[0]->id,$_POST["emp"],$SuperID,$_POST["status"],1);
                            }else{
                                $this->Employee_Taskes->ReAssignExisted($ClientData[0]->id,$_POST["emp"],$SuperID,$_POST["status"]);
                            }
                        }else{
                            if (count($this->Follows->isFollow($ID)) > 0){
                                $inputData['redirect']=true;
                                $where['ClientID'] = $ID;
                                $follow['UserID'] = $_POST["emp"];
                                $this->Follows->resetFollow($where,$follow);
                            }
                            $inputData['clientID']=$ID;
                            $this->Employee_Taskes->Assign($inputData);
                        }

                        // update follows

                    }
                }
                echo 0;
            }else{
                redirect(site_url("CRM_Users"));
            }

        }

    }
    public function Delete_Client()
    {
        $data['url'] = base_url();
        $data["title"]="تعيين مهام";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            redirect(site_url("CRM_Users"));
        }
        else
        {
            $customerid =  $_POST["customerid"];
            $count = count($customerid);
            if ($count > 0){
                $where = "";
                foreach ($customerid as $ID){
                    if ($ID !=''){
                        $where .="customerCrmId=".$ID;
                        // $this->Customers_Model->DeleteCustomers($ID);
                        if ($count > 2){
                            $where .=" or ";
                            $count--;
                        }
                    }
                }

                echo  $this->Customers_Model->DeleteCustomers($where);
            }

        }

    }

    public function DeleteDistributorClient()
    {
        $data['url'] = base_url();
        $data["title"]="تعيين مهام";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            redirect(site_url("CRM_Users"));
        }
        else
        {
            $customerid = explode(",",$_POST["customerid"]);

            $count = count($customerid);
            if ($count > 0){
                $where = "";
                foreach ($customerid as $ID){
                    if ($ID !=''){
                        $where .="customerCrmId=".$ID;
                        // $this->Customers_Model->DeleteCustomers($ID);
                        if ($count > 2){
                            $where .=" or ";
                            $count--;
                        }
                    }
                }

                echo  $this->Customers_Model->DeleteCustomers($where);
            }

        }

    }

    function GetUserNotifications(){
        $result = $this->Employee_Taskes->IsExistedNotification($_SESSION['userid']);
        $this->Employee_Taskes->deleteNotification($_SESSION['userid']);
        if ($result)
            echo 1;
        else
            echo 0;
    }
}