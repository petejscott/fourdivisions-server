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
	
	protected function SetModelData(array $params, Model $model, $allowedParameters)
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
	
	public function Execute($method, $params) // : ActionResult
	{
		$model = null;
		if (property_exists($this, "defaultModel"))
		{
			$model = $this->defaultModel;
			$bindingProperty = "autoBindings_".$method;
			if (property_exists($this, $bindingProperty))
			{
				$model = $this->SetModelData($params, $model, $this->$bindingProperty);
			}
		}
		
		$parameterProperty = "expectedParams_".$method;
		if (property_exists($this, $parameterProperty))
		{
			$this->validateParams($this->$parameterProperty, $params);
		}
		
		$result = $this->$method($params, $model);
		
		if ($result instanceof IPrintableResult || $result instanceof IPrintableResult) 
		{
			http_response_code($result->GetResponseCode());
			print $result->Render();
		}
		return $result;
	}
	
}

?>
