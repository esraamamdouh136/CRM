<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 17/12/2018
 * Time: 01:53 م
 */

class CRM_MessagesModel extends CI_Model
{
    function AddMessage($MessageData,$MessageDetails,$ToUsers){
        $this->db->insert('crm_messages', $MessageData);
        $Messge_id = $this->db->insert_id();
        if ($Messge_id > 0){
            $usersMessage['MessageID'] = $Messge_id;
            foreach ($ToUsers as $ID){
                $usersMessage['UserID'] = $ID;
                $this->db->insert('crm_messages_users', $usersMessage);
            }
            $MessageDetails['Message_ID'] = $Messge_id;
            $this->db->insert('crm_messages_details', $MessageDetails);
            if ($this->db->insert_id() > 0)
                return $this->db->insert_id();
            else
                return -1;
        }else{
            return -1;
        }
    }

    function ReplyMessage($MessageDetails){
        $this->db->insert('crm_messages_details', $MessageDetails);
        if ($this->db->insert_id() > 0)
            return $this->db->insert_id();
        else
            return -1;
    }

    function RenewMessage($ID){
        $this->db->where('ID',$ID);
        $data['Deleted'] = 0;
        $data['Admin_Delete'] = 0;
        $this->db->update('crm_messages',$data);
        $this->RenewMessagecrm_messages_users($ID);
    }
    private function RenewMessagecrm_messages_users($ID){
        $this->db->where('ID',$ID);
        $data['Deleted'] = 0;
        $data['Is_Seen'] = 0;
        $this->db->update('crm_messages_users',$data);
    }


    function GetReceived($UserID,$type = null,$alldata = null){

        $SelectedData['crm_messages_users.UserID']=$UserID;
        $SelectedData['crm_messages_users.Deleted']= 0;
        $this->db->select('crm_messages.ID,crm_messages.UserID as FromUser,GROUP_CONCAT(crm_users.Name) as ToUsers,crm_messages.Titel,Is_Seen');
        $this->db->join('crm_messages_users','crm_messages_users.MessageID=crm_messages.ID','inner');
        $this->db->join('crm_users','crm_users.ID=crm_messages_users.UserID','inner');
        $this->db->where($SelectedData);
        $this->db->group_by('crm_messages.ID');

        return $this->db->get('crm_messages')->result();

    }

    function GetCirculated($UserID){
        $this->db->where('crm_messages_users.UserID !='.$UserID);
        $this->db->where('crm_messages.UserID !='.$UserID);
        $this->db->where('crm_messages.Admin_Delete =0');
        $this->db->select('crm_messages.ID,crm_messages.UserID as FromUser,GROUP_CONCAT(crm_users.Name) as ToUsers,crm_messages.Titel,Is_Seen');
        $this->db->join('crm_messages_users','crm_messages_users.MessageID=crm_messages.ID','inner');
        $this->db->join('crm_users','crm_users.ID=crm_messages_users.UserID','inner');
        $this->db->group_by('crm_messages.ID');
        return $this->db->get('crm_messages')->result();
    }
    function GetSend($UserID){
        $SelectedData['crm_messages.UserID']=$UserID;
        $SelectedData['crm_messages.Deleted'] = 0;
        $this->db->select('crm_messages.ID,crm_messages.UserID as FromUser,GROUP_CONCAT(crm_users.Name) as ToUsers,crm_messages.Titel,Is_Seen');
        $this->db->join('crm_messages_users','crm_messages_users.MessageID=crm_messages.ID','inner');
        $this->db->join('crm_users','crm_users.ID=crm_messages_users.UserID','inner');
        $this->db->where($SelectedData);
        $this->db->group_by('crm_messages.ID');

        return $this->db->get('crm_messages')->result();
    }
    function SetRead($ID,$userType,$UserID){

        $update['Is_Seen'] = 1;
        $this->db->where('MessageID', $ID);
        $this->db->where('UserID', $UserID);
        $this->db->update('crm_messages_users', $update);


    }
    function GetMessageDetails($msgID){
        $this->db->select('*');
        $this->db->from('crm_messages');
        $this->db->join('crm_messages_details', 'crm_messages_details.Message_ID = crm_messages.ID');
        $this->db->where('crm_messages.ID', $msgID);
        $query = $this->db->get();
        return $query->result();
    }
    function GetMessage($msgID){
        $this->db->where('ID', $msgID);
        $query = $this->db->get('crm_messages');
        return $query->result();
    }
    function Delete($msgID,$userType,$userID){
        if ($userType == 1){
            $this->db->where('ID', $msgID);
            $this->db->update('crm_messages', array('Admin_Delete' => 1));
            //crm_messages_users
        }
        $this->db->where('MessageID', $msgID);
        $this->db->where('UserID', $userID);
        if (count($this->db->get('crm_messages_users')->result()) > 0){
            $this->db->where('MessageID', $msgID);
            $this->db->where('UserID', $userID);
            $this->db->delete('crm_messages_users');
        }
        $message = $this->GetMessage($msgID);
        if ($message[0]->UserID == $userID){
            $this->db->where('ID', $msgID);
            $this->db->update('crm_messages', array('Deleted' => 1));
        }
    }

    function GetUnreadMessages($UserID,$type = null){
        $SelectedData['Is_Seen']=0;
        $SelectedData['UserID']=$UserID;
        $this->db->where($SelectedData);
        $this->db->order_by('ID', 'DESC');
        return count($this->db->get('crm_messages_users')->result());

    }
}