<?php
	
class statusController extends coreController{

	private $address;
	private $port;

	public function __construct(){
		$setupController 	= new setupController();
		if($setupController->verifySetup())
		{
			$this->address = $_SESSION['settings']['address'];
			$this->port = $_SESSION['settings']['port'];
		}
	}
	
	public function serverStatus(){

		$monitorModel 	= new monitorModel($this->address, $this->port);
		$status 		= $monitorModel->showStatus();

		if(isset($_SESSION['settings']['auto_refresh_time']) && !empty($_SESSION['settings']['auto_refresh_time'])){
			$timer = $_SESSION['settings']['auto_refresh_time'] * 1000;
		}else{
			$timer = 1000;
		}
		$this->load->view('serverStatus', array('status' => $status, 'timer' => $timer));
	}

	public function ajaxServerStatus(){

		$monitorModel 	= new monitorModel($this->address, $this->port);
		$status 		= $monitorModel->showStatus();

		$this->load->layout('serverStatusTable', array('status' => $status));
	}

	public function workers(){

		$workers = @$this->gearmanManager->workers();

		return $workers;
	}



}