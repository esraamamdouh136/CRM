<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 16/01/2019
 * Time: 02:33 م
 */

class Follows extends CI_Model
{
    private $Tablename = 'crm_follows';
    function isFollow($clinetID){
        $this->db->where('ClientID',$clinetID);
        $select = $this->db->get($this->Tablename);
        return $select->result();
    }
    function resetFollow($where,$data){
        $this->db->where($where);
        $this->db->update($this->Tablename, $data);

    }

    function updateFollow($id,$data){
        $this->db->where('ID',$id);
        $this->db->update($this->Tablename, $data);
    }

    function deleteFolow($id){
        $this->updateFollowComment($id);
        $this->db->where('ID',$id);
       $result= $this->db->delete($this->Tablename);


//        print_r("<pre>");
//        print_r($result);
//        print_r("</pre>");die();

    }

    function addFollow($data){
        $this->db->insert($this->Tablename, $data);
        return $this->db->insert_id();
    }

    private function updateFollowComment($followID){
        $this->db->where('FollowID',$followID);
        $data["FollowID"] = null;
        $data["IsFollowComment"] = false;
        $this->db->update("crm_comments",$data);

    }
}