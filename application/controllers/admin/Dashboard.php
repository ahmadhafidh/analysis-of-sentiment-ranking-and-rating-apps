<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function index(){
		// $this->load->model('Blog_model');
		// $this->load->model('Portofolio_model');
		// $this->load->model('Clientsay_model');
		$this->load->model('Konfirmasi_model');
		// $this->load->model('Jenisportofolio_model');
		// $this->load->model('Komentar_model');
		// $this->load->model('Featured_model');
		$this->load->model('Ion_auth_model');

		/* cek status login */
		if (!$this->ion_auth->logged_in()){
			// apabila belum login maka diarahkan ke halaman login
			redirect('admin/auth/login', 'refresh');
		}
		elseif($this->ion_auth->is_user()){
			// apabila belum login maka diarahkan ke halaman login
			redirect('admin/auth/login', 'refresh');
		}
		else{
			$this->data = array(
				'title' 							=> 'Dashboard',
				'button' 							=> 'Tambah',
				// 'total_blog' 						=> $this->Blog_model->total_rows(),
				// 'total_portofolio'					=> $this->Portofolio_model->total_rows(),
				// // 'total_blog' 						=> $this->Blog_model->total_rows(),
				'total_user' 						=> $this->Ion_auth_model->total_rows(),
				// 'total_komen' 						=> $this->Komentar_model->get_total_row_kategori(),
				// 'total_komen_pending' 				=> $this->Komentar_model->get_total_row_kategori_pending(),
				// 'total_featured' 					=> $this->Featured_model->total_rows(),
				'total_konfirmasi' 					=> $this->Konfirmasi_model->total_rows()
				// 'total_jenisportofolio' 			=> $this->Jenisportofolio_model->total_rows()
				);

			$this->load->view('back/dashboard',$this->data);
		}
	}
	
}
