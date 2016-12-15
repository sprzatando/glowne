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
		if($this->session->has_userdata('zalogowany')){
			$zalogowany = true;
		}else{
			$zalogowany = false;
		}
		$user_id = $this->session->zalogowany;
		$porzadek = $this->input->post("lista_porzadek");
		$filtr = "";
		$pp = "";
		$pokoje = $this->baza->pokoje();
		foreach($pokoje as $x){
			$nazwa = 'lista_'.$x->id_pokoj;
			$a = $this->input->post($nazwa);
			if($a != null){
				$ile_prac=0;
				$prace = $this->baza->praceDla($x->id_pokoj);
				foreach($prace as $y){
					$nazwa2 = 'lista_'.$y->pokoj_id.'_'.$y->praca_id;
					$b = $this->input->post($nazwa2);
					if($b != null){
						$ile_prac++;
						$filtr .= '%'.$y->pokoj_id.'\_'.$y->praca_id;
						$pp .= '|'.$y->pokoj_id.'_'.$y->praca_id;
					}
				}
				if($ile_prac == 0){
					$filtr .= '%'.$x->id_pokoj.'\_';
					$pp .= '|'.$x->id_pokoj.'_';
				}
			}
		}
		$filtr .= '%';
		$aktualna_data = date('Y-m-d');
		$aktualna_godzina = date('H:i');
		$zlecenia = $this->baza->zlecenia_aktualne($aktualna_data,$aktualna_godzina,$user_id,$porzadek,$filtr);
		$prace = $this->baza->prace();
		$this->load->view("naglowek",array('tytul'=>'SPRZĄTANDO - ZLECENIA'));
		$this->load->view('glowny/glowna',array('zalogowany'=>$zalogowany,'porzadek'=>$porzadek,'sparsowany'=>$pp,'zlecenia'=>$zlecenia,'prace'=>$prace));
	}
	
	public function zaloguj(){
		if(!$this->session->has_userdata('zalogowany')){
			$email = $this->input->post('email_logowanie');
			$haslo = $this->input->post('haslo_logowanie');
			if($email != null && $haslo != null){
				$zwrot = $this->baza->loguj($email,$haslo);
				if($zwrot != false){
					$this->session->set_userdata('zalogowany',$zwrot->id_uzytkownik);
					redirect('glowny');
				}
				$this->load->view("naglowek",array('tytul'=>'SPRZATANDO - LOGOWANIE'));
				$this->load->view("glowny/logowanie",array('zledane'=>true));
			}else{
				//formularz logowania			
				$this->load->view("naglowek",array('tytul'=>'SPRZATANDO - LOGOWANIE'));
				$this->load->view("glowny/logowanie");
			}
		}else{
			redirect('glowny');
		}
	}
	
	public function wyloguj(){
		if($this->session->has_userdata('zalogowany')){
			$this->session->unset_userdata('zalogowany');
		}
		redirect('glowny');
	}
	
	public function przypomnij(){
		$email = $this->input->post('email_przypominajka');
		if($email != null){
			if($this->baza->przypominajka($email)){
				//przypominajka na 10 minut
				$kod = rand(1000,9999);
				$this->session->set_tempdata('email',$email,600);
				$this->session->set_tempdata('przypominajka',$kod,600);
				$link = site_url('glowny/linkhaslo').'/'.$kod;
				$temat='SPRZATANDO - RESET HASLA';
				$wiadomosc='Witaj!<br/>Aby zresetować hasło użyj <a href="'.$link.'">tego linku</a>';
				$naglowki='From:sprzatando@onet.pl' . "\r\n" .
				'MIME-Version: 1.0' . "\r\n" .
				'Content-type: text/html; charset=utf-8';
				if(mail($email,$temat,$wiadomosc,$naglowki)){
					$this->load->view("naglowek",array('tytul'=>'PRZYPOMNIJ HASLO'));
					$this->load->view('glowny/przypominajka',array('email'=>$email));
				}else{
					$this->load->view('blad',array('komunikat'=>'Wystąpił problem z wysłaniem linku do resetu hasła!'));
				}
			}else{
				$this->load->view('blad',array('komunikat'=>'Nie ma takiego e-maila w bazie'));
			}
		}else{
			$this->load->view("naglowek",array('tytul'=>'PRZYPOMNIJ HASLO'));
			$this->load->view("glowny/przypominajka");
		}
	}
	
	public function linkhaslo($kod){
		if($this->session->has_userdata('email') && $this->session->has_userdata('przypominajka')){
			if($this->session->przypominajka == $kod){
				$this->session->set_tempdata('kodzlinku',$kod,600);
				$this->load->view('naglowek',array('tytul'=>'ZMIANA HASŁA'));
				$this->load->view('glowny/zmianahasla');
			}else{
				$this->load->view('blad',array('komunikat'=>'Najprawdopodobniej link do zmiany hasła wygasnął<br/>Spróbuj ponownie'));
			}
		}else{
			$this->load->view('blad',array('komunikat'=>'Najprawdopodobniej link do zmiany hasła wygasnął<br/>Spróbuj ponownie'));
		}
	}
	
	public function zmianahasla(){
		if($this->session->has_userdata('email') && $this->session->has_userdata('przypominajka') && $this->session->has_userdata('kodzlinku')){
			if($this->session->przypominajka == $this->session->kodzlinku){
				$nowehaslo = $this->input->post('nowehaslo');
				$repnowehaslo = $this->input->post('repnowehaslo');
				if($nowehaslo == $repnowehaslo){
					$this->baza->zmien_haslo($this->session->email,$nowehaslo);
					$this->session->unset_userdata('email');
					$this->session->unset_userdata('przypominajka');
					$this->session->unset_userdata('kodzlinku');
					$this->load->view('naglowek',array('tytul'=>'ZMIANA HASŁA'));
					$this->load->view('glowny/zmianahasla',array('zmieniono'=>true));
				}else{
					$this->load->view('naglowek',array('tytul'=>'ZMIANA HASŁA'));
					$this->load->view('glowny/zmianahasla',array('zmieniono'=>false));
				}
			}else{
				$this->load->view('blad',array('komunikat'=>'Najprawdopodobniej link do zmiany hasła wygasnął<br/>Spróbuj ponownie'));
			}
		}else{
			$this->load->view('blad',array('komunikat'=>'Najprawdopodobniej link do zmiany hasła wygasnął<br/>Spróbuj ponownie'));
		}
	}
}