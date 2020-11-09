<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 04/03/2019
 * Time: 03:21 م
 */


class SMS extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        session_start();
        $this->load->model('SMSModel');
        $this->load->model('Clients');
        $this->load->model('Users_Model');
        $this->load->model('premissions');
        // $this->load->library('PHPRequests');

    }

    function index()
    {
        $data['url'] = base_url();
        $data["title"] = "الرسائل النصية";
        $_SESSION["PAGE"] = "sms";
        if (!isset($_SESSION['userid'])) {
            redirect(site_url("CRM_Users"));
        } else {
            if ($_SESSION['usertype'] == 4) {
                $Reports = $this->premissions->get_premissions($_SESSION["userid"], '7');
                if ($Reports != 1) {
                    redirect(site_url("CRM_Users"));
                    return;
                }
            }
            // Get All Employees
            $per = $this->premissions->get_premissions($_SESSION['userid'], "07");
            if ($_SESSION['usertype'] == 1 || $per == 1) {
                $data["users"] = $this->Users_Model->GetEmployee($_SESSION['userid'], $_SESSION['usertype']);
            } else if ($_SESSION['usertype'] == 2 && $per != 1) {
                $data["users"] = $this->Users_Model->GetSuperVisorEmployee($_SESSION['userid']);
            }
            //Get All SMS
            if ($per == 1 || $_SESSION['usertype'] == 1) {
                $data["smsList"] = $this->SMSModel->GetAllSMS($_SESSION['userid'], $_SESSION['usertype'], 1);
            } else {
                $data["smsList"] = $this->SMSModel->GetAllSMS($_SESSION['userid'], $_SESSION['usertype']);
            }

//            print_r("<pre>");
//            print_r($data);
//            print_r("</pre>");die();
        }
        $this->load->view('sms/index', $data);
    }

    function send($clientID, $message)
    {
        if ($_SESSION['usertype'] == 4) {
            $Reports = $this->premissions->get_premissions($_SESSION["userid"], '7');
            if ($Reports != 1) {
                redirect(site_url("CRM_Users"));
                return;
            }
        }
        $clinet = $this->Clients->GetClientByID($clientID);
        $phone = $clinet[0]->customerCrmPhone;
        if (strlen($phone) == 11) {
            $phone = '2' . $phone;
        } else if (strlen($phone) == 12) {
            if ($phone[0] == '2') {
                $phone = $phone;
            } else {
                return false;
            }
        } else if (strlen($phone) == 13) {
            if ($phone[0] == '+' && $phone[1] == '2') {
                $phone = $phone;
            } else {
                return false;
            }
        } else {
            return false;
        }
        $API = $this->SMSModel->GetAPI();
        $message = urlencode($message);
        $URL = $API->BaseURL
            . '?Username=' . $API->UserID
            . '&Password=' . $API->UserPassword
            . '&Sender=' . $API->SenderName
            . '&Recipients=' . $phone
            . '&MessageData=' . $message;
        $result = file_get_contents($URL);
        if (strpos(strtolower($result), 'ok') !== false)
            return true;
        else
            return false;
    }

    function deleteSMS()
    {

        if ($_SESSION['usertype'] == 4) {
            $Reports = $this->premissions->get_premissions($_SESSION["userid"], '7');
            if ($Reports != 1) {
                redirect(site_url("CRM_Users"));
                return;
            }
        }
        $data['url'] = base_url();
        $per = $this->premissions->get_premissions($_SESSION['userid'], "07");
        if (!isset($_SESSION['userid']) || ($_SESSION['usertype'] != 1 && $per != 1)) {
            $result['error'] = 1;
            $result['message'] = "عفوا لا تملك الصلاحية لاتمام هذه العملية";
            echo json_encode($result);
        } else {

            $smsID = $_POST['id'];
            if (!isset($smsID) || is_null($smsID) || $smsID <= 0) {
                $result['error'] = 1;
                $result['message'] = "هذه الرسالة غير موجوده";
                echo json_encode($result);
            } else {
                $type = 0;
                if ($_SESSION['usertype'] == 4) {
                    $type = 1;
                } else {
                    $type = $_SESSION['usertype'];
                }
                // get sms
                $sms = $this->SMSModel->GetSMSDetails($smsID);
                if ($sms->UserID == $_SESSION['userid']) {
                    $this->SMSModel->deleteSMS($smsID, 3);
                }
                if ($per == 1){
                    $type = 1;
                }
                if ($this->SMSModel->deleteSMS($smsID, $type) > 0) {
                    $result['error'] = 0;
                    $result['message'] = "تمت العملية بنجاح";
                    echo json_encode($result);
                } else {
                    $result['error'] = 1;
                    $result['message'] = "حدث خطأ اثناء عملية الحذف";
                    echo json_encode($result);
                }
            }

        }
    }


    function SendSMS()
    {
        $data['url'] = base_url();
        $data["title"] = "العملاء";
        if (!isset($_SESSION['userid'])) {
            $result['errorCode'] = 1;
            $result['message'] = 'Pleas Login First';
            echo json_encode($result);
        } else {
            if ($_SESSION['usertype'] == 4) {
                $Reports = $this->premissions->get_premissions($_SESSION["userid"], '7');
                if ($Reports != 1) {
                    redirect(site_url("CRM_Users"));
                    return;
                }
            }
            $userID = $_SESSION['userid'];

            if ($this->Users_Model->IsMaximumSMS($userID)) {
                $result['errorCode'] = 1;
                $result['message'] = 'تم الوصول إلى الحد المسموح به لارسال الرسائل النصية اليومى';
                echo json_encode($result);
            } else {
                // Send SMS
                $clientID = $_POST['phone'];
                $Content = $_POST['message'];
                if ($this->SMSModel->send($clientID, $Content, $userID, 1)) {
                    $result['errorCode'] = 0;
                    $result['message'] = 'تم إرسال الرسالة بنجاح';
                    echo json_encode($result);
                } else {
                    $result['errorCode'] = 1;
                    $result['message'] = 'حدث خطأ أثناء إرسال الرسالة';
                    echo json_encode($result);
                }

            }

        }
    }

    function details($ID)
    {
        $data['url'] = base_url();
        if (!isset($_SESSION['userid'])) {
            redirect(site_url("CRM_Users"));
        } else {
            if ($_SESSION['usertype'] == 4) {
                $Reports = $this->premissions->get_premissions($_SESSION["userid"], '7');
                if ($Reports != 1) {
                    redirect(site_url("CRM_Users"));
                    return;
                }
            }
            if ($ID == null) {
                redirect(site_url("users/emails_view"));
            } else {
                $data["title"] = "تفاصيل الرساله النصيه";
                $data['SMSDetails'] = $this->SMSModel->GetSMSDetails($ID);

                $this->load->view('sms/details_sms', $data);
            }
        }

    }

    function SMSAPI(){
        $data['url'] = base_url();
        $data["title"] = "إعدادات الرسائل النصية";
        $_SESSION["PAGE"] = "smsSettings";
        if (!isset($_SESSION['userid'])) {
            redirect(site_url("CRM_Users"));
        } else {
            if ($_SESSION['usertype'] == 4) {
                $Reports = $this->premissions->get_premissions($_SESSION["userid"], '04');
                if ($Reports != 1) {
                    redirect(site_url("CRM_Users"));
                    return;
                }
            }else if ($_SESSION['usertype'] == 3 || $_SESSION['usertype'] == 2){
                $Reports = $this->premissions->get_premissions($_SESSION["userid"], '04');
                if ($Reports != 1) {
                    redirect(site_url("CRM_Users"));
                    return;
                }
            }
            $data['settings'] = $this->SMSModel->GetAPI();
            $this->load->view('sms/Settings', $data);
        }
    }

    function SaveSMSSettings(){

        //  print_r($_POST);die();
        if (isset($_SESSION['userid'])) {
            if ($_SESSION['usertype'] == 4) {
                $Reports = $this->premissions->get_premissions($_SESSION["userid"], '04');
                if ($Reports != 1) {
                    $result['error'] = true;
                    $result['msg'] = 'انت لا تملك صلاحية التعديل فى هذه الصفحة';
                    echo json_encode($result);return;
                }
            }else if ($_SESSION['usertype'] == 3 || $_SESSION['usertype'] == 2) {
                $Reports = $this->premissions->get_premissions($_SESSION["userid"], '04');
                if ($Reports != 1) {
                    $result['error'] = true;
                    $result['msg'] = 'انت لا تملك صلاحية التعديل فى هذه الصفحة';
                    echo json_encode($result);
                    return;
                }
            }
            $data['UserID'] = $_POST['UserID'];
            $data['UserPassword'] = $_POST['UserPassword'];
            $data['SenderName'] = $_POST['SenderName'];
            $APIID = $_POST['Update'];
            if (!isset($APIID) || is_null($APIID) || $APIID <= 0){
                $data['BaseURL'] = 'http://tekegy.org';
            }
            $result['error'] = false;
            if ($this->SMSModel->SetAPISettings($data,$APIID) >0){
                $result['msg'] = 'تم الحفظ بنجاح';
            }else{
                $result['error'] = true;
                $result['msg'] = 'حدث خطأ اثناء حفظ البيانات';
            }
            echo json_encode($result);
        }else{
            $result['error'] = true;
            $result['msg'] = 'برجاء إعادة تسجيل الدخول';
            echo json_encode($result);
        }
    }

}