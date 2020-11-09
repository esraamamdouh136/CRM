<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 10/10/2018
 * Time: 1:05 AM
 */

class Users_Model extends CI_Model
{

    public function LogOut($UserID){
        $this->db->update('crm_users_log', array('Status' => 2), array('id' => $UserID));
    }
    public function LogIn($UserID){
        $this->db->update('crm_users_log', array('Status' => 1), array('id' => $UserID));
    }

    public function CheckData($UserName,$Password){
        $this->db->where(array('UserName'=>$UserName,'Pass'=>$Password));
        $query = $this->db->get('crm_users')->result();

        return $query;
    }
    public function GetUserPermissions($UserID){
        $this->db->where(array('UserID'=>$UserID));
        $query = $this->db->get('crm_users_permissions')->result();
        return $query;
    }

    public function CreateEmployee($data){
        $this->db->insert('crm_users', $data);
        return $this->db->insert_id();
    }

    public function SetPermissions($UserID,$Permission_Code,$IsGranted){
        $this->db->update('crm_users_permissions', array('IsGranted' => $IsGranted), array('UserID' => $UserID,'Object_Code'=>$Permission_Code));
    }
    public function UpdateUserPermissions($UserID,$Permission_List){
        $this->db->set('IsGranted', 0);
        $this->db->where('UserID', $UserID);
        $this->db->update('crm_users_permissions');
        if (isset($Permission_List) && !is_null($Permission_List)){
            for ($i=0;$i<count($Permission_List);$i++){
                $this->db->set('IsGranted', 1);
                $this->db->where('ID', $Permission_List[$i]);
                $this->db->update('crm_users_permissions');
            }
        }


    }
    public function CheckEmployeeData($UserName,$Email){
        $this->db->where("UserName ='". $UserName."' or Email ='". $Email."'");
        $query = $this->db->get('crm_users')->result();
        return count($query)>0;
    }

    public function GetSupervisors($empID = null){
        if ($empID != null){
            $query = "SELECT U1.* FROM crm_users U1 INNER JOIN crm_users U2 on U1.ID=U2.Super
                      WHERE U2.ID = ".$empID;
            return $this->db->query($query)->result();
        }else{
            $this->db->where(array('Type'=>2));
            $query = $this->db->get('crm_users')->result();
            return $query;
        }

    }

    public function DeActive($UserID,$Status){
        $this->db->update('crm_users', array('active' => $Status), array('ID' => $UserID));
    }

    public function GetUserByID($UserID){
        $this->db->where(array('ID'=>$UserID));
        $query = $this->db->get('crm_users')->result();
        return $query;
    }

    public function UpdateUserData($data,$ID){
        $this->db->where('ID', $ID);
        $this->db->update('crm_users', $data);
    }
    public function GetEmployee($UserID ,$Type=null){
        if ($Type != null && $Type!=1){
            $this->db->where('Type', 3);
        }
        $this->db->where('ID !=', $UserID);
        $this->db->where('Type !=', 1);
        $query=$this->db->get('crm_users')->result();
        return $query;
    }

    public function GetUsers($UserID ){

        $this->db->where('ID !=', $UserID);
        //$this->db->where('Type !=1');
        $query=$this->db->get('crm_users')->result();
        return $query;
    }

    public function GetUsersByTypes($UserType,$userID =null ){

        if ($userID != null){
            $this->db->where('ID !='.$userID);
        }
        $this->db->where('Type',$UserType);
        $query=$this->db->get('crm_users')->result();
        return $query;
    }

    public function GetEmployeeSuper($UserID){
        $this->db->where('ID', $UserID);
        $query=$this->db->get('crm_users')->result();

        if (count($query) == 0 || $query[0]->Super ==0){
            return null;
        }else{
            $SuperID = $query[0]->Super;
            return $SuperID;
        }
    }
    public function GetSuperVisorEmployee($UserID){
        $this->db->where('Super', $UserID);
        $query=$this->db->get('crm_users')->result();
        return $query;
    }

    function SetMailServerConfig($MailServerData){
        //print_r($MailServerData);die();
        $this->db->insert('smtp_configuration', $MailServerData);
        return $this->db->insert_id();
    }

    function updateMailServerConfig($ID,$MailServerData){
//        print_r($ID);
//        print_r($MailServerData);die();
        $this->db->where('ID', $ID);
        $this->db->set($MailServerData);
        $this->db->update('smtp_configuration');
    }
    function GetMailServerConfig($UserID){
        $this->db->where('Emp_ID', $UserID);
        $query=$this->db->get('smtp_configuration')->result();
        return $query;
    }

    function IsMaximumSMS($userID,$requerdNum = null){
        $this->db->where('ID', $userID);
        $userData  = $this->db->get('crm_users')->result()[0];
        $this->db->where('UserID', $userID);
        $this->db->where('Date', date("Y-m-d"));
        $userSms = $this->db->get('crm_sms')->result();
        $userSmsCount = count($userSms);

//        print_r("<pre>");
//        print_r($userData);
//        print_r("</pre>");die();
        if ($requerdNum !=null){
            $userSmsCount = $userSmsCount+ $requerdNum;
        }

        if ($userSmsCount > $userData->num_message)
            return true;
        else
            return false;


    }

    function GetCallDuration($parameters){
        $query = $this->db->query('CALL GetCallDuration (?,?)',$parameters);
        $result = $query->result();
        $query->next_result();
        $query->free_result();
        return $result;
    }


    function Delete($UserID){
        $this->db->where('ID', $UserID);
        $this->db->delete('crm_users');
    }

    function  GetNotifyTime(){
        $this->db->where('settingcrmId', 1);
        return $this->db->get('settingcrm')->result()[0]->notifyTime;
    }

    function  SetNotifyTime($time){
        $this->db->where('settingcrmId', 1);
        $data['notifyTime'] = $time;
        $this->db->update('settingcrm', $data);

    }
}