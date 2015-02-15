<?php

class RequestRouter
{
	
	private $routeConfig = null;
	
	public function __construct(RouteConfig $routeConfig)
	{
		if ($routeConfig === null) throw new Exception("null $routeConfig");		
		$this->routeConfig = $routeConfig;
	}
	
	public function Route($params, $server)
	{
		list($verb, $isxmlhttprequest) = $this->getServerParameters($server);
		
		$this->validateParams($params);
		
		$route = null;
		foreach ($this->routeConfig->GetRoutes() as $r)
		{
			if ($r->ControllerName === $params['controller'])
			{
				$route = $r;
				break;
			}
		}
		if ($route === null) throw new Exception("No matching controller in registered routes");
		
		$method = null;
		foreach ($route->Actions as $actionName => $controllerMethod)
		{
			if ($actionName === $params['action'])
			{
				$method = $verb.'_'.$controllerMethod;
				break;
			}			
		}
		if ($method === null) throw new Exception("No matching action in registered routes");
		
		if (!method_exists($route->ControllerObject, $method))
		{
			throw new Exception("Action in Controller is not callable ($method)");
		}
		
		// let the controller know what kind of request it is dealing with
		$route->ControllerObject->IsXMLHTTPRequest = $isxmlhttprequest;
		
		// execute the request on the controller
		return $route->ControllerObject->Execute($method, $params);
	}
	
	private function validateParams($params)
	{
		if (!isset($params['controller']) || empty($params['controller']))
		{
			throw new Exception("missing controller param");
		}
		if (!isset($params['action']) || empty($params['action']))
		{
			throw new Exception("missing action param");
		}
	}
	
	private function getServerParameters($server)
	{
		$verb = "";
		if (!empty($server['REQUEST_METHOD'])) $verb = strtoupper($server['REQUEST_METHOD']);
		
		$isxmlhttprequest = false;
		if (!empty($server['HTTP_X_REQUESTED_WITH']) 
			&& strtolower($server['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest") 
		{
			$isxmlhttprequest = true;
		}

		return [$verb, $isxmlhttprequest];
	}
	
}

?>