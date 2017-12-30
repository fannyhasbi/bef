<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
    parent::__construct();
  }

  public function index(){
    $q = $this->db->get('publish');

    if($q->row()->publish == 0){
      $this->load->view('home/maintenance.php');
    }
    else {
  		$this->load->view('home/index');
    }
	}

  public function notfound(){
    $this->load->view('errors/html/error_404');
  }
}
