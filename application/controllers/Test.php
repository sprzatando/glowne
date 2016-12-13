<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
	}
	
	public function index(){
		var_dump($_POST);
		echo '<form method="post">';
		for($i = 0;$i<10;$i++){
			echo '<button type="submit" class="btn btn-default" name="zlecenie_zwyciezca" value="'.$i.'">'.$i.'</button>';
		}
		echo '</form>';
	}
	
	public function dwa(){
		
		redirect('test');
	}
}