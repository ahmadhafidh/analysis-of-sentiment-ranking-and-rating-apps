<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proses_Teks extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	    $this->load->model(array('model_sentimen','model_global'));
	}

	public function preprocess_awal(){		
		$kal=array();
		$dt_dataset=$this->model_sentimen->tampil_teks_unik()->result();
		$sw=$this->model_global->stop_word();
		foreach ($dt_dataset as $dt) {
			$teks=$dt->teks;
			$token=strtok($teks, " ");
			while ($token != false)
		    {
		        $cek=in_array($token, $sw);
		        if ($cek=="") {
		            $kal[]=$token;
		    	}
				$token = strtok(" ");
			}
		}
		// echo "<pre>";
		// print_r($kal);
		$this->kata_tunggal($kal);
	}

	//--- Proses Hilang Duplikat Kata ---//
	function kata_tunggal($dt){
		$kt_tunggal=array();
		foreach ($dt as $k) {
			$cek=in_array($k,$kt_tunggal);
		    if($cek == "")
		    {
		        $kt_tunggal[]=$k;
		    }
		}
		// echo "<pre>";
		// print_r($kt_tunggal);
		$this->cari($kt_tunggal);
	}

	function cari($dt2)
	{
		$cek_kata=array();
		$insert_kata=array();

		$kata=$this->model_sentimen->tampil_kata()->result();
		foreach ($kata as $kt) {
			$cek_kata[]=$kt->nm_kata;
		}

	    foreach ($dt2 as $k2) {
	    	$cek=in_array($k2,$cek_kata);
	        if ($cek=="") {
	        	$insert_kata[]=$k2;
	        }
	    }
	    $jml_awal=count($cek_kata);
	    $this->input_kt($insert_kata,$jml_awal);
	}

	function input_kt($dt,$jml_awal){
		foreach ($dt as $dt_kt) {
			$this->model_sentimen->input_kata($dt_kt);
		}
		$jml_akhir=count($this->model_sentimen->tampil_kata()->result());
		$kode="";
		if ($jml_akhir>$jml_awal) {
			$kode="true";
		}
		elseif ($jml_akhir==$jml_awal) {
			$kode="false";
		}
		echo $kode;
	}
}
