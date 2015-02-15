<?php 

class GameController extends Controller
{
	
	public function GET_Plys($params) 
	{		
		// validate params 
		$this->validateParams(array('apikey', 'gameId'), $params);
		
		// validate the provided API Key
		$userId = $this->getUserIdFromAPIKey($params['apikey']);
		if ($userId == null) throw new Exception("Invalid API Key; try authenticating");
		
		// future code: load a User using userId, and validate user can view this game
		
		// get the game
		$encGame = $this->retrieveEncodedGameObject($params['gameId']);
		// make sure the game actually exists
		if ($encGame === null) throw new Exception("Invalid Game; check the gameId");
		
		$game = json_decode($encGame);
		
		$plys = $game->Plys;
		
		// return plys array
		if ($this->IsXMLHTTPRequest)
		{
			return new JSONResult($plys);
		}
		
		return new RawResult($plys);
	}
	public function PUT_Ply($params)
	{
		throw new Exception("Not implemented");
	}
	
	private function getUserIdFromAPIKey($apikey)
	{
		// create the APIService
		$memStorage = new MemCacheStorage();
		$as = new APIService($memStorage);
		// validate the provided API Key
		$userId = $as->ValidateAPIKey($apikey);
		return $userId;
	}
	private function retrieveEncodedGameObject($gameId)
	{
		// create the GameService
		$fileStorage = new FileStorage();
		$gs = new GameService($fileStorage);
		// get the game using the provided gameId
		$game = $gs->GetGame($gameId);
		return $game;
	}
	
}

?>
