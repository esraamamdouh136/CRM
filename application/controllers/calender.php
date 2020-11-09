<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class calender extends CI_Controller {

	  function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
		session_start();
		$this->load->model('Model1');
    }
		 
	public function index()
	{
		$data = $this->getall();
		$data['url'] = base_url();
	    $this->load->view('calendar',$data);
	}


	

	public function AddToCalender()
	{
		$notes = $_POST['name'] ;
		$color = $_POST['color'] ;
		$date = $_POST['date'] ;
		$Content = $_POST['Content'] ;
		$id = $this->Model1->addtotable("my_calender", ["content"=>$Content,"Notes" =>$notes ,"color" =>$color,"fayfrom" =>$date ,"user_id" =>$_SESSION['userid']  ]);

		echo $id;
	}

	public function deletecalender()
	{
		$id = $_POST['id'] ;
		$id = $this->Model1->removefromtable("my_calender", ["calender_id"=>$id]);

		echo $id;
	}

	public function updateCalender()
	{
		$start = $_POST['start'] ;
		$end = $_POST['end'] ;
		$id = $_POST['id'] ;

		$this->Model1->updatedata("my_calender", ["calender_id" =>$id],["fayfrom"=>$start,"dayto"=>$end] );
	}
	public function MyCalender()
	{
		$data["MyData"] = $this->Model1->selectdata("my_calender",[ "user_id "=> $_SESSION['userid'] ]);

		echo json_encode($data);
	}
	
}
