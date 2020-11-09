<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 18/02/2019
 * Time: 05:05 م
 */

class ReportModel extends CI_Model
{
    function GetEmployeeReport($date = null){
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $parameters['date1']=$date1;
        $parameters['date2']=$date2;
        $query = $this->db->query('CALL EmpReport(?,?)',$parameters);
        $result = $query->result();
        $query->next_result();
        $query->free_result();
        return $result;

    }
    function GetEmployeeTotalAmount($EmpID,$date1,$date2){
        $this->db->select('sum(client_orders_details.Quantity)*client_orders_details.Price as TotalAmount');
        $this->db->from('client_orders_details');
        $this->db->join('client_orders', 'client_orders_details.Order_ID = client_orders.ID');
        $this->db->where('client_orders.User_ID',$EmpID);
        $this->db->where('CONVERT(client_orders.Date,date) <="'.$date2.'"');
        $this->db->where('CONVERT(client_orders.Date,date) >="'.$date1.'"');
        $query = $this->db->get();
        return $query->result();
    }

    function GetSupervisorEmployeeReport($date = null,$userID){
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $parameters['date1']=$date1;
        $parameters['date2']=$date2;
        $query = $this->db->query('CALL EmpReport(?,?)',$parameters);
        $result = $query->result();
        $query->next_result();
        $query->free_result();
        return $result;

    }


    function GetHomeDataReport($date = null,$SuperID){
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $parameters['date1']=$date1;
        $parameters['date2']=$date2;
        $parameters['SuperID']=$SuperID;
        $query = $this->db->query('CALL EmpReportForSuperVisor(?,?,?)',$parameters);
        $result = $query->result();
        $query->next_result();
        $query->free_result();
        return $result;

    }
    function GetSupervisorReport($date = null){
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $parameters['date1']=$date1;
        $parameters['date2']=$date2;
        $query = $this->db->query('CALL SuperReport(?,?)',$parameters);
        $result = $query->result();
        $query->next_result();
        $query->free_result();
        return $result;

    }
    function GetEmployeeDetailsReport($userID,$date){

        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }

    }
    function GetProductsReport($date = null){
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $parameters['date1']=$date1;
        $parameters['date2']=$date2;
        $query = $this->db->query('CALL ProductsReport(?,?)',$parameters);
        $result = $query->result();
        $query->next_result();
        $query->free_result();

        return $result;

    }
    function GetCallsReport($date = null){
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $parameters['date1']=$date1;
        $parameters['date2']=$date2;
        $query = $this->db->query('CALL CallsReport(?,?)',$parameters);
        $result = $query->result();
        $query->next_result();
        $query->free_result();

        return $result;

    }
    function GetNewCallsCount($userID,$date = null){
        //UserCallsWithStatusType
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $parameters['UserID']=$userID;
        $parameters['statusType']=0;
        $parameters['date1']=$date1;
        $parameters['date2']=$date2;
        $query = $this->db->query('CALL UserCallsWithStatusType(?,?,?,?)',$parameters);
        $result = $query->result()[0]->total;
        $query->next_result();
        $query->free_result();

        return $result;

    }
    function GetTotalCallsCount($userID,$date = null){
//UserCallsCount
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $parameters['UserID']=$userID;
        $parameters['date1']=$date1;
        $parameters['date2']=$date2;
        $query = $this->db->query('CALL UserCallsCount(?,?,?)',$parameters);
        $result = $query->result()[0]->total;
        $query->next_result();
        $query->free_result();

        return $result;
    }
    function GetCallStatusReport($userID,$status,$date = null){
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $parameters['CStatus']=$status;
        $parameters['UserID']=$userID;
        $parameters['date1']=$date1;
        $parameters['date2']=$date2;


        $query = $this->db->query('CALL ReportCallStatus(?,?,?,?)',$parameters);
        $result = $query->result();
        $query->next_result();
        $query->free_result();
//        print_r("<pre>");
//        print_r($parameters);
//        print_r($result);
//        print_r("</pre>");die();
        return $result;
    }
    function GetHomeCallsReport($userType,$UserID,$date = null){
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }

        if ($userType == 1){
            $parameters['date1']=$date1;
            $parameters['date2']=$date2;
            $query = $this->db->query('CALL  HomeCallsReportForAdmin(?,?)',$parameters);
            $result = $query->result();
            $query->next_result();
            $query->free_result();
//            print_r("<pre>");
//            print_r($result);
//            print_r("</pre>");die();
            return $result;
        }else{
            $parameters['UserID']=$UserID;
            $parameters['date1']=$date1;
            $parameters['date2']=$date2;
            $query = $this->db->query('CALL  HomeCallsReport(?,?,?)',$parameters);
            $result = $query->result();
            $query->next_result();
            $query->free_result();
//            print_r("<pre>");
//            print_r($result);
//            print_r("</pre>");die();
            return $result;
        }







    }
    function GetHomeDataReportAdmin($userType,$UserID){


        if ($userType == 1){

            $query = $this->db->query('CALL  HomeDataReportForAdmin()');
            $result = $query->result();
            $query->next_result();
            $query->free_result();

            return $result;
        }else{
            $parameters['UserID']=$UserID;

            $query = $this->db->query('CALL  HomeDataReport(?)',$parameters);
            $result = $query->result();
            $query->next_result();
            $query->free_result();
            return $result;
        }







    }

    function GetGovernmentReport($date = null){
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $parameters['date1']=$date1;
        $parameters['date2']=$date2;
        $query = $this->db->query('CALL GovernmentReport (?,?)',$parameters);
        $result = $query->result();
        $query->next_result();
        $query->free_result();

        return $result;
    }

    function GetJobReport($date = null){
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $parameters['date1']=$date1;
        $parameters['date2']=$date2;
        $query = $this->db->query('CALL JobReport (?,?)',$parameters);
        $result = $query->result();
        $query->next_result();
        $query->free_result();

        return $result;
    }


    function GetAgeReport($date = null){
        if ($date == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$date);
            $date1 = $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }
        $parameters['date1']=$date1;
        $parameters['date2']=$date2;
        $query = $this->db->query('CALL AgeReport (?,?)',$parameters);
        $result = $query->result();
        $query->next_result();
        $query->free_result();

        return $result;
    }
}