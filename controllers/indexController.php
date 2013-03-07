<?php
	
class indexController extends coreController{

	public function init(){

	}

	public function index(){

		$this->load->redirect('/monitor/status/serverStatus');
	}

}