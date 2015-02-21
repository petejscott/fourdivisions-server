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
			new APIService(new MemcacheStorage(new SecureUniqueIdFactory())),
			new GameService(new FileStorage(new SimpleUniqueIdFactory()))
		);
		$result = $gc->Execute(
			"GET_Game",
			["apikey"=>$apikey]);
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
			new APIService(new MemcacheStorage(new SecureUniqueIdFactory())),
			new GameService(new FileStorage(new SimpleUniqueIdFactory()))
		);
		$result = $gc->Execute(
			"GET_Game",
			["gameId"=>"4d.game.empty"]);
	}
	
	public function testGetGame()
	{		
		// we need a valid auth for this
		$apikey = $this->getValidApiKey();
		
		$gc = new GameController(
			new APIService(new MemcacheStorage(new SecureUniqueIdFactory())),
			new GameService(new FileStorage(new SimpleUniqueIdFactory()))
		);
		$result = $gc->Execute(
			"GET_Game",
			[
				"gameId"=>"4d.game.54dff62b775906.47811541",
				"apikey"=>$apikey
			]);
		
		$gameModel = $result->GetModel();
		$this->assertTrue($result instanceof ViewResult);
		$this->assertTrue($gameModel instanceof GameModel);
		
		// cleanup
		$this->deleteValidApiKey();
	}
	
	private function getValidApiKey()
	{
		$storage = new MemcacheStorage(new SecureUniqueIdFactory());
		$as = new APIService($storage);
		$key = $as->CreateAPIKey(999);
		return $key;
	}
	private function deleteValidApiKey()
	{
		$storage = new MemcacheStorage(new SecureUniqueIdFactory());
		$as = new APIService($storage);
		$as->RevokeAPIKey(999);
	}

}

?>