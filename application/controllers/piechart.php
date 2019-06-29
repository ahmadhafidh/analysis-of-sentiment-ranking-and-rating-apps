<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Piechart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	    $this->load->model(array('model_sentimen','model_global'));
	}

	public function index()
	{
		$output= shell_exec(FCPATH.'sklearn_try/try_new_datasentimen.py');
		$out['sentimen'] = json_decode($output);
		// echo "<pre>";
		// print_r($out['sentimen'] );
		// print_r($kadal);
		$this->load->view('template/header');
		$this->load->view('piechart_view',$out);
		$this->load->view('template/footer');

	}

}
