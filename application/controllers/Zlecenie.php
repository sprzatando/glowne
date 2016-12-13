<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zlecenie extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('session');
		$this->load->model('baza');
	}
	
	public function index($id){
		//sprawdz czy zlecenie istnieje
		$po_prostu_pokaz = true;
		$user = $this->session->zalogowany;
		if($dane = $this->baza->czy_zlecenie_istnieje($id)){
			$dane[0]->nick = $this->baza->daj_nick($dane[0]->zlecajacy_id);
			$prace = $this->baza->prace();
			$aktualna_data = date('Y-m-d');
			$aktualna_godzina = date('H:i');
			if($this->baza->czy_zlecenie_aktualne($id,$aktualna_data,$aktualna_godzina)){
				//zlecenie aktualne
				if($user != null){
					if($dane[0]->zlecajacy_id != $user){
						//nie jesteś zlecającym
						$zwyciezca = $this->baza->dane_zwyciezcy($id);
						if(count($zwyciezca)==0){
							//jeszcze nie wybrano zwycięzcy
							if(!$this->baza->czy_juz_zgloszono($id,$user)){
								//nie zgłosiłeś się jeszcze
								$po_prostu_pokaz = false;
								$zgloszenie = $this->input->post('zlecenie_zgloszenie');
								if($zgloszenie != null){
									//wyświetl komunikat informujący o poprawnym zgłoszeniu się
									$this->baza->dodaj_zgloszenie($id,$user);
									$this->load->view("naglowek",array('tytul'=>'ZLECENIE'));
									$this->load->view('zlecenie/zlecenie',array('dane'=>$dane,'prace'=>$prace,'zglos_sie'=>1));
								}else{
									//wyswietl widok z możliwością zgłoszenia się do niego
									//aktualne - true,jestes_zlecajacym=false,zgloszono_sie=false
									$this->load->view("naglowek",array('tytul'=>'ZLECENIE'));
									$this->load->view('zlecenie/zlecenie',array('dane'=>$dane,'prace'=>$prace,'zglos_sie'=>0));
								}
							}
						}else{
							//wybrano zwycięzcę
							if($this->baza->czy_juz_zgloszono($id,$user)){
								//zgłoszono się
								if($this->baza->czy_wygrales_zlecenie($id,$user)){
									//jesteś zwycięzcą
									
									$status = $zwyciezca[0]->status;
									if($status == 0){
										//zostałeś wybrany przez zlecającego
										$po_prostu_pokaz = false;
										$this->load->view("naglowek",array('tytul'=>'ZLECENIE'));
										$podjecie = $this->input->post('zlecenie_podjecie');
										if($podjecie != null){
											//komunikat o pomyślnym podjęciu się pracy
											$this->baza->potwierdz_podjecie($id);
											$this->load->view('zlecenie/zlecenie',array('dane'=>$dane,'prace'=>$prace,'podjecie'=>1));
										}else{
											//strona z możliwością potwierdzenia podjecia się pracy
											$this->load->view('zlecenie/zlecenie',array('dane'=>$dane,'prace'=>$prace,'podjecie'=>0));
										}
									}
								}
							}
						}
					}else{
						//zalogowany jest zlecajacym
						$jestes_zlecajacym = true;
						$dane_zwyciezcy = $this->baza->dane_zwyciezcy($id);
						if(count($dane_zwyciezcy)==0){
							//nie wybrano zwycięzcy
							$po_prostu_pokaz = false;
							$this->load->view("naglowek",array('tytul'=>'ZLECENIE'));
							$wybrany = $this->input->post('zlecenie_zwyciezca');
							if($wybrany != null){
								$this->baza->wybierz_zwyciezce($id,$wybrany);
								$this->load->view('zlecenie/zlecenie',array('dane'=>$dane,'prace'=>$prace,'zgloszenia'=>1));
							}else{
								//wyświetl listę zgłoszeń
								//daj możliwość wybrania jednego
								$zgloszenia = $this->baza->lista_zgloszen($id);
								$this->load->view('zlecenie/zlecenie',array('dane'=>$dane,'prace'=>$prace,'zgloszenia'=>$zgloszenia));
							}
						}
					}
				}
			}else{
				//zlecenie po czasie wykonania
				$user = $this->session->zalogowany;
				if($dane[0]->zlecajacy_id == $user){
					//jesteś zleceniodawcą
					$dane_zwyciezcy = $this->baza->dane_zwyciezcy($id);
					if(count($dane_zwyciezcy)>0){
						//ktoś wygrał
						$status = $dane_zwyciezcy[0]->status;
						if($status == 1){
							$po_prostu_pokaz = false;
							//daj możliwość potwierdzenia wykonania
							$this->load->view("naglowek",array('tytul'=>'ZLECENIE'));
							$potwierdzono = $this->input->post('zlecenie_potwierdzenie');
							if($potwierdzono != null){
								$this->baza->potwierdz_wykonanie($id);
								$this->load->view('zlecenie/zlecenie',array('dane'=>$dane,'prace'=>$prace,'ocena'=>0));
							}else{
								$this->load->view('zlecenie/zlecenie',array('dane'=>$dane,'prace'=>$prace,'potwierdzenie'=>0));
							}
						}else if($status == 2){
							$po_prostu_pokaz = false;
							//daj możliwość ocenienia
							$this->load->view("naglowek",array('tytul'=>'ZLECENIE'));
							$ocena = $this->input->post('zlecenie_ocena');
							$komentarz = $this->input->post('zlecenie_komentarz');
							if($ocena != null && $komentarz != null){
								$this->baza->ocen($id,$dane_zwyciezcy[0]->zglaszajacy_id,$ocena,$komentarz);
								$this->load->view('zlecenie/zlecenie',array('dane'=>$dane,'prace'=>$prace,'ocena'=>1));
							}else{
								$this->load->view('zlecenie/zlecenie',array('dane'=>$dane,'prace'=>$prace,'ocena'=>0));
							}
						}
					}
				}
			}
			if($po_prostu_pokaz){
				$this->load->view("naglowek",array('tytul'=>'ZLECENIE'));
				$this->load->view('zlecenie/zlecenie',array('dane'=>$dane,'prace'=>$prace));
			}
		}else{
			$this->load->view('blad',array('komunikat'=>'Nie ma takiego zlecenia!'));
		}
	}
	
	public function nowe(){
		if($this->session->has_userdata('zalogowany')){
			//walidacja formularza
			$miejsce = $this->input->post('zlecenie_miejsce');
			//var_dump($_POST);
			if($miejsce != null){
				//sprawdz dane i wpisz do bazy
				$zlecajacy = $this->session->zalogowany;
				//$data = $this->input->post(')
				
				//sparsuj prace do wykonania
				$sparsowany = "";
				$pokoje = $this->baza->pokoje();
				foreach($pokoje as $x){
					$nazwa = 'zlecenie_'.$x->id_pokoj;
					$a = $this->input->post($nazwa);
					if($a != null){
						$ile_prac=0;
						$prace = $this->baza->praceDla($x->id_pokoj);
						foreach($prace as $y){
							$nazwa2 = 'zlecenie_'.$y->pokoj_id.'_'.$y->praca_id;
							$b = $this->input->post($nazwa2);
							if($b != null){
								$ile_prac++;
								if($sparsowany != ""){
									$sparsowany .= '|';
								}
								$sparsowany .= $y->pokoj_id.'_'.$y->praca_id;
							}
						}
						if($ile_prac==0){
							if($sparsowany != ""){
								$sparsowany .= '|';
							}
							$sparsowany .= $x->id_pokoj.'_';
						}
					}
				}
				if($sparsowany == ''){
					//zle dane nowego zlecenia
				}
				$dane = array(
					'zlecajacy_id'=>$this->session->zalogowany,
					'miejsce'=>$this->input->post('zlecenie_miejsce'),
					'data'=>$this->input->post('zlecenie_data'),
					'godzina'=>$this->input->post('zlecenie_godzina'),
					'telefon'=>$this->input->post('zlecenie_telefon'),
					'mail_kontaktowy'=>$this->input->post('zlecenie_email'),
					'cena'=>$this->input->post('zlecenie_cena'),
					'pokoje_i_prace'=>$sparsowany
				);
				$this->baza->dodaj_zlecenie($dane);
				redirect('zlecenie/zleconopomyslnie');
			}else{
				$this->load->view('naglowek',array('tytul'=>'NOWE ZLECENIE'));
				$prace = $this->baza->prace();
				//var_dump($prace);
				$email = $this->baza->podaj_email($this->session->zalogowany);
				$this->load->view('zlecenie/nowezlecenie',array('prace'=>$prace,'email'=>$email));
				//podaj formularz
			}
		}else{
			$this->load->view('blad',array('komunikat'=>'Należy się zalogować aby móc korzystać z tej podstrony!'));
		}
	}
	
	public function zleconopomyslnie(){
		$this->load->view('naglowek',array('tytul'=>'NOWE ZLECENIE'));
		$this->load->view('zlecenie/zleconopomyslnie');
	}
}