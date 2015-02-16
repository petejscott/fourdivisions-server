<?php

class GameService
{
	private $storage;
	
	public function __construct(IStorage $storage)
	{		
		if ($storage === null) throw new InvalidArgumentException('Null $storage');
		$this->storage = $storage;
	}
	
	/**
	* Stores a provided Game object using a random name in the storage implementation.
	*/
	public function SaveGame($game)
	{
		$gameId = $this->storage->GetUniqueId('4d.game.');
		$this->storage->SetData($gameId, $game);
		return $gameId;
	}
	
	/**
	* Returns the Game (as stdClass) associated with the game id, or null if there is no 
	* Game found
	*/
	public function GetGame($gameId)
	{
		$game = $this->storage->GetData($gameId);
		return json_decode($game);
	}
	
	/**
	* Removes the game identified by $gameId from the storage implementation
	*/
	public function DeleteGame($gameId)
	{
		return $this->storage->DeleteData($gameId);
	}
}

?>