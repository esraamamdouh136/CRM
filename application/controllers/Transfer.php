<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 9/27/2018
 * Time: 11:26 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Transfer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        session_start();
        $this->load->model('Transfer_Model');
        $this->load->model('Model1');

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

    public function index(){
        $data['url'] = base_url();
        $data['title'] = "طرق الشحن";
        if(!isset($_SESSION['userid'])) {
            $this->load->view('login', $data);
        }else{

            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }

            if ($this->get_premissions($_SESSION['userid'],'04') ==1 || $_SESSION['usertype'] == 1){
                $data['Transfer'] = $this->Transfer_Model->GetTransfer();
                $data['PaymentTypes'] = $this->Model1->selectdata('PaymentTypes');
                $_SESSION["PAGE"] = "Transfer";
                $this->load->view('Transfer/Index', $data);
            }else{
                redirect(site_url("CRM_Users"));
            }

        }
    }
    public function add(){
        $data['url'] = base_url();
        $data['title'] = "طرق الشحن : إضافة";
        if(!isset($_SESSION['userid'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($this->get_premissions($_SESSION['userid'],'04') ==1 || $_SESSION['usertype'] == 1){
                $_SESSION["PAGE"] = "Transfer";
                redirect(base_url().'Transfer');
            }
            else{
                redirect(site_url("CRM_Users"));
            }



        }
    }
    public function create(){
        $data['url'] = base_url();
        $data['title'] =  "طرق الشحن : إضافة";
        if(!isset($_SESSION['userid'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($this->get_premissions($_SESSION['userid'],'04') ==1 || $_SESSION['usertype'] == 1){
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('transferName', ' طريقة الشحن', 'required',array('required'      => ' %s مطلوبه'));
                $this->form_validation->set_rules('transferPrice', 'تكلفة الشحن', 'required',array('required'      => ' %s مطلوبه'));
                if ($this->form_validation->run() === FALSE)
                {
                    redirect(base_url().'Transfer');
                }else
                {
                    // Add
                    $row['transfer_Name']=$_POST['transferName'];
                    $row['Price']=$_POST['transferPrice'];
                    if (!is_null($_POST['transferDescription']) && !empty($_POST['transferDescription']))
                        $row['Description']=$_POST['transferDescription'];
                    $this->Transfer_Model->add($row);
                    $_SESSION["PAGE"] = "Transfer";
                    redirect(base_url().'Transfer');

                }
            }
            else{
                redirect(site_url("CRM_Users"));
            }

        }
    }
    public function update($ID){
        $data['url'] = base_url();
        $data['title'] = "طرق الشحن : تعديل";
        if(!isset($_SESSION['userid'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($this->get_premissions($_SESSION['userid'],'04') ==1 || $_SESSION['usertype'] == 1){
                $data['Transfer'] = $this->Transfer_Model->__GetTransfer($ID)[0];
                $_SESSION["PAGE"] = "Transfer";
                redirect(base_url().'Transfer');
            } else{
                redirect(site_url("CRM_Users"));
            }


        }
    }

    public function GetData()
    {
        if (isset($_POST["ID"]) && !is_null($_POST["ID"])){
            $ID = $_POST["ID"];
            if ($this->get_premissions($_SESSION['userid'],'04') ==1 || $_SESSION['usertype'] == 1){
                $data['Transfer'] = $this->Transfer_Model->__GetTransfer($ID)[0];
                $_SESSION["PAGE"] = "Transfer";
                $data["Error"] =0;
                echo json_encode($data);

            } else{
                $data["Error"] =1;
                echo json_encode($data);
            }
        }else{
            $data["Error"] =1;
            echo json_encode($data);
        }

    }


    public function updateData(){
        $data['url'] = base_url();
        $data['title'] = "طرق الشحن : تعديل";
        if(!isset($_SESSION['userid'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($this->get_premissions($_SESSION['userid'],'04') ==1 || $_SESSION['usertype'] == 1){
                $transID = $_POST['transID'];
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('transferName', ' طريقة الشحن', 'required',array('required'      => ' %s مطلوبه'));
                $this->form_validation->set_rules('transferPrice', 'تكلفة الشحن', 'required',array('required'      => ' %s مطلوبه'));
                if ($this->form_validation->run() === FALSE)
                {
                    redirect(base_url().'Transfer');
                }else
                {
                    // Add
                    $row['transfer_Name']=$_POST['transferName'];
                    $row['Price']=$_POST['transferPrice'];
                    if (!is_null($_POST['transferDescription']) && !empty($_POST['transferDescription']))
                        $row['Description']=$_POST['transferDescription'];
                    $this->Transfer_Model->update($transID,$row);
                    $_SESSION["PAGE"] = "Transfer";
                    redirect(base_url().'Transfer');
                }
            } else{
                redirect(site_url("CRM_Users"));
            }


        }
    }
    public function delete(){
        if ($_SESSION['usertype'] ==  4){
            $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
            if  ($Reports !=1){
                redirect(site_url("CRM_Users"));return;
            }
        }else {

            if (isset($_POST['ID']) && !is_null($_POST['ID']) && !empty($_POST['ID'])){
                if ( $this->Transfer_Model->TransferInUse($_POST['ID']) > 0){
                    $result['Error'] = 1;
                    $result['message'] = 'هذا العنصر قيد الاستخدام';

                    echo json_encode($result);return;
                }
                $this->Transfer_Model->delete($_POST['ID']);
                $_SESSION["PAGE"] = "Products";
                $result['Error'] = 0;
                echo json_encode($result);return;
            }else{
                $result['Error'] = 1;
                $result['message'] = 'حدث خطأ غير متوقع';
                echo json_encode($result);return;
            }
        }


    }
}