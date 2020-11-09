<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mainPage extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('common_helper');
        $this->load->helper('url');
		session_start();
		$this->load->model('Model1');
    }
	 
	public function index()
	{
		$data['url'] = base_url();
		$this->load->view("welcome_message.php");	
	}
    public function calender()
	{
            $data['url'] = base_url();

		//$data['users'] = $this->Model1->selectdata("users",[ "user_id !="=> $_SESSION['userid'] ]);

		
		$this->load->view('calender',$data);
	}
	public function MyCalender()
	{
		$data["MyData"] = $this->Model1->selectdata("my_calender",[ "user_id "=> 60 ]);

		echo json_encode($data);
	}
	public function AddToCalender()
	{
		$notes = $_POST['name'] ;
		$color = $_POST['color'] ;
		$date = $_POST['date'] ;
		$Content = $_POST['Content'] ;
		$id = $this->Model1->addtotable("my_calender", ["content"=>$Content,"Notes" =>$notes ,"color" =>$color,"fayfrom" =>$date ,"user_id" =>60  ]);

		echo $id;
	}
	public function updateCalender()
	{
		$start = $_POST['start'] ;
		$end = $_POST['end'] ;
		$id = $_POST['id'] ;

		$this->Model1->updatedata("my_calender", ["calender_id" =>$id],["fayfrom"=>$start,"dayto"=>$end] );
	}
	public function deletecalender()
	{
		$id = $_POST['id'] ;
		$id = $this->Model1->removefromtable("my_calender", ["calender_id"=>$id]);

		echo $id;
	}
}	
