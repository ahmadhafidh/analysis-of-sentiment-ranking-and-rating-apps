<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_textpreprocessing extends CI_Model{

  public function tokenizing()
  {
      $kalimat = $this->db->select('konten')
          ->from('data_crawling')
          ->where('id_crawling', 1)
          ->get()
          ->result();

      $text_procesing['case'] = 0;

      return $kalimat;
  }

  public function tokenizing2()
  {
      $kalimat = $this->db->select('konten')
          ->from('data_crawling')
          ->where('id_crawling', 2)
          ->get()
          ->result();

      $text_procesing['case'] = 0;

      return $kalimat;
  }

  public function tokenizing3()
  {
      $kalimat = $this->db->select('konten')
          ->from('data_crawling')
          ->where('id_crawling', 3)
          ->get()
          ->result();

      $text_procesing['case'] = 0;

      return $kalimat;
  }

  public function tokenizing4()
  {
      $kalimat = $this->db->select('konten')
          ->from('data_crawling')
          ->where('id_crawling', 4)
          ->get()
          ->result();

      $text_procesing['case'] = 0;

      return $kalimat;
  }

  public function tokenizing5()
  {
      $kalimat = $this->db->select('konten')
          ->from('data_crawling')
          ->where('id_crawling', 5)
          ->get()
          ->result();

      $text_procesing['case'] = 0;

      return $kalimat;
  }



}