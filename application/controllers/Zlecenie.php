<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zlecenie extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->model('baza');
	}
	
	public function index($id){
		//opcja tylko dla zalogowanych
		//if($this->session->has_userdata('zalogowany')){
			//sprawdz czy zlecenie istnieje
			if($dane = $this->baza->czy_zlecenie_istnieje($id)){
				$aktualna_data = date('Y-m-d');
				$aktualna_godzina = date('H:i');
				$zwrot = $this->baza->zlecenia_aktualne($aktualna_data,$aktualna_godzina,$id);
				if(count($zwrot)>0){
					//zlecenie aktualne
					$user = $this->session->zalogowany;
					if($zwrot[0]->zlecajacy_id != $user){
						if(!$this->db->czy_juz_zgloszono($id,$user)){
							$zgloszenie = $this->input->post('zlecenie_zgloszenie');
							if($zgloszenie != null){
								$this->baza->dodaj_zgloszenie($id,$user);
							}
						}else{
							//już zgłoszono się do tego zlecenia
							
							//potwierdzenie pracy
							$dane_zwyciezcy = $this->baza->dane_zwyciezcy($id)
							if(count($dane_zwyciezcy)>0){
								$status = $dane_zwyciezcy[0]->status;
								if($status == 0){
									$podjecie = $this->input->post('zlecenie_podjecie');
									if($podjecie != null){
										potwierdz_podjecie($id);
									}
								}
							}
						}
					}else{
						//zalogowany jest zlecajacym
						$dane_zwyciezcy = $this->baza->dane_zwyciezcy($id);
						if(count($dane_zwyciezcy)>0){
							//sprawdz status zgłoszenia
							$status = $dane_zwyciezcy[0]->status;
							if($status == 1){
								$wykonane = $this->input->post('zlecenie_wykonane');
								$if($wykonane != null){
									//potwierdź wykonanie
									$this->baza->potwierdz_wykonanie($id);
								}else{
									
								}
							}else if($status == 2){
								//daj możliwosć oceny
							}
						}else{
							//wyświetl listę zgłoszeń
							$zgloszenia = $this->db->lista_zgloszen($id);
							var($zgloszenia);
						}
					}
				}else{
					//zlecenie jest przestarzale
				}
			}else{
				//echo 'nie ma takiego zlecenia';
			}
		//}else{
			//musisz się zalogować
		//}
	}
	
	public function nowe(){
		//if($this->session->has_userdata('zalogowany')){
			$miejsce = $this->input->post('zlecenie_miejsce');
			if($miejsce != null){
				//sprawdz dane i wpisz do bazy
				var_dump($_POST);
				$zlecajacy = $this->session->zalogowany;
				//$data = $this->input->post(')
				
				//sparsuj prace do wykonania
				$sparsowany = "";
				$pokoje = $this->baza->pokoje();
				foreach($pokoje as $x){
					$nazwa = 'zlecenie_'.$x->id_pokoj;
					$a = $this->input->post($nazwa);
					if($a != null){
						$prace = $this->baza->praceDla($x->id_pokoj);
						foreach($prace as $y){
							$nazwa2 = 'zlecenie_'.$y->pokoj_id.'_'.$y->praca_id;
							$b = $this->input->post($nazwa2);
							if($b != null){
								if($sparsowany != ""){
									$sparsowany .= '|';
								}
								$sparsowany .= $y->pokoj_id.'_'.$y->praca_id;
							}
						}
					}
				}
				$dane = array(
					'miejsce'=>$this->input->post('zlecenie_miejsce'),
					'data'=>$this->input->post('zlecenie_data'),
					'godzina'=>$this->input->post('zlecenie_godzina'),
					'telefon'=>$this->input->post('zlecenie_telefon'),
					'mail_kontaktowy'=>$this->input->post('zlecenie_email'),
					'cena'=>$this->input->post('zlecenie_cena'),
					'pokoje_i_prace'=>$sparsowany
				);
				$this->baza->dodaj_zlecenie($dane);
			}else{
				$this->load->view('naglowek',array('tytul'=>'NOWE ZLECENIE'));
				$prace = $this->baza->prace();
				//var_dump($prace);
				$email = $this->baza->podaj_email(this->session->zalogowany);
				$this->load->view('nowezlecenie',array('prace'=>$prace,'email'=>$email));
				//podaj formularz
			}
		//}else{
			//opcja tylko dla zalogowanych
		//}
	}
}