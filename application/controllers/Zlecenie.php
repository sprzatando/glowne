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
		if($miejsce != null){;
			$x = $this->input->post('zlecenie_pokoje');
			//sprawdz dane i wpisz do bazy
		}else{
			$this->load->view('naglowek',array('tytul'=>'NOWE ZLECENIE'));
			$prace = $this->baza->prace();
			//var_dump($prace);
			$this->load->view('nowezlecenie',array('prace'=>$prace));
			//podaj formularz
		}
	}
}