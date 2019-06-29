<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seleksi_Crawling extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	    $this->load->model(array('model_sentimen','model_global'));
	}

	public function index(){
		$teks_hasil=array();
		$dt_teks=$this->model_sentimen->tampil_data_crawling()->result();
		
		$id_teks=0;
		foreach ($dt_teks as $teks) {
			$teks_hasil[$id_teks][]=$teks->konten;
			$teks_hasil[$id_teks][]=$teks->id_crawling;
			
			$id_teks++;
		}
		// echo "<pre>";
		// print_r($teks_hasil);
		$this->clean_case($teks_hasil);
	}

	function clean_case($teks){
		$potongan_kata=array();
		$sw=$this->model_global->stop_word();
		$id_teks=0;
		foreach ($teks as $dt) {
			$str = preg_replace('/[^A-Za-z0-9\ ]/', ' ',$dt[0]);
			$token=strtok($str, " ");
			while ($token != false)
			{
			    $low=strtolower($token);
			    $cek=in_array($low, $sw);
			    if ($cek=="") {
					$potongan_kata[$id_teks][]=$low;
			 	}
				$token = strtok(" ");
			}
			$potongan_kata[$id_teks][]=$dt[1];
			$id_teks++;
		}
		// echo "<pre>";
		// print_r($potongan_kata);
		$this->gabung_kata($potongan_kata);
	}

	function gabung_kata($potongan_kata){
		$teks_baru=array();
		$id_teks=0;
		foreach ($potongan_kata as $k) {
			$teks_baru[]=implode(" ",$k);
			$id_teks++;
		}
		$hasil_seleksi=array_unique($teks_baru);
		$hasil_seleksi=array_values($hasil_seleksi);

		$crawl_baru=$this->db->query("SELECT * FROM data_crawling_baru")->result();
		$cek_cb=array();
		foreach ($crawl_baru as $cb) {
			$cek_cb[]=$cb->konten." ".$cb->id_tes;
		}
		// echo "<pre>";
		// print_r($cek_cb);
		foreach ($hasil_seleksi as $k) {
			$cek=in_array($k,$cek_cb);
			if ($cek==0) {
				$jml_kata=count(explode(" ",$k));
				$konten=implode(" ", array_slice(explode(" ", $k), 0, $jml_kata-1));
				if ($konten!="") {
					$input["konten"]=$konten;
					$input["id_tes"]=implode(" ", array_slice(explode(" ", $k), $jml_kata-1, 1));
					// echo $input["teks"]." LABEL ".$input["label"]."<br>";
					$this->model_sentimen->input_crawling_baru($input);
				}
			}
		}
		$output = shell_exec(FCPATH.'sklearn_try\try_new_data.py');
		// $hasil=json_decode($output);
		// echo "<pre>";
		print_r($output);

		
		// $output = shell_exec(FCPATH.'sklearn_try\try_new_data.py');
		
		// // echo "<pre>";
		// // echo $output;
		// // $a = json_decode($output);
		// print_r($output);
	}

}
