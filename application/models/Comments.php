<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 13/10/2018
 * Time: 03:17 ص
 */

class Comments extends CI_Model
{
    public function GetClientComments($ClientID){
        $this->db->select('crm_comments.*,Follow_Date,Follow_Time,(CASE WHEN SUBTIME(crm_calls.`endcall`,crm_calls.`startcall`) IS NULL THEN null ELSE SUBTIME(crm_calls.`endcall`,crm_calls.`startcall`) END) as Duration');
        $this->db->from('crm_comments');
        $this->db->join('crm_follows', 'crm_follows.ID = crm_comments.FollowID','left');
        $this->db->join('crm_calls', 'crm_calls.CommentID = crm_comments.ID','left');
        $this->db->where('crm_comments.ClientID',$ClientID);
        $this->db->order_by('crm_comments.date', 'DESC');
        $this->db->order_by('crm_comments.time', 'DESC');
        return $this->db->get()->result();
    }
    public function AddClientComments($data){
        $this->db->insert('crm_comments', $data);
        return $this->db->affected_rows();
    }

}