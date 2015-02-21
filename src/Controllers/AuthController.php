<?php 

class AuthController extends Controller
{	

	private $apiService = null;
	
	public function GetAPIService()
	{
		return $this->apiService;
	}
	
	public function __construct(APIService $apiService)
	{
		if ($apiService === null) throw new InvalidArgumentException('Null $apiService');
		$this->apiService = $apiService;
	}
	
	public function GET_Login($params, $model = null)
	{
		if ($model === null) $model = new UserModel();
		return new ViewResult('LoginView', $model);
	}
	
	public function POST_Login($params, $model = null)
	{
		if ($model === null) $model = new UserModel();
		
		// validate params and verb
		$this->validateParams(array('email', 'password'), $params);
		
		// verify some hardcoded values 
		// (TODO: replace this with an actual user implementation)
		$validCredentials = [
			'1000' => 
				[
				"email" => "user1@example.com",
				"password" => "user1password"
				],
			'1001' =>
				[
				"email" => "user2@example.com",
				"password" => "user2password"
				]
			];
		
		$userId = 0;
		foreach($validCredentials as $id => $credentials)
		{
			if ($credentials["email"] == $params["email"] && 
				$credentials["password"] == $params["password"])
			{
				$userId = $id;
			}
		}
		
		// make sure we have a user Id
		if ($userId === 0) 
		{
			//throw new OutOfBoundsException("Invalid credentials");
			$model->AddError("Invalid Credentials");
			if ($this->IsXMLHTTPRequest)
			{
				return new JSONResult($model);
			}
			else 
			{
				return new ViewResult('LoginView', $model);
			}
		}
		
		// okay, create an API Key
		$key = $this->GetAPIService()->CreateAPIKey($userId);
		
		// god this ugly mocking just keeps getting uglier:
		$model->Id = $userId;
		$model->Email = $params['email'];
		$model->APIKey = $key;
		
		if ($this->IsXMLHTTPRequest)
		{
			// return the key in a json response so the client can 
			// manage it all by itself.
			return new JSONResult($model);
		}
		
		return new ViewResult('UserView', $model);
	}
	
}

?>
