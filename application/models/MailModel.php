<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 08/01/2019
 * Time: 02:23 م
 */

class MailModel extends CI_Model
{
    function GetMailDetails($ID){
        $this->db->where('ID', $ID);
        $query=$this->db->get('crm_mails')->result();
        return $query;
    }

    function addMail($data,$Files){
        $this->db->insert('crm_mails', $data);
        $id = $this->db->insert_id();
        $this->addMailFiles($id,$Files);
    }
    private function addMailFiles($id,$FilesList){
        if (count($FilesList) > 0){
            $row['MailID'] = $id;
            for ($i=0;$i<count($FilesList);$i++){
                $row['FileName'] = $FilesList[$i];
                $this->db->insert('mailattachs', $row);
            }
        }
    }

}