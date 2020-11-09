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
      public function add_service()
      {
        if(isset($_SESSION['email'])){
            $data['url'] = base_url();
			$this->load->view('home',$data);
        }else{
            $data['url'] = base_url();
            if (!(empty($_POST['ProductCrmName'])) && !(empty($_POST['ProductCrmPrice']))
               && (!(empty($_POST['ProductCrmDesc'])) || !(empty($_POST['ProductCrmCancelDate']))) 
               && !(empty($_POST['ProductCrmType']))){


                
                 
                      $row["ProductCrmName"]=$_POST['ProductCrmName'];
                  
                      $row["ProductCrmPrice"]=$_POST['ProductCrmPrice'];
                      $row["ProductCrmDesc"]=$_POST['ProductCrmDesc'];
                    
                      $row["ProductCrmCancelDate"]=$_POST['ProductCrmCancelDate'];
                      $row["ProductCrmType"]=$_POST['ProductCrmType'];
                      
                   
                   
                   
                   
                   
                   $result=$this->load->addtotable("productcrm",$row );
                   echo "Product added successfully";
                  
            }else{

                 echo "Missing in Data";                
                
             
            }
        }
      }
     //update product
     public function update_service()
     {
       if(isset($_SESSION['email'])){
           $data['url'] = base_url();
           $this->load->view('home',$data);
       }else{
           $data['url'] = base_url();
           if (!(empty($_POST['ProductCrmName'])) && !(empty($_POST['ProductCrmPrice']))
              && (!(empty($_POST['ProductCrmDesc'])) || !(empty($_POST['ProductCrmCancelDate']))) 
              && !(empty($_POST['ProductCrmType'])) && !(empty($_POST['ProductCrmId']))){


               
                     $cond["ProductCrmId"]=$_POST['ProductCrmId'];
                     $row["ProductCrmName"]=$_POST['ProductCrmName'];
                 
                     $row["ProductCrmPrice"]=$_POST['ProductCrmPrice'];
                     $row["ProductCrmDesc"]=$_POST['ProductCrmDesc'];
                   
                     $row["ProductCrmCancelDate"]=$_POST['ProductCrmCancelDate'];
                     $row["ProductCrmType"]=$_POST['ProductCrmType'];
                     
                  
                  
                  
                  
                  
                  $result=$this->load->updatedata("productcrm",$cond,$row );
                  echo "Product Edited successfully";
                 
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
            if ( !(empty($_POST['ProductCrmId']))){
                   
                   $cond["ProductCrmId"]=$_POST["ProductCrmId"];
                   $result=$this->load->removefromtable("productcrm",$cond);
                   echo "Product deleted Successfully";
            }else{

                 echo "some thing is wrong";                
                
             
            }
        }
      }
    
    
      //function to add company data 
      public function Company_data()
      {
        if(isset($_SESSION['email'])){
            $data['url'] = base_url();
			$this->load->view('home',$data);
        }else{
            $data['url'] = base_url();
            if (!(empty($_POST['logCrm'])) && !(empty($_POST['nameCrm']))
               && (!(empty($_POST['phoneCrm'])) || !(empty($_POST['faxCrm']))) 
               && !(empty($_POST['emailCrm'])) && !(empty($_POST['addressCrm'])) && !(empty($_POST['siteCrm']))){


                
                 
                      $row["logCrm"]=$_POST['logCrm'];
                      if(!empty($_POST['TimeMinute'])){
                      $row["settingcrmTimeMinute"]=$_POST['TimeMinute'];
                      }
                      if(!empty($_POST['crmType'])){
                        $row["settimgcrmType"]=$_POST['crmType'];
                        }
                          $row["settingcrmLogo"]=$_POST['logCrm'];
                      
                          $row["settingcrmName"]=$_POST['nameCrm'];
                          $row["settingcrmPhone"]=$_POST['phoneCrm'];
                        
                          $row["settingcrmFax"]=$_POST['faxCrm'];
                          $row["settingcrmEmail"]=$_POST['emailCrm'];
                          $row["settingcrmAddress"]=$_POST['addressCrm'];
                          $row["settingcrmSite"]=$_POST['siteCrm'];
                      
                   
                   
                   
                   
                   
                   $result=$this->load->addtotable("settingcrm",$row );
                   echo "Company added successfully";
                  
            }else{

                 echo "Missing in Data";                
                
             
            }
        }
      }
     //function to update company data 
     public function updateCompany_data()
     {
       if(isset($_SESSION['email'])){
           $data['url'] = base_url();
           $this->load->view('home',$data);
       }else{
           $data['url'] = base_url();
           if (!(empty($_POST['logCrm'])) && !(empty($_POST['nameCrm']))
              && (!(empty($_POST['phoneCrm'])) || !(empty($_POST['faxCrm']))) 
              && !(empty($_POST['emailCrm'])) && !(empty($_POST['addressCrm'])) 
              && !(empty($_POST['siteCrm']))  && !(empty($_POST['settingcrmId']))){


               
                    $cond['settingcrmId']=$_POST['settingcrmId'];
                     $row["settingcrmLogo"]=$_POST['logCrm'];
                 
                     $row["settingcrmName"]=$_POST['nameCrm'];
                     $row["settingcrmPhone"]=$_POST['phoneCrm'];
                   
                     $row["settingcrmFax"]=$_POST['faxCrm'];
                     $row["settingcrmEmail"]=$_POST['emailCrm'];
                     $row["settingcrmAddress"]=$_POST['addressCrm'];
                     $row["settingcrmSite"]=$_POST['siteCrm'];
                     
                  
                  
                  
                  
                  
                  $result=$this->load->updatedata("settingcrm",$cond,$row );
                  echo "Company added successfully";
                 
           }else{

                echo "Missing in Data";                
               
            
           }
       }
     }
     
     //function to add status 
     public function add_status()
     {
       if(isset($_SESSION['email'])){
           $data['url'] = base_url();
           $this->load->view('home',$data);
       }else{
           $data['url'] = base_url();
           if (!(empty($_POST['name'])) && !(empty($_POST['parent']))){


               
                
                     $row["statusCrmContent"]=$_POST['name'];
                     $row["statusCrmParent"]=$_POST['parent'];
                     
                     if(!empty($_POST['type'])){
                     $row["statusCrmType"]=$_POST['type'];
                     }                  
                  
                  $result=$this->load->addtotable("statuscrm",$row );
                  echo "Status added successfully";
                 
           }else{

                echo "Missing in Data";                
               
            
           }
       }
     }
      //function to update status 
     public function update_status()
     {
       if(isset($_SESSION['email'])){
           $data['url'] = base_url();
           $this->load->view('home',$data);
       }else{
           $data['url'] = base_url();
           if (!(empty($_POST['statusid']))){


                
                    $cond["statusCrmId"]=$_POST['statusid'];
                      if(!(empty($_POST["deactive"])))
                      {
                     $row["deactive"]=$_POST["deactive"];
                      }
                      if(!(empty($_POST["name"])))
                      {
                     $row["statusCrmContent"]=$_POST['name'];
                      }
                      if(!(empty($_POST["parent"])))
                      {
                     $row["statusCrmParent"]=$_POST['parent'];
                      }
                     
                     if(!empty($_POST['type'])){
                     $row["statusCrmType"]=$_POST['type'];
                     }                  
                  
                  $result=$this->load->updatedata("statuscrm",$cond,$row);
                  echo "Status updated successfully";
                 
           }else{

                echo "Missing in Data";                
               
            
           }
       }
     }

      //function to select status 
      public function retrive_status()
      {
        if(isset($_SESSION['email'])){
            $data['url'] = base_url();
            $this->load->view('home',$data);
        }else{
            $data['url'] = base_url();
            $cond['deactive']=0;
            
             if(!(empty($_POST['parent'])))
               {
                   $cond['statusCrmParent']=$_POST['parent'];
               }
               else
               {
                $cond['statusCrmParent']=0;   
               }
            $result=$this->load->selectdata("statuscrm",$cond );
            return $result ;                 
           
        }
      }
}
