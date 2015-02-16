<?php
class RouteTest extends PHPUnit_Framework_TestCase
{
	
	public function testRoutePropertyAccessors()
	{
		$expectedControllerName = "RouteTestMock";
		$expectedControllerObject = new GameController(
			new APIService(new MemcacheStorage()),
			new GameService(new FileStorage())
		);
		$expectedActions = array( 
			"X" => "Y"
		);
		
		$sut = new Route();
		$sut->ControllerName = $expectedControllerName;
		$sut->ControllerObject = $expectedControllerObject;
		$sut->Actions = $expectedActions;
		
		$this->assertEquals($expectedControllerName, $sut->ControllerName);
		$this->assertEquals($expectedControllerObject, $sut->ControllerObject);
		$this->assertEquals($expectedActions, $sut->Actions);		
	}

}

?>