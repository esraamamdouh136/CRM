<?php
/**
 * Created by PhpStorm.
 * User: boody
 * Date: 08/08/2018
 * Time: 07:07 م
 */

class Employee_Taskes extends CI_Model
{



    public function GetTasksCount($date1,$date2,$StatusID,$userID,$IsSuper = false)
    {


        if ($date1 == null || $date2 == null){
            if ($userID > 0){

                if ($IsSuper){
                    if ($StatusID > 0)
                        //SELECT COUNT(*) as count FROM employees_tasks INNER JOIN call_status on call_status.id = employees_tasks.Status WHERE employees_tasks.Date >= Date("."$date1".") and employees_tasks.Date <= Date ("."$date2".") and (call_status.id = ".$StatusID." or call_status.Status_Parent =".$StatusID.") and (supervisor_ID = ".$userID." or userID = ".$userID.");
                        $query = $this->db->query("SELECT COUNT(*) as count FROM employees_tasks INNER JOIN call_status on call_status.id = employees_tasks.Status WHERE (DATE_ADD(employees_tasks.Date, INTERVAL 1 DAY) <= now())  and (call_status.id = ".$StatusID.") and (supervisor_ID = ".$userID." or userID = ".$userID.");")->result();
                    else
                        $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` WHERE  (DATE_ADD(employees_tasks.Date, INTERVAL 1 DAY) <= now() ) and (supervisor_ID = ".$userID." or userID = ".$userID.") ;")->result();
                } else{
                    if ($StatusID > 0)
                        $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` INNER JOIN call_status on call_status.id = employees_tasks.Status WHERE  (DATE_ADD(employees_tasks.Date, INTERVAL 1 DAY) <= now() ) and (call_status.id = ".$StatusID.") and userID = ".$userID.";")->result();
                    else
                        $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` WHERE  (DATE_ADD(employees_tasks.Date, INTERVAL 1 DAY) <= now() or  DATE_ADD(employees_tasks.Follow_Date, INTERVAL 1 DAY) <= now()) and userID = ".$userID.";")->result();

                }
            }else{
                if ($StatusID > 0)
                    $query = $this->db->query("SELECT COUNT(*) as count FROM employees_tasks INNER JOIN call_status on call_status.id = employees_tasks.Status WHERE  (DATE_ADD(employees_tasks.Date, INTERVAL 1 DAY) <= now() ) and (call_status.id = ".$StatusID.");")->result();
                else
                    $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` WHERE  (DATE_ADD(employees_tasks.Date, INTERVAL 1 DAY) <= now() or  DATE_ADD(employees_tasks.Follow_Date, INTERVAL 1 DAY) <= now());")->result();
            }
        }else{
            if ($userID > 0){
                if ($IsSuper){
                    if ($StatusID > 0){
                        //SELECT COUNT(*) as count FROM employees_tasks INNER JOIN call_status on call_status.id = employees_tasks.Status WHERE employees_tasks.Date >= Date("."$date1".") and employees_tasks.Date <= Date ("."$date2".") and (call_status.id = ".$StatusID." or call_status.Status_Parent =".$StatusID.") and (supervisor_ID = ".$userID." or userID = ".$userID.");
                        $query = $this->db->query("SELECT COUNT(*) as count FROM employees_tasks INNER JOIN call_status on call_status.id = employees_tasks.Status WHERE (employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date (\"".$date2."\") ) and (call_status.id = ".$StatusID.") and (supervisor_ID = ".$userID." or userID = ".$userID.");")->result();

                    }  else{
                        $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` WHERE  (employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date (\"".$date2."\")) and (supervisor_ID = ".$userID." or userID = ".$userID.") ;")->result();

                    }
                } else{
                    if ($StatusID > 0)
                        $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` INNER JOIN call_status on call_status.id = employees_tasks.Status WHERE  ((employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date (\"".$date2."\")) ) and (call_status.id = ".$StatusID." ) and userID = ".$userID.";")->result();
                    else
                        $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` WHERE  ((employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date (\"".$date2."\")) )  and userID = ".$userID.";")->result();
                }}else{
                if ($StatusID > 0)
                    $query = $this->db->query("SELECT COUNT(*) as count FROM employees_tasks INNER JOIN call_status on call_status.id = employees_tasks.Status WHERE  ((employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date (\"".$date2."\")) ) and (call_status.id = ".$StatusID.");")->result();
                else
                    $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` WHERE  ((employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date (\"".$date2."\")) );")->result();
            }
        }

        return $query[0]->count;
    }
    public function GetTasksCountForclient($date1,$date2,$StatusID,$userID,$IsSuper = false)
    {
        if ($userID > 0){
            if ($IsSuper){
                if ($StatusID > 0)
                    $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` INNER JOIN call_status on call_status.id = employees_tasks.Status WHERE `Date` >= Date(\"".$date1."\") and `Date` <= Date (\"".$date2."\") and call_status.id = ".$StatusID."  and (supervisor_ID = ".$userID." or userID = ".$userID.");")->result();
                else
                    $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` WHERE `Date` >= Date(\"".$date1."\") and `Date` <= Date (\"".$date2."\")  and userID = ".$userID.";")->result();
            }else{
                if ($StatusID > 0)
                    $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` INNER JOIN call_status on call_status.id = employees_tasks.Status WHERE `Date` >= Date(\"".$date1."\") and `Date` <= Date (\"".$date2."\") and call_status.id = ".$StatusID." and userID = ".$userID.";")->result();
                else
                    $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` WHERE `Date` >= Date(\"".$date1."\") and `Date` <= Date (\"".$date2."\")  and userID = ".$userID.";")->result();
            }

        }else{
            if ($StatusID > 0)
                $query = $this->db->query("SELECT COUNT(*) as count FROM employees_tasks INNER JOIN call_status on call_status.id = employees_tasks.Status WHERE employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date (\"".$date2."\") and call_status.id = ".$StatusID.";")->result();
            else
                $query = $this->db->query("SELECT COUNT(*) as count FROM `employees_tasks` WHERE `Date` >= Date(\"".$date1."\") and `Date` <= Date (\"".$date2."\");")->result();
        }

        return $query[0]->count;
    }
    public function TasksReset($Olduser,$newuser,$customerid,$comment)
    {
        $SuperID = $this->db->query("SELECT `userCrmSuper` FROM `usercrm` where `userCrmId` =".$_GET["newuser"])->result();
        $Date=date("Y:m:d");
        $Time=date("h:i:sa");
        //UPDATE `employees_tasks` SET `userID` = where `userID` = `supervisor_ID` = `clientID` =
        $this->db->query("UPDATE `employees_tasks` SET`userID`= ".$newuser.",supervisor_ID = ".$SuperID.",Date = ".$Date.",Time = ".$Time.",Notes".$comment." where `userID` =".$Olduser." and `clientID` =".$customerid);
    }
    public function GetUserClients($date1,$date2,$status,$userID,$UserType){
        if ($date1 !=null && $date2 !=null){
            switch ($UserType){
                case 0:
                    // Admin
                    $quere = "select * FROM customercrm INNER JOIN employees_tasks on customercrm.customerCrmId = employees_tasks.clientID INNER JOIN call_status on employees_tasks.Status = call_status.id 
                          where employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date (\"".$date2."\") and (call_status.id = ".$status." or call_status.Status_Parent= ".$status.") ORDER BY employees_tasks.Time";
                    $Result = $this->db->query($quere)->result();
                    break;
                case 1:
                    //Supervisor
                    $quere = "select * FROM customercrm INNER JOIN employees_tasks on customercrm.customerCrmId = employees_tasks.clientID INNER JOIN call_status on employees_tasks.Status = call_status.id 
                          where employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date (\"".$date2."\") and (employees_tasks.Status = ".$status." or call_status.Status_Parent=".$status.")
                           and  (employees_tasks.userID = ".$userID." or employees_tasks.supervisor_ID = ".$userID." )  ORDER BY employees_tasks.Time";
                    $Result = $this->db->query($quere)->result();
                    break;
                case 2:
                    //Employee
                    $quere = "select * FROM customercrm INNER JOIN employees_tasks on customercrm.customerCrmId = employees_tasks.clientID INNER JOIN call_status on employees_tasks.Status = call_status.id 
                          where employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date (\"".$date2."\") and (call_status.id = ".$status." or call_status.Status_Parent = ".$status.")
                           and employees_tasks.userID = ".$userID." ORDER BY employees_tasks.Time";
                    $Result = $this->db->query($quere)->result();
                    break;
            }
        }else{
            switch ($UserType){
                case 0:
                    // Admin
                    $quere = "select * FROM customercrm INNER JOIN employees_tasks on customercrm.customerCrmId = employees_tasks.clientID INNER JOIN call_status on employees_tasks.Status = call_status.id 
                          where employees_tasks.Date < now()  and (call_status.id = ".$status." or call_status.Status_Parent= ".$status.") ORDER BY employees_tasks.Time ,employees_tasks.`Date`";
                    $Result = $this->db->query($quere)->result();
                    break;
                case 1:
                    //Supervisor
                    $quere = "select * FROM customercrm INNER JOIN employees_tasks on customercrm.customerCrmId = employees_tasks.clientID INNER JOIN call_status on employees_tasks.Status = call_status.id 
                          where employees_tasks.Date < now() and (employees_tasks.Status = ".$status." or call_status.Status_Parent=".$status.")
                           and  (employees_tasks.userID = ".$userID." or employees_tasks.supervisor_ID = ".$userID." )  ORDER BY employees_tasks.Time  ,employees_tasks.`Date`";
                    $Result = $this->db->query($quere)->result();
                    break;
                case 2:
                    //Employee
                    $quere = "select * FROM customercrm INNER JOIN employees_tasks on customercrm.customerCrmId = employees_tasks.clientID INNER JOIN call_status on employees_tasks.Status = call_status.id 
                          where employees_tasks.Date < now() and (call_status.id = ".$status." or call_status.Status_Parent = ".$status.")
                           and employees_tasks.userID = ".$userID." ORDER BY employees_tasks.Time ,employees_tasks.`Date`";
                    $Result = $this->db->query($quere)->result();
                    break;
            }
        }

        return $Result;
    }
    public function GetUserFollow($userID){

        $quere = "SELECT count(*) as count FROM `employees_tasks` WHERE userID = ".$userID." AND `Status` = 4 AND Date = Date(now()) and `Time` <= TIME(now()) + INTERVAL 5 MINUTE and `Time` >= TIME(now()) ;";
        $Result = $this->db->query($quere)->result()[0]->count;
        return $Result;
    }
    public function ReAssign($userID,$ClientID,$status = null){
        $userSuper  =$this->db->query("SELECT * FROM `crm_users` where `ID` = $userID")->result();
        if (!is_null($userSuper[0]->Super)){
            if ($userSuper[0]->Super > 0 )
                $super = $userSuper[0]->Super;
            else
                $super = 'null';
            $querey = "UPDATE `employees_tasks` SET`userID`= $userID,supervisor_ID = $super where `clientID` = $ClientID";
        }else{
            $querey = "UPDATE `employees_tasks` SET`userID`= $userID,supervisor_ID =null where  `clientID` = $ClientID";
        }

        $this->db->query($querey);
        if ($status !=null){
            if ($status == 1){
                $this->updateStatus($ClientID,1,$userID);
                $this->DeleteClientComments($ClientID);
                $this->DeleteClientFollows($ClientID);
                $this->DeleteClientCalls($ClientID);
                $this->updateClientOrders($ClientID);

            }
        }
    }
    public function Assign($data){
        $this->db->insert("employees_tasks",$data);
    }
    public function GetUserTaskes($userID){
        $this->db->select('*');
        $this->db->from('employees_tasks');
        $this->db->join('customercrm', 'employees_tasks.clientID = customercrm.customerCrmId');
        $this->db->where('employees_tasks.userID', $userID);
        $this->db->where('employees_tasks.Status', 1);
        $this->db->where('employees_tasks.Date >= Date(now())');

        $query=$this->db->get()->result();
        return $query;

    }
    function GetAllUserTasks($ID){
        $this->db->select('*');
        $this->db->from('employees_tasks');
        $this->db->where('employees_tasks.userID', $ID);
        $query=$this->db->get()->result();
        return $query;
    }
    function GetAllUserFollowTasks($ID){
    $this->db->select('*');
    $this->db->from('crm_follows');
    $this->db->where('crm_follows.UserID', $ID);
    $query=$this->db->get()->result();
    return $query;
}


    public function GetUserFollows($date1,$date2,$userID,$UserType){
        switch ($UserType){
            case 0:
                // Admin
                $quere = "select * FROM customercrm INNER JOIN crm_follows on customercrm.customerCrmId = crm_follows.ClientID 
                          where crm_follows.Follow_Date >= Date(\"".$date1."\") and crm_follows.Follow_Date <= Date (\"".$date2."\")  ORDER BY crm_follows.Follow_Time";
                $Result = $this->db->query($quere)->result();
                break;
            case 1:
                //Supervisor
                $quere = "select * FROM customercrm INNER JOIN crm_follows on customercrm.customerCrmId = crm_follows.ClientID 
                          where crm_follows.Follow_Date >= Date(\"".$date1."\") and crm_follows.Follow_Date <= Date (\"".$date2."\") 
                           and  (crm_follows.UserID = ".$userID." or crm_follows.UserID in (SELECT ID from crm_users WHERE crm_users.Super =".$userID." ))  ORDER BY crm_follows.Follow_Time";

                //echo $quere;die();
                $Result = $this->db->query($quere)->result();
                break;
            case 2:
                //Employee
                $quere = "select * FROM customercrm INNER JOIN crm_follows on customercrm.customerCrmId = crm_follows.ClientID 
                          where crm_follows.Follow_Date >= Date(\"".$date1."\") and crm_follows.Follow_Date <= Date (\"".$date2."\") 
                           and crm_follows.userID = ".$userID." ORDER BY crm_follows.Follow_Time";
                $Result = $this->db->query($quere)->result();
                break;
        }
        return $Result;
    }
    public function IsExisted($ClientID){
        $query = $this->db->get_where('employees_tasks', array('clientID' => $ClientID));
        return $query->result();
    }
    public function ReAssignExisted($taskID,$EmpID,$superID = null,$status,$redirect=null){
        if ($redirect == null){
            $data = array(
                'userID' => $EmpID,
                'supervisor_ID' => $superID,
                'Date'=>date("Y:m:d"),
                'Time' =>date("h:i:sa"),
                'Distributor_By'=>$_SESSION['userid']
            );
        }else{
            $data = array(
                'userID' => $EmpID,
                'supervisor_ID' => $superID,
                'Date'=>date("Y:m:d"),
                'Time' =>date("h:i:sa"),
                'Distributor_By'=>$_SESSION['userid'],
                'redirect '=>true
            );
        }

        if ($status == 1){
            $this->CleanData($taskID,$EmpID);
        }
        $this->db->where('id', $taskID);
        $this->db->update('employees_tasks', $data);
    }
    public function SetTaskStatus($UserID=null,$ClientID,$status,$issuper=false){
//        if ($UserID != null){
//            $this->db->where('userID', $UserID);
//        }
//        if ($issuper){
//            $this->db->where('userID = '.$UserID.' or supervisor_ID ='.$UserID );
//        }
        $this->db->where('clientID', $ClientID);
        $this->db->update('employees_tasks', ['Status'=>$status]);
    }
    function updateStatus($clientID,$status,$userID){
        $Super= $this->GetEmployeeSuper($userID);
        $this->db->where('clientID', $clientID);

        $this->db->update('employees_tasks', ['Status'=>$status,'userID'=>$userID,'supervisor_ID'=>$Super,'Date'=>date("Y-m-d"),'Time'=>date("h:i")]);
    }
    function getClientCallStatus($clientID){
        $this->db->select('*');
        $this->db->from('employees_tasks');
        $this->db->join('call_status', 'call_status.id = employees_tasks.Status');
        $this->db->where('employees_tasks.clientID', $clientID);
        $query = $this->db->get()->result();
        return $query;
    }
    function addNotification($UserID){
        $data['HaveNewCalls'] = true;
        if ($this->IsExistedNotification($UserID)){
            $this->db->where('UserID',$UserID);
            $this->db->update('crm_empnotifications',$data );

        }else{
            $data['UserID'] = $UserID;
            $this->db->insert("crm_empnotifications",$data);
        }
    }
    function deleteNotification($UserID){
        if ($this->IsExistedNotification($UserID)) {
            $this->db->where('UserID',$UserID);
            $this->db->delete('crm_empnotifications');
        }
    }

    private function CleanData($taskID,$userID){
        $this->db->where('id', $taskID);

        $query = $this->db->get("employees_tasks")->result();

        $clientID =$query[0]->clientID;
        $this->updateStatus($clientID,1,$userID);
        $this->DeleteClientComments($clientID);
        $this->DeleteClientFollows($clientID);
        $this->DeleteClientCalls($clientID);
        $this->updateClientOrders($clientID);
    }


    private function DeleteClientComments($clientID){
        $this->db->where('crm_comments.ClientID',$clientID);

        $this->db->delete('crm_comments');
    }
    private function DeleteClientFollows($clientID){

        $this->db->where('crm_follows.ClientID',$clientID);

        $this->db->delete('crm_follows');
    }
    private function DeleteClientCalls($clientID){

        $this->db->where('crm_calls.ClientID',$clientID);
        $this->db->delete('crm_calls');
    }
    private function updateClientOrders($clientID){
        $this->db->where('Client_ID',$clientID);
        $data["isDeleted"] = true;
        $this->db->update('client_orders',$data);
    }
    private function GetEmployeeSuper($UserID){
        $this->db->where('ID', $UserID);
        $query=$this->db->get('crm_users')->result();

        if (count($query) == 0 || $query[0]->Super ==0){
            return null;
        }else{
            $SuperID = $query[0]->Super;
            return $SuperID;
        }
    }
    function IsExistedNotification($UserID){
        $this->db->where('UserID', $UserID);
        $query=$this->db->get('crm_empnotifications')->result();
        return (count($query)>0);
    }
}