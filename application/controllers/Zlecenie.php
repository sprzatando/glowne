<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zlecenie extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->model('baza');
	}
	
	public function index(){
		
	}
	
	public function nowe(){
		$miejsce = $this->input->post('zlecenie_miejsce');
		if($miejsce != null){
			var_dump($_POST);
			$x = $this->input->post('zlecenie_pokoje');
			var_dump($x);
			//sprawdz dane i wpisz do bazy
		}else{
			$this->load->view('naglowek',array('tytul'=>'NOWE ZLECENIE'));
			$this->load->view('nowezlecenie');
			//podaj formularz
		}
	}
}