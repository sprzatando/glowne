<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
	}
	
	public function index(){
		$this->load->view('naglowek',array('tytul'=>'NOWE ZLECENIE'));
		$this->load->view('glowny/zmianahasla',array('zmieniono'=>true));
	}
	
	public function dwa(){
		
		redirect('test');
	}
}