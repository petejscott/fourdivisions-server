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
	
	public function SetModelData(array $params, Model $model, $allowedParameters)
	{
		foreach($params as $key => $value)
		{
			if (!in_array($key, $allowedParameters)) continue;
			if (property_exists($model, $key))
			{
				$model->$key = $value;
			}
		}
		return $model;
	}
	
}

?>
