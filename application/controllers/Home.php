<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    error_reporting(0);
    ini_set('max_execution_time', 0);
    ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

	defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('home_view');
		// echo "kadal";
		$this->load->view('template/footer');
	}
}
