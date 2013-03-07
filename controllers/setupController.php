<?php
	
class setupController extends coreController{

	public function init(){

	}

	public function index(){
		
		$this->load->view('setup');
	}

	public function saveSetup(){
		
		$formHelper 	= new formHelper();
		$post 		= $formHelper->getPost();
		
		$_SESSION['settings'] = array();

		$_SESSION['settings']['address'] 		= $post['address'];
		$_SESSION['settings']['port'] 			= $post['port'];
		if(isset($post['auto-refresh']) && !empty($post['auto-refresh']))
		{
			$_SESSION['settings']['auto_refresh']	= $post['auto-refresh'];
			$_SESSION['settings']['auto_refresh_time']	= $post['auto-refresh-time'];
		}else{
			$_SESSION['settings']['auto_refresh']	= 0;
		}

		$this->load->redirect('/monitor/setup');
	}

	public function verifySetup(){
		if(!isset($_SESSION['settings']['address']) || empty($_SESSION['settings']['address']) ||
		  !isset($_SESSION['settings']['port']) || empty($_SESSION['settings']['port']))
		{
			$this->load->redirect('/monitor/setup');
			exit;
		}

		return true;
	}

}