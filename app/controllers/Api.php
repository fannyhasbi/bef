<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('api_model');
    // Mengatasi isu CORS
    header( "Access-Control-Allow-Origin: *");
    header( "Access-Control-Allow-Headers: x-requested-with, x-requested-by");
    header( "Access-Control-Allow-Methods: POST, GET");
    // header( "Access-Control-Allow-Credentials: true");
    // header( "Access-Control-Max-Age: 604800");
    // header( "Access-Control-Request-Headers: x-requested-with");
  }
  
  public function ptn(){
      $this->db->order_by('nama');
      $q = $this->db->get('ptn')->result();
      $out = '<option value="0">--- Pilih Universitas ---</option>';
      
      foreach($q as $item){
          $out .= '<option value="'. $item->kode .'">'. $item->nama .'</option>';
      }
      
      $data = array(
        'ptn'     => $out
      );
      
      echo json_encode($data);
  }

  public function prodi(){
    if($this->input->post('ptn') == ""){
      show_404();
    }
    
    $kode_ptn   = $this->input->post('ptn');

    $prodi = $this->api_model->getProdiByKode($kode_ptn);

    $out = '<option value="0">--- Pilih Prodi ---</option>';
    foreach($prodi as $item){
      $out .= '<option value="'. $item->kode .'">'. $item->nama ."</option>";
    }

    $data = array(
      'prodi' => $out
    );

    echo json_encode($data);
  }
  
  public function resize(){
        if($this->input->post('id') && $this->input->get('token') && $this->input->post('to')){
        $this->api_model->updateSize($this->input->post('id'), $this->input->post('to'));
    
        $data = array(
          'success' => true
        );
    
        echo json_encode($data);
      }
      else {
        show_404();
      }
  }

}
