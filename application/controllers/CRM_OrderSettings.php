<?php
/**
 * Created by PhpStorm.
 * User: abdob
 * Date: 30/01/2019
 * Time: 04:12 م
 */

class CRM_OrderSettings extends CI_Controller
{



    function __construct()
    {
        parent::__construct();


        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common_helper');
        session_start();
        $this->load->model('ordersettingsModel');
    }

    function index()
    {
        $data['url'] = base_url();
        $data["title"] = "إعدادات التعاقد";
        $_SESSION["PAGE"] = "OrderSettings";
        if (!isset($_SESSION['userid']) || !isset($_SESSION['UserPermissions'])) {
            $this->load->view('login', $data);
        } else {

            $data['parent'] = $this->ordersettingsModel->GetAllOrderSettings();

            $this->load->view('Orders/index', $data);


        }
    }

    function update(){
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            $data['url'] = base_url();
            if ( !(empty($_POST["id"])) &&!(empty($_POST["StatusName"]) )){

                $valuse['Text'] = $_POST["StatusName"];
                $result = $this->ordersettingsModel->UpdateSettings($_POST["id"],$valuse);

                if ($result > 0 )
                    echo 1;
                else
                    echo 0;

            }else{
                echo 0;

            }
        }

    }

    function ChangeStatus(){
        if(!isset($_SESSION['userid'])){
            $data['url'] = base_url();
            $this->load->view('login',$data);
        }else{
            $data['url'] = base_url();
            if ( !(empty($_POST["id"])) &&!(empty($_POST["status"]) )){
                $status = 0;
                if ($_POST["status"] == 'true'){
                    $status=1;
                }
                $result = $this->ordersettingsModel->UpdateSettingsStatus($_POST["id"],$status);
                if ($result > 0 )
                    echo 1;
                else
                    echo 0;

            }else{
                echo 0;

            }
        }
    }
}