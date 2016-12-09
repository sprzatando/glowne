<?php
class Baza extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	//konto uzytkownika
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
	
	//zlecenie
	public function czy_zlecenie_istnieje($id){
		$zapytanie = $this->db->get_where('zlecenie',array('id_zlecenie'=>$id));
		$zwrot = $zapytanie->result();
		if(count($zwrot) > 0){
			return $zwrot;
		}else{
			return false;
		}
	}
	
	public function dodaj_zlecenie($dane){
		$this->db->insert('zlecenie',$dane);
	}
	
	public function zlecenia_aktualne($data,$czas,$id=-1,$porzadek=0,$filtr = -1){
		$aktualne = '(data > "'.$data.'" OR (data = "'.$data.'" AND godzina > "'.$czas.'"))';
		$this->db->where($aktualne);
		if($id != -1){
			$this->db->where('id_zlecenie',$id);	
		}
		if($filtr != -1){
			$this->db->like('pokoje_i_prace',$filtr);
		}
		//0-domyslne,1-cena malejaco,2-cena rosnaco
		if($porzadek == 0){
			$this->db->order_by('id_zlecenie','DESC');
		}else if($porzadek == 1){
			$this->db->order_by('cena','DESC');
		}else if($porzadek == 2){
			$this->db->order_by('cena','ASC');
		}
		
		$zapytanie = $this->db->get('zlecenie');
		return $zapytanie->result();
	}
	
	public function podaj_email($user_id){
		return $this->db->get_where('uzytkownik',array('id_uzytkownik'=>$user_id))->result()[0]->email;
	}
	
	//zgloszenia
	
	public function czy_juz_zgloszono($id_zlecenie,$id_zglaszajacy){
		$zapytanie = $this->db->get_where('zgloszenie',array('zlecenie_id'=>$id_zlecenie,'zglaszajacy_id'=>$id_zglaszajacy));
		$zwrot = $zapytanie->result();
		if(count($zwrot)>0){
			//już zgłoszono się do tego zlecenia
			return true;
		}
		return false;
	}
	public function dodaj_zgloszenie($id_zlecenie,$id_zglaszajacy){
		if(czy_juz_zgloszono($id_zlecenie,$id_zglaszajacy)){
			return false;
		}
		$teraz = date('Y-m-d H:i:s');
		$dane = array(
			'zlecenie_id'=>$id_zlecenie,
			'zglaszajacy_id'=>$id_zglaszajacy,
			'czas'=>$teraz
		);
		$this->db->insert('zgloszeni',$dane);
		return true;
	}
	
	public function lista_zgloszen($id_zlecenia){
		$this->db->join('uzytkownik','id_uzytkownik = zglaszajacy_id');
		$this->db->where('zlecenie_id',$id_zlecenia);
		$this->db->order_by('czas','ASC');
		$zapytanie = $this->db->get('zgloszenie');
		$zwrot = $zapytanie->result();
		return $zwrot;
	}
	
	public function wybierz_zwyciezce($zlecenie_id,$zgloszenie_id){
		$dane = array(
			'zlecenie_id'=>$zlecenie_id,
			'zgloszenie_id'=>$zgloszenie_id,
			'status'=>0
		);
		$this->db->insert('zwyciezca',$dane);
	}
	
	public function dane_zwyciezcy($zlecenie_id){
		$zapytanie = $this->db->get_where('zwyciezca',array('zlecenie_id'=>$zlecenie_id));
		return $zapytanie->result();
	}
	
	public function potwierdz_podjecie($zlecenie_id){
		$this->db->set('status',1);
		$this->db->where('zlecenie_id',$zlecenie_id);
		$this->db->update('zwyciezca');
	}
	
	public function potwierdz_wykonanie($zlecenie_id){
		$this->db->set('status',2);
		$this->db->where('zlecenie_id',$zlecenie_id);
		$this->db->update('zwyciezca');
	}
	
	//ocena
	
	public function ocen($zlecenie_id,$uzytkownik_id,$ocena,$komentarz){
		$dane = array(
			'zlecenie_id'=>$zlecenie_id,
			'uzytkownik_id'=>$uzytkownik_id,
			'ocena'=>$ocena,
			'komentarz'=>$komentarz
		);
		$this->db->insert('ocena',$dane);
	}
	
	public function pokaz_oceny_usera($user_id){
		return $this->get_where('ocena',array('uzytkownik_id'=>$user_id))->result();
	}
	
	//dodawanie zleceń
	public function prace(){
		$zapytanie = $this->db->query('SELECT id_pokoj, id_praca, pokoj.nazwa as "pokoj", praca.nazwa as "praca" FROM praca_pokoj JOIN praca ON praca_id = id_praca JOIN pokoj ON pokoj_id = id_pokoj ORDER BY id_pokoj, id_praca');
		$zwrot = $zapytanie->result();
		return $zwrot;
	}
	
	public function pokoje(){
		$zapytanie = $this->db->get('pokoj');
		return $zapytanie->result();
	}
	
	public function praceDla($pokojId){
		$zapytanie = $this->db->get_where('praca_pokoj',array('pokoj_id'=>$pokojId));
		return $zapytanie->result();
	}
}