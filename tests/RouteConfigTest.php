<?php
class RouteConfigTest extends PHPUnit_Framework_TestCase
{
	
	public function testRouteConfigAddValidRoute()
	{
		$expectedControllerName = "RouteConfigTestMock";
		$expectedControllerObject = new GameController();
		$expectedActions = array( 
			"X" => "Y"
		);
		
		$route = new Route();
		$route->ControllerName = $expectedControllerName;
		$route->ControllerObject = $expectedControllerObject;
		$route->Actions = $expectedActions;
		
		$sut = new RouteConfig();
		$sut->AddRoute($route);
		
		$routes = $sut->GetRoutes();
		$this->assertTrue($routes->contains($route));
	}

}

?>