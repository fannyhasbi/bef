<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model {
  public function getProdiByKode($kode_ptn){
    $q = $this->db->get_where('prodi', ['ptn' => $kode_ptn]);
    return $q->result();
  }
  

}
