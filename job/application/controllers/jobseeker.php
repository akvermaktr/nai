<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jobseeker extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function register()
	{
		$this->load->view('register_jobseeker');
	}
}

