<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Sentimen extends CI_Model{

  public function __construct()
  {
    parent::__construct();
  }

  function tampil_all_teks(){
    $tampil=$this->db->get('dataset');
    // $tampil=$this->db->query("select * from dataset limit 5");
    return $tampil;
  }

  function input_teks_unik($data){
    $tampil=$this->db->insert('dataset_baru',$data);
  }

  function tampil_teks_unik(){
    $tampil=$this->db->get('dataset_baru');
    // $tampil=$this->db->query("select * from dataset limit 5");
    return $tampil;
  }

  function tampil_data_crawling(){
    $tampil=$this->db->get('data_crawling');
    return $tampil;
  }

  function input_crawling_baru($data){
    $tampil=$this->db->insert('data_crawling_baru',$data);
  }

  function tampil_all_kata(){
    $tampil=$this->db->get('tb_kata');
    // $tampil=$this->db->query("select * from tb_kata limit 2");
    return $tampil;
  }

  function tampil_kata(){
    $this->db->select('nm_kata');
    $this->db->from('tb_kata');
    $tampil=$this->db->get();

    return $tampil;
  }

  function tampil_all_tf(){
    $tampil=$this->db->query("SELECT kata.nm_kata, dataset_baru.label, dataset_baru.teks, tf.id_kata, tf.id_teks, tf.tf from tb_kata as kata join tb_tf as tf on tf.id_kata=kata.id_kata join dataset_baru as dataset_baru on tf.id_teks=dataset_baru.id_teks");
    return $tampil;
  }

  function tampil_jumKata(){
    $jumKata=$this->db->count_all('tb_kata');
    return $jumKata;
  }

  function input_kata($data){
    $this->db->query("insert into tb_kata(nm_kata) values('".$data."')");
  }

  function input_tf($data){
    $this->db->query("DELETE FROM tb_tf WHERE id_kata=".$data['id_kata']." AND id_teks=".$data['id_teks']);
    $this->db->insert('tb_tf',$data);
  }

}
