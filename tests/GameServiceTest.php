<?php
class GameServiceTest extends PHPUnit_Framework_TestCase
{

	public function testInsertThenGetGame()
	{
		$storage = new FileStorage();
		$game = new GameModel();
		$sut = new GameService($storage);
		$gameId = $sut->InsertGame($game);
		$data = $sut->GetGame($gameId);
		
		$this->assertTrue($data instanceof StdClass);
		$this->assertEquals($gameId, $data->Id);
		$this->assertEquals(0, count($data->Plys));
		
		//cleanup
		$sut->DeleteGame($gameId);
	}
	
	public function testInsertThenUpdateThenGetGame()
	{
		$storage = new FileStorage();
		$game = new GameModel();
		$sut = new GameService($storage);
		
		// insert a new game and get its ID
		$gameId = $sut->InsertGame($game);
		// retrieve the game we just saved
		$data = $sut->GetGame($gameId);
		// give it a new ply
		$data->Plys[] = "new ply";
		// update it
		$sut->UpdateGame($gameId, $data);
		// reset $data
		$data = null;
		// retrieve the game
		$data = $sut->GetGame($gameId);
		
		$this->assertTrue($data instanceof StdClass);
		$this->assertEquals($gameId, $data->Id);
		$this->assertEquals(1, count($data->Plys));
		$this->assertEquals("new ply", $data->Plys[0]);
		
		//cleanup
		$sut->DeleteGame($gameId);
	}

}

?>