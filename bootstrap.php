<?php

// Define constants PATHS
define("APPLICATION_PATH", 	__DIR__."/");
define("CONTROLLERS_PATH", 	APPLICATION_PATH."controllers/");
define("MODELS_PATH", 		APPLICATION_PATH."models/");
define("LIBRARIES_PATH", 	APPLICATION_PATH."libraries/");
define("HELPERS_PATH", 		APPLICATION_PATH."helpers/");
define("VIEWS_PATH", 		APPLICATION_PATH."views/");
define("LAYOUT_PATH", 		APPLICATION_PATH."views/layouts/");

// Define autolod to classes CONTROLLERS MODELS HELPERS and LIBRARIES
function __autoload($className) {
    if(strpos($className, "Model")){
    	//echo MODELS_PATH.$className.'.php';exit;
    }
    $pathToLoad = false;
    if(is_file(CONTROLLERS_PATH.$className.'.php'))
    	$pathToLoad = CONTROLLERS_PATH.$className.'.php';
    if(is_file(MODELS_PATH.$className.'.php'))
    	$pathToLoad = MODELS_PATH.$className.'.php';
    if(is_file(LIBRARIES_PATH.$className.'.php'))
    	$pathToLoad = LIBRARIES_PATH.$className.'.php';
    if(is_file(HELPERS_PATH.$className.'.php'))
    	$pathToLoad = HELPERS_PATH.$className.'.php';
    if(isset($pathToLoad) && !empty($pathToLoad))
    	require_once($pathToLoad);
}


class load{

	/**
	*	
	*/
	public function loader($request = NULL)
	{
		// If request not seted or empty get request by SERVER redirect url value
		if(empty($request))
		{
			$request = $_SERVER['REQUEST_URI'];
		}

		// Explode URL requested to parse
		$request = explode("/", $request);
		// Ignore /subdirectory if exist
		array_shift($request);
		array_shift($request);

		// Define index controller method and set params
		$controller = "index";
		$action 	= "index";
		$params 	= array();
		// Check controler was received
		if(isset($request[0]) && !empty($request[0]))
		{
			$controller = $request[0];

			// Check action was received
			if(isset($request[1]) && !empty($request[1]))
			{
				$action = $request[1];

				// Remove os index de controller e action
				unset($request[0]);
				unset($request[1]);

				// Verifica se foram passados parametros
				if(!empty($request))
				{
					// Varre o request buscando os parametros
					foreach($request as $param)
					{
						$params[] = $param;
					}
				}
			}
		}
		
		if(!file_exists(CONTROLLERS_PATH.$controller."Controller.php"))
		{
			$this->view("404");
			exit;
		}

		// Add string "Controller" in requested controller
		$controller = $controller."Controller";
		
		// Load requested controller
		$controller = new $controller($this);
		// Execute init in coreController
		$controller->initCore();
		// Send class load to controller
		$controller->setLoader($this);
		// Send URL params to controller
		$controller->setParams($params);
		// Run method init if exist
		if(method_exists($controller,'init'))
			$controller->init();
		// Run action requested by user
		$controller->$action();

	}

	/**
	* Load a view
	*/
	public function view($view, $params = NULL)
	{
		// If params are sended, parse array and turn key in variable name
		// Ex: array("language" => "portuguese") turns $language = "portuguese";
		if(isset($params) && !empty($params))
		{
			foreach($params as $paramKey => $paramValue)
			{
				$$paramKey = $paramValue;
			}
		}

		// Require view file
		require_once(VIEWS_PATH.$view.".phtml");
	}

	/**
	* Load a layout into a view
	*/
	public function layout($layout, $params = NULL)
	{
		// If params are sended, parse array and turn key in variable name
		// Ex: array("language" => "portuguese") turns $language = "portuguese";
		if(isset($params) && !empty($params))
		{
			foreach($params as $paramKey => $paramValue)
			{
				$$paramKey = $paramValue;
			}
		}
		// Include layout file
		include(LAYOUT_PATH.$layout.".phtml");
	}

	function redirect($url)
	{
		header("Location: $url");
	}

}