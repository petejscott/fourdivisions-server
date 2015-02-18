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
	* Stores a provided Game object using a random name (id) in the storage implementation.
	*/
	public function InsertGame($game)
	{
		$gameId = $this->storage->GetUniqueIdFactory()->GetUniqueId('4d.game.');
		$game->Id = $gameId; // set the Id on the game before saving
		$this->storage->SetData($gameId, json_encode($game));
		return $gameId;
	}
	
	/**
	* Stores a provided Game object using the provided name (id) in the storage implementation.
	*/
	public function UpdateGame($gameId, $game)
	{
		$this->storage->SetData($gameId, json_encode($game));
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