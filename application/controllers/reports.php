<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reports extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        session_start();
        $this->load->model('ReportModel');
        $this->load->model('Model1');
        $this->load->model('Users_Model');
        $this->load->model('premissions');
    }

    public function index()
    {
        $data['url'] = base_url();
        redirect(site_url("CRM_Users"));
    }

    public function employee($userType,$dateRange = null)
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            redirect(site_url("CRM_Users"));
            return;
        }
        if ($_SESSION['usertype'] ==  4){
            $Reports =$this->premissions->get_premissions($_SESSION["userid"],'02');
            if  ($Reports !=1){
                redirect(site_url("CRM_Users"));return;
            }
        }
        $data['url'] = base_url();
        if ($dateRange == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$dateRange);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $data["date1"] = $date1 ;
        $data["date2"] = $date2;

        if ($userType == 2){
            //supervispr
            $data["title"]="تقارير المشرفين";
            $_SESSION["PAGE"] ="reports_Supervisor";
            $reportData = $this->ReportModel->GetSupervisorReport($dateRange,$userType);
        }else if ($userType == 3){
            //employee
            $data["title"]="تقارير الموظفيين";
            $_SESSION["PAGE"] = "reports_employee";
            if ($_SESSION["usertype"] == 2){
                $reportData = $this->ReportModel->GetHomeDataReport($dateRange,$_SESSION['userid']);
            }else{
                $reportData = $this->ReportModel->GetEmployeeReport($dateRange,$userType);
            }
        }else{
            redirect(site_url("CRM_Users"));
            return;
        }
        $data['reportData']=$reportData;
        $data["TotalCalls"] = 0;
        $data["NoAnswerCalls"] = 0;
        $data["FollowCalls"] = 0;
        $data["ReservationCalls"] = 0;
        $data["contractCalls"] = 0;
        $data["DecontractCalls"] = 0;
        for ($i=0;$i<count($reportData);$i++){
            $data["TotalCalls"] +=$reportData[$i]->TotalCalls;
            $data["NoAnswerCalls"]+=$reportData[$i]->NoAnswerCalls;
            $data["FollowCalls"]+=$reportData[$i]->FollowCalls;
            $data["ReservationCalls"]+=$reportData[$i]->ReservationCalls;
            $data["contractCalls"]+=$reportData[$i]->contractCalls;
            $data["DecontractCalls"]+=$reportData[$i]->DecontractCalls;
        }

        $data['type'] = $userType;

//                print_r("<pre>");
//        print_r($data);
//        print_r("</pre>");die();
        $this->load->view('reports/employee',$data);
    }

    public function products($dateRange = null)
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            redirect(site_url("CRM_Users"));
            return;
        }
        if ($_SESSION['usertype'] ==  4){
            $Reports =$this->premissions->get_premissions($_SESSION["userid"],'02');
            if  ($Reports !=1){
                redirect(site_url("CRM_Users"));return;
            }
        }


        $data["title"]="تقارير المنتجات";
        $_SESSION["PAGE"] = "reports_employee";
        $data['url'] = base_url();
        if ($dateRange == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$dateRange);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $data["date1"] = $date1 ;
        $data["date2"] = $date2;
        $reportData = $this->ReportModel->GetProductsReport($dateRange);
        $data['reportData']=$reportData;


        $totalCount = 0;
        for ($i=0;$i<count($reportData);$i++){
            $totalCount += $reportData[$i]->PCount;
        }
        $data['totalCount']=$totalCount;
//        print_r("<pre>");
//        print_r($data);
//        print_r("</pre>");die();
        $this->load->view('reports/products',$data);
    }


    public function Calls($dateRange = null)
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            redirect(site_url("CRM_Users"));
            return;
        }

        if ($_SESSION['usertype'] ==  4){
            $Reports =$this->premissions->get_premissions($_SESSION["userid"],'02');
            if  ($Reports !=1){
                redirect(site_url("CRM_Users"));return;
            }
        }
        $data["title"]="تقارير المكالمات";
        $_SESSION["PAGE"] = "reports_calls";
        $data['url'] = base_url();
        if ($dateRange == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$dateRange);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $data["date1"] = $date1 ;
        $data["date2"] = $date2;
        $reportData = $this->ReportModel->GetCallsReport($dateRange);
        $data['reportData']=$reportData;
//        print_r("<pre>");
//        print_r($data);
//        print_r("</pre>");die();
        $this->load->view('reports/call',$data);
    }


    public function employeeDetails($userID=null,$dateRange = null)
    {
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            redirect(site_url("CRM_Users"));
            return;
        }
        if ($_SESSION['usertype'] ==  4){
            $Reports =$this->premissions->get_premissions($_SESSION["userid"],'02');
            if  ($Reports !=1){
                redirect(site_url("CRM_Users"));return;
            }
        }
        $data['url'] = base_url();
        if ($userID == null){
            $userID =$_SESSION['userid'];
        }
        if ($dateRange == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$dateRange);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $data["date1"] = $date1 ;
        $data["date2"] = $date2;
        $data["UserID"] = $userID;
        $data["title"]="تفاصيل التقرير";
        $_SESSION["PAGE"] = "reports_employeeDetails";
        $data['TotalNewCalls'] = $this->ReportModel->GetNewCallsCount($userID,$dateRange);
        $data['TotalCalls'] = $this->ReportModel->GetTotalCallsCount($userID,$dateRange);
        $data["AnswerCalls"] = $this->ReportModel->GetCallStatusReport($userID,1,$dateRange);
        $data["NoAnswerCalls"] = $this->ReportModel->GetCallStatusReport($userID,2,$dateRange);
        $data["ReservationCalls"] = $this->ReportModel->GetCallStatusReport($userID,3,$dateRange);
        $data["WrongCalls"] = $this->ReportModel->GetCallStatusReport($userID,4,$dateRange);
        $data["contractCalls"] = $this->ReportModel->GetCallStatusReport($userID,5,$dateRange);
        $data["DecontractCalls"] = $this->ReportModel->GetCallStatusReport($userID,6,$dateRange);
        $AnswerCallsCount = 0;
        $NoAnswerCallsCount = 0;
        $ReservationCallsCount = 0;
        $WrongCallsCount = 0;
        $contractCallsCount = 0;
        $DecontractCallsCount = 0;
        for ($i=0;$i<count($data["AnswerCalls"]);$i++){
            $AnswerCallsCount +=$data["AnswerCalls"][$i]->count;
        }
        for ($i=0;$i<count($data["NoAnswerCalls"]);$i++){
            $NoAnswerCallsCount+=$data["NoAnswerCalls"][$i]->count;
        }
        for ($i=0;$i<count($data["ReservationCalls"]);$i++){
            $ReservationCallsCount+=$data["ReservationCalls"][$i]->count;
        }
        for ($i=0;$i<count($data["WrongCalls"]);$i++){
            $WrongCallsCount+=$data["WrongCalls"][$i]->count;
        }
        for ($i=0;$i<count($data["contractCalls"]);$i++){
            $contractCallsCount+=$data["contractCalls"][$i]->count;
        }
        for ($i=0;$i<count($data["DecontractCalls"]);$i++){
            $DecontractCallsCount+=$data["DecontractCalls"][$i]->count;
        }
        $data['AnswerCallsCount']=$AnswerCallsCount;
        $data['NoAnswerCallsCount']=$NoAnswerCallsCount;
        $data['ReservationCallsCount']=$ReservationCallsCount;
        $data['WrongCallsCount']=$WrongCallsCount;
        $data['contractCallsCount']=$contractCallsCount;
        $data['DecontractCallsCount']=$DecontractCallsCount;
        $data['totalAmount'] = $this->ReportModel->GetEmployeeTotalAmount($userID,$date1,$date2)[0]->TotalAmount;
//        print_r("<pre>");
//        print_r($data);
//        print_r("</pre>");die();
        $this->load->view('reports/Emp_Report_Details',$data);
    }



    public function StaffEvaluation(){
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            redirect(site_url("CRM_Users"));
            return;
        }
        if ($_SESSION['usertype'] ==  4){
            $Reports =$this->premissions->get_premissions($_SESSION["userid"],'02');
            if  ($Reports !=1){
                redirect(site_url("CRM_Users"));return;
            }
        }

        $data['url'] = base_url();
        $_SESSION["PAGE"] = "StaffEvaluation";
        $data["title"]="تقييم أداء الموظفين";
        if (!isset($_SESSION['date1']) || is_null($_SESSION['date1'])){
            $_SESSION['date1'] = date("Y-m-d") ;
        }
        if (!isset($_SESSION['date2']) || is_null($_SESSION['date2'])){
            $_SESSION['date2'] = date("Y-m-d") ;
        }
        $data["date1"] = $_SESSION['date1'] ;
        $data["date2"] = $_SESSION['date2'] ;
        $data['users'] = $this->Users_Model->GetEmployee($_SESSION['userid'],$_SESSION['usertype']);
        $this->load->view('reports/Staff_Evaluation',$data);
    }

    function GetStaffData(){
//        print_r("<pre>");
//        print_r($_POST);
//        print_r("</pre>");
        $userID = $_POST['empID'];
        $dateRange = $_POST['Date'];
        if(!isset($_SESSION['userid']) || is_null($userID) || $userID <=0 ){
            $data['url'] = base_url();
            redirect(site_url("CRM_Users"));
            return;
        }
        if ($dateRange == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$dateRange);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $data['TotalNewCalls'] = $this->ReportModel->GetNewCallsCount($userID,$dateRange);
        $data['TotalCalls'] = $this->ReportModel->GetTotalCallsCount($userID,$dateRange);
        $data["AnswerCalls"] = $this->ReportModel->GetCallStatusReport($userID,1,$dateRange);
        $data["NoAnswerCalls"] = $this->ReportModel->GetCallStatusReport($userID,2,$dateRange);
        $data["ReservationCalls"] = $this->ReportModel->GetCallStatusReport($userID,3,$dateRange);
        $data["WrongCalls"] = $this->ReportModel->GetCallStatusReport($userID,4,$dateRange);
        $data["contractCalls"] = $this->ReportModel->GetCallStatusReport($userID,5,$dateRange);
        $data["DecontractCalls"] = $this->ReportModel->GetCallStatusReport($userID,6,$dateRange);
        $data["EmpName"] = get_Emp_name($userID);
        $AnswerCallsCount = 0;
        $NoAnswerCallsCount = 0;
        $ReservationCallsCount = 0;
        $WrongCallsCount = 0;
        $contractCallsCount = 0;
        $DecontractCallsCount = 0;
        for ($i=0;$i<count($data["AnswerCalls"]);$i++){
            $AnswerCallsCount +=$data["AnswerCalls"][$i]->count;
        }
        for ($i=0;$i<count($data["NoAnswerCalls"]);$i++){
            $NoAnswerCallsCount+=$data["NoAnswerCalls"][$i]->count;
        }
        for ($i=0;$i<count($data["ReservationCalls"]);$i++){
            $ReservationCallsCount+=$data["ReservationCalls"][$i]->count;
        }
        for ($i=0;$i<count($data["WrongCalls"]);$i++){
            $WrongCallsCount+=$data["WrongCalls"][$i]->count;
        }
        for ($i=0;$i<count($data["contractCalls"]);$i++){
            $contractCallsCount+=$data["contractCalls"][$i]->count;
        }
        for ($i=0;$i<count($data["DecontractCalls"]);$i++){
            $DecontractCallsCount+=$data["DecontractCalls"][$i]->count;
        }
        $data['AnswerCallsCount']=$AnswerCallsCount;
        $data['NoAnswerCallsCount']=$NoAnswerCallsCount;
        $data['ReservationCallsCount']=$ReservationCallsCount;
        $data['WrongCallsCount']=$WrongCallsCount;
        $data['contractCallsCount']=$contractCallsCount;
        $data['DecontractCallsCount']=$DecontractCallsCount;

        $totalAmount = $this->ReportModel->GetEmployeeTotalAmount($userID,$date1,$date2)[0]->TotalAmount;

        $data['totalAmount'] = isset($totalAmount)?$totalAmount:0;

//        print_r("<pre>");
//        print_r($data);
//        print_r("</pre>");die();

        echo json_encode($data);
        // $this->load->view('reports/Emp_Report_Details',$data);
    }

    function TargetedClients($dateRange = null){
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            redirect(site_url("CRM_Users"));
            return;
        }
        if ($_SESSION['usertype'] ==  4){
            $Reports =$this->premissions->get_premissions($_SESSION["userid"],'02');
            if  ($Reports !=1){
                redirect(site_url("CRM_Users"));return;
            }
        }

        $data['url'] = base_url();
        $_SESSION["PAGE"] = "TargetedClients";
        $data["title"]="العملاء المستهدفين";
        if ($dateRange == null){
            if (!isset($_SESSION['date1']) || is_null($_SESSION['date1'])){
                $_SESSION['date1'] = date("Y-m-d") ;
            }
            if (!isset($_SESSION['date2']) || is_null($_SESSION['date2'])){
                $_SESSION['date2'] = date("Y-m-d") ;
            }
        }else{
            $dateArray = explode("@",$dateRange);
            $_SESSION['date1'] = $dateArray[0] ;
            $_SESSION['date2'] = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }


        $data["date1"] = $_SESSION['date1'] ;
        $data["date2"] = $_SESSION['date2'] ;
        $data['Age'] = $this->ReportModel->GetAgeReport($dateRange);
        $data['Job'] = $this->ReportModel->GetJobReport($dateRange);
        $data['Government'] = $this->ReportModel->GetGovernmentReport($dateRange);
//print_r("<pre>");
//print_r($data);
//print_r("</pre>");die();
        $this->load->view('reports/TargetedClients',$data);

    }

}
