<?php
/**
 * Created by PhpStorm.
 * User: boodykamel
 * Date: 10/18/18
 * Time: 3:27 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class CRM_Complain extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->model('ComplainModel');
        $this->load->model('Users_Model');
        $this->load->model('premissions');
        session_start();

    }
    public function index(){
        $data['url'] = base_url();
        $_SESSION["PAGE"] = "Complains";
        if(isset($_SESSION['userid'])){
            $UserType = $_SESSION['usertype'];
            $userID = $_SESSION['userid'];
            if ($_SESSION['usertype'] ==  4){
                $Reports =$this->premissions->get_premissions($_SESSION["userid"],'10');
                if  ($Reports !=1){
                    redirect(site_url("CRM_Users"));return;
                }
            }
//get permissions
            $per = $this->premissions->get_premissions($_SESSION['userid'],"10");

            if ($UserType == 2 && $per != 1){
                // Get Supervisors
                $data["super"] =$this->Users_Model->GetUsersByTypes(2,$userID);

                /*
                 * شكاوى مرسلة
                 *شكاوى مستقبله
                 *ملاحظات مرسلة
                 *ملاحظات مستقبله
                 *
                 * */

                //Sent
                $data["Complain"] =  $this->ComplainModel->GetComplains(0,$userID,$UserType);
                $data["notes"] =  $this->ComplainModel->GetComplains(1,$userID,$UserType);
                // received
                $data["ReceivedComplain"] =  $this->ComplainModel->GetComplains(0,$userID,$UserType,true);
                $data["ReceivedNotes"] =  $this->ComplainModel->GetComplains(1,$userID,$UserType,true);

            }else if ($UserType !=3 || $per == 1){
                $data["Complain"] =  $this->ComplainModel->GetComplains(0,$userID,$UserType,false,1);
                $data["notes"] =  $this->ComplainModel->GetComplains(1,$userID,$UserType,false,1);

            }else if ($UserType ==3){
                $data["Complain"] =  $this->ComplainModel->GetComplains(0,$userID,$UserType);
                $data["notes"] =  $this->ComplainModel->GetComplains(1,$userID,$UserType);
            }


//                print_r("<pre>");
//                print_r($data);
//                print_r("</pre>");die();


            $data["title"]="الشكاوى";
            $this->load->view('Complain/index', $data);
        }else{
            $this->load->view('login', $data);
        }
    }

    function newComplain(){
        $data['url'] = base_url();
        $_SESSION["PAGE"] = "Complains";
        if(isset($_SESSION['userid'])){
//            print_r("<pre>");
//            print_r($_POST);
//            print_r("</pre>");die();
            $ComplainData['Client_ID'] = null;
            $ComplainData['Titel'] = $_POST['title'];
            $ComplainData['UserID'] = $_SESSION['userid'];
            if (isset($_POST['ToSuper'])){
                $ComplainData['To_Super'] = 1;
                if ($_SESSION['usertype'] == 3){
                    $superID = $this->Users_Model->GetSupervisors($_SESSION['userid']);
                    $ComplainData['To_User'] =$superID[0]->ID;
                }else{
                    $ComplainData['To_User'] = $_POST['mto'];
                }
            }else{
                $ComplainData['Super_Deleted'] = 1;
            }
            if ($_POST['type'] == 1)
                $ComplainData['Type'] =$_POST['type'];
            $ComplainDetails['Owner_ID']=$_SESSION['userid'];
            $ComplainDetails['complaints_details']=htmlspecialchars($_POST['content']);

            $this->ComplainModel->AddComplain($ComplainData,$ComplainDetails);

//            print_r("<pre>");
//            print_r($_POST);
//            print_r("</pre>");die();


            redirect(site_url('CRM_Complain/index'));
        }else{
            redirect(site_url("CRM_Users"));
        }
    }


    function ClientComplain(){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            $this->load->view('login',$data);
        }
        else
        {
            $ComplainData['Client_ID'] = $_POST["clientid"];
            $ComplainData['Titel'] = $_POST["subject"];
            $ComplainData['UserID'] = $_SESSION['userid'];


            if (isset($_POST['toSuepr']) && !is_null($_POST['toSuepr'])){
                if ($_POST['toSuepr'] == 1){
                    if ($_SESSION['usertype'] == 3){
                        $superID = $this->Users_Model->GetSupervisors($_SESSION['userid']);
                        $ComplainData['To_User'] =$superID[0]->ID;
                    }
                }
            }
            if ($_POST['complain'] == 1)
                $ComplainData['Type'] =1;
            $ComplainDetails['Owner_ID']=$_SESSION['userid'];
            $ComplainDetails['complaints_details']=htmlspecialchars($_POST["content"]);
            $result= $this->ComplainModel->AddComplain($ComplainData,$ComplainDetails);

            if ($result > 0){
                echo 1 ;
            }else{
                echo 0 ;
            }
        }
    }

    function Delete(){
        $data['url'] = base_url();
        $_SESSION["PAGE"] = "Complains";
        if(isset($_SESSION['userid'])){
            $type = null;
            if ($_SESSION['usertype'] == 1 || $_SESSION['usertype'] == 4){
                $type = 1;
            }
            if ( !(empty($_POST['ComplainID']))){
                $result =  $this->ComplainModel->Delete($_POST["ComplainID"],$_SESSION['userid'],$type);
                if ($result >= 0 )
                    echo 1;
                else
                    echo 0;
            }else{
                echo 0;
            }
        }else{
            redirect(site_url("CRM_Users"));
        }
    }
    function details($id){
        $data['url'] = base_url();
        if(!isset($_SESSION['userid'])){
            redirect(site_url("CRM_Users"));
        }else {
            if ($id == null){
                redirect(site_url("CRM_Complain"));
            }else{

                $data["title"]="التفاصيل";
                // Set Seen  SetRead
                $this->ComplainModel->SetRead($id,$_SESSION['usertype'],$_SESSION['userid']);
                $data['MessageDetails'] = $this->ComplainModel->GetComplaintDetails($id);
                $this->load->view('Complain/details', $data);
            }
        }
    }
    function Replay(){

        $data['url'] = base_url();
        $_SESSION["PAGE"] = "Complains";
        if(isset($_SESSION['userid'])){
            $ComplainDetails['complaints_ID']=$_POST['msgID'];
            $ComplainDetails['Owner_ID']=$_SESSION['userid'];
            $ComplainDetails['complaints_details']=htmlspecialchars($_POST['content']);
            $this->ComplainModel->ReplyComplain($ComplainDetails);
            // update
            $this->ComplainModel->RenewComplain($_POST['msgID']);
            redirect(site_url('CRM_Complain/details/'.$_POST['msgID']));
        }else{
            redirect(site_url("CRM_Users"));
        }
    }
}