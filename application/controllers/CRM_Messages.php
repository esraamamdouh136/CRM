<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 15/10/2018
 * Time: 06:24 م
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class CRM_Messages extends CI_Controller
{
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
        $this->load->model('Comments');
        $this->load->model('CRM_MessagesModel');
        $this->load->model('premissions');

        session_start();

    }

    public function index()
    {

        $data['url'] = base_url();
        $_SESSION["PAGE"] = "message_view";
        if(isset($_SESSION['userid'])){
            $userID = $_SESSION['userid'];
            $per=$this->premissions->get_premissions($_SESSION['userid'],'10');
            if ($_SESSION['usertype'] == 1 || $per == 1){
                $data["Circulated"] =  $this->CRM_MessagesModel->GetCirculated($userID);
            }
            $data["received"] =  $this->CRM_MessagesModel->GetReceived($userID);

            $data["sent"]  =  $this->CRM_MessagesModel->GetSend($userID);

            $data["emp"]=$this->Users_Model->GetUsers($userID);


            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'10');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }


            $data["title"]="الرسائل الداخلية";
//usertype
//            print_r("<pre>");
//            print_r($data);
//            print_r("</pre>");die();
            $this->load->view('Messages/index', $data);
        }else{
            $this->load->view('login', $data);
        }
    }
    public function sendMessage(){


        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'10');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $from=$_SESSION['userid'];
            $MessageData['UserID'] =$from ;
            $MessageData['Titel'] = $_POST["title"];
            $MessageDetails['Message_Details'] = htmlspecialchars($_POST["content"]);
            $MessageDetails['Owner_ID'] = $from;
            //get all admins
//            $admins =$this->Users_Model->GetUsersByTypes(1,$_SESSION['userid']);
//            for ($i=0;$i<count($admins);$i++){
//                if (array_search($admins[$i]->ID,$_POST['mto']) <=0){
//                    array_push($_POST['mto'],$admins[$i]->ID);
//                }
//            }
           // print_r($_POST);die();
            if(!empty($_POST["mto"]))
            {



                $ToUsers = $_POST['mto'];

                $this->CRM_MessagesModel->AddMessage($MessageData,$MessageDetails,$ToUsers);

            }
            redirect(site_url("CRM_Messages"));
        }
    }
    public function ReplayMessage(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'10');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $MessageData['Message_ID'] =$_POST['msgID'] ;
            $MessageData['Message_Details'] = htmlspecialchars($_POST["content"]);
            $MessageData['Owner_ID'] =$_SESSION['userid'];
            $this->CRM_MessagesModel->ReplyMessage($MessageData);
            $this->CRM_MessagesModel->RenewMessage($_POST['msgID']);
            redirect(site_url("CRM_Messages"));
        }
    }


    function message_details($msgID){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            redirect(site_url("CRM_Users"));
        }else {
            if ($msgID == null){
                redirect(site_url("CRM_Messages"));
            }else{
                if ($_SESSION['usertype'] ==  4){
                    $Reports =$this->premissions->get_premissions($_SESSION["userid"],'10');
                    if  ($Reports !=1){
                        redirect(site_url("CRM_Users"));return;
                    }
                }
                $data["title"]="تفاصيل الرساله";
                $data['MessageDetails'] = $this->CRM_MessagesModel->GetMessageDetails($msgID);
                $this->CRM_MessagesModel->SetRead($msgID,$_SESSION['usertype'],$_SESSION['userid']);
                $this->load->view('message_details',$data);
            }
        }
    }

    public function Delete(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            redirect(site_url("CRM_Users"));
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'10');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ( !(empty($_POST['messid']))){
                $this->InternalMessages->DeleteMessage($_POST["messid"]);
                echo 1;
            }else{

                echo 0;


            }
        }
    }
    function DeleteInstruction(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            redirect(site_url("CRM_Users"));
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'10');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }

            if ( !(empty($_POST['messid']))){
                $result =  $this->CRM_MessagesModel->Delete($_POST["messid"],$_SESSION['usertype'],$_SESSION["userid"]);
                if ($result >= 0 )
                    echo 1;
                else
                    echo 0;
            }else{
                echo 0;
            }
        }
    }
    public function sendComplaint(){

        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'10');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $ClientID = $_POST["clientid"];
            $from= $_SESSION['userid'];
            $Messagetitle = $_POST["subject"];
            $content = $_POST["content"];
            $Message_Type = $_POST["complain"];
            $ISRead = 0;
            $msgData['From_User']=$from;
            $msgData['Titel']=$Messagetitle;
            $msgData['Message']=$content;
            $msgData['ISRead']=$ISRead;
            $msgData['ownerUserID']=$from;
            $msgData['Message_Type']=$Message_Type;
            $msgData['Client_ID']=$ClientID;
            // get Admins
            $admins = $this->Users_Model->GetUsersByTypes(1);
            foreach ($admins as $adminID) {
                if ($adminID->ID != $from){
                    $msgData['To_User']=$adminID->ID;
                    $msgData['ownerUserID']=$from;
                    $this->InternalMessages->SendMessages($msgData);
                    $msgData['ownerUserID']=$adminID->ID;
                    $this->InternalMessages->SendMessages($msgData);
                }
            }
            // get Supervisors

            if ($_SESSION['usertype'] ==3 ){
                $Super = $this->Users_Model->GetSupervisors($from);
                $msgData['To_User']=$Super[0]->ID;
                $msgData['ownerUserID']=$Super[0]->ID;
                $this->InternalMessages->SendMessages($msgData);
            }
        }
    }
    public function AddComment(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            $CommentData['ClientID'] = $_POST["clientid"];
            $CommentData['UserID'] = $_SESSION["userid"];
            $CommentData['Comment_Text'] = htmlspecialchars($_POST["content"]) ;
            $CommentData['date']=date("Y:m:d");
            $CommentData['time']=date("H:i:s");

            if ($this->Comments->AddClientComments($CommentData) == 0){
                echo 0;
            }else{
                echo 1;
            }
        }
    }

}