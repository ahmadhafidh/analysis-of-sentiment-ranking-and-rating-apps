<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog_model extends CI_Model
{
  public $table = 'blog';
  public $id    = 'id_blog';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->order_by($this->id, $this->order);
    return $this->db->get($this->table)->result();
  }

  function get_combo_blog()
  {
    $this->db->order_by('judul_blog', 'ASC');
    $query = $this->db->get($this->table);

    if($query->num_rows() > 0){
      $data = array();
      foreach ($query->result_array() as $row) 
      {
        $data[$row['id_blog']] = $row['judul_blog'];
      }
      return $data;
    }
  }

  function get_all_random()
  {
    $this->db->limit(4); 
    $this->db->order_by($this->id, 'random');
    return $this->db->get($this->table)->result();
  }

  function get_all_new_home()
  {
    $this->db->limit(4);
    $this->db->where('publish','ya');
    $this->db->order_by($this->id, $this->order);
    return $this->db->get($this->table)->result();
  }

  function get_all_blog_sidebar()
  {
    $this->db->limit(5); 
    $this->db->where('publish','ya');
    $this->db->order_by($this->id, $this->order);
    return $this->db->get($this->table)->result();
  }

  function get_all_komentar_sidebar()
  {
    $this->db->from($this->table);
    $this->db->where('status', 'ya');
    $this->db->limit(5); 
    $this->db->order_by('time_verif', $this->order);
    $this->db->join('komentar', 'blog.id_blog = komentar.id_blog');
    return $this->db->get()->result();  
  }

  // get data by id
  function get_by_id($id)
  {
    $this->db->where($this->id, $id);
    $this->db->or_where('judul_seo', $id);
    return $this->db->get($this->table)->row();    
  }

  function get_komentar($id)
  {
    $this->db->from($this->table);
    $this->db->where('judul_seo', $id);
    $this->db->where('status', 'ya');
    $this->db->join('komentar', 'blog.id_blog = komentar.id_blog');
    return $this->db->get()->result();    
  }

  function get_all_arsip($per_page,$dari)
  {
    $query = $this->db->get($this->table,$per_page,$dari);
    return $query->result();
  }
  
  // get total rows
  function total_rows() {
    return $this->db->get($this->table)->num_rows();
  }

  // insert data
  function insert($data)
  {
    $this->db->insert($this->table, $data);
  }

  // insert data
  function insert_komentar($data)
  {
    $this->db->insert('komentar', $data);
  }

  // update data
  function update($id, $data)
  {
    $this->db->where($this->id,$id);
    $this->db->update($this->table, $data);
  }

  // delete data
  function delete($id)
  {
    $this->db->where($this->id, $id);
    $this->db->delete($this->table);
  }

  // get all
  function get_cari_blog()
  {
    $cari_blog = $this->input->post('cari_blog');

    $this->db->like('judul_blog', $cari_blog);
    return $this->db->get($this->table)->result();
  }

}