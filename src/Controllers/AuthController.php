<?php 

class AuthController extends Controller
{	
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
		if ($userId === 0) throw new Exception("Invalid credentials");
		
		// okay, create an API Key
		$as = new APIService(new MemCacheStorage());
		$key = $as->CreateAPIKey($userId);
		
		if ($this->IsXMLHTTPRequest)
		{
			return new JSONResult($key);
		}
		
		return new RawResult($key);
	}
	
}

?>
