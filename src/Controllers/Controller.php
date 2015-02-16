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
	
	public function Execute($method, $params) // : ActionResult
	{
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
