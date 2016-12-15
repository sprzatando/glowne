<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rejestracja extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->model('baza');
	}
	public function index(){
		$email = $this->input->post('email_rejestracja');
		$haslo = $this->input->post('haslo_rejestracja');
		$rep_haslo = $this->input->post('rep_haslo_rejestracja');
		$nick = $this->input->post('nick_rejestracja');
		if($email != null && $haslo != null && $rep_haslo != null && $nick != null){
			if($haslo == $rep_haslo){
				$podobnehaslo = true;
			}else{
				$podobnehaslo = false;
			}
			$odp = $this->baza->walidacja_rejestracji($email,$nick);
			if($odp === true && $podobnehaslo === true){
				$kod = rand(1000,9999);
				$id_rejestracji = $this->baza->wolne_id();
				$link = site_url('rejestracja/aktywacja/'.$id_rejestracji.'/'.$kod);
				$temat='REJESTRACJA W SPRZATANDO';
				$wiadomosc='Witaj!<br/>Aby aktywować konto użyj <a href="'.$link.'">tego linku</a>';
				$naglowki='From: sprzatando@onet.pl' . "\r\n" .
				'MIME-Version: 1.0' . "\r\n" .
				'Content-type: text/html; charset=utf-8';
				if(mail($email,$temat,$wiadomosc,$naglowki)){
					$this->baza->rejestruj($id_rejestracji,$email,$haslo,$kod,$nick);
					$this->load->view("naglowek",array('tytul'=>'REJESTRACJA'));
					$this->load->view("rejestracja/rejestracja",array('email'=>$email));
				}else{
					$this->load->view('blad',array('komunikat'=>'Wystąpił problem z wysłaniem linku aktywacyjnego!'));
				}
			}else{
				$this->load->view("naglowek",array('tytul'=>'REJESTRACJA'));
				$this->load->view("rejestracja/rejestracja",array('bledy'=>$odp,'hasla'=>$podobnehaslo));
			}
		}else{
			$this->load->view("naglowek",array('tytul'=>'REJESTRACJA'));
			$this->load->view("rejestracja/rejestracja");
		}
	}
	
	public function aktywacja($par1,$par2){
		if($this->baza->aktywuj($par1,$par2)){
			$this->load->view("naglowek",array('tytul'=>'AKTYWACJA'));
			$this->load->view("rejestracja/aktywacja");
		}else{
			$this->load->view('blad',array('komunikat'=>'Podany link aktywacyjny jest niepoprawny lub został już użyty'));
		}
	}
}