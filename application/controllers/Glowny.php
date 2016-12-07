<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Glowny extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');
	}
	public function index(){
		$this->load->view("naglowek",array('tytul'=>'STRONA LOGOWANIA'));
		$this->load->view("logowanie");
	}
	
}