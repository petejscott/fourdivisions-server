<?php
class GameServiceTest extends PHPUnit_Framework_TestCase
{

	public function testSaveAndGetGame()
	{
		$storage = new FileStorage();
		$game = new Game();
		$sut = new GameService($storage);		
		$gameId = $sut->SaveGame(json_encode($game));
		$data = $sut->GetGame($gameId);
		
		$this->assertEquals('{"Plys":[]}', $data);
		
		//cleanup
		$sut->DeleteGame($gameId);
	}

}

?>