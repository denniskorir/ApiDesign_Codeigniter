<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
* 
*/
class Myapi extends REST_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function students_get(){
		$studentID = $this->uri->segment(4);
		$this ->load->model('ModelStudents');
		$student = $this->ModelStudents->get_by(array('studentID'=>$studentID,'status'=>'active'));
	
			if (isset($student['studentID' ])) {
				$this->response(array('status'=>'success', 'message'=>$student));

			}else{
				$this->response(array('status'=>'failure', 'messege'=>'The spcified student cannot be found'), REST_Controller::HTTP_NOT_FOUND);
				}
	} 
	function students_put(){

		// var_dump(array());
		$this->load->library('form_validation');
		$this->form_validation->set_data($this->put());  

		if ($this->form_validation->run('students_put')!=false) {
		 	$this ->load->model('ModelStudents');
		 	$student = $this->put();
		 	$studentID = $this->ModelStudents->isert($student);

		 	if (!$studentID) {
		 		$this->response(array('status'=>'failure', 'messege'=>'internal server error'), REST_Controller::HTTP_NOT_FOUND);
		 		
		 	}else{
		 		$this->response(array('status'=>'success', 'message'=>'Created'));

		 	}
		 } 
		 else{
		
		 	$this->response(array('status'=>'failure','message'=>$this->form_validation->get_errors_as_array()),REST_Controller::HTTP_BAD_REQUEST);
		 }
	}
}

  