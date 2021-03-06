<?php 

class GameController extends Controller
{
	
	private $apiService = null;
	private $gameService = null;
	
	protected $defaultModel = null;
	
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
		$this->defaultModel = new GameModel();
		
		if ($apiService === null) throw new InvalidArgumentException('Null $apiService');
		if ($gameService === null) throw new InvalidArgumentException('Null $gameService');
		$this->apiService = $apiService;
		$this->gameService = $gameService;
	}
	
	protected $expectedParams_GET_Game = ["APIKey", "Id"];
	protected $autoBindings_GET_Game = ["APIKey", "Id"];
	protected function GET_Game(GameModel $model) 
	{	
		// validate the provided API Key
		$userId = $this->GetAPIService()->ValidateAPIKey($model->APIKey);
		if ($userId == null) throw new OutOfBoundsException("Invalid API Key; try authenticating");
		// TODO: rather than throw an exception, maybe redirect to an auth mechanism? Or add an error to the model 
		// and move on.

		// TODO: future code: load a User using userId, and validate user can view this game
		
		// get the game
		$game = $this->GetGameService()->GetGame($model->Id);
		if ($game === null) throw new OutOfBoundsException("Invalid Game; check the gameId");
		// throw an exception? Seems wrong. Probably add an error to the model and skip the population of it.

		// if all went well, populate the GameModel with data from the storage mechanism.
		if ($game !== null)
		{
			$model->Plys = $game->Plys;
		}
		
		// return GameModel
		if ($this->IsXMLHTTPRequest)
		{
			return new JSONResult($model);
		}
		
		return new ViewResult('GameView', $model);
	}
	
}

?>
