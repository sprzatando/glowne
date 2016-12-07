<?php
class Baza extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('date');
	}
	
	public function rejestruj($email,$haslo,$kod){
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
			'kod_aktywacyjny'=>$kod,
			'data_rejestracji'=>date('Y-m-d')
		);
		$this->db->insert('rejestracja',$dane);
		return true;
	}
}