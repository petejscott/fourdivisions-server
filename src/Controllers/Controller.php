<?php 

abstract class Controller 
{	
	public $IsXMLHTTPRequest = false;
	
	protected function ValidateParams(array $expected, $params)
	{
		foreach($expected as $expectedParam)
		{
			if (!isset($params[$expectedParam]) || empty($params[$expectedParam]))
			{
				throw new LogicException("Missing expected parameter (" . $expectedParam . ")");
			}
		}
	}
	
	public function Execute($method, $params)
	{
		//TODO: Implement typed exceptions and handle them here.
		// e.g. if NotAuthenticatedException, set a response code on the ActionResult of 401.
		// to that end, it might make sense to have a ResponseBuilder class passed in to this Execute method 
		// by the RequestRouter, and let that handle all the ActionResult tweaking.
		$result = $this->$method($params);
		
		if ($result instanceof ActionResult) 
		{
			http_response_code($result->GetResponseCode());
			print $result->Render();
		}
		return $result;
	}
	
}

?>
