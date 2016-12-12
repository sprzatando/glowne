<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uzytkownik extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('baza');
	}
	
	public function index(){
		//dwie kolumny
		//lewa to aktualnosci dotyczace zg³oszeñ
		//prawa to krótka lista ostatnich opinii
	}
	
	public function mojezlecenia(){
		//historia zlecen wraz z osobami, ktore je wykonaly
		//pierwsze w kolejnosci beda zlecenia aktualne
		// w widoku dodac odnosnik do zlecenia
	}
	
	public function mojeprace(){
		//historia prac
		//w pierwszej kolejnosci prace niezakonczone
		// w widoku dodac odnosnik do zlecenia
	}
}