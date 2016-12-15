<?php
class Baza extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	//konto uzytkownika
	public function walidacja_rejestracji($email,$nick){
		$odpowiedz = "";
		$zapytanie = $this->db->get_where('rejestracja',array('email'=>$email));
		$zwrot = $zapytanie->result();
		if(count($zwrot) != 0){
			$odpowiedz .= 'Już rejestrowano się na podany email';
		}
		$zapytanie = $this->db->get_where('uzytkownik',array('email'=>$email));
		$zwrot = $zapytanie->result();
		if(count($zwrot) != 0){
			if($odpowiedz != ""){
				$odpowiedz .= '|';
			}
			$odpowiedz .= 'Już istnieje użytkownik o podanym emailu';
		}
		$zapytanie = $this->db->get_where('rejestracja',array('nick'=>$nick));
		$zwrot = $zapytanie->result();
		if(count($zwrot) != 0){
			if($odpowiedz != ""){
				$odpowiedz .= '|';
			}
			$odpowiedz .= 'Ktoś już zarejestrował się na podany nick';
		}
		$zapytanie = $this->db->get_where('uzytkownik',array('nick'=>$nick));
		$zwrot = $zapytanie->result();
		if(count($zwrot) != 0){
			if($odpowiedz != ""){
				$odpowiedz .= '|';
			}
			$odpowiedz .= 'Już istnieje użytkownik o podanym nicku';
		}
		if($odpowiedz != ""){
			return $odpowiedz;
		}else{
			return true;
		}
	}
	
	public function wolne_id(){
		$this->db->select('id_rejestracja');
		$this->db->from('rejestracja');
		$this->db->order_by('id_rejestracja','DESC');
		$this->db->limit('1');
		$x = $this->db->get()->result();
		if(count($x)==0){
			return 1;
		}else{
			$x = $x[0]->id_rejestracja;
			$x++;
			return $x;
		}
	}
	
	public function rejestruj($id,$email,$haslo,$kod,$nick){
		$dane = array(
			'id_rejestracja'=>$id,
			'email'=>$email,
			'haslo'=>$haslo,
			'nick'=>$nick,
			'kod_aktywacyjny'=>$kod,
			'data_rejestracji'=>date('Y-m-d')
		);
		$this->db->insert('rejestracja',$dane);
		return $this->db->insert_id();
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
	
	public function zmien_haslo($email,$nowehaslo){
		$this->db->where('email',$email);
		$this->db->update('uzytkownik',array('haslo'=>$nowehaslo));
	}
	
	public function daj_nick($user_id){
		$this->db->select('nick');
		$this->db->where('id_uzytkownik',$user_id);
		$x = $this->db->get('uzytkownik')->result();
		return $x[0]->nick;
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
	
	public function czy_zlecenie_aktualne($id_zlecenie,$data,$czas){
		$aktualne = '(data > "'.$data.'" OR (data = "'.$data.'" AND godzina > "'.$czas.'"))';
		$this->db->where($aktualne);
		$this->db->where('id_zlecenie',$id_zlecenie);
		$zwrot = $this->db->get('zlecenie')->result();
		if(count($zwrot)>0){
			return true;
		}else{
			return false;
		}
	}
	
	public function zlecenia_aktualne($data,$czas,$user_id,$porzadek,$filtr){
	//public function zlecenia_aktualne($data,$czas,$porzadek=0,$filtr = -1){
		$this->db->select('id_zlecenie,miejsce,data,godzina,cena,nick,id_zwyciezca');
		$this->db->from('zlecenie');
		$this->db->join('uzytkownik','id_uzytkownik = zlecajacy_id');
		if($user_id != null){
			$this->db->join('zgloszenie','zglaszajacy_id = '.$user_id.' AND zgloszenie.zlecenie_id = id_zlecenie','left');
		}
		$this->db->join('zwyciezca','id_zlecenie = zwyciezca.zlecenie_id','left');
		$aktualne = '(data > "'.$data.'" OR (data = "'.$data.'" AND godzina > "'.$czas.'"))';
		$this->db->where($aktualne);
		$this->db->where('id_zwyciezca is NULL');
		
		if($filtr != "%"){
			$this->db->where('pokoje_i_prace LIKE "'.$filtr.'"');
		}
		//0-domyslne,1-cena malejaco,2-cena rosnaco
		if($porzadek == null){
			$this->db->order_by('id_zlecenie','DESC');
		}else if($porzadek == 1){
			$this->db->order_by('cena','DESC');
		}else if($porzadek == 2){
			$this->db->order_by('cena','ASC');
		}
		if($user_id != null){
			$this->db->where('zlecajacy_id !=',$user_id);
			$this->db->where('zglaszajacy_id IS NULL');
		}
		$x = $this->db->get()->result();
		return $x;
	}
	
	public function podaj_email($user_id){
		$x = $this->db->get_where('uzytkownik',array('id_uzytkownik'=>$user_id))->result();
		return $x[0]->email;
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
		$teraz = date('Y-m-d H:i:s');
		$dane = array(
			'zlecenie_id'=>$id_zlecenie,
			'zglaszajacy_id'=>$id_zglaszajacy,
			'czas'=>$teraz
		);
		$this->db->insert('zgloszenie',$dane);
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
	
	public function czy_wygrales_zlecenie($zlecenie_id,$user_id){
		$x = $this->db->query('SELECT * FROM zwyciezca JOIN zgloszenie ON zgloszenie_id = id_zgloszenie WHERE zwyciezca.zlecenie_id = '.$zlecenie_id.' AND zglaszajacy_id = '.$user_id.';')->result();
		if(count($x)>0){
			return true;
		}else{
			return false;
		}
	}
	
	public function dane_zwyciezcy($zlecenie_id){
		return $this->db->query('SELECT * FROM zwyciezca JOIN zgloszenie ON zgloszenie_id = id_zgloszenie WHERE zwyciezca.zlecenie_id = '.$zlecenie_id.';')->result();
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
	
	//panel uzytkownika
	
	public function aktualne_zgloszenia($user_id){
		$data = date('Y-m-d');
		$czas = date('H:i:s');
		$aktualne = '(data > "'.$data.'" OR (data = "'.$data.'" AND godzina > "'.$czas.'"))';
		$this->db->from('zgloszenie');
		$this->db->join('zlecenie','zlecenie_id = id_zlecenie');
		$this->db->join('zwyciezca','zgloszenie_id = id_zgloszenie','left');
		$this->db->where('zglaszajacy_id',$user_id);
		$this->db->where($aktualne);
		$this->db->order_by('status','DESC');
		$this->db->order_by('data','DESC');
		$this->db->order_by('czas','DESC');
		return $this->db->get()->result();
	}
	
	public function moje_zlecenia($user_id){
		$this->db->select('id_zlecenie,zlecajacy_id,miejsce,zlecenie.data,godzina,cena,ocena,komentarz,nick');
		$this->db->from('zlecenie');
		$this->db->join('zwyciezca','id_zlecenie = zwyciezca.zlecenie_id','left');
		$this->db->join('zgloszenie','id_zgloszenie = zwyciezca.zgloszenie_id','left');
		$this->db->join('ocena','id_zlecenie = ocena.zlecenie_id','left');
		$this->db->join('uzytkownik','id_uzytkownik = zgloszenie.zglaszajacy_id','left');
		$this->db->where('zlecajacy_id',$user_id);
		$this->db->order_by('zlecenie.data DESC,godzina DESC');
		$x = $this->db->get()->result();
		//var_dump($this->db->last_query());
		return $x;
	}
	
	//ocena
	
	public function ocen($zlecenie_id,$uzytkownik_id,$ocena,$komentarz){
		$dane = array(
			'zlecenie_id'=>$zlecenie_id,
			'uzytkownik_id'=>$uzytkownik_id,
			'ocena'=>$ocena,
			'komentarz'=>$komentarz,
			'data'=>date("Y-m-d")
		);
		$this->db->insert('ocena',$dane);
		
		$this->db->set('status',3);
		$this->db->where('zlecenie_id',$zlecenie_id);
		$this->db->update('zwyciezca');
	}
	
	public function pokaz_oceny_usera($user_id){
		$this->db->where('uzytkownik_id',$user_id);
		$this->db->order_by('data','DESC');
		$oceny = $this->db->get('ocena')->result();
		$this->db->select_avg('ocena');
		$this->db->where('uzytkownik_id',$user_id);
		$srednia = $this->db->get('ocena')->result();
		$zwrot = new stdClass;
		$zwrot->oceny = $oceny;
		$zwrot->srednia = $srednia[0]->ocena;
		$this->db->select('nick');
		$this->db->from('uzytkownik');
		$this->db->where('id_uzytkownik',$user_id);
		$nick = $this->db->get()->result();
		$zwrot->nick = $nick[0]->nick;
		return $zwrot;
	}
	
	public function top_10(){
		return $this->db->query('SELECT uzytkownik_id, nick, avg(ocena) as "srednia" FROM ocena LEFT JOIN uzytkownik ON id_uzytkownik = uzytkownik_id GROUP BY uzytkownik_id ORDER BY srednia DESC LIMIT 10')->result();
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