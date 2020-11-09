<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 9/27/2018
 * Time: 11:26 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        session_start();
        $this->load->model('Products_Model');
        $this->load->model('premissions');
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
        $data['title'] = "منتجات / خدمات";
        $_SESSION["PAGE"] = "Products";
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
                $data['products'] = $this->Products_Model->GetProductsByType(1);
                $data['services'] = $this->Products_Model->GetProductsByType(2);
                $this->load->view('Products/Index', $data);
            }else{
                redirect(site_url("CRM_Users"));
            }

        }
    }
    public function add(){
        $data['url'] = base_url();
        $data['title'] = "منتجات / خدمات : إضافة";
        $_SESSION["PAGE"] = "Products";
        if(!isset($_SESSION['userid'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'04');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            if ($this->get_premissions($_SESSION['userid'],'04') ==1 || $_SESSION['usertype'] == 1)
                $this->load->view('Products/Add', $data);
            else{
                redirect(site_url("CRM_Users"));
            }
        }
    }
    public function create(){


        $data['url'] = base_url();
        $data['title'] =  "منتجات / خدمات : إضافة";
        $_SESSION["PAGE"] = "Products";
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
                $this->form_validation->set_rules('ProductName', 'إسم المنتج / الخدمة', 'required',array('required'      => ' %s مطلوبه'));
                $this->form_validation->set_rules('ProductPrice', 'سعر المنتج / الخدمة', 'required',array('required'      => ' %s مطلوبه'));
                $this->form_validation->set_rules('ProductType', 'النوع', 'required',array('required'      => ' %s مطلوبه'));
                if ($this->form_validation->run() === FALSE)
                {
                    redirect(base_url().'Products');
                }else
                {
                    // Add
                    $row['Product_Name']=$_POST['ProductName'];
                    $row['Price']=$_POST['ProductPrice'];
                    $row['Product_Type']=$_POST['ProductType'];
                    if (!is_null($_POST['ProductDescription']) && !empty($_POST['ProductDescription']))
                        $row['Description']=$_POST['ProductDescription'];


                    $this->Products_Model->add($row);
                    $_SESSION["PAGE"] = "Products";
                    redirect(base_url().'Products');

                }
            }
            else{
                redirect(site_url("CRM_Users"));
            }

        }

    }
    public function update($ID){
        $data['url'] = base_url();
        $data['title'] = "منتجات / خدمات : تعديل";
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
                $data['Product'] = $this->Products_Model->__GetProducts($ID)[0];
                $_SESSION["PAGE"] = "Products";
                $this->load->view('Products/Update', $data);
            }
            else{
                redirect(site_url("CRM_Users"));
            }

        }
    }
    public function GetData()
    {
        if (isset($_POST["ID"]) && !is_null($_POST["ID"])){
            $ID = $_POST["ID"];
            if ($this->get_premissions($_SESSION['userid'],'04') ==1 || $_SESSION['usertype'] == 1){
                $data['Product'] = $this->Products_Model->__GetProducts($ID)[0];
                $_SESSION["PAGE"] = "Products";
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


    public function GetProductData($ID){
        $data['url'] = base_url();

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

                $productData = $this->Products_Model->__GetProducts($ID);
                if (   count($productData) > 0 ){
                    $Product = $productData[0];
                    echo json_encode($Product);
                }else{
                    $error["error"] = 1;
                    echo  json_encode($error);
                }


            }
            else{
                $error["error"] = 1;
                json_encode($error);
            }

        }
    }


    public function updateData(){
        $data['url'] = base_url();
        $data['title'] = "منتجات / خدمات : تعديل";
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
                $productID = $_POST['productID'];
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('ProductName', 'إسم المنتج / الخدمة', 'required',array('required'      => ' %s مطلوبه'));
                $this->form_validation->set_rules('ProductPrice', 'سعر المنتج / الخدمة', 'required',array('required'      => ' %s مطلوبه'));
                $this->form_validation->set_rules('ProductType', 'النوع', 'required',array('required'      => ' %s مطلوبه'));
                if ($this->form_validation->run() === FALSE)
                {
                    $this->load->view('Products/Update'.$productID, $data);
                }
                else
                {

                    $row['Product_Name']=$_POST['ProductName'];
                    $row['Price']=$_POST['ProductPrice'];
                    $row['Product_Type']=$_POST['ProductType'];
                    if (!is_null($_POST['ProductDescription']) && !empty($_POST['ProductDescription']))
                        $row['Description']=$_POST['ProductDescription'];

                    $this->Products_Model->update($productID,$row);
                    $_SESSION["PAGE"] = "Products";
                    redirect(base_url().'Products');
                }
            }
            else{
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
        }else{
            if (isset($_POST['ID']) && !is_null($_POST['ID']) && !empty($_POST['ID'])){
                if ( $this->Products_Model->ProductInUse($_POST['ID']) > 0){
                    $result['Error'] = 1;
                    $result['message'] = 'هذا المنتج قيد الاستخدام';

                    echo json_encode($result);return;
                }
                $this->Products_Model->delete($_POST['ID']);
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