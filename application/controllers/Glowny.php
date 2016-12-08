<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Glowny extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->library('session');
		$this->load->model('baza');
	}
	public function index(){
		if(!$this->session->has_userdata('zalogowany')){
			$this->load->view("naglowek",array('tytul'=>'STRONA LOGOWANIA'));
			$this->load->view("logowanie");
		}else{
			$this->load->view("naglowek",array('tytul'=>'STRONA GLÓWNA'));
			//strona z ofertami
		}
	}
	
	public function zaloguj(){
		if(!$this->session->has_userdata('zalogowany')){
			$email = $this->input->post('email_logowanie');
			$haslo = $this->input->post('haslo_logowanie');
			if($email != null && $haslo != null){
				$zwrot = $this->baza->loguj($email,$haslo);
				var_dump($zwrot);
				if($zwrot != false){
					$this->session->set_userdata('zalogowany',$zwrot->id_uzytkownik);
					//echo 'zalogowano jako '.$zwrot->nick;
				}
			}
		}else{
			//echo 'nie mozesz sie zalogowac po raz drugi';
		}
	}
	
	public function wyloguj(){
		if($this->session->has_userdata('zalogowany')){
			$this->session->unset_userdata('zalogowany');
			//echo 'wylogowano pomyślnie';
		}
	}
	
	public function przypomnij(){
		$email = $this->input->post('email_przypominajka');
		if($email != null){
			if($this->baza->przypominajka($email)){
				//przypominajka na 10 minut
				$kod = rand(1000,9999);
				$this->session->set_tempdata('email',$email,600);
				$this->session->set_tempdata('przypominajka',$kod,600);
				//wyslij link do zmiany hasla na podany email
			}else{
				//echo 'nie ma takiego maila w bazie';//brak podanego maila w bazie
			}
		}
		$this->load->view("naglowek",array('tytul'=>'PRZYPOMNIJ HASŁO'));
		$this->load->view("przypominajka");
	}
	
	public function linkhaslo($kod){
		if($this->session->has_userdata('email') && $this->session->has_userdata('przypominajka')){
			if($this->session->przypominajka == $kod){
				$this->session->set_tempdata('kodzlinku',$kod,600);
				//echo 'daj formularz do zmiany hasla';
				//dodac widok z formularzem zmiany hasła
			}
		}
	}
	
	public function zmianahasla(){
		if($this->session->has_userdata('email') && $this->session->has_userdata('przypominajka') && $this->session->has_userdata('kodzlinku')){
			if($this->session->przypominajka == $this->session->kodzlinku){
				$nowehaslo = $this->input->post('nowehaslo');
				$this->baza->zmien_haslo($this->session->email,$nowehaslo);
			}
		}
	}
}