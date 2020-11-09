<?php
/**
 * Created by PhpStorm.
 * User: boody
 * Date: 14/08/2018
 * Time: 01:55 م
 */

class Clients extends CI_Model
{
    public function GetClient($date1,$date2,$UserID,$UserType){
        switch ($UserType){
            case 1:
                // Admin
                $query = "SELECT customercrm.*,employees_tasks.* FROM customercrm 
                          INNER JOIN employees_tasks ON customercrm.customerCrmId = employees_tasks.clientID
                          WHERE employees_tasks.Status = 2 AND employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date(\"".$date2."\")";

                break;
            case 2:
                // supervisor
                $query = "";$query = "SELECT customercrm.*,employees_tasks.* FROM customercrm 
                          INNER JOIN employees_tasks ON customercrm.customerCrmId = employees_tasks.clientID
                          WHERE employees_tasks.Status = 2 AND employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date(\"".$date2."\")
                           and (userID = '".$UserID."' || supervisor_ID = '".$UserID."')";
                break;
            case 3:
                // Employee
                $query = "";$query = "SELECT customercrm.*,employees_tasks.* FROM customercrm 
                          INNER JOIN employees_tasks ON customercrm.customerCrmId = employees_tasks.clientID
                          WHERE employees_tasks.Status = 2 AND employees_tasks.Date >= Date(\"".$date1."\") and employees_tasks.Date <= Date(\"".$date2."\")
                           and userID = '".$UserID."'";
                break;
        }
        return $this->db->query($query)->result();
    }
    public function GetClientByID($ClientID){
        $this->db->where('customerCrmId',$ClientID);
        $query = $this->db->get('customercrm');
        $Result= $query->result();
        return $Result;
    }
    public function AddClientNote($UserID,$ClientID,$NoteText){
        $data['UserID'] = $UserID;
        $data['ClientID'] = $ClientID;
        $data['NoteText'] = $NoteText;
        $data['Date'] = date("Y-m-d h:m:s a");
        $this->db->insert('client_notes', $data);
    }
    public function GetCurrentClients($UserID,$UserType){
        $where = '';
        $this->db->select('customercrm.customerCrmName,
        customercrm.customerCrmId,
        customercrm.customerCrmCompany,
        customercrm.customerCrmJob,
        crm_orders.UserID,
        crm_orders.notes as ONotes');

        $this->db->from('crm_orders');
        $this->db->join('customercrm', 'crm_orders.ClientID = customercrm.customerCrmId');
        switch ($UserType){
            case 1:
                // admin
                $where = '';
                break;
            case 2:
                $where = "crm_orders.UserID = '".$UserID."' or crm_orders.UserID in (SELECT ID from crm_users where crm_users.Super = ".$UserID.")";
                $this->db->where($where);
                // Supervisor
                break;
            case 3:
                //Employee
                $where = "crm_orders.UserID = '".$UserID."'";
                $this->db->where($where);
                break;
        }
        // echo $where;die;


        $query = $this->db->get();
        return $query->result();

    }

    public function GetClientByMail($mail){
        $query = $this->db->select('customerCrmId')
            ->where('customerCrmEmail', $mail)
            ->limit(1)
            ->get('customercrm');
        return $query->result();
    }


    function GetClientDataForExport(){
        $this->db->select('*');
        $this->db->from('customercrm');
        $this->db->join('(SELECT call_status.title,employees_tasks.clientID from employees_tasks inner JOIN call_status on employees_tasks.Status = call_status.id ) as tasks', 'customercrm.customerCrmId = tasks.clientID','left');
        $this->db->join('(select DISTINCT crm_comments.ClientID,crm_comments.Comment_Text from crm_comments ORDER BY crm_comments.date DESC,crm_comments.time DESC ) as comment', 'customercrm.customerCrmId = comment.ClientID','left');
        $this->db->group_by("customercrm.customerCrmId");
        $query = $this->db->get();
        return $query->result();
    }
}