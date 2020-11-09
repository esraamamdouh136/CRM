<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 9/4/2018
 * Time: 11:56 AM
 */

class InternalMessages extends CI_Model
{
    function NewMessage($from,$to,$title,$message,$ClientID = null){
// message type = 0

        if ($ClientID !=null){
            //INSERT INTO `CRM_internal_messages` (`ID`, `UserID`, `Titel`, `Message`, `Send_Date`, `ISRead`, `Type`, `Message_Type`, `Client_ID`) VALUES (NULL, '60', 'asd', 'asd', Now(), '0', '0', '0', NULL)
            $Query= "INSERT INTO `CRM_internal_messages` (`ID`, `UserID`, `From_User`, `To_User`, `Titel`, `Message`, `Send_Date`, `ISRead`, `Type`, `Message_Type`, `Client_ID`) VALUES (NULL, '".$from."','".$from."','".$to."', '".$title."', '".$message."', Now(), '0', '0', '0', '".$ClientID."')";
            // insert
            $this->db->query( $Query);
            $Query= "INSERT INTO `CRM_internal_messages` (`ID`, `UserID`, `From_User`, `To_User`, `Titel`, `Message`, `Send_Date`, `ISRead`, `Type`, `Message_Type`, `Client_ID`) VALUES (NULL, '".$to."','".$from."','".$to."', '".$title."', '".$message."', Now(), '0', '1', '0', '".$ClientID."')";
            // insert
            $this->db->query( $Query);
        }else{
            $Query= "INSERT INTO `CRM_internal_messages` (`ID`, `UserID`, `From_User`, `To_User`, `Titel`, `Message`, `Send_Date`, `ISRead`, `Type`, `Message_Type`, `Client_ID`) VALUES (NULL, '".$from."','".$from."','".$to."', '".$title."', '".$message."', Now(), '0', '0', '0', NULL)";
            // insert
            $this->db->query($Query);
            $Query= "INSERT INTO `CRM_internal_messages` (`ID`, `UserID`, `From_User`, `To_User`, `Titel`, `Message`, `Send_Date`, `ISRead`, `Type`, `Message_Type`, `Client_ID`) VALUES (NULL, '".$to."','".$from."','".$to."', '".$title."', '".$message."', Now(), '0', '1', '0', NULL)";
            // insert
            $this->db->query($Query);
        }
    }
    function NewComplaint($from,$type,$title,$message,$ClientID ){
        $Query = "INSERT INTO `complaints` (`ID`, `UserID`, `ComplaintsIN`, `Titel`, `Message`, `Send_Date`, `ISRead`, `Type`) VALUES (NULL, '$from', '$ClientID', '$title', '$message', Now(), '0', '$type')";
        $this->db->query($Query);
    }
    function NewInstructions($from,$to,$title,$message,$ClientID = null){
// message type = 2
        if ($ClientID !=null){
            $Query= "INSERT INTO `CRM_internal_messages` (`ID`, `ownerUserID`, `From_User`, `To_User`, `Titel`, `Message`, `Send_Date`, `ISRead`,  `Message_Type`, `Client_ID`) VALUES (NULL, '".$from."','".$from."','".$to."', '".$title."', '".$message."', Now(), '0',  '5', '".$ClientID."')";
//insert
            $this->db->query( $Query);
            $Query= "INSERT INTO `CRM_internal_messages` (`ID`, `ownerUserID`, `From_User`, `To_User`, `Titel`, `Message`, `Send_Date`, `ISRead`,  `Message_Type`, `Client_ID`) VALUES (NULL, '".$to."','".$from."','".$to."', '".$title."', '".$message."', Now(), '0',  '5', '".$ClientID."')";
//insert
            $this->db->query( $Query);
        }else{
            $Query= "INSERT INTO `CRM_internal_messages` (`ID`, `ownerUserID`, `From_User`, `To_User`, `Titel`, `Message`, `Send_Date`, `ISRead`,  `Message_Type`, `Client_ID`) VALUES (NULL, '".$from."','".$from."','".$to."', '".$title."', '".$message."', Now(), '0',  '5', NULL)";
            // insert
            $this->db->query( $Query);
            $Query2= "INSERT INTO `CRM_internal_messages` (`ID`, `ownerUserID`, `From_User`, `To_User`, `Titel`, `Message`, `Send_Date`, `ISRead`,  `Message_Type`, `Client_ID`) VALUES (NULL, '".$to."','".$from."','".$to."', '".$title."', '".$message."', Now(), '0',  '5', NULL)";
            //insert
            $this->db->query( $Query2);
        }
    }
    function GetUserMessage($UserID,$Type,$issend){
        if ($issend){
            $Query= "SELECT * FROM `CRM_internal_messages` WHERE `ownerUserID` = $UserID and `Message_Type` =$Type and From_User =$UserID  ORDER BY `Send_Date`";
        }else{
            $Query= "SELECT * FROM `CRM_internal_messages` WHERE `ownerUserID` = $UserID and `Message_Type` =$Type and To_User =$UserID ORDER BY `Send_Date`";
        }

//        print_r($Query);die();
        $Result= $this->db->query( $Query)->result();
        return $Result;
    }
    function UpdateMessageStatus($UserID,$Type){
        $this->db->where('Message_Type', $Type);
        $this->db->where('To_User', $UserID);
        $this->db->update('crm_internal_messages', array('ISRead' => 1));

    }
    function GetUnReadMessages($UserID,$MessageType){
        $Query= "SELECT count(*) AS Count FROM `CRM_internal_messages` WHERE `ISRead` = 0 AND `Type` = 1 and `Message_Type` = $MessageType and `UserID` = $UserID";
        $Result= $this->db->query( $Query)->result();;
        return $Result[0]->Count;

    }
    function GetUserComplaint($Type,$UserID = null){
        if ($UserID == null){
            // get all data
            $Query= "SELECT * FROM `complaints` WHERE `Type` = $Type ORDER BY `Send_Date`";
        }else{
            // get user data
            $Query= "SELECT * FROM `complaints` WHERE `UserID` = $UserID AND `Type` = $Type ORDER BY `Send_Date`";
        }

        $Result= $this->db->query( $Query)->result();
        return $Result;
    }
    function UpdateComplaintStatus(){
        $Query= "UPDATE `complaints` SET `ISRead` = 1 ";
        $this->db->query( $Query);

    }
    function GetUnReadComplaint(){
        $Query= "SELECT count(*) AS Count FROM `complaints` WHERE `Admin_Seen` = 0";
        $Result= $this->db->query( $Query)->result();;
        return $Result[0]->Count;

    }
    function GetReceivedMessages($UserID,$Type){
        $query = $this->db->get_where('crm_internal_messages',array('To_User'=>$UserID,'ownerUserID'=>$UserID,'Message_Type'=>$Type));
        return $query->result();
    }
    function GetSendMessages($UserID,$Type){
        $query = $this->db->get_where('crm_internal_messages',array('From_User'=>$UserID,'ownerUserID'=>$UserID,'Message_Type='=>$Type));
        return $query->result();
    }
    function SendMessages($msgData){
        $this->db->insert('crm_internal_messages', $msgData);
    }
    function DeleteMessage($msgID){
        $this->db->delete('crm_internal_messages', array('ID' => $msgID));
    }
    function GetMSGCount($UserID,$Type){

        $query = $this->db->get_where('crm_internal_messages',array('To_User'=>$UserID,'Message_Type'=>$Type));

        return $query->result();
    }



    function GetComplain($UserID,$Type){

        $where = "crm_internal_messages.Message_Type ='".$Type."' AND crm_internal_messages.ownerUserID = '".$UserID."'";
        $this->db->select('crm_internal_messages.From_User,
        crm_internal_messages.Client_ID,
        crm_internal_messages.Titel,
        crm_internal_messages.Message,
        crm_internal_messages.Send_Date,
        crm_internal_messages.ID as MSGID');
        $this->db->from('crm_internal_messages');
        $this->db->join('crm_users', 'crm_internal_messages.ownerUserID = crm_users.ID');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

}