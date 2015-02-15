<?php

class Bootstrap 
{
	public $Router;

	public function Compose()
	{		
		$routeConfig = new RouteConfig();
		$routeConfig = $this->registerRoutes($routeConfig);
		$this->Router = new RequestRouter($routeConfig);
	}
	
	public function __construct()
	{
		$this->load();
	}
	
	private function load()
	{		
		require_once 'Classes/FileStorage.php';
		require_once 'Classes/MemcacheStorage.php';
		
		require_once 'Classes/User.php';
		require_once 'Classes/Game.php';
		
		require_once 'Classes/APIService.php';
		require_once 'Classes/GameService.php';
		
		require_once 'Result/ActionResult.php';
		require_once 'Result/RawResult.php';
		require_once 'Result/JSONResult.php';
		
		require_once 'Controllers/Controller.php';
		require_once 'Controllers/AuthController.php';
		require_once 'Controllers/GameController.php';
		
		require_once 'Router/Route.php';
		require_once 'Router/RouteConfig.php';
		require_once 'Router/RequestRouter.php';
	}
	
	private function registerRoutes(RouteConfig $routeConfig)
	{		
		$authRouting = new Route();
		$authRouting->ControllerName = "Auth";
		$authRouting->ControllerObject = new AuthController();
		$authRouting->Actions = [
			"Auth" => "APIKey"
		];
		$routeConfig->AddRoute($authRouting);
		
		$gameRouting = new Route();
		$gameRouting->ControllerName = "Game";
		$gameRouting->ControllerObject = new GameController();
		$gameRouting->Actions = [
			"Plys" => "Plys"
		];
		$routeConfig->AddRoute($gameRouting);
		
		return $routeConfig;
	}
}

$bootstrap = new Bootstrap();
$bootstrap->Compose();
$requestRouter = $bootstrap->Router;

?>
