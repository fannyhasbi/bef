<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->model('api_model');
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

}
