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
		require_once 'Classes/IStorage.php';
		require_once 'Classes/FileStorage.php';
		require_once 'Classes/MemcacheStorage.php';
		
		require_once 'Classes/User.php';
		require_once 'Classes/Game.php';
		
		require_once 'Services/APIService.php';
		require_once 'Services/GameService.php';
		
		require_once 'Models/Model.php';
		require_once 'Models/APIKeyModel.php';
		require_once 'Models/GameModel.php';
		
		require_once 'Results/ActionResult.php';
		require_once 'Results/RawResult.php';
		require_once 'Results/ViewResult.php';
		require_once 'Results/JSONResult.php';
		
		require_once 'Controllers/Controller.php';
		require_once 'Controllers/AuthController.php';
		require_once 'Controllers/GameController.php';
		
		require_once 'Router/Route.php';
		require_once 'Router/RouteConfig.php';
		require_once 'Router/RequestRouter.php';
	}
	
	private function registerRoutes(RouteConfig $routeConfig)
	{		
		// TODO: Add a "default" action so that one doesn't need 
		// to be explicitly declared (e.g. https://host/User routes to 
		// UserController->GET_User() method.
		$authRouting = new Route();
		$authRouting->ControllerName = "Auth";
		$authRouting->ControllerObject = new AuthController(
			new APIService(new MemcacheStorage())
		);
		$authRouting->Actions = [
			"Auth" => "APIKey"
		];
		$routeConfig->AddRoute($authRouting);
		
		$gameRouting = new Route();
		$gameRouting->ControllerName = "Game";
		$gameRouting->ControllerObject = new GameController(
			new APIService(new MemcacheStorage()),
			new GameService(new FileStorage())
		);
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
