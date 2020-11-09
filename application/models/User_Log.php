<?php
/**
 * Created by PhpStorm.
 * User: boody
 * Date: 14/08/2018
 * Time: 04:08 م
 */

class User_Log extends CI_Model
{
    public function Login($UserID){
        $Query= "SELECT * FROM `crm_users_log` WHERE `UserID` =  ".$UserID;
        $Result =$this->db->query($Query)->result();
        if (count($Result) > 0){
            $Query= "UPDATE `crm_users_log` SET `Login_Time` = NOW() ,`Status` = 1  where `UserID` = ".$UserID;
        }else{
            $Query= "INSERT INTO `crm_users_log`(`UserID`, `Login_Time`,`Status`) VALUES (".$UserID.",NOW(),1)";
        }
        $this->db->query( $Query);
    }
    public function LogOut($UserID){
        $Query= "SELECT * FROM `crm_users_log` WHERE `UserID` =  ".$UserID;
        $Result =$this->db->query($Query)->result();
        if (count($Result) > 0) {
            $Query = "UPDATE `crm_users_log` SET `Last_Seen` = NOW(),`Status` = 2 where `UserID` = " . $UserID;
        }else{
            $Query= "INSERT INTO `crm_users_log`(`UserID`, `Last_Seen`,`Status`) VALUES (".$UserID.",NOW(),2)";
        }
        $this->db->query( $Query);
    }
    public function StartCall($UserID){
        $Query= "SELECT * FROM `crm_users_log` WHERE `UserID` =  ".$UserID;
        $Result =$this->db->query($Query)->result();
        if (count($Result) > 0){
            $Query= "UPDATE `crm_users_log` SET `Last_Seen` = NOW() ,`Status` = 3  where `UserID` = ".$UserID;
        }else{
            $Query= "INSERT INTO `crm_users_log`(`UserID`, `Last_Seen`,`Status`) VALUES (".$UserID.",NOW(),3)";
        }
        $this->db->query( $Query);
    }
    public function EndCall($UserID){
        $Query= "SELECT * FROM `crm_users_log` WHERE `UserID` =  ".$UserID;
        $Result =$this->db->query($Query)->result();
        if (count($Result) > 0){
            $Query= "UPDATE `crm_users_log` SET `Last_Seen` = NOW() ,`Status` = 1  where `UserID` = ".$UserID;
        }else{
            $Query= "INSERT INTO `crm_users_log`(`UserID`, `Last_Seen`,`Status`) VALUES (".$UserID.",NOW(),1)";
        }
        $this->db->query( $Query);
    }
    public function UpdateLastSeen($UserID){
        $Query= "SELECT * FROM `crm_users_log` WHERE `UserID` =  ".$UserID;
        $Result =$this->db->query($Query)->result();
        if (count($Result) > 0){
            $Query= "UPDATE `crm_users_log` SET `Last_Seen` = NOW(),`Status` = 1 where `UserID` = ".$UserID;
        }else{
            $Query= "INSERT INTO `crm_users_log`(`UserID`, `Last_Seen`,`Status`) VALUES (".$UserID.",NOW(),1)";
        }
        $this->db->query( $Query);
    }
    public function SetOfflineUsers(){
        $this->db->query("UPDATE crm_users_log SET `Status` = 2 where Now() >= `Last_Seen` + INTERVAL 2 MINUTE");
    }
    public function GetUserStatus($UserType ,$status,$type,$UserID){
        switch ($type){
            case 1:
                $Result = $this->db->query("select count(*) as count from crm_users_log INNER JOIN crm_users on crm_users_log.UserID = crm_users.ID WHERE crm_users_log.Status = ".$status." and crm_users.Type = ".$UserType)->result();
                break;
            case 2:
                $Result = $this->db->query("select count(*) as count from crm_users_log INNER JOIN crm_users on crm_users_log.UserID = crm_users.ID WHERE crm_users_log.Status = ".$status." and crm_users.Type = ".$UserType ." and crm_users.Super = " .$UserID)->result();
                break;
            case 3:
                $Result = $this->db->query("select count(*) as count from crm_users_log INNER JOIN crm_users on crm_users_log.UserID = crm_users.ID WHERE crm_users_log.Status = ".$status." and crm_users.Type = ".$UserType)->result();
                break;
        }

        return  $Result[0]->count;
    }
    public function GetUserByStatus($UserType,$Status){
        $query = "select * from crm_users 
                  INNER JOIN crm_users_log on crm_users.ID = crm_users_log.UserID
                  where crm_users.Type = ".$UserType." and crm_users_log.Status = ".$Status;

        $Result = $this->db->query($query)->result();
        return  $Result;
    }
    public function GetUserLastSeen($UserID){
        $query = "SELECT Last_Seen FROM `crm_users_log` WHERE `UserID` = ".$UserID;
        $Result = $this->db->query($query)->result();
        return  $Result[0]->Last_Seen;
    }
}