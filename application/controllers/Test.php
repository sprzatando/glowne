﻿<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
	}
	
	public function index(){
		
	}
	
	public function dwa(){
		
		redirect('test');
	}
}