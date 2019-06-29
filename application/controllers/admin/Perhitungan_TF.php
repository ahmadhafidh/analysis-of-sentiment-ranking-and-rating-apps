<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perhitungan_TF extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	    $this->load->model(array('model_sentimen','model_global'));
	}

	// public function index()
	// {
	// 	$data["p"]=$this->uri->segment(4);
	// 	$data["header"] = $this->load->view("admin/template/header", null,true);
	// 	$data["footer"] = $this->load->view("admin/template/footer", null,true);
	// 	$data["dt_term"] = $this->model_lirik->tampil_all_tf();
	// 	$data["dt_lirik"] = $this->model_lirik->tampil_all_lirik();
	// 	$data["dt_kata"] = $this->model_lirik->tampil_all_kata();
	// 	// $data["dt_nc"] = $arr_class;
	// 	// $data["jum_v"] = $jum_kata;
	// 	$this->load->view('admin/v_training', $data);
	// }

	public function bentuk_matrix(){
		$kal=array();
		$dt_teks=$this->model_sentimen->tampil_teks_unik()->result();
		
		foreach ($dt_teks as $teks) {
			$id_teks=$teks->id_teks;
			$isi_teks=$teks->teks;

			$kal[$id_teks]=$isi_teks;
		}
		// echo "<pre>";
		// print_r($kal);
		$this->preprocess_awal($kal);
	}

	function preprocess_awal($teks){
		$kal2=array();
		$sw=$this->model_global->stop_word();
		foreach ($teks as $dt) {
			$id_teks=array_search($dt, $teks);
			// $str = preg_replace('/[^A-Za-z0-9\ ]/', ' ',$dt);
			$token=strtok($dt, " ");
			while ($token != false)
			{
			    $cek=in_array($token, $sw);
			    if ($cek=="") {
			        $kal2[$id_teks][]=$token;
			 	}
				$token = strtok(" ");
			}
		}
		// echo "<pre>";
		// print_r($kal2);
		$this->kata_tunggal($kal2);
	}

	//--- Proses TF ---//
	function kata_tunggal($dt){
		$kt_tunggal=array();
		$tf_array=array();

		// echo "Pembentukan Term Frequency : <br>";
		$dt_tunggal=$this->model_sentimen->tampil_all_kata()->result();
		foreach ($dt_tunggal as $kt) {
			$id_kata=$kt->id_kata;
			$kt_tunggal[$id_kata]= $kt->nm_kata;
		}

		$dt_tf=$this->model_sentimen->tampil_all_tf()->result();
		foreach ($dt_tf as $d) {
			$tf_array[]=$d->id_kata."-".$d->id_teks."-".$d->tf;
		}
		// echo "<pre>";
		// print_r($tf_array);

		$kode="";
		foreach ($dt as $dt_kata) {
			$id_teks=array_search($dt_kata, $dt);

			foreach ($kt_tunggal as $k_tunggal) {
				$nb=0;
				if (in_array($k_tunggal, $dt_kata)) {
					$id_kata=array_search($k_tunggal, $kt_tunggal);

					foreach ($dt_kata as $k_data) {
		    			// echo $k_data;		
						if ($k_data==$k_tunggal) {
							$nb++;
						}
			    	}
			    	$tf['id_kata']=$id_kata;
		    		$tf['id_teks']=$id_teks;
		    		$tf['tf']=$nb;

		    		$cek=$id_kata."-".$id_teks."-".$nb;
		    		if (in_array($cek, $tf_array)) {
						$kode="false";// echo "Tidak Ada Pembaruan Data TF";
		    		}
		    		else{
		    			$this->model_sentimen->input_tf($tf);
		    			$kode="true";// echo "Data TF Diperbarui";
		    		}
		    	}
			}
		}
		// echo "<pre>";
		echo $kode;
		// redirect(site_url()."admin/perhitungan_tf/index/".$kode,"refresh");
	}

}
