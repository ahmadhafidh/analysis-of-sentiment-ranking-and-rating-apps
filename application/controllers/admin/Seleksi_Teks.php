<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seleksi_Teks extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('PHPExcel');
	    $this->load->model(array('model_sentimen','model_global'));
	}

	public function index(){
		$msg    = $this->uri->segment(3);
        $alert  = '';
        if($msg == 'sukses'){
            $alert  = 'Upload Dataset Sukses';
        }
        elseif ($msg == 'tetap'){
            $alert  = 'Dataset Tetap';
		}
		elseif ($msg == 't_sukses'){
            $alert  = 'Training Selesai';
        }
		$data['_alert'] = $alert;
		$this->load->view('back/call_train',$data);
	}

	function upload_train() {
        $arr_teks=array();
        $dt_teks=$this->model_sentimen->tampil_all_teks()->result();
        foreach ($dt_teks as $dt) {
            $arr_teks[]=$dt->teks;
		}

        $fileName = $_FILES['fileImport']['name'];
        $config['upload_path'] = './fileExcel/';
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;

        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('fileImport'))
            $this->upload->display_errors();
        $media = $this->upload->data('fileImport');
        $inputFileName = './fileExcel/'.$config['file_name'];
        
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            
            $data = array(
                // "id_teks" => $rowData[0][0],
                "teks" => $rowData[0][0],
                "label" => $rowData[0][1]
            );
			$cek=in_array($data['teks'], $arr_teks);
            if ($cek==1) {
				$status="tetap";
            }
            else{
            	$this->db->insert("dataset", $data);
				$status="sukses";
            }
        }
        if (file_exists($inputFileName)) {
            unlink($inputFileName);
		}
		// redirect(base_url()."admin/seleksi_teks/index/".$status,"refresh");
		redirect(base_url()."admin/seleksi_teks/suksesupload","refresh");

    }

	public function train(){
		$teks_hasil=array();
		$dt_teks=$this->model_sentimen->tampil_all_teks()->result();
		
		$id_teks=0;
		foreach ($dt_teks as $teks) {
			$teks_hasil[$id_teks][]=$teks->teks;
			$teks_hasil[$id_teks][]=$teks->label;
			
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

		$train_baru=$this->db->query("SELECT * FROM dataset_baru")->result();
		$cek_tb=array();
		foreach ($train_baru as $tb) {
			$cek_tb[]=$tb->teks." ".$tb->label;
		}
		// echo "<pre>";
		// print_r($hasil_seleksi);
		foreach ($hasil_seleksi as $k) {
			$cek=in_array($k,$cek_tb);
			if ($cek==0) {
				$jml_kata=count(explode(" ",$k));
				$teks=implode(" ", array_slice(explode(" ", $k), 0, $jml_kata-1));
				if ($teks!="") {
					$input["teks"]=$teks;
					$input["label"]=implode(" ", array_slice(explode(" ", $k), $jml_kata-1, 1));
					// echo $input["teks"]." LABEL ".$input["label"]."<br>";
					$this->model_sentimen->input_teks_unik($input);
				}
			}
		}
		shell_exec(FCPATH.'sklearn_try\train_py.py');
		// echo "<pre>";
		// print_r($output);
		redirect(base_url()."admin/seleksi_teks/sukses","refresh");
	}
  
  public function sukses(){
    $this->load->view('traindatasukses_view');
  }
  public function suksesupload(){
    $this->load->view('uploaddatasetsukses_view');
  }
}