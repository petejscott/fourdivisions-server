<?php 

class RouteConfig 
{
	private $routes = null;
	
	public function __construct()
	{
		$this->routes = new SplObjectStorage();
	}
	
	public function AddRoute(Route $route)
	{
		if ($route === null) throw new InvalidArgumentException('Null $route');
		if (!$route->ControllerObject instanceof Controller)
		{
			throw new InvalidArgumentException("Route defines a ControllerObject that is not an instance of Controller");
		}
		foreach($this->routes as $r)
		{
			if ($r->ControllerName == $route->ControllerName)
			{
				throw new OutOfRangeException("A Route with that ControllerName is already registered");
			}
		}
		$this->routes->attach($route);
	}
	public function RemoveRoute(Route $route)
	{
		$this->routes->detach($route);
	}
	public function GetRoutes()
	{
		return $this->routes;
	}
}

?>