<?php
class RequestRouterTest extends PHPUnit_Framework_TestCase
{
	
	/**
	* @expectedException LogicException
	*
	*/
	public function testRouteCallWIthMissingControllerParam()
	{
		$mockRequest = array("action" => "test");
		$mockVerb = "GET";
		
		$config = new RouteConfig();
		$route = $this->buildSimpleMockRoute();		
		$config->AddRoute($route);
		
		$sut = new RequestRouter($config);
		$sut->Route(
			$mockRequest, 
			$this->buildMockServerParameters($mockVerb, false));
	}
	
	/**
	* @expectedException LogicException
	*
	*/
	public function testRouteCallWIthMissingActionParam()
	{
		$mockRequest = array("controller" => "SimpleMock");
		$mockVerb = "GET";
		
		$config = new RouteConfig();
		$route = $this->buildSimpleMockRoute();		
		$config->AddRoute($route);
		
		$sut = new RequestRouter($config);
		$sut->Route(
			$mockRequest, 
			$this->buildMockServerParameters($mockVerb, false));
	}
	
	/**
	* @expectedException BadMethodCallException
	*
	*/
	public function testRouteCallWIthInvalidMethodForAction()
	{
		$mockRequest = array("controller" => "BadMock", "action" => "DoTest");
		$mockVerb = "GET";
		
		$config = new RouteConfig();
		$route = $this->buildBadMockRoute();		
		$config->AddRoute($route);
		
		$sut = new RequestRouter($config);
		$sut->Route(
			$mockRequest, 
			$this->buildMockServerParameters($mockVerb, false));
	}
	
	/**
	* @expectedException LogicException
	*
	*/
	public function testRouteCallWIthInvalidControllerParam()
	{
		$mockRequest = array("controller" => "ThisControllerNameDoesNotExist", "action" => "DoTest");
		$mockVerb = "GET";
		
		$config = new RouteConfig();
		$route = $this->buildSimpleMockRoute();		
		$config->AddRoute($route);
		
		$sut = new RequestRouter($config);
		$sut->Route(
			$mockRequest, 
			$this->buildMockServerParameters($mockVerb, false));
	}
	
	/**
	* @expectedException OutOfRangeException
	*
	*/
	public function testAddTwoRoutesWithSameControllerName()
	{
		$config = new RouteConfig();
		$route1 = $this->buildSimpleMockRoute();		
		$route2 = $this->buildSimpleMockRoute();
		
		$config->AddRoute($route1);
		$config->AddRoute($route2);
	}
	
	/**
	* @expectedException Exception
	*
	*/
	public function testRouteCallWIthInvalidActionParam()
	{
		$mockRequest = array("controller" => "SimpleMock", "action" => "ThisMethodDoesNotExist");
		$mockVerb = "GET";
		
		$config = new RouteConfig();
		$route = $this->buildSimpleMockRoute();		
		$config->AddRoute($route);
			
		
		$sut = new RequestRouter($config);
		$sut->Route($mockRequest, $mockVerb, false);
	}
	
	public function testRouteCallWIthProperParamsExecutesAction()
	{
		$mockRequest = array("controller" => "SimpleMock", "action" => "DoTest");
		$mockVerb = "GET";		
		
		$config = new RouteConfig();
		$route = $this->buildSimpleMockRoute();		
		$config->AddRoute($route);
		
		$sut = new RequestRouter($config);
		$result = $sut->Route(
			$mockRequest, 
			$this->buildMockServerParameters($mockVerb, true));
		
		$this->assertEquals("{}", $result);
	}
	
	private function buildSimpleMockRoute()
	{
		$expectedControllerName = "SimpleMock";
		$expectedControllerObject = new MockController();
		$expectedActions = array( 
			"DoTest" => "Test"
		);
		
		$route = new Route();
		$route->ControllerName = $expectedControllerName;
		$route->ControllerObject = $expectedControllerObject;
		$route->Actions = $expectedActions;
		
		return $route;
	}
	
	private function buildBadMockRoute()
	{
		$expectedControllerName = "BadMock";
		$expectedControllerObject = new MockController();
		$expectedActions = array( 
			"DoTest" => "TestMethodDoesNotExist"
		);
		
		$route = new Route();
		$route->ControllerName = $expectedControllerName;
		$route->ControllerObject = $expectedControllerObject;
		$route->Actions = $expectedActions;
		
		return $route;
	}
	
	private function buildMockServerParameters($verb, $isAjax)
	{
		return [
			'REQUEST_METHOD' => $verb,
			'HTTP_X_REQUESTED_WITH' => ($isAjax ? "" : "xmlhttprequest")
			];
	}
	
}

class MockController extends Controller
{
	public function GET_Test($params)
	{
		return "{}";
	}
}

?>