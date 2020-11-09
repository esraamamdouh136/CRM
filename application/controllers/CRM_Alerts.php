<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 14/10/2018
 * Time: 03:17 م
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class CRM_Alerts extends CI_Controller
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
    public function index(){
        $data['url'] = base_url();
        $_SESSION["PAGE"] = "alerts";
        if(isset($_SESSION['userid'])){
            $data['UserType']=$_SESSION['usertype'];
            $data['']='';
            $data['']='';
        }else{
            $this->load->view('login', $data);
        }
    }
    public function NewAlert(){

    }
    public function Delete(){

    }

}