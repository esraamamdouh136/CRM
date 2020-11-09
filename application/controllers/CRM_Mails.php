<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 22/10/2018
 * Time: 12:25 م
 */

class CRM_Mails extends CI_Controller
{
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
        $this->load->model('Clients');
        $this->load->model('User_Log');
        $this->load->model('Users_Model');
        $this->load->model('InternalMessages');
        $this->load->model('MailModel');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');
        $this->load->model('premissions');
    }
    public function sendemail(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'7');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $result = 1;
            $communicationData = $this->Users_Model->GetMailServerConfig($_SESSION['userid']);
            $email_Address = '';

            if (count($communicationData) <= 0  || is_null($communicationData) ){
                $communicationData = $this->Model1->selectdata("communication_settings");
            }
            if (count($communicationData) <= 0 || strlen($communicationData[0]->Mail_Server) <=0 ){

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
                //echo "asdsa";
                return;
            }

            //die();
            $row["UserID"]=$_SESSION["userid"];
            $row["Title"]=$_POST["subject"];
            $row["Message"]=$_POST["content"];

            $row['Date'] = date("Y-m-d");
            if (isset($_POST["clientid"]) && !is_null($_POST["clientid"])){
                if ($_POST["clientid"] > 0 ){
                    $row["ClientID"] = $_POST["clientid"];
                }
            }
            $row["Mail"]=$_POST["mail"];
            $email=$_POST["mail"];
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($email_Address, 'CRM');
            $this->email->subject($_POST["subject"]);
            $this->email->message($_POST["content"] );
            $this->email->to($email);
            // print_r($config);
            if (!$this->email->send())
            {
                $result = 0;
            }
            else {
                $result = 1;
                $this->Model1->addtotable("crm_mails",$row );
            }
            echo $result;


        }
    }


    public function sendBuckMail(){
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



            $row["UserID"]=$_SESSION["userid"];
            $row["Title"]=$_POST["subject"];
            $row["Message"]=$_POST["content"];
            $row['Date'] = date("Y-m-d");
            $clinetsIDs = explode(",", $_POST["to"]);
            $this->load->library('email', $config);
            foreach ($clinetsIDs as $clientID){
                if (!empty($clientID)){

                    $res=$this->Model1->selectdata("customercrm", ["customerCrmId"=>$clientID] );
                    $email=$res[0]->customerCrmEmail;
                    //$email="abdob2623@gmail.com,abdalraheem.kamel@gmail.com,a.kamel@quantumsit.com";
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
                        $row["ClientID"] = $clientID;
                        $row["Mail"] = $email;
                        $this->Model1->addtotable("crm_mails",$row );
                    }

                }
            }
            echo $result;

        }
    }


    function  sendMailWithAttach(){

        $files=array();
        // upload files
        if(!empty($_FILES['file']['name'])) {
            $filesCount = count($_FILES['file']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['mailFiles']['name'] = $_FILES['file']['name'][$i];
                $_FILES['mailFiles']['type'] = $_FILES['file']['type'][$i];
                $_FILES['mailFiles']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
                $_FILES['mailFiles']['error'] = $_FILES['file']['error'][$i];
                $_FILES['mailFiles']['size'] = $_FILES['file']['size'][$i];
                $uploadPath = 'MailFiles/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $filename = 'File_'.date('d-m-Y').time().$i;
                $config['file_name'] = $filename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('mailFiles')) {
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $files[$i]= $fileData['file_name'];
                }
            }
        }
        // send mail

        if (isset($_POST["title"]) && !is_null($_POST["title"]) && !empty($_POST["title"]) &&
            isset($_POST["To"]) && !is_null($_POST["To"]) && !empty($_POST["To"]) &&
            isset($_POST["Mailcontent"]) && !is_null($_POST["Mailcontent"]) && !empty($_POST["Mailcontent"]) ){
            $communicationData = $this->Users_Model->GetMailServerConfig($_SESSION['userid']);
            $email_Address = '';
            if (count($communicationData) <= 0  || is_null($communicationData) ){
                $communicationData = $this->Model1->selectdata("communication_settings");
            }
            if (count($communicationData) <= 0 || strlen($communicationData[0]->Mail_Server) <=0 ){

                $communicationData = $this->Model1->selectdata("communication_settings");
                if (is_null($communicationData) || count($communicationData) <= 0){

                }else{
                    $email_Address = $communicationData[0]->Mail_Address;
                    $config = array(
                        'protocol' => 'smtp',
                        'smtp_host' => $communicationData[0]->Mail_Server,
                        'smtp_port' => $communicationData[0]->Port,
                        'smtp_user' => $communicationData[0]->Mail_Address,
                        'smtp_pass' => $communicationData[0]->Mail_Password,
                        'smtp_crypto' => 'tls',
                        'mailtype'  => 'html'
                    );
                }
            }else if (count($communicationData) > 0 && strlen($communicationData[0]->Mail_Address) >0){
                // Emp SMTP configurations
                $email_Address = $communicationData[0]->Mail_Address;
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => $communicationData[0]->Mail_Server,
                    'smtp_port' => $communicationData[0]->Port,
                    'smtp_user' => $communicationData[0]->Mail_Address,
                    'smtp_pass' => $communicationData[0]->Mail_Password ,
                    'smtp_crypto' => 'tls',
                    'mailtype'  => 'html'
                );
            }else{

            }
            $email=$_POST["To"];
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from($email_Address, 'CRM');
            $this->email->subject($_POST["title"]);
            $this->email->message($_POST["Mailcontent"] );
            $this->email->to($email);
            for ($i=0;$i<count($files);$i++){
                $this->email->attach('MailFiles/'.$files[$i]);
            }
            // print_r($config);
            if (!$this->email->send())
            {
                $result = 0;
            }
            else {
                $result = 1;
                // insert data
                $returnURL='';
                $MailData['UserID'] = $_SESSION['userid'];
                if (isset($_POST['CustomerID']) && !is_null($_POST['CustomerID'])){
                    $clientID = $_POST['CustomerID'];
                    $returnURL = 'Client/Details/'.$clientID;
                }else{
                    $clientID = $this->Clients->GetClientByMail($_POST["To"]);
                    $returnURL = 'users/emails_view';
                }

                if (isset($clientID) && !is_null($clientID) && count($clientID) >0){
                    $MailData['ClientID'] =$clientID[0]->customerCrmId;
                }
                $MailData['Mail'] = $_POST["To"];
                $MailData['Title'] = $_POST["title"];
                $MailData['Date'] = date('Y-m-d');
                $MailData['Message'] = $_POST["Mailcontent"];
                $this->MailModel->addMail($MailData,$files);
                //  $this->Model1->addtotable("crm_mails",$row );
            }

        }


        redirect(site_url($returnURL));


    }



    function  sendbulkMailWithAttach(){

        //  print_r("<pre>");
//        print_r(htmlspecialchars($_POST['Mailcontent']));
//        print_r(addslashes($_POST["Mailcontent"]));
        //print_r($_POST);
        // print_r("</pre>");//die();


        $files=array();
        // upload files
        if(!empty($_FILES['file']['name'])) {
            $filesCount = count($_FILES['file']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['mailFiles']['name'] = $_FILES['file']['name'][$i];
                $_FILES['mailFiles']['type'] = $_FILES['file']['type'][$i];
                $_FILES['mailFiles']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
                $_FILES['mailFiles']['error'] = $_FILES['file']['error'][$i];
                $_FILES['mailFiles']['size'] = $_FILES['file']['size'][$i];
                $uploadPath = 'MailFiles/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $filename = 'File_'.date('d-m-Y').time().$i;
                $config['file_name'] = $filename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('mailFiles')) {
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $files[$i]= $fileData['file_name'];
                }
            }
        }
        // send mail

        if (isset($_POST["title"]) && !is_null($_POST["title"]) && !empty($_POST["title"]) &&
            isset($_POST["mailAddress"]) && !is_null($_POST["mailAddress"]) && !empty($_POST["mailAddress"]) &&
            isset($_POST["Mailcontent"]) && !is_null($_POST["Mailcontent"]) && !empty($_POST["Mailcontent"]) ){
            $communicationData = $this->Users_Model->GetMailServerConfig($_SESSION['userid']);
            $email_Address = '';
            if (count($communicationData) <= 0  || is_null($communicationData) ){
                $communicationData = $this->Model1->selectdata("communication_settings");
            }
            if (count($communicationData) <= 0 || strlen($communicationData[0]->Mail_Server) <=0 ){

                $communicationData = $this->Model1->selectdata("communication_settings");
                if (is_null($communicationData) || count($communicationData) <= 0){

                }else{
                    $email_Address = $communicationData[0]->Mail_Address;
                    $config = array(
                        'protocol' => 'smtp',
                        'smtp_host' => $communicationData[0]->Mail_Server,
                        'smtp_port' => $communicationData[0]->Port,
                        'smtp_user' => $communicationData[0]->Mail_Address,
                        'smtp_pass' => $communicationData[0]->Mail_Password,
                        'smtp_crypto' => 'tls',
                        'mailtype'  => 'html',
                        'charset'  => 'utf-8'
                    );
                }
            }else if (count($communicationData) > 0 && strlen($communicationData[0]->Mail_Address) >0){
                // Emp SMTP configurations
                $email_Address = $communicationData[0]->Mail_Address;
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => $communicationData[0]->Mail_Server,
                    'smtp_port' => $communicationData[0]->Port,
                    'smtp_user' => $communicationData[0]->Mail_Address,
                    'smtp_pass' => $communicationData[0]->Mail_Password ,
                    'smtp_crypto' => 'tls',
                    'mailtype'  => 'html',
                    'charset'  => 'utf-8'
                );
            }else{

            }


            $email='';
            $messageBody=$_POST["Mailcontent"];

            $this->load->library('email', $config);
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
            $this->email->from($email_Address, 'CRM');
            $this->email->subject($_POST["title"]);
            $this->email->message($messageBody);
            for ($i=0;$i<count($files);$i++){
                $this->email->attach('MailFiles/'.$files[$i]);
            }
            $coun=0;
            $this->email->to($_POST['mailAddress']);
            $this->email->send();
//            $result= $this->email->print_debugger();
//
//            print_r("<pre>");
//            print_r($result);
//            print_r("</pre>");die();
            for ($i=0;$i<count($_POST['mailAddress']);$i++){
                $email .=$_POST['mailAddress'][$i].';';
                $coun++;
            }
            // print_r($coun);die();

            $result = 1;
            // insert data
            $MailData['UserID'] = $_SESSION['userid'];
            // $clientID = $this->Clients->GetClientByMail($_POST["mailAddress"]);
            if (isset($clientID) && !is_null($clientID) && count($clientID) >0){
                $MailData['ClientID'] =$clientID[0]->customerCrmId;
            }
            $MailData['Mail'] = $email;
            $MailData['Title'] = $_POST["title"];
            $MailData['Date'] = date('Y-m-d');
            $MailData['Message'] = htmlspecialchars($_POST["Mailcontent"]);
            $this->MailModel->addMail($MailData,$files);
            //  $this->Model1->addtotable("crm_mails",$row );


        }

//        print_r("<pre>");
//        print_r(htmlspecialchars($_POST['Mailcontent']));
//        print_r(addslashes($_POST["Mailcontent"]));
////        print_r($_POST);
//        print_r("</pre>");die();

        redirect(site_url("users/emails_view"));


    }

    function  sendbulkMailWithAttachForClients(){

//        print_r("<pre>");
////        print_r(htmlspecialchars($_POST['Mailcontent']));
////        print_r(addslashes($_POST["Mailcontent"]));
//        print_r($_POST);
//        print_r("</pre>");


        $files=array();
        // upload files
        if(!empty($_FILES['file']['name'])) {
            $filesCount = count($_FILES['file']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['mailFiles']['name'] = $_FILES['file']['name'][$i];
                $_FILES['mailFiles']['type'] = $_FILES['file']['type'][$i];
                $_FILES['mailFiles']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
                $_FILES['mailFiles']['error'] = $_FILES['file']['error'][$i];
                $_FILES['mailFiles']['size'] = $_FILES['file']['size'][$i];
                $uploadPath = 'MailFiles/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $filename = 'File_'.date('d-m-Y').time().$i;
                $config['file_name'] = $filename;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('mailFiles')) {
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $files[$i]= $fileData['file_name'];
                }
            }
        }
        // send mail

        if (isset($_POST["title"]) && !is_null($_POST["title"]) && !empty($_POST["title"]) &&
            isset($_POST["mailAddress"]) && !is_null($_POST["mailAddress"]) && !empty($_POST["mailAddress"]) &&
            isset($_POST["Mailcontent"]) && !is_null($_POST["Mailcontent"]) && !empty($_POST["Mailcontent"]) ){
            $communicationData = $this->Users_Model->GetMailServerConfig($_SESSION['userid']);
            $email_Address = '';
            if (count($communicationData) <= 0  || is_null($communicationData) ){
                $communicationData = $this->Model1->selectdata("communication_settings");
            }
            if (count($communicationData) <= 0 || strlen($communicationData[0]->Mail_Server) <=0 ){

                $communicationData = $this->Model1->selectdata("communication_settings");
                if (is_null($communicationData) || count($communicationData) <= 0){

                }else{
                    $email_Address = $communicationData[0]->Mail_Address;
                    $config = array(
                        'protocol' => 'smtp',
                        'smtp_host' => $communicationData[0]->Mail_Server,
                        'smtp_port' => $communicationData[0]->Port,
                        'smtp_user' => $communicationData[0]->Mail_Address,
                        'smtp_pass' => $communicationData[0]->Mail_Password,
                        'smtp_crypto' => 'tls',
                        'mailtype'  => 'html',
                        'charset'  => 'utf-8'
                    );
                }
            }else if (count($communicationData) > 0 && strlen($communicationData[0]->Mail_Address) >0){
                // Emp SMTP configurations
                $email_Address = $communicationData[0]->Mail_Address;
                $config = array(
                    'protocol' => 'smtp',
                    'smtp_host' => $communicationData[0]->Mail_Server,
                    'smtp_port' => $communicationData[0]->Port,
                    'smtp_user' => $communicationData[0]->Mail_Address,
                    'smtp_pass' => $communicationData[0]->Mail_Password ,
                    'smtp_crypto' => 'tls',
                    'mailtype'  => 'html',
                    'charset'  => 'utf-8'
                );
            }else{

            }



            $messageBody=$_POST["Mailcontent"];

            $this->load->library('email', $config);
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
            $this->email->from($email_Address, 'CRM');
            $this->email->subject($_POST["title"]);
            $this->email->message($messageBody);
            $MailData['UserID'] = $_SESSION['userid'];
            $MailData['Title'] = $_POST["title"];
            $MailData['Date'] = date('Y-m-d');
            $MailData['Message'] = htmlspecialchars($_POST["Mailcontent"]);

            for ($i=0;$i<count($files);$i++){
                $this->email->attach('MailFiles/'.$files[$i]);
            }
            $mailsAddress=[];
            $coun = 0;
            for ($i=0;$i<count($_POST['mailAddress']);$i++){
                // get client By ID
                $Client = $this->Clients->GetClientByID($_POST['mailAddress'][$i]);
                if (count($Client) > 0){
                    if (strlen($Client[0]->customerCrmEmail) >0){
                        $mailsAddress[$coun] = $Client[0]->customerCrmEmail;
                        $coun++;
                        $MailData['ClientID'] = $_POST['mailAddress'][$i];
                        $MailData['Mail'] = $Client[0]->customerCrmEmail;
                        $this->MailModel->addMail($MailData,$files);
                    }

                }

            }
            $this->email->to($mailsAddress);
            $this->email->send();
            //  die();
            // print_r($config);

            $result = 1;
            // insert data

            // $clientID = $this->Clients->GetClientByMail($_POST["mailAddress"]);
            if (isset($clientID) && !is_null($clientID) && count($clientID) >0){
                $MailData['ClientID'] =$clientID[0]->customerCrmId;
            }



            //  $this->Model1->addtotable("crm_mails",$row );


        }

//        print_r("<pre>");
//        print_r(htmlspecialchars($_POST['Mailcontent']));
//        print_r(addslashes($_POST["Mailcontent"]));
////        print_r($_POST);
//        print_r("</pre>");die();
        if (isset($_SESSION['date1']) && isset($_SESSION['date2'])){
            redirect(site_url("Client/Distributors/".$_SESSION['date1']."@".$_SESSION['date2']));
        }else{
            redirect(site_url("Client/Distributors"));
        }



    }

    function details($ID){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            redirect(site_url("CRM_Users"));
        }else {
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'7');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($ID == null){
                redirect(site_url("users/emails_view"));
            }else{
                $data["title"]="تفاصيل البريد الإلكتروني";
                $data['MailDetails'] = $this->MailModel->GetMailDetails($ID);

//                print_r("<pre>");
//                print_r($data);
//                print_r("</pre>");die();
                $this->load->view('Mails/details',$data);
            }
        }
    }



    function DeleteMail(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            $per = $this->premissions->get_premissions($_SESSION["userid"],'7');
            if ($_SESSION['usertype'] ==  4){

                if  ($per !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if (!isset($_POST['id']) || is_null($_POST['id'])){
                echo 1;return;
            }
//            print_r($_POST);die();
            $ids =$_POST["id"];

            for ($i=0;$i <count($ids) ;$i++){
                if ($_SESSION['usertype'] == 1){
                    $rowData['DeleteForAdmin'] = 1;
                    $rowWhere['ID'] = $ids[$i];
                    $this->Model1->updatedata("crm_mails",$rowWhere,$rowData );
                }else if ($_SESSION['usertype'] == 2){
                    $rowData['DeleteForSupervisor'] = 1;
                    $rowWhere['ID'] = $ids[$i];
                    $this->Model1->updatedata("crm_mails",$rowWhere,$rowData );
                }else if ($_SESSION['usertype'] == 3){
                    if ($per ==1){
                        $rowData['DeleteForAdmin'] = 1;
                        $rowWhere['ID'] = $_POST['ID'];
                        $this->Model1->updatedata("crm_mails",$rowWhere,$rowData );
                    }else{
                        $rowData[' DeleteForEmployee'] = 1;
                        $rowWhere['ID'] = $ids[$i];
                        $this->Model1->updatedata("crm_mails",$rowWhere,$rowData );
                    }
                }else if ($_SESSION['usertype'] == 4){
                    if ($per == 1){
                        $rowData['DeleteForAdmin'] = 1;
                        $rowWhere['ID'] = $ids[$i];
                        $this->Model1->updatedata("crm_mails",$rowWhere,$rowData );
                    }
                }


            }
            echo  0 ;

        }
    }

    function DeleteSMail(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            $per = $this->premissions->get_premissions($_SESSION["userid"],'7');
            if ($_SESSION['usertype'] ==  4){

                if  ($per !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if (!isset($_POST['messid']) || is_null($_POST['messid'])){
                echo 1;return;
            }
//            print_r($_POST);die();
            $ids =$_POST["messid"];


            if ($_SESSION['usertype'] == 1){
                $rowData['DeleteForAdmin'] = 1;
                $rowWhere['ID'] = $ids;
                $this->Model1->updatedata("crm_mails",$rowWhere,$rowData );
            }else if ($_SESSION['usertype'] == 2){
                $rowData['DeleteForSupervisor'] = 1;
                $rowWhere['ID'] = $ids;
                $this->Model1->updatedata("crm_mails",$rowWhere,$rowData );
            }else if ($_SESSION['usertype'] == 3){
                if ($per ==1){
                    $rowData['DeleteForAdmin'] = 1;
                    $rowWhere['ID'] = $_POST['ID'];
                    $this->Model1->updatedata("crm_mails",$rowWhere,$rowData );
                }else{
                    $rowData[' DeleteForEmployee'] = 1;
                    $rowWhere['ID'] = $ids;
                    $this->Model1->updatedata("crm_mails",$rowWhere,$rowData );
                }
            }else if ($_SESSION['usertype'] == 4){
                if ($per == 1){
                    $rowData['DeleteForAdmin'] = 1;
                    $rowWhere['ID'] = $ids;
                    $this->Model1->updatedata("crm_mails",$rowWhere,$rowData );
                }
            }

            echo  0 ;

        }

    }
}