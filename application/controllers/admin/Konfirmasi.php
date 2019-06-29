<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Konfirmasi extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Konfirmasi_model');

    $this->data['module'] = 'Konfirmasi';    

    /* cek login */
    // if (!$this->ion_auth->logged_in()){
    //   // apabila belum login maka diarahkan ke halaman login
    //   redirect('admin/auth/login', 'refresh');
    // }
    // elseif($this->ion_auth->is_user()){
    //   // apabila belum login maka diarahkan ke halaman login
    //   redirect('admin/auth/login', 'refresh');
    // }
  }

  public function index()
  {
    if (!$this->ion_auth->is_superadmin()){
      redirect('admin/dashboard', 'refresh');
    }
    else{
      $this->data['title'] = "Data Konfirmasi";

      $this->data['konfirmasi_data'] = $this->Konfirmasi_model->get_all();
      $this->load->view('back/konfirmasi/konfirmasi_list', $this->data);
    }
  }

  public function create() 
  {
    $this->data['title']          = 'Tambah Konfirmasi Baru';
    $this->data['action']         = site_url('admin/konfirmasi/create_action');
    $this->data['button_submit']  = 'Submit';
    $this->data['button_reset']   = 'Reset';

    $this->data['id_konfirmasi'] = array(
      'name'  => 'id_konfirmasi',
      'id'    => 'id_konfirmasi',
      'type'  => 'hidden',
    );

    $this->data['bank_tujuan'] = array(
      'name'  => 'bank_tujuan',
      'id'    => 'bank_tujuan',
      'type'  => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('bank_tujuan'),
    );

    $this->data['bank_anda'] = array(
      'name'  => 'bank_anda',
      'id'    => 'bank_anda',
      'type'  => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('bank_anda'),
    );

    $this->data['rekening_atas_nama'] = array(
      'name'  => 'rekening_atas_nama',
      'id'    => 'rekening_atas_nama',
      'type'  => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('rekening_atas_nama'),
    );

    $this->data['metode_transfer'] = array(
      'name'  => 'metode_transfer',
      'id'    => 'metode_transfer',
      'type'  => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('metode_transfer'),
    );

    $this->data['nominal_transfer'] = array(
      'name'  => 'nominal_transfer',
      'id'    => 'nominal_transfer',
      'type'  => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('nominal_transfer'),
    );

    $this->data['tanggal_transfer'] = array(
      'name'  => 'tanggal_transfer',
      'id'    => 'tanggal_transfer',
      'type'  => 'text',
      'class' => 'form-control',
      'value' => $this->form_validation->set_value('tanggal_transfer'),
    );

    $this->load->view('back/konfirmasi/konfirmasi_add', $this->data);
  }
  
  public function create_action() 
  {
    // $this->load->helper('judul_seo_helper');
    $this->_rules();

    if ($this->form_validation->run() == FALSE) 
    {
      $this->create();
    } 
      else 
      {
        $data = array(
          'bank_tujuan'  => $this->input->post('bank_tujuan'),
          'bank_anda'  => $this->input->post('bank_anda'),
          'rekening_atas_nama'  => $this->input->post('rekening_atas_nama'),
          'metode_transfer'  => $this->input->post('metode_transfer'),
          'nominal_transfer'  => $this->input->post('nominal_transfer'),
          'tanggal_transfer'  => $this->input->post('tanggal_transfer')
        );

        // eksekusi query INSERT
        $this->Konfirmasi_model->insert($data);
        // set pesan data berhasil dibuat
        $this->session->set_flashdata('message', 'Data berhasil dibuat');
        redirect(site_url('admin/konfirmasi'));
      }  
  }
  
  public function update($id) 
  {
    $row = $this->Konfirmasi_model->get_by_id($id);
    $this->data['konfirmasi'] = $this->Konfirmasi_model->get_by_id($id);

    if ($row) 
    {
      $this->data['title']          = 'Update konfirmasi';
      $this->data['action']         = site_url('admin/konfirmasi/update_action');
      $this->data['button_submit']  = 'Update';
      $this->data['button_reset']   = 'Reset';

    $this->data['id_konfirmasi'] = array(
      'name'  => 'id_konfirmasi',
      'id'    => 'id_konfirmasi',
      'type'  => 'hidden',
    );

    $this->data['bank_tujuan'] = array(
      'name'  => 'bank_tujuan',
      'id'    => 'bank_tujuan',
      'type'  => 'text',
      'class' => 'form-control',
    );

    $this->data['bank_anda'] = array(
      'name'  => 'bank_anda',
      'id'    => 'bank_anda',
      'type'  => 'text',
      'class' => 'form-control',
    );

    $this->data['rekening_atas_nama'] = array(
      'name'  => 'rekening_atas_nama',
      'id'    => 'rekening_atas_nama',
      'type'  => 'text',
      'class' => 'form-control',
    );

    $this->data['metode_transfer'] = array(
      'name'  => 'metode_transfer',
      'id'    => 'metode_transfer',
      'type'  => 'text',
      'class' => 'form-control',
    );

    $this->data['nominal_transfer'] = array(
      'name'  => 'nominal_transfer',
      'id'    => 'nominal_transfer',
      'type'  => 'text',
      'class' => 'form-control',
    );

    $this->data['tanggal_transfer'] = array(
      'name'  => 'tanggal_transfer',
      'id'    => 'tanggal_transfer',
      'type'  => 'text',
      'class' => 'form-control',
    );

      $this->load->view('back/konfirmasi/konfirmasi_edit', $this->data);
    } 
      else 
      {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('admin/konfirmasi'));
      }
  }
  
  public function update_action() 
  {
    // $this->load->helper('judul_seo_helper');
    $this->_rules();

    if ($this->form_validation->run() == FALSE) 
    {
      $this->update($this->input->post('id_konfirmasi'));
    } 
      else 
      {
        $data = array(
          'bank_tujuan'  => $this->input->post('bank_tujuan'),
          'bank_anda'  => $this->input->post('bank_anda'),
          'rekening_atas_nama'  => $this->input->post('rekening_atas_nama'),
          'metode_transfer'  => $this->input->post('metode_transfer'),
          'nominal_transfer'  => $this->input->post('nominal_transfer'),
          'tanggal_transfer'  => $this->input->post('tanggal_transfer'),
          'bank_tujuan'  => $this->input->post('bank_tujuan'),
          'kategori_seo'    => $this->input->post('bank_tujuan')
        );

        $this->Konfirmasi_model->update($this->input->post('id_konfirmasi'), $data);
        $this->session->set_flashdata('message', 'Edit Data Berhasil');
        redirect(site_url('admin/konfirmasi'));
      }
  }
  
  public function delete($id) 
  {
    $row = $this->Konfirmasi_model->get_by_id($id);
    
    if ($row) 
    {
      $this->Konfirmasi_model->delete($id);
      $this->session->set_flashdata('message', 'Data berhasil dihapus');
      redirect(site_url('admin/konfirmasi'));
    } 
      // Jika data tidak ada
      else 
      {
        $this->session->set_flashdata('message', 'Data tidak ditemukan');
        redirect(site_url('admin/konfirmasi'));
      }
  }

  public function _rules() 
  {
    $this->form_validation->set_rules('bank_tujuan', 'bank tujuan', 'trim|required');
    $this->form_validation->set_rules('bank_anda', 'bank anda', 'trim|required');
    $this->form_validation->set_rules('rekening_atas_nama', 'rekening atas nama', 'trim|required');
    $this->form_validation->set_rules('metode_transfer', 'metode transfer', 'trim|required');
    $this->form_validation->set_rules('nominal_transfer', 'nominal transfer', 'trim|required');
    $this->form_validation->set_rules('tanggal_transfer', 'tanggal transfer', 'trim|required');

    // set pesan form validasi error
    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_rules('id_konfirmasi', 'id_konfirmasi', 'trim');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger alert">', '</div>');
  }

}

/* End of file Kategori.php */
/* Location: ./application/controllers/Kategori.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2016-10-17 02:19:21 */
/* http://harviacode.com */