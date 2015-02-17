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
	
	public function GET_Game($params) 
	{
		// validate params 
		$this->validateParams(array('apikey', 'gameId'), $params);
		
		$model = new GameModel();
		
		// validate the provided API Key
		$userId = $this->GetAPIService()->ValidateAPIKey($params['apikey']);
		if ($userId == null) throw new OutOfBoundsException("Invalid API Key; try authenticating");
		
		// future code: load a User using userId, and validate user can view this game
		
		// get the game
		$game = $this->GetGameService()->GetGame($params['gameId']);
		if ($game === null) throw new OutOfBoundsException("Invalid Game; check the gameId");
		
		$model->Id = $game->Id;
		$model->Plys = $game->Plys;
		
		// return GameModel
		if ($this->IsXMLHTTPRequest)
		{
			return new JSONResult($model);
		}
		
		return new RawResult($model);
	}
	public function PUT_Ply($params)
	{
		throw new BadMethodCallException("Not implemented");
	}
	
}

?>
