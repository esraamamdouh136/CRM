<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 12/03/2019
 * Time: 02:24 م
 */

class SMSModel extends CI_Model
{
    function __construct()    {
        parent::__construct();
        $this->load->model('Clients');
    }

    function GetAPI(){
        $query = $this->db->get('smsconfiguration');
        return $query->result()[0];
    }

    function send($clientID,$message,$userID,$withphone = null){
        if ($withphone == null){
            $clinet= $this->Clients->GetClientByID($clientID);
            $phone = $clinet[0]->customerCrmPhone;
            if (strlen($phone) == 11){
                $phone = '2'.$phone;
            }else if (strlen($phone) == 12){
                if ($phone[0] == '2'){
                    $phone = $phone;
                }else{
                    return false;
                }
            }else if (strlen($phone) == 13){
                if ($phone[0] == '+' && $phone[1] == '2'){
                    $phone = $phone;
                }else{
                    return false;
                }
            }else{
                return false;
            }

            $API=$this->GetAPI();
            $insertedData['MessageText'] = $message;
            $message = urlencode($message);
            $URL = $API->BaseURL
                .'?Username='.$API->UserID
                .'&Password='.$API->UserPassword
                .'&Sender='.$API->SenderName
                .'&Recipients='.$phone
                .'&MessageData='.$message;
            $result = file_get_contents($URL);
            if (strpos(strtolower($result),'ok')!== false){
                $insertedData['UserID'] = $userID;
                $insertedData['ClientID'] = $clientID;
                $insertedData['Phone'] = $phone;
                $insertedData['Date'] = date("Y-m-d");
                $this->addSMS($insertedData);
                return true;
            }

            else
                return false;
        }else{
            //$clinet= $this->Clients->GetClientByID($clientID);
            $phone = $clientID;
            if (strlen($phone) == 11){
                $phone = '2'.$phone;
            }else if (strlen($phone) == 12){
                if ($phone[0] == '2'){
                    $phone = $phone;
                }else{
                    return false;
                }
            }else if (strlen($phone) == 13){
                if ($phone[0] == '+' && $phone[1] == '2'){
                    $phone = $phone;
                }else{
                    return false;
                }
            }else{
                return false;
            }
            $API=$this->GetAPI();
            $insertedData['MessageText'] = $message;
            $message = urlencode($message);
            $URL = $API->BaseURL
                .'?Username='.$API->UserID
                .'&Password='.$API->UserPassword
                .'&Sender='.$API->SenderName
                .'&Recipients='.$phone
                .'&MessageData='.$message;
            $result = file_get_contents($URL);
            if (strpos(strtolower($result),'ok')!== false){
                $insertedData['UserID'] = $userID;
                $insertedData['ClientID'] = null;
                $insertedData['Phone'] = $phone;
                $insertedData['Date'] = date("Y-m-d");
                $this->addSMS($insertedData);
                return true;
            }

            else
                return false;
        }

    }

    function GetAllSMS($userID,$userType,$alldata = null){
        if ($alldata == null){
            if ($userType ==1){
                $this->db->select('crm_sms.*,customercrm.customerCrmName,crm_users.Name,crm_users.Type');
                $this->db->from('crm_sms');
                $this->db->join('customercrm', 'crm_sms.ClientID = customercrm.customerCrmId', 'left');
                $this->db->join('crm_users', 'crm_sms.UserID = crm_users.ID');
                $this->db->where('crm_sms.DeleteForAdmin = 0');
                $query = $this->db->get();
                return $query->result();
            }else if ($userType ==2){
                $this->db->select('crm_sms.*,customercrm.customerCrmName,crm_users.Name,crm_users.Type');
                $this->db->from('crm_sms');
                $this->db->join('customercrm', 'crm_sms.ClientID = customercrm.customerCrmId','left');
                $this->db->join('crm_users', 'crm_sms.UserID = crm_users.ID');
                $this->db->where('(crm_sms.DeleteForEmployee = 0 and crm_users.ID='.$userID.')');
                $this->db->or_where('(crm_sms.DeleteForSupervisor = 0 and crm_users.Super='.$userID.')');
                $query = $this->db->get();
                return $query->result();
            }else{
                $this->db->select('crm_sms.*,customercrm.customerCrmName,crm_users.Name,crm_users.Type');
                $this->db->from('crm_sms');
                $this->db->join('customercrm', 'crm_sms.ClientID = customercrm.customerCrmId','left');
                $this->db->join('crm_users', 'crm_sms.UserID = crm_users.ID');
                $this->db->where('crm_users.ID', $userID);
                $this->db->where('crm_sms.DeleteForEmployee = 0');
                $query = $this->db->get();
                return $query->result();
            }
        }else{
            $this->db->select('crm_sms.*,customercrm.customerCrmName,crm_users.Name,crm_users.Type');
            $this->db->from('crm_sms');
            $this->db->join('customercrm', 'crm_sms.ClientID = customercrm.customerCrmId','left');
            $this->db->join('crm_users', 'crm_sms.UserID = crm_users.ID');
            $this->db->where('crm_sms.DeleteForAdmin = 0');
            $query = $this->db->get();
            return $query->result();
        }

    }
    function deleteSMS($id,$userType){
        switch ($userType){
            case 1:
                $data['DeleteForAdmin'] = 1;
                break;
            case 2:
                $data['DeleteForSupervisor'] = 1;
                break;
            case 3:
                $data['DeleteForEmployee'] = 1;
                break;
        }
        $this->db->where('ID', $id);
        $this->db->update('crm_sms', $data);
        return $this->db->affected_rows();
    }

    private function addSMS($data){
        $this->db->insert('crm_sms', $data);
    }


    public  function  GetSMSDetails($ID){
        $this->db->where('ID', $ID);
        $query = $this->db->get('crm_sms');
        return $query->result()[0];
    }

    function  SetAPISettings($data,$id=null){
        if ($id == null){
            //insert
            $this->db->insert('smsconfiguration', $data);
        }else{
//            update
            $this->db->where('ID', $id);
           return $this->db->update('smsconfiguration', $data);
        }
        return $this->db->affected_rows();
    }
}