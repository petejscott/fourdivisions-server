<?php
class GameServiceTest extends PHPUnit_Framework_TestCase
{

	public function testInsertAndGetGame()
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

}

?>