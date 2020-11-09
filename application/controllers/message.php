<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class users extends CI_Controller {

	  function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
		session_start();
		$this->load->model('Model1');
    }
		 
	public function index()
	{
		
	}
	
	//function to insert user into crmUser Not implemented 
      public function send_message()
      {
        if(isset($_SESSION['email'])){
            $data['url'] = base_url();
			$this->load->view('home',$data);
        }else{
            $data['url'] = base_url();
            if (!(empty($_POST['messagecrmtype'])) && !(empty($_POST['CrmMessagesFrom']))
               && (!(empty($_POST['CrmMessagesTo'])) || !(empty($_POST['CrmMessagesCustomer']))) 
               && !(empty($_POST['CrmMessagesTitle'])) && !(empty($_POST['CrmMessagesContent'])) 
               && !(empty($_POST['CrmMessagesStatus']))){


                
                 
                   $row["messagecrmtype"]=$_POST['messagecrmtype'];
                  
                    $row["CrmMessagesFrom"]=$_POST['CrmMessagesFrom'];
                   
                   if(!(empty($_POST['CrmMessagesTo'])) ){
                    $row["CrmMessagesTo"]=$_POST['CrmMessagesTo'];
                   }
                   if(!(empty($_POST['CrmMessagesCustomer'])) ){
                    $row["CrmMessagesCustomer"]=$_POST['CrmMessagesCustomer'];
                   }
                  
                    $row["CrmMessagesTitle"]=$_POST['CrmMessagesTitle'];
                  
                    $row["CrmMessagesContent"]=$_POST['CrmMessagesContent'];
                  
                    $row["CrmMessagesStatus"]=$_POST['CrmMessagesStatus'];
                   
                   
                   
                   $result=$this->load->addtotable("messagecrm",$row );
                   echo "Message sent successfully";
                  
            }else{

                 echo "Missing in Data";                
                
             
            }
        }
      }
      //function to insert user into crmUser Not implemented 
      public function update_message()
      {
        if(isset($_SESSION['email'])){
            $data['url'] = base_url();
			$this->load->view('home',$data);
        }else{
            $data['url'] = base_url();
            if (!(empty($_POST['messagecrmtype'])) && !(empty($_POST['CrmMessagesFrom']))
               && (!(empty($_POST['CrmMessagesTo'])) || !(empty($_POST['CrmMessagesCustomer']))) 
               && !(empty($_POST['CrmMessagesTitle'])) && !(empty($_POST['CrmMessagesContent'])) 
               && !(empty($_POST['CrmMessagesStatus'])) && !(empty($_POST['CrmMessagesId']))){


                
                 
                   $row["messagecrmtype"]=$_POST['messagecrmtype'];
                  
                    $row["CrmMessagesFrom"]=$_POST['CrmMessagesFrom'];
                    $cond["CrmMessagesId"]=$_POST['CrmMessagesId'];
                   if(!(empty($_POST['CrmMessagesTo'])) ){
                    $row["CrmMessagesTo"]=$_POST['CrmMessagesTo'];
                   }
                   if(!(empty($_POST['CrmMessagesCustomer'])) ){
                    $row["CrmMessagesCustomer"]=$_POST['CrmMessagesCustomer'];
                   }
                  
                    $row["CrmMessagesTitle"]=$_POST['CrmMessagesTitle'];
                  
                    $row["CrmMessagesContent"]=$_POST['CrmMessagesContent'];
                  
                    $row["CrmMessagesStatus"]=$_POST['CrmMessagesStatus'];
                   
                   
                   
                   $result=$this->load->updatedata("messagecrm",$cond,$row );
                   echo "Message updated successfully";
                  
            }else{

                 echo "Missing in Data";                
                
             
            }
        }
      }

     
       //function to delete message 
      public function delete_user()
      {
        if(isset($_SESSION['email'])){
            $data['url'] = base_url();
			$this->load->view('home',$data);
        }else{
            $data['url'] = base_url();
            if ( !(empty($_POST['CrmMessagesId']))){
                   
                   $cond["CrmMessagesId"]=$_POST["CrmMessagesId"];
                   $result=$this->load->removefromtable("messagecrm",$cond);
                   echo "message deleted Successfully";
            }else{

                 echo "some thing is wrong";                
                
             
            }
        }
      }
    
    

	
}
