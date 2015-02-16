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
	
	public function GET_APIKey($params)
	{
		$model = new APIKeyModel("hello");
		$model->AddError(array("Error1","Error2"));
		
		if ($this->IsXMLHTTPRequest)
		{
			$model->APIKey = "hello ajax";
			$result = new JSONResult($model);
		}
		else
		{
			$result = new ViewResult('AuthView', $model);
		}
		return $result;
	}
	public function PUT_APIKey($params)
	{
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
		if ($userId === 0) throw new OutOfBoundsException("Invalid credentials");
		
		// okay, create an API Key
		$key = $this->GetAPIService()->CreateAPIKey($userId);
		
		if ($this->IsXMLHTTPRequest)
		{
			return new JSONResult(new APIKeyModel($key));
		}
		
		return new RawResult(new APIKeyModel($key));
	}
	
}

?>
