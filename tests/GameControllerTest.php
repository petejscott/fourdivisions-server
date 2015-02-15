<?php
class GameControllerTest extends PHPUnit_Framework_TestCase
{
	
	/**
	* @expectedException Exception
	*
	*/
	public function testGetPlysWithoutGameIdThrowsException()
	{
		// we need a valid auth for this
		$apikey = $this->getValidApiKey();
		
		$gc = new GameController();
		$result = $gc->GET_Plys(
			array(
				"apikey"=>$apikey), 
			"GET");
	}
	
	/**
	* @expectedException Exception
	*
	*/
	public function testGetPlysWithoutApiKeyThrowsException()
	{
		// we need a valid auth for this
		$apikey = $this->getValidApiKey();
		
		$gc = new GameController();
		$result = $gc->GET_Plys(
			array(
				"gameId"=>"4d.game.empty"), 
			"GET");
	}
	
	public function testGetPlys()
	{
		// we need a valid auth for this
		$apikey = $this->getValidApiKey();
		
		$gc = new GameController();
		$result = $gc->GET_Plys(
			array(
				"gameId"=>"4d.game.54dff62b775906.47811541",
				"apikey"=>$apikey), 
			"GET");
		
		$plys = $result->GetContent();
		$this->assertTrue(is_array($plys));
		$this->assertEquals(0, count($plys));
		
		// cleanup
		$this->deleteValidApiKey();
	}
	
	private function getValidApiKey()
	{
		$storage = new MemcacheStorage();
		$as = new APIService($storage);
		$key = $as->CreateAPIKey(999);
		return $key;
	}
	private function deleteValidApiKey()
	{
		$storage = new MemcacheStorage();
		$as = new APIService($storage);
		$as->RevokeAPIKey(999);
	}

}

?>