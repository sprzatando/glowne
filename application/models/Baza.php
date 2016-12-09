<?php
class Baza extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('date');
	}
	
	public function rejestruj($email,$haslo,$kod,$nick){
		//dodac weryfikacje nicku
		$zapytanie = $this->db->get_where('rejestracja',array('email'=>$email));
		$zwrot = $zapytanie->result();
		if(count($zwrot) != 0){
			return false;
		}else{
			$zapytanie = $this->db->get_where('uzytkownik',array('email'=>$email));
			$zwrot = $zapytanie->result();
			if(count($zwrot) != 0){
				return false;
			}
		}
		
		$dane = array(
			'email'=>$email,
			'haslo'=>$haslo,
			'nick'=>$nick,
			'kod_aktywacyjny'=>$kod,
			'data_rejestracji'=>date('Y-m-d')
		);
		$this->db->insert('rejestracja',$dane);
		return true;
	}
	
	public function loguj($email,$haslo){
		$zapytanie = $this->db->get_where('uzytkownik',array('email'=>$email,'haslo'=>$haslo));
		$zwrot = $zapytanie->result();
		if(count($zwrot)>0){
			return $zwrot[0];
		}else{
			return false;
		}
	}
	
	public function aktywuj($id,$kod){
		$zapytanie = $this->db->get_where('rejestracja',array('id_rejestracja'=>$id,'kod_aktywacyjny'=>$kod));
		$zwrot = $zapytanie->result();
		if(count($zwrot) > 0){
			$id_rej = $zwrot[0]->id_rejestracja;
			$dane = array(
				'email'=>$zwrot[0]->email,
				'haslo'=>$zwrot[0]->haslo,
				'nick'=>$zwrot[0]->nick,
				'data_rejestracji'=>date('Y-m-d')
			);
			$this->db->insert('uzytkownik',$dane);
			$this->db->delete('rejestracja',array('id_rejestracja'=>$id_rej));
			return true;
		}else{
			return false;
		}
	}
	
	public function przypominajka($email){
		$zapytanie = $this->db->get_where('uzytkownik',array('email'=>$email));
		$zwrot = $zapytanie->result();
		if(count($zwrot) > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function zmienhaslo($email,$nowehaslo){
		$this->db->where('email',$email);
		$this->db->update('uzytkownik',array('haslo'=>$nowehaslo));
	}
	
	public function prace(){
		$zapytanie = $this->db->query('SELECT pokoj.nazwa as "pokoj", praca.nazwa as "praca" FROM praca_pokoj JOIN praca ON praca_id = id_praca JOIN pokoj ON pokoj_id = id_pokoj ORDER BY id_pokoj, id_praca');
		$zwrot = $zapytanie->result();
		return $zwrot;
	}
}