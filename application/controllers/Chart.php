<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index() {
		$getdata = file_get_contents(base_url('seleksi_crawling'));
		$data2 = json_decode($getdata);

		// echo "<pre>";
		// print_r($data2);

		// print_r($data);		
		// rsort($data, "positif");
		// natsort($data);

		// sort($data2);
		$result = array();
		$result2 = array();
		$result3 = array();
		$arrlength = count($data2);

		for($x = 0; $x < $arrlength; $x++) {
		    $a = $data2[$x]->positif-$data2[$x]->negatif;
		    echo "<br>";
			// array_push($result,$a);    
		 //    echo $a;
		    // print_r($data2[$x]->positif);
		    // echo "<br>";
		    // print_r($a);

			$id[$x] = $data2[$x]->id_tes;
		    $positif[$x] = $data2[$x]->positif;
		    $negatif[$x] = $data2[$x]->negatif;
		    $hasil[$x] = $a;

		}



		$data["id"] = $id;
	    $data["positif"] = $positif;
	    $data["negatif"] = $negatif;	
		arsort($hasil);
		$data["hasil"] = $hasil;

		$this->load->view('template/header');
		$this->load->view('view_chart', $data);
		$this->load->view('template/footer');
		// redirect('/chart#feature');
	}

	public function tes() {
		$getdata = file_get_contents(base_url('seleksi_crawling'));
		$data2 = json_decode($getdata);

		// echo "<pre>";
		// print_r($data2);

		// print_r($data);		
		// rsort($data, "positif");
		// natsort($data);

		// sort($data2);
		$result = array();
		$result2 = array();
		$result3 = array();
		$arrlength = count($data2);

		for($x = 0; $x < $arrlength; $x++) {
		    $a = $data2[$x]->positif-$data2[$x]->negatif;
		    echo "<br>";
			// array_push($result,$a);    
		 //    echo $a;
		    // print_r($data2[$x]->positif);
		    // echo "<br>";
		    // print_r($a);

			$id[$x] = $data2[$x]->id_tes;
		    $positif[$x] = $data2[$x]->positif;
		    $negatif[$x] = $data2[$x]->negatif;
		    $hasil[$x] = $a;

		}



		$data["id"] = $id;
	    $data["positif"] = $positif;
	    $data["negatif"] = $negatif;	
		arsort($hasil);
		$data["hasil"] = $hasil;	

		// echo "<pre>";		
		// print_r(($hasil));
		// echo "</pre>";	

		$this->load->view('coba_view', $data);
	}

}

/* End of file Chart.php */
/* Location: ./application/controllers/Chart.php */