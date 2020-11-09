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
	
	//function to add product to order
      public function add_prod()
      {
        if(isset($_SESSION['email'])){
            $data['url'] = base_url();
			$this->load->view('home',$data);
        }else{
            $data['url'] = base_url();
            if (!(empty($_POST['callcrmId'])) && !(empty($_POST['prouductCrmId']))
            && !(empty($_POST['orderTruck'])) && !(empty($_POST['dateTruck']))){

                      $row["callcrmId"]=$_POST['callcrmId'];
                  
                      $row["prouductCrmId"]=$_POST['prouductCrmId'];
                      $row["dateTruck"]=$_POST['dateTruck'];
                      if(!empty($_POST['orderQuantity']))
                      {
                        $row['orderQuantity']=$_POST['orderQuantity'];
                      }
                      if(!empty($_POST['orderTruck']))
                      {
                        $row['orderTruck']=$_POST['orderTruck'];
                      }
                   $result=$this->load->addtotable("customerProductcrm",$row );
                   echo "Product added successfully";
                  
            }else{

                 echo "Missing in Data";                
                
             
            }
        }
      }
     //update product
     public function update_prod()
     {
       if(isset($_SESSION['email'])){
           $data['url'] = base_url();
           $this->load->view('home',$data);
       }else{
           $data['url'] = base_url();
           if (!(empty($_POST['customerProductId'])) && !(empty($_POST['callcrmId'])) && !(empty($_POST['prouductCrmId']))
           && !(empty($_POST['orderTruck']))  && !(empty($_POST['dateTruck']))){

                $cond['customerProductId']=$_POST['customerProductId'];
                     $row["callcrmId"]=$_POST['callcrmId'];
                 
                     $row["prouductCrmId"]=$_POST['prouductCrmId'];
                     $row["dateTruck"]=$_POST['dateTruck'];
                     if(!empty($_POST['orderQuantity']))
                     {
                       $row['orderQuantity']=$_POST['orderQuantity'];
                     }
                     if(!empty($_POST['orderTruck']))
                     {
                       $row['orderTruck']=$_POST['orderTruck'];
                     }
                   
                  $result=$this->load->updatedata("customerProductcrm",$cond,$row );
                  echo "Product updated successfully";
                 
           }else{

                echo "Missing in Data";                
               
            
           }
       }
     }
     
       //function to delete message 
      public function delete_Product()
      {
        if(isset($_SESSION['email'])){
            $data['url'] = base_url();
			$this->load->view('home',$data);
        }else{
            $data['url'] = base_url();
            if ( !(empty($_POST['customerProductId']))){
                   
                   $cond["customerProductId"]=$_POST["customerProductId"];
                   $result=$this->load->removefromtable("customerProductcrm",$cond);
                   echo "Product deleted Successfully";
            }else{

                 echo "some thing is wrong";                
                
             
            }
        }
      }
    
    
     
}
