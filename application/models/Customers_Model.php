<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 10/11/2018
 * Time: 1:06 PM
 */

class Customers_Model extends CI_Model
{
    public function GetPotentialCustomers($userType,$userID = null,$dateRange=null){
        switch ($userType){
            case 1:
                // admin
                if ($dateRange == null){
                    $sql ="select count(*) as count from customercrm where 
                      customerCrmCreateDate <= Date (LAST_DAY(NOW())) and 
                      customerCrmCreateDate >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))";
                }else{
                    $dateArray = explode("@",$dateRange);
                    $date1 =    $dateArray[0] ;
                    $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                    $sql ="select count(*) as count from customercrm where 
                      Date(CONVERT(customerCrmCreateDate, DATE)) >=Date('".$date1."') and 
                      Date (CONVERT(customerCrmCreateDate, DATE)) <= Date('".$date2."')";

                }

                break;
            case 2:
            case 3:
                if ($dateRange == null){
                    $sql ="select count(*) as count from customercrm where 
                      customerCrmCreateDate <= Date (LAST_DAY(NOW())) and 
                      customerCrmCreateDate >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH)) 
                       and addedby=".$userID;
                }else{
                    $dateArray = explode("@",$dateRange);
                    $date1 =    $dateArray[0] ;
                    $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;

                    $sql ="select count(*) as count from customercrm where 
                      Date(CONVERT(customerCrmCreateDate, DATE)) >=Date('".$date1."') and 
                      Date (CONVERT(customerCrmCreateDate, DATE)) <= Date('".$date2."')
                       and addedby=".$userID;
//
                }


                break;


        }

        $query= $this->db->query($sql)->result();

        return $query[0]->count;
    }
    public function NonDistributors($userType, $userID = null,$dateRange=null){
        switch ($userType){
            case 1:
                if ($dateRange == null){
                    $sql ="select count(*) as count from customercrm where 
                      customerCrmCreateDate <= Date (LAST_DAY(NOW())) and 
                      customerCrmCreateDate >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))
                      and customercrm.customerCrmId NOT IN (SELECT clientID from employees_tasks)";
                }else{
                    $dateArray = explode("@",$dateRange);
                    $date1 =    $dateArray[0] ;
                    $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                    $sql ="select count(*) as count from customercrm where 
                     Date(CONVERT(customerCrmCreateDate, DATE)) >=Date('".$date1."') and 
                      Date (CONVERT(customerCrmCreateDate, DATE)) <= Date('".$date2."')
                      and customercrm.customerCrmId NOT IN (SELECT clientID from employees_tasks)";

                }

                break;
            case 2:
                if ($dateRange == null){
                    $sql = "select (select count(*) as count1 from customercrm where 
                      Date(CONVERT(customerCrmCreateDate, DATE)) >=Date(NOW()) and 
                      Date (CONVERT(customerCrmCreateDate, DATE)) <= Date(NOW())
                      and customercrm.customerCrmId NOT IN (SELECT clientID from employees_tasks) 
                      and customercrm.addedby = ".$userID.") + 
                     (select count(*) as count2 FROM `employees_tasks` WHERE 
                      `Date` = Date (NOW()) AND employees_tasks.userID = ".$userID." 
                      and employees_tasks.clientID IN 
                      (SELECT `customerCrmId` FROM customercrm
                       WHERE customercrm.addedby = ".$userID." or true)) as count ";
                }else{
                    $dateArray = explode("@",$dateRange);
                    $date1 =    $dateArray[0] ;
                    $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;

                    $sql = "select (select count(*) as count1 from customercrm  where 
                      Date(CONVERT(customerCrmCreateDate, DATE)) >=Date('".$date1."') and 
                      Date (CONVERT(customerCrmCreateDate, DATE)) <= Date('".$date2."')
                      and customercrm.customerCrmId NOT IN (SELECT clientID from employees_tasks) 
                      and customercrm.addedby = ".$userID.") + 
                     (select count(*) as count2 FROM `employees_tasks`  where 
                      Date(CONVERT(employees_tasks.Date, DATE)) >=Date('".$date1."') and 
                      Date (CONVERT(employees_tasks.Date, DATE)) <= Date('".$date2."') AND employees_tasks.userID = ".$userID." 
                      and employees_tasks.clientID IN 
                      (SELECT `customerCrmId` FROM customercrm
                       WHERE customercrm.addedby = ".$userID." or true)and employees_tasks.Status=1) as count ";


//                    $sql = "select count(*) as count from customercrm where
//                      Date(CONVERT(customerCrmCreateDate, DATE)) >=Date('".$date1."') and
//                      Date (CONVERT(customerCrmCreateDate, DATE)) <= Date('".$date2."')
//                      and customercrm.customerCrmId NOT IN (SELECT clientID from employees_tasks) and customercrm.addedby = ".$userID;
                }

//                print_r("<pre>");
//                print_r($sql);
//                print_r("</pre>");die();
                break;
            case 3:
                if ($dateRange == null){
                    $sql ="select count(*) as count from customercrm where 
                      customerCrmCreateDate <= Date (LAST_DAY(NOW())) and 
                      customerCrmCreateDate >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH)) 
                      and customercrm.customerCrmId NOT IN (SELECT clientID from employees_tasks)";
                }else{
                    $dateArray = explode("@",$dateRange);
                    $date1 =    $dateArray[0] ;
                    $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                    $sql ="select count(*) as count from customercrm where 
                      Date(CONVERT(customerCrmCreateDate, DATE)) >=Date('".$date1."') and 
                      Date (CONVERT(customerCrmCreateDate, DATE)) <= Date('".$date2."') 
                      and customercrm.customerCrmId NOT IN (SELECT clientID from employees_tasks)";

                }

                break;


        }

//        print_r($sql);die();
        $query= $this->db->query($sql)->result();

        return $query[0]->count;
    }
    public function Distributors($userType,$userID = null,$dateRange=null,$alldata=null){
        if ($alldata == null){
            switch ($userType){
                case 1:
                    if ($dateRange == null){
                        $sql ="select count(*) as count FROM `employees_tasks` WHERE 
                      `Date` = Date (NOW())";
                    }else{
                        $dateArray = explode("@",$dateRange);
                        $date1 =    $dateArray[0] ;
                        $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                        $sql ="select count(*) as count FROM `employees_tasks` WHERE 
                      `Date` >= Date ('".$date1."') and 
                      `Date` <= Date ('".$date2."')";
                    }

                    break;
                case 2:
                    if ($dateRange == null){
                        $sql ="select count(*) as count FROM `employees_tasks` WHERE 
                      `Date` = Date (NOW())
                      and (supervisor_ID = ".$userID." or employees_tasks.clientID IN (SELECT `customerCrmId` FROM customercrm WHERE customercrm.addedby = ".$userID." or true))";
                    }else{
                        $dateArray = explode("@",$dateRange);
                        $date1 =    $dateArray[0] ;
                        $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                        $sql ="select count(*) as count FROM `employees_tasks` WHERE 
                      `Date` >= Date ('".$date1."') and 
                      `Date` <= Date ('".$date2."')
                      and (employees_tasks.Distributor_By = ".$userID." or employees_tasks.clientID IN (SELECT `customerCrmId` FROM customercrm WHERE customercrm.addedby = ".$userID."))";
                        //die($sql);
                    }


                    break;
                case 3:
                    if ($dateRange == null){
                        $sql ="select count(*) as count FROM `employees_tasks` WHERE 
                      `Date` = Date (NOW()) 
                      and (userID = ".$userID.")";
                    }else{
                        $dateArray = explode("@",$dateRange);
                        $date1 =    $dateArray[0] ;
                        $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                        $sql ="select count(*) as count FROM `employees_tasks` WHERE 
                       `Date` >= Date ('".$date1."') and 
                      `Date` <= Date ('".$date2."')
                      and (userID = ".$userID.")";
                    }

                    break;


            }
        }else{
            if ($dateRange == null){
                $sql ="select count(*) as count FROM `employees_tasks` WHERE 
                      `Date` = Date (NOW())";
            }else{
                $dateArray = explode("@",$dateRange);
                $date1 =    $dateArray[0] ;
                $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                $sql ="select count(*) as count FROM `employees_tasks` WHERE 
                      `Date` >= Date ('".$date1."') and 
                      `Date` <= Date ('".$date2."')";
            }
        }
//print_r($sql);die();
        $query= $this->db->query($sql)->result();

        return $query[0]->count;
    }
    public function DistributorsClients($userType,$userID = null,$dateRange=null,$status = null,$alldata=null){

        if ( $alldata == null){
            if ($status == null){
                switch ($userType){
                    case 1:
                        if ($dateRange == null){
                            $sql ="select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID 
                               left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                           WHERE employees_tasks.`Date` <= Date (LAST_DAY(NOW())) and 
                                 employees_tasks.`Date` >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))";
                        }else{
                            $dateArray = explode("@",$dateRange);
                            $date1 =    $dateArray[0] ;
                            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;

                            $sql ="select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID 
                              left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                           WHERE employees_tasks.`Date` >= Date ('".$date1."') and 
                                 employees_tasks.`Date` <= Date ('".$date2."')";
                        }
                           // die($sql);
                        break;
                    case 2:
                        if ($dateRange == null){
                            $sql ="select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID 
                                left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                           WHERE 
                      employees_tasks.`Date` <= Date (LAST_DAY(NOW())) and 
                      employees_tasks.`Date` >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))
                      and (employees_tasks.supervisor_ID = ".$userID." or employees_tasks.userID = ".$userID.")";
                        }else{
                            $dateArray = explode("@",$dateRange);
                            $date1 =    $dateArray[0] ;
                            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                            $sql ="select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID
                               left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                            WHERE 
                      employees_tasks.`Date` >= Date ('".$date1."') and 
                      employees_tasks.`Date` <= Date ('".$date2."')
                      and (employees_tasks.supervisor_ID = ".$userID." or employees_tasks.userID = ".$userID.")";
                        }


                        break;
                    case 3:
                        if ($dateRange == null){
                            $sql ="select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID 
                               left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                           WHERE 
                      employees_tasks.`Date` <= Date (LAST_DAY(NOW())) and 
                     employees_tasks.`Date` >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))
                      and (userID = ".$userID.")";
                        }else{
                            $dateArray = explode("@",$dateRange);
                            $date1 =    $dateArray[0] ;
                            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                            $sql ="select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID 
                               left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                           WHERE 
                       employees_tasks.`Date` >= Date ('".$date1."') and 
                     employees_tasks.`Date` <= Date ('".$date2."')
                      and (employees_tasks.userID = ".$userID.")";
                        }

                        break;


                }}else{
                switch ($userType) {
                    case 1:
                        if ($dateRange == null) {
                            $sql = "select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID 
                                left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                           WHERE
                            employees_tasks.Status = ".$status."
                      employees_tasks.`Date` <= Date (LAST_DAY(NOW())) and 
                      employees_tasks.`Date` >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))";
                        } else {
                            $dateArray = explode("@", $dateRange);
                            $date1 = $dateArray[0];
                            $date2 = ($dateArray[1] == "") ? $dateArray[0] : $dateArray[1];

                            $sql = "select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID 
                               left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                           WHERE 
                            employees_tasks.Status = ".$status."
                      employees_tasks.`Date` >= Date ('" . $date1 . "') and 
                     employees_tasks.`Date` <= Date ('" . $date2 . "')";
                        }

                        break;
                    case 2:
                        if ($dateRange == null) {
                            $sql = "select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID
                               left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                            WHERE 
                      employees_tasks.Status = ".$status."
                      employees_tasks.`Date` <= Date (LAST_DAY(NOW())) and 
                      employees_tasks.`Date` >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))
                      and (supervisor_ID = " . $userID . " or userID = " . $userID . ")";
                        } else {
                            $dateArray = explode("@", $dateRange);
                            $date1 = $dateArray[0];
                            $date2 = ($dateArray[1] == "") ? $dateArray[0] : $dateArray[1];
                            $sql = "select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID
                               left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                            WHERE 
                       employees_tasks.Status = ".$status."
                     employees_tasks.`Date` >= Date ('" . $date1 . "') and 
                      employees_tasks.`Date` <= Date ('" . $date2 . "')
                      and (employees_tasks.supervisor_ID = " . $userID . " or employees_tasks.userID = " . $userID . ")";
                        }


                        break;
                    case 3:
                        if ($dateRange == null) {
                            $sql = "select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID
                               left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                           WHERE 
                      employees_tasks.Status = ".$status."
                      employees_tasks.`Date` <= Date (LAST_DAY(NOW())) and 
                     employees_tasks.`Date` >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))
                      and (employees_tasks.userID = " . $userID . ")";
                        } else {
                            $dateArray = explode("@", $dateRange);
                            $date1 = $dateArray[0];
                            $date2 = ($dateArray[1] == "") ? $dateArray[0] : $dateArray[1];
                            $sql = "select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID
                               left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                            WHERE 
                      employees_tasks.Status = ".$status."
                      employees_tasks.`Date` >= Date ('" . $date1 . "') and 
                     employees_tasks.`Date` <= Date ('" . $date2 . "')
                      and (employees_tasks.userID = " . $userID . ")";
                        }

                        break;

                }
            }
        }else{
            if ($status == null){
                if ($dateRange == null){
                    $sql ="select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID
                                left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                            WHERE 
                      employees_tasks.`Date` <= Date (LAST_DAY(NOW())) and 
                     employees_tasks.`Date` >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))";
                }else{
                    $dateArray = explode("@",$dateRange);
                    $date1 =    $dateArray[0] ;
                    $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;

                    $sql ="select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID
                                left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                            WHERE 
                      employees_tasks.`Date` >= Date ('".$date1."') and 
                     employees_tasks.`Date` <= Date ('".$date2."')";
                }
            }else{
                if ($dateRange == null) {
                    $sql = "select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID 
                               left join crm_follows
                           on crm_follows.ClientID = employees_tasks.clientID
                           WHERE
                            employees_tasks.Status = ".$status."
                      employees_tasks.`Date` <= Date (LAST_DAY(NOW())) and 
                      employees_tasks.`Date` >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))";
                } else {
                    $dateArray = explode("@", $dateRange);
                    $date1 = $dateArray[0];
                    $date2 = ($dateArray[1] == "") ? $dateArray[0] : $dateArray[1];

                    $sql = "select * FROM `employees_tasks` inner join customercrm on employees_tasks.clientID = customercrm.customerCrmId
                           inner join crm_users on employees_tasks.userID = crm_users.ID 
                             left join ( SELECT crm_follows.Follow_Date,crm_follows.Follow_Time,crm_follows.ClientID FROM crm_follows ORDER BY Follow_Date,Follow_Time LIMIT 1) as calls  
                           on calls.ClientID = employees_tasks.clientID
                           WHERE 
                            employees_tasks.Status = ".$status."
                      employees_tasks.`Date` >= Date ('" . $date1 . "') and 
                      employees_tasks.`Date` <= Date ('" . $date2 . "')";
                }
            }
        }

        $query= $this->db->query($sql)->result();

        return $query;
    }
    public function delayedData($userID = null,$dateRange=null){

        if ($userID !=null){
            if ($dateRange ==null){
                $sql ="select count(*) as count from customercrm where 
                       customerCrmCreateDate < Date (now()) and addedby=".$userID;
//                print_r($sql);die();
            }else{
                $dateArray = explode("@",$dateRange);
                $date1 =    $dateArray[0] ;
                $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                $sql ="select count(*) as count from customercrm where 
                      Date(CONVERT(customerCrmCreateDate, DATE)) < Date('".$date1."')
                      and addedby=".$userID;
//                print_r($sql);die();
            }

        }else{
            if ($dateRange ==null){
                $sql ="select count(*) as count from customercrm where 
                      customerCrmCreateDate < Date (now())";
            }else{
                $dateArray = explode("@",$dateRange);
                $date1 =    $dateArray[0] ;
                $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                $sql ="select count(*) as count from customercrm where 
                     Date(CONVERT(customerCrmCreateDate, DATE)) < Date('".$date1."') and 
                      Date (CONVERT(customerCrmCreateDate, DATE)) > Date('".$date2."')
                      ";
            }

        }

        $sql .=" and customercrm.customerCrmId NOT IN (SELECT clientID from employees_tasks)";

        $query= $this->db->query($sql)->result();

        return $query[0]->count;
    }
    public function GetCustomers($UserType,$UserID = null,$dateRange=null,$per = 0){

        if ($dateRange == null){
            $date1 =  date("Y-m-d") ;
            $date2 =  date("Y-m-d");
        }else{
            $dateArray = explode("@",$dateRange);
            $date1 =    $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
        }

        if ($UserType == 1 || $per==1){
            // Admin
            $sql = "SELECT * FROM customercrm WHERE customercrm.customerCrmId not IN (SELECT clientID FROM employees_tasks)";
            $sql .="and Date(CONVERT(customercrm.customerCrmCreateDate, DATE))>= Date('".$date1."') and 
                      Date (CONVERT(customercrm.customerCrmCreateDate, DATE)) <= Date('".$date2."')";
        }else{
            if ($UserID != null)
            {
                $sql = "SELECT customercrm.* FROM customercrm INNER Join employees_tasks ON customercrm.customerCrmId = employees_tasks.clientID WHERE employees_tasks.userID = ".$UserID." and employees_tasks.Status = 1 ";
                $sql .="and Date(CONVERT(customercrm.customerCrmCreateDate, DATE))>= Date('".$date1."') and 
                      Date (CONVERT(customercrm.customerCrmCreateDate, DATE)) <= Date('".$date2."') UNION (SELECT * FROM customercrm WHERE customercrm.customerCrmId not IN (SELECT clientID FROM employees_tasks) AND customercrm.addedby = ".$UserID.")";
            } else{
                return null;
            }
        }
        $query=$this->db->query($sql)->result();
        return $query;
    }
    public function DeleteCustomers($where){
        $this->db->where($where);
        $this->db->delete('customercrm');
        return $this->db->affected_rows();
    }
    public function missionsCount($userID,$dateRange=null){
        $where = "userID = ".$userID;

        if ($dateRange !=null){
            $dateArray = explode("@",$dateRange);
            $date1 =    $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
            $where .= " and Date(CONVERT(Date, DATE))>= Date('".$date1."') and 
                      Date (CONVERT(Date, DATE)) <= Date('".$date2."')";

        }else{
            $date1 = date("Y-m-d") ;
            $date2 = date("Y-m-d") ;
            $where .= " and Date(CONVERT(Date, DATE))>= Date('".$date1."') and 
                      Date (CONVERT(Date, DATE)) <= Date('".$date2."')";
        }
        $this->db->select('Count(*) as Count');
        $this->db->where($where);
        $query = $this->db->get('employees_tasks')->result();
        return $query[0]->Count;
    }
    public function missionsDone($userID,$dateRange=null){
        $where = "userID = ".$userID;
        $where .= " and Status <> 1 ";
        if ($dateRange !=null){
            $dateArray = explode("@",$dateRange);
            $date1 =    $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
            $where .= "and Date(CONVERT(Date, DATE))>= Date('".$date1."') and 
                      Date (CONVERT(Date, DATE)) <= Date('".$date2."')";

        }else{
            $date1 = date("Y-m-d") ;
            $date2 = date("Y-m-d") ;
            $where .= "and Date(CONVERT(Date, DATE))>= Date('".$date1."') and 
                      Date (CONVERT(Date, DATE)) <= Date('".$date2."')";
        }
        $this->db->select('Count(*) as Count');
        $this->db->where($where);
        $query = $this->db->get('employees_tasks')->result();
        return $query[0]->Count;
    }
    public function missions($userID,$dateRange=null){
        $where = "userID = ".$userID;
        $where .= " and Status = 1 ";
        if ($dateRange !=null){
            $dateArray = explode("@",$dateRange);
            $date1 =    $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
            $where .= "and Date(CONVERT(Date, DATE))>= Date('".$date1."') and 
                      Date (CONVERT(Date, DATE)) <= Date('".$date2."')";

        }else{
            $date1 = date("Y-m-d") ;
            $date2 = date("Y-m-d") ;
            $where .= "and Date(CONVERT(Date, DATE))>= Date('".$date1."') and 
                      Date (CONVERT(Date, DATE)) <= Date('".$date2."')";
        }
        $this->db->select('Count(*) as Count');
        $this->db->where($where);
        $query = $this->db->get('employees_tasks')->result();
        return $query[0]->Count;
    }
    public function GetCustomerByID($CustomerID){
        $this->db->where('customerCrmId',$CustomerID);
        return $this->db->get('customercrm')->result();
    }
    public function GetCalCount($status,$UserID = null ,$UserType = null,$dateRange=null,$alldata = null){
        if ($alldata ==null){

            if ($UserID == null ||$UserType==1){
                // Admin
                $this->db->select('Count(*) as Count');
                $this->db->where('Status',$status);
                if ($dateRange==null){
                    $this->db->where('Date <= Date (LAST_DAY(NOW())) and 
                      Date >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))');
                }else{
                    $dateArray = explode("@",$dateRange);
                    $date1 =    $dateArray[0] ;
                    $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                    $this->db->where('Date >= Date("'.$date1.'") and 
                      Date <= Date ("'.$date2.'")');
                }

                $query = $this->db->get('employees_tasks');

            }else{

                if ($UserType == 2){
                    //Super
                    $this->db->select('Count(*) as Count');
                    if ($dateRange==null){
                        $where = "`Status` = '".$status."' AND (`userID` = '".$UserID."' or `supervisor_ID` ='".$UserID."') 
                        AND `Date` <= Date (LAST_DAY(NOW())) and `Date` >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))";
                    }else{
                        $dateArray = explode("@",$dateRange);
                        $date1 =    $dateArray[0] ;
                        $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                        $where = "`Status` = '".$status."' AND (`userID` = '".$UserID."' or `supervisor_ID` ='".$UserID."') 
                        AND `Date` >= Date ('".$date1."') and `Date` <= Date ('".$date2."')";
                    }

                    $this->db->where($where);

                    $query = $this->db->get('employees_tasks');

                }else{
                    //Employee
                    $this->db->select('Count(*) as Count');
                    $this->db->where('Status',$status);
                    $this->db->where('userID',$UserID);
                    if ($dateRange==null){
                        $this->db->where('Date <= Date (LAST_DAY(NOW())) and 
                      Date >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))');
                    }else{
                        $dateArray = explode("@",$dateRange);
                        $date1 =    $dateArray[0] ;
                        $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                        $this->db->where("Date >= Date ('".$date1."') and 
                      Date <= Date ('".$date2."')");
                    }

                    $query = $this->db->get('employees_tasks');

                }
            }
        }else{
            $this->db->select('Count(*) as Count');
            $this->db->where('Status',$status);
            if ($dateRange==null){
                $this->db->where('Date <= Date (LAST_DAY(NOW())) and 
                      Date >= Date (DATE_ADD(DATE_ADD(LAST_DAY(now()),INTERVAL 1 DAY),INTERVAL - 1 MONTH))');
            }else{
                $dateArray = explode("@",$dateRange);
                $date1 =    $dateArray[0] ;
                $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
                $this->db->where('Date >= Date("'.$date1.'") and 
                      Date <= Date ("'.$date2.'")');
            }

            $query = $this->db->get('employees_tasks');
        }
        $result['counter'] = $query->result()[0]->Count;
        $result['Status_Name'] = $this->GetStatusName($status);
        return $result;
    }
    public function GetStatusName($statusID){
        $this->db->where('id',$statusID);
        return $this->db->get('call_status')->result()[0]->title;
    }
    public function GetEmployeeCalls($EmpID,$dateRange=null){

        $this->db->select('*');
        $this->db->from('customercrm');
        $this->db->join('employees_tasks', 'employees_tasks.clientID = customercrm.customerCrmId');
        if ($dateRange !=null){
            $dateArray = explode("@",$dateRange);
            $date1 =    $dateArray[0] ;
            $date2 = ($dateArray[1] == "") ?  $dateArray[0] : $dateArray[1] ;
            $this->db->where("Date(CONVERT(employees_tasks.Date, DATE))>= Date('".$date1."') and 
                      Date (CONVERT(employees_tasks.Date, DATE)) <= Date('".$date2."')");
        }else{
            $date1 = date("Y-m-d") ;
            $date2 = date("Y-m-d") ;
            $this->db->where("Date(CONVERT(employees_tasks.Date, DATE))>= Date('".$date1."') and 
                      Date (CONVERT(employees_tasks.Date, DATE)) <= Date('".$date2."')");
        }
        $_SESSION['date1'] = $date1;
        $_SESSION['date2'] = $date2;
        $this->db->where('employees_tasks.userID',$EmpID);
        return $this->db->get()->result();
    }
    public function GetCallStatus(){

        $this->db->select('*');
        $this->db->from('call_status');

        return $this->db->get()->result();
    }
    /////////////////////////AymanBassiony
    public function call_status_count($user_id,$status,$type=3,$start_date='',$end_date=''){
        if($start_date==''){
            $start_date=date("Y-m-d", strtotime('1-'.date('m').'-'.date('Y')));
        }
        if($end_date==''){
            $end_date=date("Y-m-d", strtotime('30-'.date('m').'-'.date('Y')));
        }
        $sql='select count(employees_tasks.id) as counter,call_status.title as Status_Name from employees_tasks RIGHT join call_status on call_status.id=employees_tasks.Status where employees_tasks.Status=? and employees_tasks.Date BETWEEN ? and ? ';
        $arr=[(int)$status,$start_date,$end_date];
        if($type==1){
            $sql .='and employees_tasks.userID=?';
            $arr[]=$user_id;
        }elseif($type==2){
            $sql .='and employees_tasks.supervisor_ID=?';
            $arr[]=$user_id;
        }

        $count=$this->SelectRow($sql,$arr,'A');
        // echo $this->db->last_query();die;
        return $count;
    }
    public function call_status($home=false){
        $sql='Select * from call_status';
        if($home){
            $sql .=' where at_home=1';
        }
        // echo $sql;die;
        $rows=$this->Select($sql,'','A');
        if($rows=='0'){
            $rows=[];
        }
        return $rows;
    }
    public function get_setting(){
        $sql='select * from settingcrm';
        $rows=$this->Select($sql,'','A');
        if($rows=='0'){
            $rows=[];
        }
        return $rows;
    }
    public function SelectRow($sql, $array, $ResultType) {
        if ($array == '') {
            $query = $this->db->query($sql);
        } else {
            $query = $this->db->query($sql, $array);
        }
        if ($query->num_rows() > 0) {
            if ($ResultType == 'J') {
                $result = $query->row();
            } elseif ($ResultType == 'A') {
                $result = $query->row_array();
            }

        } else {
            $result = '0';
        }
        return $result;
    }
    public function Select($sql, $array, $ResultType) {
        if ($array == '') {
            $query = $this->db->query($sql);
        } else {
            $query = $this->db->query($sql, $array);
        }
        if ($query->num_rows() > 0) {
            if ($ResultType == 'J') {
                $result = $query->result();
            } elseif ($ResultType == 'A') {
                $result = $query->result_array();
            }
        } else {
            $result = '0';
        }
        return $result;
    }
}