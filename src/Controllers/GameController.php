<?php 

class GameController extends Controller
{
	
	private $apiService = null;
	private $gameService = null;
	
	public function GetAPIService()
	{
		return $this->apiService;
	}
	public function GetGameService()
	{
		return $this->gameService;
	}
	
	public function __construct(APIService $apiService, GameService $gameService)
	{
		if ($apiService === null) throw new InvalidArgumentException('Null $apiService');
		if ($gameService === null) throw new InvalidArgumentException('Null $gameService');
		$this->apiService = $apiService;
		$this->gameService = $gameService;
	}
	
	public function GET_Plys($params) 
	{		
		// validate params 
		$this->validateParams(array('apikey', 'gameId'), $params);
		
		// validate the provided API Key
		$userId = $this->getUserIdFromAPIKey($params['apikey']);
		if ($userId == null) throw new OutOfBoundsException("Invalid API Key; try authenticating");
		
		// future code: load a User using userId, and validate user can view this game
		
		// get the game
		$encGame = $this->retrieveEncodedGameObject($params['gameId']);
		// make sure the game actually exists
		if ($encGame === null) throw new OutOfBoundsException("Invalid Game; check the gameId");
		
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
		throw new BadMethodCallException("Not implemented");
	}
	
	private function getUserIdFromAPIKey($apikey)
	{
		// validate the provided API Key
		$userId = $this->GetAPIService()->ValidateAPIKey($apikey);
		return $userId;
	}
	private function retrieveEncodedGameObject($gameId)
	{
		// get the game using the provided gameId
		$game = $this->GetGameService()->GetGame($gameId);
		return $game;
	}
	
}

?>
