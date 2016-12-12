<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Opinie extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('baza');
	}
	
	public function index(){
		//ranking top 10 uzytkowników na podstawie œredniej
		//dla ka¿dego u¿ytkownika wyœwietla 3 ostatnie opinie wraz z ocen¹
		$lista = $this->baza->top_10();
		foreach($lista as $x){
			$oceny = $this->baza->pokaz_oceny_usera($x->uzytkownik_id);
			$x->najnowsze = array();
			for($i = 0; $i < 3; $i++){
				if(count($oceny)>$i){
					$x->najnowsze[$i] = $oceny[$i]->komentarz.' '.$oceny[$i]->ocena.'/6';
				}
			}
		}
		//var_dump($lista);
		//w widoku dodaj dla kazdego usera odnosnik do wszystkich opini
	}
	
	public function dla($index_osoby){
		//oceny osoby uporz¹dkowane wed³ug daty malejaco
		$oceny = pokaz_oceny_usera($index_osoby);
		//w widoku dodaj odnosniki do zlecenia
	}
}