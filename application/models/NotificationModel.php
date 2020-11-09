<?php


class NotificationModel extends CI_Model
{
    function GetUserNotification($UserID,$UserType){
        switch ($UserType){
            case 1://Admin
                $this->db->select('crm_call_notifications.*,crm_follows.Follow_Time,crm_follows.Follow_Date');
               // $this->db->where('crm_follows.Follow_Date = date(now())');
                $this->db->join('crm_follows', 'crm_follows.ID = crm_call_notifications.FollowID');
                $query=$this->db->get('crm_call_notifications')->result();
                return $query;
                break;
            case 2: // Supervisor
                $this->db->select('crm_call_notifications.*,crm_follows.Follow_Time,crm_follows.Follow_Date');
                $this->db->where('(crm_call_notifications.UserID ='.$UserID.')' );
                $this->db->where('crm_follows.Follow_Date = date(now())');
                $this->db->join('crm_follows', 'crm_follows.ID = crm_call_notifications.FollowID');
                $query=$this->db->get('crm_call_notifications')->result();
                return $query;
                break;
            case 3: // Employee

                $this->db->select('crm_call_notifications.*,crm_follows.Follow_Time,crm_follows.Follow_Date');
                $this->db->where('crm_call_notifications.UserID', $UserID);
              //  $this->db->where('(Befor15M = 0 or Befor10M = 0 or Befor10M = 0 or After5M = 0 or After10M = 0 or After15M = 0)');
                $this->db->where('crm_follows.Follow_Date = date(now())');
                $this->db->join('crm_follows', 'crm_follows.ID = crm_call_notifications.FollowID');
                $query=$this->db->get('crm_call_notifications')->result();
                return $query;
                break;
            default : break;

        }

    }


    function GetFollow($ID){
        $this->db->where('ID', $ID);
        return $this->db->get('crm_follows')->result();
    }




    function UpdateNotificationStatus($notifyID, $notifyNum)
    {

        switch ($notifyNum){
            case 1:
                $this->db->set('Befor15M', 1);
                $this->db->where('ID', $notifyID);
                $this->db->update('crm_call_notifications');
                break;
            case 2:
                $this->db->set('Befor10M', 1);
                $this->db->where('ID', $notifyID);
                $this->db->update('crm_call_notifications');
                break;
            case 3:
                $this->db->set('Befor5M', 1);
                $this->db->where('ID', $notifyID);
                $this->db->update('crm_call_notifications');
                break;
            case 4:
                $this->db->set('After5M', 1);
                $this->db->where('ID', $notifyID);
                $this->db->update('crm_call_notifications');
                break;
            case 5:
                $this->db->set('After10M', 1);
                $this->db->where('ID', $notifyID);
                $this->db->update('crm_call_notifications');
                break;
            case 6:
                $this->db->set('After15M', 1);
                $this->db->where('ID', $notifyID);
                $this->db->update('crm_call_notifications');
                break;
            case 7:
                $this->db->set('ForSupervisor', 1);
                $this->db->where('ID', $notifyID);
                $this->db->update('crm_call_notifications');
                break;
            case 8:
                $this->db->set('ForAdmin', 1);
                $this->db->where('ID', $notifyID);
                $this->db->update('crm_call_notifications');
                break;
        }


    }



}

