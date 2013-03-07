<?php

class coreController{

	public $load;
	public $params;

	public function __construct()
	{
		session_start();
		$this->load = new load();
	}

	public function initCore()
	{
		
	}

	public function setLoader($loadClass = NULL){
		if($loadClass){
			$this->load = $loadClass;
		}
	}

	public function setParams($params){
		$this->params = $params;	
	}
}