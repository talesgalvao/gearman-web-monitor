<?php

class monitorModel{

	static private $gearmanManager;

	public function __construct($address, $port){
		@include_once('Net/Gearman/Manager.php');

		if(!class_exists('Net_Gearman_Manager', true))
		{
			echo "Net Gearman is required!!!";
			exit;
		}

		$this->connectServer($address, $port);
	}

	public function connectServer($address, $port){
		if (!isset(self::$gearmanManager)) {
            self::$gearmanManager = new Net_Gearman_Manager($address.":".$port);;
        }

        return self::$gearmanManager;		
	}

	public function showStatus(){

		$status = self::$gearmanManager->status();
		
		return $status;
	}

	public function showWorkers(){

		$workers = @self::$gearmanManager->workers();

		return $workers;
	}

	public function __destruct(){

		self::$gearmanManager->disconnect();
	}
	
}