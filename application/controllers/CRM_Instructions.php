<?php
/**
 * Created by PhpStorm.
 * User: boodykamel
 * Date: 10/18/18
 * Time: 3:28 PM
 */

class CRM_Instructions extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        $this->load->model('Users_Model');
        $this->load->model('Employee_Taskes');
        $this->load->model('User_Log');
        $this->load->model('InternalMessages');
        $this->load->model('CRM_User_Log');
        $this->load->model('Model1');
        $this->load->model('Customers_Model');
        session_start();

    }

}