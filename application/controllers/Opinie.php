﻿<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opinie extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('baza');
		$this->load->helper('html');
		$this->load->helper('url');
	}
	
	public function index(){
		//ranking top 10 uzytkowników na podstawie średniej
		//dla każdego użytkownika wyświetla 3 ostatnie opinie wraz z oceną
		$lista = $this->baza->top_10();
		foreach($lista as $x){
			$zwrot = $this->baza->pokaz_oceny_usera($x->uzytkownik_id);
			$oceny = $zwrot->oceny;
			$x->najnowsze = array();
			for($i = 0; $i < 3; $i++){
				if(count($oceny)>$i){
					$x->najnowsze[$i] = new stdClass;
					$x->najnowsze[$i]->ocena = $oceny[$i]->ocena;
					$x->najnowsze[$i]->komentarz = $oceny[$i]->komentarz;
				}
			}
		}
		$this->load->view("naglowek",array('tytul'=>'TOP 10'));
		$this->load->view('opinie/top10',array('lista'=>$lista));
		//w widoku dodaj dla kazdego usera odnosnik do wszystkich opini
	}
	
	public function dla($index_osoby){
		//oceny osoby uporządkowane według daty malejaco
		$zwrot = $this->baza->pokaz_oceny_usera($index_osoby);
		$this->load->view("naglowek",array('tytul'=>'OCENY'));
		$this->load->view('opinie/dlausera',array('zwrot'=>$zwrot));
		//w widoku dodaj odnosniki do zlecenia
	}
}