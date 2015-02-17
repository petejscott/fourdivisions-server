<?php
class GameControllerTest extends PHPUnit_Framework_TestCase
{
	
	/**
	* @expectedException LogicException
	*
	*/
	public function testGetGameWithoutGameIdThrowsException()
	{
		// we need a valid auth for this
		$apikey = $this->getValidApiKey();
		
		$gc = new GameController(
			new APIService(new MemcacheStorage()),
			new GameService(new FileStorage())
		);
		$result = $gc->GET_Game(
			array(
				"apikey"=>$apikey), 
			"GET");
	}
	
	/**
	* @expectedException LogicException
	*
	*/
	public function testGetGameWithoutApiKeyThrowsException()
	{
		// we need a valid auth for this
		$apikey = $this->getValidApiKey();
		
		$gc = new GameController(
			new APIService(new MemcacheStorage()),
			new GameService(new FileStorage())
		);
		$result = $gc->GET_Game(
			array(
				"gameId"=>"4d.game.empty"), 
			"GET");
	}
	
	public function testGetGame()
	{
		// we need a valid auth for this
		$apikey = $this->getValidApiKey();
		
		$gc = new GameController(
			new APIService(new MemcacheStorage()),
			new GameService(new FileStorage())
		);
		$result = $gc->GET_Game(
			array(
				"gameId"=>"4d.game.54dff62b775906.47811541",
				"apikey"=>$apikey), 
			"GET");
		
		$gameModel = $result->GetModel();
		$this->assertTrue(is_array($gameModel->Plys));
		$this->assertEquals(0, count($gameModel->Plys));
		
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