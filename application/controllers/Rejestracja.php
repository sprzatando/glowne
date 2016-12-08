<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rejestracja extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->model('baza');
	}
	public function index(){
		$this->load->view("naglowek",array('tytul'=>'REJESTRACJA'));
		$this->load->view("rejestracja");
	}
	
	public function rejestruj(){
		$email = $this->input->post('email_rejestracja');
		$haslo = $this->input->post('haslo_rejestracja');
		$nick = $this->input->post('nick_rejestracja');
		if($email != null && $haslo != null && $nick != null){
			$kod = rand(1000,9999);
			if($this->baza->rejestruj($email,$haslo,$kod,$nick)){
				//pomyslnie wklepano do bazy
				//przeslij wiadomosc z kodem na email uzytkownika
			}
		}
	}
	
	public function aktywacja($par1,$par2){
		if($this->baza->aktywuj($par1,$par2)){
			echo 'aktywacja pomyślna';
		}else{
			echo 'aktywacja niepomyślna';
		}
	}
}