<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 10/02/2019
 * Time: 03:59 م
 */

class CRM_FollowsModel extends CI_Model
{
    function getAllFollows(){
        return $this->db->get('crm_follows')->result();
    }
    function getUpcommingCalls($UserID){
        $this->db->where('userID',$UserID);
        $this->db->where('UpcommingCalls_Seen',false);
        $query = $this->db->get('user_messages')->result();
        if(isset($query) && !is_null($query) && count($query) > 0){
            return $query[0]->UpcommingCalls;
        }else{
            return 0;
        }

    }
    function  getDelayedCalls($UserID,$Usertype,$alldata=null){
        $count = 0;
        if ($alldata == null){
            switch ($Usertype){
                case 1:
                    //Admin
                    $this->db->select_sum('Delayed_ForAdmin');
                    $count = $this->db->get('user_messages')->result()[0]->Delayed_ForAdmin;
                    $this->db->where('userID',$UserID);
                    $Delayed_Calls = $this->db->get('user_messages')->result();
                    if (count($Delayed_Calls) >0)
                        $count += $this->db->get('user_messages')->result()[0]->Delayed_Calls;
                    break;
                case 2:
                    // Supervisor
                    $this->db->select_sum('Delayed_ForSupervisor');
                    $this->db->where('userID in (select ID from crm_users where Super = '.$UserID.')');
                    $Delayed_ForSupervisor = $this->db->get('user_messages')->result();
                    if (count($Delayed_ForSupervisor) > 0)
                        $count += $this->db->get('user_messages')->result()[0]->Delayed_ForSupervisor;
                    $this->db->where('userID',$UserID);
                    $Delayed_Calls = $this->db->get('user_messages')->result();
                    if (count($Delayed_Calls)>0)
                        $count += $this->db->get('user_messages')->result()[0]->Delayed_Calls;
                    break;
                case 3:
                    // Employee
                    $this->db->where('userID',$UserID);
                    $this->db->where('Delayed_Calls_Seen',false);
                    $Delayed_Calls = $this->db->get('user_messages')->result();
                    if (count($Delayed_Calls) > 0)
                        $count = $this->db->get('user_messages')->result()[0]->Delayed_Calls;
                    break;
            }
        }else{
            $this->db->select_sum('Delayed_ForAdmin');
            $count = $this->db->get('user_messages')->result()[0]->Delayed_ForAdmin;
            $this->db->where('userID',$UserID);
            $Delayed_Calls = $this->db->get('user_messages')->result();
            if (count($Delayed_Calls) >0)
                $count += $this->db->get('user_messages')->result()[0]->Delayed_Calls;
        }
        return $count;
    }
    function getCalls($UserID){
        $this->db->where('userID',$UserID);
        $query = $this->db->get('user_messages')->result();
        return $query;
    }
    function SetSeen($id,$type){
        $this->db->where('id',$id);
        switch ($type){
            case 1:
                $this->db->set('Delayed_Calls_Seen', true);
                break;
            case 2:
                $this->db->set('UpcommingCalls_Seen', true);
        }
        $this->db->update('user_messages');
    }

    function getUpcoming($userID,$type,$userType = null,$alldata = null){
        $this->db->select('customercrm.*,employees_tasks.*,crm_follows.Follow_Date,crm_follows.Follow_Time');
        $this->db->from('crm_follows');
        $this->db->join('customercrm', 'customercrm.customerCrmId = crm_follows.ClientID');
        $this->db->join('employees_tasks', 'crm_follows.ClientID = employees_tasks.clientID');
        if ($alldata == null){
            if ($type == 1){
                $this->db->where('crm_follows.Follow_Date = date(now())');
                $this->db->where('crm_follows.Follow_Time >= time(now())');
                $this->db->where('crm_follows.Follow_Time < time(DATE_ADD(now(),INTERVAL 15 MINUTE))');
            }else if ($type == 2){

                if ($userType == 1){
                    $this->db->where('((time(DATE_ADD(crm_follows.Follow_Time,INTERVAL 30 MINUTE)) < time(now()) and crm_follows.Follow_Date = date(now())) or crm_follows.Follow_Date < date(now()))');
                }else if ($userType == 2){
                    $this->db->where('((time(DATE_ADD(crm_follows.Follow_Time,INTERVAL 30 MINUTE)) >= time(now()) and time(DATE_ADD(crm_follows.Follow_Time,INTERVAL 15 MINUTE)) <= time(now()) and crm_follows.Follow_Date = date(now())))');

                }else{

                    $this->db->where('((crm_follows.Follow_Time <= time(now()) and crm_follows.Follow_Date = date(now())))');
                }
            }
            if ($userType == 2){
                $this->db->where('(crm_follows.UserID='.$userID.' or crm_follows.userID in (select ID from crm_users where Super = '.$userID.'))');


//
//                $this->db->or_where();
            }else if ($userType == 3){
                $this->db->where('crm_follows.UserID='.$userID);
            }
        }else{
            if ($type == 1){
                $this->db->where('crm_follows.Follow_Date = date(now())');
                $this->db->where('crm_follows.Follow_Time >= time(now())');
                $this->db->where('crm_follows.Follow_Time < time(DATE_ADD(now(),INTERVAL 15 MINUTE))');
            }else if ($type == 2){
                if ($userType != 1 ){
                    $this->db->where('(crm_follows.Follow_Date = date(now())) or crm_follows.Follow_Date < date(now())');
                }else{
                    $this->db->where('((time(DATE_ADD(crm_follows.Follow_Time,INTERVAL 45 MINUTE)) < time(now()) and crm_follows.Follow_Date = date(now())) or crm_follows.Follow_Date < date(now()))');
                }

            }

        }
        $this->db->order_by('crm_follows.Follow_Date', 'ASC');
        $this->db->order_by('crm_follows.Follow_Time', 'ASC');
        return $this->db->get()->result();
    }




    function AddNotification($userID){
        $data['UserID'] = $userID;
        $data['Date'] = date("Y-m-d");
        $this->db->insert('crm_notifications', $data);
    }


    function  getUpcomingCalls($UserID){
        $count = 0;
        $this->db->where('userID',$UserID);
        $this->db->where('UpcommingCalls_Seen',false);
        $Delayed_Calls = $this->db->get('user_messages')->result();
        if (count($Delayed_Calls) > 0)
            $count = $this->db->get('user_messages')->result()[0]->UpcommingCalls;
        return $count;
    }
}