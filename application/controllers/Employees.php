<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 10/10/2018
 * Time: 4:32 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->model('Model1');
        $this->load->model('Employee_Taskes');
        $this->load->model('User_Log');
        $this->load->model('InternalMessages');
        $this->load->model('Users_Model');
        $this->load->model('premissions');
        session_start();

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
    public function index()
    {
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'08');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $per = $this->premissions->get_premissions($_SESSION['userid'],"08");
            if ($_SESSION['usertype'] == 1 || $per == 1 || $_SESSION['usertype'] == 2 ){
                $_SESSION["PAGE"] = "Employees";
                $data["calltable"]=1;
                //get permissions
                if ($_SESSION["usertype"]==1 || $per == 1){
                    $data["emps"] = $this->Model1->selectdata("crm_users", "Type=3 and ID !=".$_SESSION['userid'] );
                    $data["supers"] = $this->Model1->selectdata("crm_users", "Type=2 and ID !=".$_SESSION['userid'] );
                    $data["Administrative"] = $this->Model1->selectdata("crm_users", "Type=4 and ID !=".$_SESSION['userid'] );

                }else{
                    $data["emps"] = $this->Model1->selectdata("crm_users", "Type=3 and Super =".$_SESSION['userid']." and ID !=".$_SESSION['userid']);
                }
                $data["title"]="الموارد البشرية";

                $this->load->view('Employees/Index',$data);

            }else{
                redirect(site_url("CRM_Users"));
            }
        }
    }
    public function Add(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'08');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($_SESSION['usertype'] == 1|| ($this->get_premissions($_SESSION['userid'],'08') == 1 && $_SESSION['usertype'] == 3)){
                $data["title"]="اضافه مستخدم";
                $data["supers"]=$this->Users_Model->GetSupervisors();
                $data["permissions"] = $this->premissions->get_premissionsList();
                $this->load->view('Employees/Add', $data);
            }else{
                redirect(site_url("CRM_Users"));
            }
        }
    }
    public function Create(){
        $data['url'] = base_url();
        $data["title"]="اضافه مستخدم";
        if(!isset($_SESSION['userid'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'08');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($_SESSION['usertype'] == 1||$this->get_premissions($_SESSION['userid'],'08') == 1){
                if (!(empty($_POST['name'])) && !(empty($_POST['phone'])) && !(empty($_POST['email']))
                    && !(empty($_POST['type'])) && !(empty($_POST['username'])) && !(empty($_POST['password'])) )
                {
                    if ($_POST['type'] >= 2 && $_POST['type'] <= 4){
                        if(!$this->Users_Model->CheckEmployeeData($_POST['username'],$_POST['email'])) {
                            // Add User Data
                            $UserData['Name'] = $_POST['name'];
                            $UserData["UserName"] = $_POST['username'];
                            $UserData["Pass"] = md5($_POST['password']);
                            $UserData["Email"] = $_POST['email'];
                            $UserData["Phone"] = $_POST['phone'];
                            if (!empty($_POST['birthdate'])) {
                                $UserData["BirthDate"] = $_POST['birthdate'];
                            }
                            if (!empty($_POST['type'])) {
                                $UserData["Type"] = $_POST['type'];
                            }
                            if (!empty($_POST['joinDate'])) {
                                $UserData["JoinDate"] = $_POST['joinDate'];
                            }
                            if (!empty($_POST['salary'])) {
                                $UserData["Salary"] = $_POST['salary'];
                            }
                            if (!empty($_POST['annualInc'])) {
                                $UserData["AnnInc"] = $_POST['annualInc'];
                            }
                            if (!empty($_POST['target'])) {
                                $UserData["SellInc"] = $_POST['target'];
                            }

                            if (!empty($_POST['address'])) {
                                $UserData["Address"] = $_POST['address'];
                            }
                            if (!empty($_POST['nmess'])) {
                                $UserData["num_message"] = $_POST['nmess'];
                            }


                            if ($UserData["Type"] != 3 && $UserData["Type"] != 4) {
                                $UserData["Super"] = NULL;
                            } else {
                                if (!empty($_POST['supervisor']))
                                    $UserData["Super"] = $_POST['supervisor'];
                                else
                                    $UserData["Super"] = $_SESSION['userid'];
                            }
                            $this->load->helper("file");
                            $config['upload_path']          = 'ProfielsImages/';
                            $config['allowed_types']        = 'jpg|png';
                            $config['file_name']             = $_POST['username'];
                            $this->load->library('upload', $config);
                            $this->upload->overwrite = true;
                            if ($this->upload->do_upload('imgInp') )
                            {
                                $error = array('error' => $this->upload->display_errors());
                                $data['error'] = true;
                                $data['msg'] = $error;
                                $data['data'] = array('upload_data' => $this->upload->data());
                                $UserData["Image"]=$data['data']['upload_data']["orig_name"];
                                // echo $error;die();
                            }

                            $EmpID= $this->Users_Model->CreateEmployee($UserData);
                            if ($EmpID > 0 ){
                                // add mail server Data
                                if (isset($_POST['mailserver']) &&
                                    isset($_POST['portnumber']) &&
                                    isset($_POST['usermail']) &&
                                    isset($_POST['userpassword']) &&
                                    !is_null($_POST['mailserver']) &&
                                    !is_null($_POST['portnumber']) &&
                                    !is_null($_POST['usermail']) &&
                                    !is_null($_POST['userpassword'])
                                ){
                                    $MailServerData['Emp_ID'] = $EmpID;
                                    $MailServerData['Mail_Address'] = $_POST['usermail'];
                                    $MailServerData['Mail_Password'] = $_POST['userpassword'];
                                    $MailServerData['Mail_Server'] = $_POST['mailserver'];
                                    $MailServerData['Port '] = $_POST['portnumber'];

                                    $MailSettingID = $this->Users_Model->SetMailServerConfig($MailServerData);
                                }

                                if (isset($_POST["permissions"]) && !is_null(isset($_POST["permissions"]))){
                                    for ($i=0;$i<count($_POST["permissions"]);$i++){
                                        $this->Users_Model->SetPermissions($EmpID,$_POST["permissions"][$i],1);
                                    }
                                }




                                redirect(site_url("Employees"));
                                $data["success"]="تم اضافه المستخدم بنجاح";
                            }else{
                                $data["error"]="حدث خطأ اثناء إضافة المستخدم";
                                $data["title"]="اضافه مستخدم";
                                $data["supers"]=$this->Users_Model->GetSupervisors();
                                $data["permissions"] = $this->premissions->get_premissionsList();
                                $this->load->view('Employees/Add', $data);
                            }
                        }
                        else
                        {
                            $data["error"]= "عذرا هذا البريد الالكتروني او اسم المستخدم موجود من قبل";
                            $data["title"]="اضافه مستخدم";
                            $data["supers"]=$this->Users_Model->GetSupervisors();
                            $data["permissions"] = $this->premissions->get_premissionsList();
                            $this->load->view('Employees/Add', $data);
                        }
                    } else
                    {
                        $data["error"]= "حدث خطأ غير متوقع";
                        $data["title"]="اضافه مستخدم";
                        $data["supers"]=$this->Users_Model->GetSupervisors();
                        $data["permissions"] = $this->premissions->get_premissionsList();
                        $this->load->view('Employees/Add', $data);
                    }

                }
                else{
                    $data["error"]= "يجب ادخال  كل البيانات";
                    $data["title"]="اضافه مستخدم";
                    $data["supers"]=$this->Users_Model->GetSupervisors();
                    $data["permissions"] = $this->premissions->get_premissionsList();
                    $this->load->view('Employees/Add', $data);
                }
            }else{
                redirect(site_url("CRM_Users"));
            }
        }
    }
    public function Update($EmpID){
        $data['url'] = base_url();
        $data["title"]="تعديل المستخدم";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'08');

                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($_SESSION['usertype'] == 1|| ($this->get_premissions($_SESSION['userid'],'08') == 1 && $_SESSION['usertype'] == 3)){
                $data['user']=$this->Users_Model->GetUserByID($EmpID);
                $data['supers']=$this->Users_Model->GetSupervisors();
                $data['MailServerConfig']=$this->Users_Model->GetMailServerConfig($EmpID);
                $data["UserPermissions"] = $this->premissions->get_UserpremissionsList($EmpID);
//                print_r("<pre>");
//                print_r($data);
//                print_r("</pre>");die();
                $this->load->view('Employees/Update', $data);
            }else{
                redirect(site_url("CRM_Users"));
            }
        }
    }
    public function Modifier(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'08');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }

            if ($_SESSION['usertype'] == 1|| ($this->get_premissions($_SESSION['userid'],'08') == 1 && $_SESSION['usertype'] == 3)){
                if (!(empty($_POST['name'])) && !(empty($_POST['phone'])) && !(empty($_POST['email']))
                    && !(empty($_POST['type'])) && !(empty($_POST['username']))  )
                {
                    $UserData['Name'] = $_POST['name'];
                    $UserData["UserName"] = $_POST['username'];
                    if (!empty($_POST['password'])){
                        $UserData["Pass"] = md5($_POST['password']);
                    }
                    $EmpID= $_POST['UserID'];
                    if (isset($_POST['mailserver']) &&
                        isset($_POST['portnumber']) &&
                        isset($_POST['usermail']) &&
                        isset($_POST['userpassword']) &&
                        !is_null($_POST['mailserver']) &&
                        !is_null($_POST['portnumber']) &&
                        !is_null($_POST['usermail']) &&
                        !is_null($_POST['userpassword'])
                    ){
                        $MailServerData['Emp_ID'] = $EmpID;
                        $MailServerData['Mail_Address'] = $_POST['usermail'];
                        $MailServerData['Mail_Password'] = $_POST['userpassword'];
                        $MailServerData['Mail_Server'] = $_POST['mailserver'];
                        $MailServerData['Port '] = $_POST['portnumber'];

                        $mailServerConfig = $this->Users_Model->GetMailServerConfig($EmpID);

                        if (count($mailServerConfig) > 0){
                            // Update
                            $this->Users_Model->updateMailServerConfig($mailServerConfig[0]->ID,$MailServerData);
                        }else{
                            // insert
                            $this->Users_Model->SetMailServerConfig($MailServerData);
                        }
                    }

                    $UserData["Email"] = $_POST['email'];
                    $UserData["Phone"] = $_POST['phone'];
                    if (!empty($_POST['birthdate'])) {
                        $UserData["BirthDate"] = $_POST['birthdate'];
                    }

                    if (!empty($_POST['type'])) {

                        $UserData["Type"] = $_POST['type'];
                    }
                    if (!empty($_POST['joinDate'])) {
                        $UserData["JoinDate"] = $_POST['joinDate'];
                    }
                    if (!empty($_POST['salary'])) {
                        $UserData["Salary"] = $_POST['salary'];
                    }
                    if (!empty($_POST['annualInc'])) {
                        $UserData["AnnInc"] = $_POST['annualInc'];
                    }
                    if (!empty($_POST['target'])) {
                        $UserData["SellInc"] = $_POST['target'];
                    }

                    if (!empty($_POST['address'])) {
                        $UserData["Address"] = $_POST['address'];
                    }
                    if (!empty($_POST['nmess'])) {
                        $UserData["num_message"] = $_POST['nmess'];
                    }
                    if ($UserData["Type"] == 2 ||$UserData["Type"] == 4 ) {
                        $UserData["Super"] = null;
                    } else {
                        if (!empty($_POST['supervisor'])){
                            if ($_POST['type']==3){
                                $UserData["Super"] = $_POST['supervisor'];
                            }else{
                                $UserData["Super"] = null;
                            }

                        }

                        else
                            $UserData["Super"] = $_SESSION['userid'];
                    }

//                print_r("<pre>");
//                print_r($_POST);
//                print_r("</pre>");die();
                    $this->load->helper("file");
                    $config['upload_path']          = 'ProfielsImages/';
                    $config['allowed_types']        = 'jpg|png';
                    $config['file_name']             = $_POST['username'];
                    $this->load->library('upload', $config);
                    $this->upload->overwrite = true;
                    if ($this->upload->do_upload('imgInp') )
                    {
                        $error = array('error' => $this->upload->display_errors());
                        $data['error'] = true;
                        $data['msg'] = $error;
                        $data['data'] = array('upload_data' => $this->upload->data());
                        $UserData["Image"]=$data['data']['upload_data']["orig_name"];
                        // echo $error;die();
                    }

                    $this->Users_Model->UpdateUserData($UserData,$EmpID);

                    $this->Users_Model->UpdateUserPermissions($EmpID,$_POST["permissions"]);


                    redirect(site_url("Employees"));
                    $data["success"]="تم اضافه المستخدم بنجاح";

                }else{
                    $data["error"]= "يجب ادخال  كل البيانات";
                    $data['user']=$this->Users_Model->GetUserByID($_POST['UserID']);
                    $data['supers']=$this->Users_Model->GetSupervisors();
                    $data['MailServerConfig']=$this->Users_Model->GetMailServerConfig($_POST['UserID']);
                    $data["UserPermissions"] = $this->premissions->get_UserpremissionsList($_POST['UserID']);


                    $this->load->view('Employees/Update', $data);
                }




            }else{
                redirect(site_url("CRM_Users"));
            }
        }
    }
    public function DeActive(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'08');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($_SESSION['usertype'] == 1|| ($this->get_premissions($_SESSION['userid'],'08') == 1 && $_SESSION['usertype'] == 3)){

                $this->Users_Model->DeActive($_POST['userid'],$_POST['status']);

            }else{
                redirect(site_url("CRM_Users"));
            }
        }
    }

    function Delete(){

        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'08');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($_SESSION['usertype'] == 1|| ($this->get_premissions($_SESSION['userid'],'08') == 1 && $_SESSION['usertype'] == 3)){

                if (isset($_POST['userid']) && !is_null($_POST['userid'])){
                    // get Tasks Count
                    if (count($this->Employee_Taskes->GetAllUserTasks($_POST['userid'])) > 0 ||
                        count($this->Employee_Taskes->GetAllUserFollowTasks($_POST['userid'])) > 0){
                        $result['error'] = 1;
                        $result['message'] = 'يوجد مهام مع هذا الموظف برجاء توزيعهم';
                        echo json_encode($result);return;
                    }else{
                        $this->Users_Model->Delete($_POST['userid']);
                        $result['error'] = 0;
                        $result['message'] = 'تم حذف الموظف بنجاح';
                        echo json_encode($result);return;
                    }
                }else{
                    $result['error'] = 1;
                    $result['message'] = 'حدث خطأ أثناء عملية الحذف';
                    echo json_encode($result);return;
                }
            }else{
                redirect(site_url("CRM_Users"));
            }
        }
    }

}