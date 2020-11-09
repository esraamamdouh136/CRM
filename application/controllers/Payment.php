<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 30/01/2019
 * Time: 03:03 م
 */

class Payment extends CI_Controller
{
    function __construct()
    {
        parent::__construct();


        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        session_start();
        $this->load->model('PaymentModel');
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

    function Create(){
        $data['url'] = base_url();
        $data['title'] = "طرق الدفع : إضافة";
        if(!isset($_SESSION['userid'])) {
            $this->load->view('login', $data);
        }else{
            if ($this->get_premissions($_SESSION['userid'],'04') ==1 || $_SESSION['usertype'] == 1){
                $_SESSION["PAGE"] = "Transfer";
                $this->load->view('PaymentTypes/Create', $data);
            }
            else{
                redirect(site_url("CRM_Users"));
            }
        }
    }

    function Add(){
        $data['url'] = base_url();
        $data['title'] =  "طرق الشحن : إضافة";
        if(!isset($_SESSION['userid'])) {
            $this->load->view('login', $data);
        }else{
            if ($this->get_premissions($_SESSION['userid'],'04') ==1 || $_SESSION['usertype'] == 1){
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('paymentName', ' طريقة الدفع', 'required',array('required'      => ' %s مطلوبه'));

                if ($this->form_validation->run() === FALSE)
                {
                    redirect(base_url().'Transfer');
                }else
                {
                    // Add
                    $row['Name']=$_POST['paymentName'];
                    $id= $this->PaymentModel->Create($row);
                    if ($id >0){
                        $_SESSION["PAGE"] = "Transfer";
                        redirect(base_url().'Transfer');
                    }else{
                        redirect(base_url().'Transfer');
                    }
                }
            }
            else{
                redirect(site_url("CRM_Users"));
            }

        }



    }

    function Edit($ID){
        $data['url'] = base_url();
        $data['title'] = "طرق الدفع : تعديل";
        if(!isset($_SESSION['userid'])) {
            $this->load->view('login', $data);
        }else{
            if ($this->get_premissions($_SESSION['userid'],'04') ==1 || $_SESSION['usertype'] == 1){
                $data['Transfer'] = $this->PaymentModel->GetPaymentType($ID)[0];
                $_SESSION["PAGE"] = "Transfer";
                $this->load->view('PaymentTypes/Update', $data);
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
                $data['Transfer'] = $this->PaymentModel->GetPaymentType($ID)[0];
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
    function Update(){


        $data['url'] = base_url();
        $data['title'] = "طرق الدفع : تعديل";
        if(!isset($_SESSION['userid'])) {
            $this->load->view('login', $data);
        }else{
            if ($this->get_premissions($_SESSION['userid'],'04') ==1 || $_SESSION['usertype'] == 1){
                $transID = $_POST['transID'];
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('paymentName', ' طريقة الدفع', 'required',array('required'      => ' %s مطلوبه'));

                if ($this->form_validation->run() === FALSE)
                {
                    redirect(base_url().'Transfer');
                }else
                {
                    // Add
                    $row['Name']=$_POST['paymentName'];
                    $this->PaymentModel->Update($transID,$row);
                    $_SESSION["PAGE"] = "Transfer";
                    redirect(base_url().'Transfer');
                }
            } else{
                redirect(site_url("CRM_Users"));
            }


        }


    }

    function Delete(){



        if ($_SESSION['usertype'] ==  4){
            $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
            if  ($Reports !=1){
                redirect(site_url("CRM_Users"));return;
            }
        }else {

            if (isset($_POST['ID']) && !is_null($_POST['ID']) && !empty($_POST['ID'])){
                if ( $this->PaymentModel->PaymentInUse($_POST['ID']) > 0){
                    $result['Error'] = 1;
                    $result['message'] = 'هذا العنصر قيد الاستخدام';

                    echo json_encode($result);return;
                }
                $this->PaymentModel->Delete($_POST['ID']);
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