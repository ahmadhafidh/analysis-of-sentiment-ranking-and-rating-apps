<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Call_Python extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	    $this->load->model(array('model_sentimen','model_global'));
	}

    public function index()
	{
		$output = shell_exec("D:/python/sklearn_try/try_new_data.py");
        echo "<pre>$output</pre>";
	}

}
