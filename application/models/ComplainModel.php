<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 06/01/2019
 * Time: 11:34 ص
 */

class ComplainModel extends CI_Model
{

    private function Complain($ComplainID){
        $this->db->where('ID', $ComplainID);
        $query = $this->db->get('complaints');
        return $query->result();
    }

    function GetUnReadComplain(){
        $selectData['Admin_Deleted']=0;
        $selectData['Admin_Seen']=0;
        $this->db->where($selectData);
        return $this->db->get('complaints')->result();
    }
    function GetComplains($type,$UserID,$User_Type=null,$super_Send = false,$alldata = null){




        $selectData['Type'] = $type;

        if ($alldata == null){
            if ($User_Type != null){
                switch ($User_Type){
                    case 1:
                        //Admin
                        $selectData['Admin_Deleted']=0;
                        //print_r($selectData);die();
                        $this->db->where($selectData);
                        return $this->db->get('complaints')->result();

                        break;
                    case 2:
                        // super

                        if ($super_Send == true){
                            $selectData['To_User'] = $UserID;
                            // $selectData['To_Super']=1;

                            $selectData['Super_Deleted']=0;
                        }else{
                            $selectData['UserID'] = $UserID;
                            $selectData['Sender_Deleted']=0;
//                        print_r($selectData);die();
                        }

                        $this->db->where($selectData);
                        return $this->db->get('complaints')->result();
                        break;
                    case 3:
                        $selectData['Sender_Deleted']=0;
                        $selectData['UserID']=$UserID;
                        $this->db->where($selectData);
                        return $this->db->get('complaints')->result();
                        break;
                }
            }else{
                return null;
            }
        }else{
            $selectData['Admin_Deleted']=0;
            //print_r($selectData);die();
            $this->db->where($selectData);
            return $this->db->get('complaints')->result();
        }



    }


    function AddComplain($ComplainData,$ComplainDetails){
        $this->db->insert('complaints', $ComplainData);
        $Complain_id = $this->db->insert_id();
        if ($Complain_id > 0){
            $ComplainDetails['complaints_ID'] = $Complain_id;
            $this->db->insert('complaints_details', $ComplainDetails);
            if ($this->db->insert_id() > 0)
                return $this->db->insert_id();
            else
                return -1;
        }else{
            return -1;
        }
    }

    function ReplyComplain($ComplainDetails){
        $this->db->insert('complaints_details', $ComplainDetails);
        if ($this->db->insert_id() > 0)
            return $this->db->insert_id();
        else
            return -1;
    }
    function RenewComplain($ID){
        $this->db->where('ID',$ID);
        $data['Super_Deleted'] = 0;
        $data['Sender_Deleted'] = 0;
        $data['Admin_Deleted'] = 0;
        $data['Is_Seen'] = 0;
        $data['Admin_Seen'] = 0;
        $this->db->update('complaints',$data);
    }

    function SetRead($ID,$userType,$UserID){

        if ($userType == 1 ){
            $update['Admin_Seen'] = 1;
            $msg = $this->Complain($ID);

            if ($msg[0]->To_User == $UserID){
                $update['Is_Seen'] = 1;
                $this->db->where('To_User', $UserID);
            }
            $this->db->where('ID', $ID);
            $this->db->update('complaints', $update);
        }else{
            $update['Is_Seen'] = 1;
            $this->db->where('ID', $ID);
            $this->db->where('To_User', $UserID);
            $this->db->update('complaints', $update);
        }
    }

    function GetComplaintDetails($ComplaintID){
        $this->db->select('*');
        $this->db->from('complaints');
        $this->db->join('complaints_details', 'complaints_details.complaints_ID = complaints.ID');
        $this->db->where('complaints.ID', $ComplaintID);
        $query = $this->db->get();
        return $query->result();
    }


    function Delete($ComplaintID,$userID,$userType=null){

        $Complaint = $this->Complain($ComplaintID);
        if ($userType == null){
            $this->db->where('ID', $ComplaintID);
            if ($Complaint[0]->UserID == $userID){
                $this->db->update('complaints', array('Sender_Deleted' => 1));
            }else if ($Complaint[0]->To_User == $userID){
                $this->db->update('complaints', array('Super_Deleted' => 1));
            }
        }else{
            $this->db->where('ID', $ComplaintID);
            $this->db->update('complaints', array('Admin_Deleted' => 1));
        }
        $Complaint = $this->Complain($ComplaintID);
        if ($Complaint[0]->Admin_Deleted == 1 && $Complaint[0]->Super_Deleted == 1 && $Complaint[0]->Sender_Deleted == 1 ){
            $this->db->delete('complaints', array('ID' => $ComplaintID));
        }
        return $this->db->affected_rows();
    }
}