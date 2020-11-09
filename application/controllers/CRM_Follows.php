<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 22/10/2018
 * Time: 01:09 م
 */

class CRM_Follows extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->model('Employee_Taskes');
        $this->load->model('CRM_FollowsModel');
        $this->load->model('Users_Model');
        $this->load->model('premissions');

        session_start();

    }
    public function index($dateRange = null){
        $data['url'] = base_url();
        $_SESSION["PAGE"] = "Complains";
        // if(isset($_SESSION['userid'])){

        redirect(site_url("CRM_Users"));return;
//
//            $data["title"]="المتابعات";
//            $userID = $_SESSION['userid'];
//            if ($dateRange !=null){
//                $dateArray = explode("@",$dateRange);
//                $date1 =    $dateArray[0] ;
//                $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
//            }else{
//                $date1 =  date("Y-m-d") ;
//                $date2 =  date("Y-m-d");
//            }
//            $_SESSION['date1'] = $date1;
//            $_SESSION['date2'] = $date2;
//            $userType = $_SESSION["usertype"]-1;
//            $data['follows'] = $this->Employee_Taskes->GetUserFollows($date1,$date2,$userID,$userType);
//            $this->load->view('Follows/index', $data);
//        }else{
//            $this->load->view('login', $data);
//        }

    }


    public function CallsCount(){


        $userID  = $_SESSION['userid'];
        $per=get_premissions($_SESSION["userid"],'06');
        if ($per == 1){
            $UpcommingCalls = $this->CRM_FollowsModel->getUpcoming($userID,1,null,1);
        }else{
            $UpcommingCalls = $this->CRM_FollowsModel->getUpcoming($userID,1);
        }

        $userType = $_SESSION['usertype'];
        $per=get_premissions($_SESSION["userid"],'05');
        if ($per == 1){
            $DelayedCalls = $this->CRM_FollowsModel->getUpcoming($userID,2,$userType,1);
        }else{
            $DelayedCalls = $this->CRM_FollowsModel->getUpcoming($userID,2,$userType);
        }

        $resultData['DelayedCalls'] = count($DelayedCalls);
        $resultData['UpcommingCalls'] = count($UpcommingCalls);
        echo json_encode($resultData);






//        $userType = $_SESSION["usertype"];
//        //get permissions
//        $per = $this->premissions->get_premissions($_SESSION['userid'],"05");
//        if ($per == 1 || $userType == 1){
//            $resultData['TotalDelayedCalls']=count($this->CRM_FollowsModel->getUpcoming($_SESSION['userid'],2,null,1));
//
//        }else{
//            $resultData['TotalDelayedCalls']=count($this->CRM_FollowsModel->getUpcoming($_SESSION['userid'],2));
//        }
//
//
//        $TotalUpcommingCalls = $this->CRM_FollowsModel->getCalls($_SESSION['userid']);
//        if (count($TotalUpcommingCalls) > 0)
//            $resultData['TotalUpcommingCalls'] = $this->CRM_FollowsModel->getCalls($_SESSION['userid'])[0]->UpcommingCalls;
//        else
//            $resultData['TotalUpcommingCalls'] =0;
//        $_SESSION['TotalDelayedCalls'] = $resultData['TotalDelayedCalls'];
//        $_SESSION['TotalUpcommingCalls'] = $resultData['TotalUpcommingCalls'];
//        if (!is_null($_SESSION['userid'])){
//
//            $UpcommingCalls= $this->CRM_FollowsModel->getUpcommingCalls($_SESSION['userid']);
//            if ($userType == 1 || $per == 1){
//                $DelayedCalls= $this->CRM_FollowsModel->getDelayedCalls($_SESSION['userid'],$userType,1);
//                $resultData['DelayedCalls'] = $DelayedCalls;
//
//            }else if ($userType == 2 && $per != 1){
//                // Supervisor
//                $DelayedCalls= $this->CRM_FollowsModel->getDelayedCalls($_SESSION['userid'],$userType);
//                $resultData['DelayedCalls'] = $DelayedCalls;
//
//                if  ($DelayedCalls > 0 || $UpcommingCalls > 0){
//                    $this->CRM_FollowsModel->AddNotification($_SESSION['userid']);
//                }
//
//            }else{
//                // Employee
//                $DelayedCalls= $this->CRM_FollowsModel->getDelayedCalls($_SESSION['userid'],$userType);
//                $resultData['DelayedCalls'] = $DelayedCalls;
//                if  ($DelayedCalls > 0 || $UpcommingCalls > 0){
//                    $this->CRM_FollowsModel->AddNotification($_SESSION['userid']);
//                }
//            }
//            $resultData['UpcommingCalls'] = $UpcommingCalls;
//            $_SESSION['TotalDelayedCalls'] = count($this->CRM_FollowsModel->getUpcoming($_SESSION['userid'],2,$_SESSION['usertype'],1));
//            $resultData['TotalDelayedCalls'] =count($this->CRM_FollowsModel->getUpcoming($_SESSION['userid'],2,$_SESSION['usertype'],1));
//            echo json_encode($resultData);
//        }

        // echo count($result);



    }

    function upcomingCalls(){
        $data['url'] = base_url();
        $_SESSION["PAGE"] = "upcomingCalls";
        if(isset($_SESSION['userid'])){
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'06');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
            $data["title"]="مكالمات قادمة";
            $userID = $_SESSION['userid'];

            $data['Clients'] =$this->CRM_FollowsModel->getUpcoming($userID,1);
            if ($_SESSION['usertype'] == 1){
                $data["employee"]=$this->Users_Model->GetEmployee($_SESSION['userid']);
            }else if ($_SESSION['usertype'] == 2){
                $data["employee"]=$this->Users_Model->GetSuperVisorEmployee($_SESSION['userid']);
            }
//            print_r("<pre>");
//            print_r($data);
//            print_r("</pre>");die();


            $this->load->view('Follows/index', $data);
        }else{
            $this->load->view('login', $data);
        }
    }

    function DelayedCalls(){
        $data['url'] = base_url();
        $_SESSION["PAGE"] = "DelayedCalls";
        if(isset($_SESSION['userid'])){

            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'05');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }

            $data["title"]="مكالمات متأخرة";
            $userID = $_SESSION['userid'];
// get permission
            $per = $this->premissions->get_premissions($_SESSION['userid'],"05");
            if ($_SESSION['usertype'] == 1){
                $data["employee"]=$this->Users_Model->GetEmployee($_SESSION['userid']);
            }else if ($_SESSION['usertype'] == 2){
                $data["employee"]=$this->Users_Model->GetSuperVisorEmployee($_SESSION['userid']);
            }
            if ($per == 1 || $_SESSION['usertype'] == 1){
                $data['Clients'] =$this->CRM_FollowsModel->getUpcoming($userID,2,$_SESSION['usertype'],1);
            }else{
                $data['Clients'] =$this->CRM_FollowsModel->getUpcoming($userID,2,$_SESSION['usertype']);
            }


//            print_r(" <pre>");
//            print_r($data);
//            print_r("</pre>");die();
            $this->load->view('Follows/index', $data);
        }else{
            $this->load->view('login', $data);
        }
    }





}