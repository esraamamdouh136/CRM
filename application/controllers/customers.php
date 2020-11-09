<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

	  function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
		session_start();
		$this->load->model('Model1');
        $this->load->model('Customers_Model');
        $this->load->model('Comments');
        $this->load->model('Orders');

    }
		 
	public function index($CustomerID)
	{
        $data['url'] = base_url();
        $data["title"]="عميل";
        if(!isset($_SESSION['userid'])||!isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        }else{
            if ($_SESSION['usertype'] >1){
                // get Customer Data
                $data["customer"]=$this->Customers_Model->GetCustomerByID($CustomerID);
                // Comments
                $data["Comments"] = $this->Comments->GetClientComments($CustomerID);
                // Orders
               // $data["Orders"] = $this->Orders->GetClientOrders($CustomerID);
                $this->load->view('Clients/index', $data);
            }else{
                redirect(site_url("CRM_Users"));
            }


        }
	}

	
}
