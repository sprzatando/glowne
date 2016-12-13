<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uzytkownik extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('baza');
		$this->load->helper('html');
		$this->load->helper('url');
	}
	
	public function index(){
		//dwie kolumny
		$user = $this->session->zalogowany;
		if($user != null){
			$moje_zgloszenia = $this->baza->aktualne_zgloszenia($user);
			$moje_opinie = $this->baza->pokaz_oceny_usera($user);
			$this->load->view("naglowek",array('tytul'=>'PANEL'));
			$this->load->view('uzytkownik/panel',array('zgloszenia'=>$moje_zgloszenia,'opinie'=>$moje_opinie));
		}else{
			$this->load->view('blad',array('komunikat'=>'Tylko dla zalogowanych!'));
		}
		//lewa to aktualnosci dotyczace zg³oszeñ
		//prawa to krótka lista ostatnich opinii
	}
	
	public function mojezlecenia(){
		$user = $this->session->zalogowany;
		if($user != null){
			$moje_zlecenia = $this->baza->moje_zlecenia($user);
			//var_dump($moje_zlecenia);
			$this->load->view("naglowek",array('tytul'=>'MOJE ZLECENIA'));
			$this->load->view('uzytkownik/mojezlecenia',array('zlecenia'=>$moje_zlecenia));
		}else{
			$this->load->view('blad',array('komunikat'=>'Tylko dla zalogowanych!'));
		}
		//historia zlecen wraz z osobami, ktore je wykonaly
		//pierwsze w kolejnosci beda zlecenia aktualne
		// w widoku dodac odnosnik do zlecenia
	}
}